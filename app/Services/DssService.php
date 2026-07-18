<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Models\Program;
use App\Models\NilaiUjian;
use App\Models\DssRanking;
use App\Models\BobotPenilaian;
use App\Models\BisnisRuleProgram;
use App\Models\PeriodePendaftaran;

class DssService
{
    /**
     * Get the current DSS settings (weights, predikats, etc.)
     */
    public static function getConfig()
    {
        $setting = \App\Models\PmbmSetting::first();
        
        if (!$setting) {
            // Default configuration
            $defaultConfig = [
                'weights' => [
                    'hafalan' => 40,
                    'tasmi' => 30,
                    'calistung' => 30,
                ],
                'predikats' => [
                    ['min' => 90, 'max' => 100, 'label' => 'Sangat Cakap'],
                    ['min' => 70, 'max' => 89, 'label' => 'Cakap'],
                    ['min' => 60, 'max' => 69, 'label' => 'Cukup Cakap'],
                    ['min' => 1, 'max' => 59, 'label' => 'Butuh Perhatian']
                ]
            ];
            
            $setting = \App\Models\PmbmSetting::create([
                'registration_open' => true,
                'current_angkatan' => date('Y'),
                'dss_weights' => $defaultConfig
            ]);
        }

        $config = $setting->dss_weights;
        
        // Ensure structure is correct
        if (!isset($config['weights']) || !isset($config['predikats'])) {
            $config = [
                'weights' => $config['weights'] ?? [
                    'hafalan' => 40,
                    'tasmi' => 30,
                    'calistung' => 30,
                ],
                'predikats' => $config['predikats'] ?? [
                    ['min' => 90, 'max' => 100, 'label' => 'Sangat Cakap'],
                    ['min' => 70, 'max' => 89, 'label' => 'Cakap'],
                    ['min' => 60, 'max' => 69, 'label' => 'Cukup Cakap'],
                    ['min' => 1, 'max' => 59, 'label' => 'Butuh Perhatian']
                ]
            ];
        }

        return $config;
    }

    /**
     * Map a raw score to a predicate label based on config bounds
     */
    public static function getPredicateLabel($score, $predikats)
    {
        $score = intval($score);
        foreach ($predikats as $p) {
            if ($score >= intval($p['min']) && $score <= intval($p['max'])) {
                return $p['label'];
            }
        }
        return 'Butuh Perhatian'; // fallback
    }

    /**
     * Generate automatically compiled comment narrative
     */
    public static function generateNarrative($scores, $config)
    {
        $predikats = $config['predikats'];
        
        $predHafalan = self::getPredicateLabel($scores['hafalan'], $predikats);
        $predTasmi = self::getPredicateLabel($scores['tasmi'], $predikats);
        $predCalistung = self::getPredicateLabel($scores['calistung'], $predikats);

        return "Kemampuan hafalan masuk kategori {$predHafalan}. " .
               "Kemampuan tasmi masuk kategori {$predTasmi}. " .
               "Kemampuan calistung masuk kategori {$predCalistung}.";
    }

    /**
     * Get the active evaluation weights or create a default record.
     */
    public static function getActiveWeights()
    {
        $weights = BobotPenilaian::first();
        if (!$weights) {
            $weights = BobotPenilaian::create([
                'bobot_hafalan' => 20.00,
                'bobot_aism' => 15.00,
                'bobot_irqa' => 20.00,
                'bobot_calistung' => 20.00,
                'bobot_dikte' => 15.00,
                'bobot_kemandirian' => 10.00,
            ]);
        }
        return $weights;
    }

    /**
     * Get rule threshold values for a program.
     */
    public static function getProgramRules($id_program)
    {
        $rule = BisnisRuleProgram::where('id_program', $id_program)->first();
        if (!$rule) {
            $rule = BisnisRuleProgram::create([
                'id_program' => $id_program,
                'minimal_nilai_akhir' => 50,
                'minimal_hafalan' => 0,
                'minimal_tasmi' => 0,
                'minimal_calistung' => 0,
            ]);
        }
        return $rule;
    }

    /**
     * Recalculate all rankings and recommendations based on the new schema.
     */
    public static function recalculateAll()
    {
        // 1. Get active weights from settings
        $config = self::getConfig();
        $weights = $config['weights'] ?? [
            'hafalan' => 20,
            'aism' => 15,
            'iqro' => 20,
            'calistung' => 20,
            'dikte' => 15,
            'kemandirian' => 10
        ];

        $wHafalan = isset($weights['hafalan']) ? (int) $weights['hafalan'] : 20;
        $wAism = isset($weights['aism']) ? (int) $weights['aism'] : 15;
        $wIqro = isset($weights['iqro']) ? (int) $weights['iqro'] : 20;
        $wCalistung = isset($weights['calistung']) ? (int) $weights['calistung'] : 20;
        $wDikte = isset($weights['dikte']) ? (int) $weights['dikte'] : 15;
        $wKemandirian = isset($weights['kemandirian']) ? (int) $weights['kemandirian'] : 10;

        // For backwards compatibility DB model use
        $dbBobot = self::getActiveWeights();

        // 2. Get active period pendaftaran
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();
        if (!$activePeriod) {
            return;
        }

        // 3. Process each program of the active period
        $programs = $activePeriod->programs;

        foreach ($programs as $program) {
            // Find all pendaftaran for this program in the active period that have exam grades
            $pendaftarans = Pendaftaran::where('periode_pendaftaran_id', $activePeriod->id)
                ->where('id_program', $program->id_program)
                ->whereHas('nilaiUjian')
                ->get();

            // Calculate score for each candidate
            $scores = [];
            foreach ($pendaftarans as $pendaftaran) {
                $nilai = $pendaftaran->nilaiUjian;
                
                // Calculate weighted total score out of 100
                $totalScore = (
                    (($nilai->nilai_hafalan ?: 0) * $wHafalan) +
                    (($nilai->nilai_aism ?: 0) * $wAism) +
                    (($nilai->nilai_iqro ?: 0) * $wIqro) +
                    (($nilai->nilai_calistung ?: 0) * $wCalistung) +
                    (($nilai->nilai_dikte ?: 0) * $wDikte) +
                    (($nilai->nilai_kemandirian ?: 0) * $wKemandirian)
                ) / 100;

                $scores[] = [
                    'pendaftaran' => $pendaftaran,
                    'nilai' => $nilai,
                    'total' => $totalScore
                ];
            }

            // Sort by total score descending
            usort($scores, function($a, $b) {
                return $b['total'] <=> $a['total'];
            });

            // Get dynamic criteria rules for this program
            $criteriaList = $program->criteria;
            
            // Get program quota for this period from the pivot table (defaulting to program quota)
            $pivot = $activePeriod->programs()->where('programs.id_program', $program->id_program)->first();
            $quota = ($pivot && isset($pivot->pivot->kuota)) ? $pivot->pivot->kuota : ($program->kuota_program ?: 30);

            $cadanganRank = 1;

            foreach ($scores as $index => $item) {
                $rank = $index + 1;
                $pendaftaran = $item['pendaftaran'];
                $nilai = $item['nilai'];
                $total = $item['total'];

                // Evaluate conditions against dynamic program criteria
                $passedThresholds = true;
                foreach ($criteriaList as $crit) {
                    $scoreValue = 0;
                    switch ($crit->nama_kriteria) {
                        case 'hafalan':
                            $scoreValue = (int) ($nilai->nilai_hafalan ?: 0);
                            break;
                        case 'aism':
                            $scoreValue = (int) ($nilai->nilai_aism ?: 0);
                            break;
                        case 'iqro':
                            $scoreValue = (int) ($nilai->nilai_iqro ?: 0);
                            break;
                        case 'calistung':
                            $scoreValue = (int) ($nilai->nilai_calistung ?: 0);
                            break;
                        case 'dikte':
                            $scoreValue = (int) ($nilai->nilai_dikte ?: 0);
                            break;
                        case 'kemandirian':
                            $scoreValue = (int) ($nilai->nilai_kemandirian ?: 0);
                            break;
                    }
                    if ($scoreValue < (int) $crit->nilai_minimum) {
                        $passedThresholds = false;
                        break; // failed a criterion
                    }
                }

                if ($passedThresholds && $rank <= $quota) {
                    $recommendation = 'Lulus Seleksi';
                } elseif ($passedThresholds) {
                    $recommendation = 'Cadangan';
                } else {
                    $recommendation = 'Tidak Lulus';
                }

                // Update or create DssRanking
                DssRanking::updateOrCreate(
                    ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
                    [
                        'id_bobot' => $dbBobot->id_bobot,
                        'nilai_total' => $total,
                        'ranking' => $rank,
                        'rekomendasi' => $recommendation
                    ]
                );

                // For candidates recommended as waitlisted (Cadangan)
                if ($recommendation === 'Cadangan') {
                    $pendaftaran->peringkat_cadangan = $cadanganRank++;
                } else {
                    $pendaftaran->peringkat_cadangan = null;
                }
                
                $pendaftaran->save();
            }
        }
    }

    /**
     * Get recommendation label for candidate.
     */
    public static function getRecommendation($pendaftaran)
    {
        $dss = DssRanking::where('id_pendaftaran', $pendaftaran->id_pendaftaran)->first();
        if (!$dss) {
            return 'Belum Dinilai';
        }
        return $dss->rekomendasi;
    }
}
