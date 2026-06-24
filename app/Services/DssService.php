<?php

namespace App\Services;

use App\Models\PmbmSetting;
use App\Models\HasilWawancaraDanUjian;
use App\Models\Pendaftaran;
use App\Models\Program;

class DssService
{
    /**
     * Get the current DSS settings (weights, predikats, etc.)
     */
    public static function getConfig()
    {
        $setting = PmbmSetting::first();
        
        if (!$setting) {
            // Default configuration
            $defaultConfig = [
                'weights' => [
                    'hafalan' => 30,
                    'wawancara' => 20,
                    'calistung' => 20,
                    'tasmi' => 15,
                    'mandiri' => 15
                ],
                'predikats' => [
                    ['min' => 85, 'max' => 100, 'label' => 'Sangat Cakap'],
                    ['min' => 70, 'max' => 84, 'label' => 'Cakap'],
                    ['min' => 60, 'max' => 69, 'label' => 'Cukup Cakap'],
                    ['min' => 1, 'max' => 59, 'label' => 'Butuh Perhatian']
                ]
            ];
            
            $setting = PmbmSetting::create([
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
                    'hafalan' => 30,
                    'wawancara' => 20,
                    'calistung' => 20,
                    'tasmi' => 15,
                    'mandiri' => 15
                ],
                'predikats' => $config['predikats'] ?? [
                    ['min' => 85, 'max' => 100, 'label' => 'Sangat Cakap'],
                    ['min' => 70, 'max' => 84, 'label' => 'Cakap'],
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
        $predWawancara = self::getPredicateLabel($scores['wawancara'], $predikats);
        $predCalistung = self::getPredicateLabel($scores['calistung'], $predikats);
        $predTasmi = self::getPredicateLabel($scores['tasmi'], $predikats);
        $predMandiri = self::getPredicateLabel($scores['mandiri'], $predikats);

        return "Kemampuan hafalan masuk kategori {$predHafalan}. " .
               "Kemampuan wawancara masuk kategori {$predWawancara}. " .
               "Kemampuan calistung masuk kategori {$predCalistung}. " .
               "Kemampuan tasmi masuk kategori {$predTasmi}. " .
               "Aspek kemandirian masuk kategori {$predMandiri}.";
    }

    /**
     * Recalculate all rankings and recommendations
     */
    public static function recalculateAll()
    {
        $config = self::getConfig();

        // Get all programs
        $programs = Program::all();

        foreach ($programs as $program) {
            // Get weights for this program or fallback to config weights
            $weights = $program->dss_weights ?: ($config['weights'] ?? [
                'hafalan' => 30,
                'wawancara' => 20,
                'calistung' => 20,
                'tasmi' => 15,
                'mandiri' => 15
            ]);

            // Find all graded students for this program
            $gradedResults = HasilWawancaraDanUjian::where('id_program', $program->id_program)->get();

            // 1. Recalculate individual scores & narratives
            foreach ($gradedResults as $result) {
                // Calculate final weighted score
                $nilaiAkhir = (
                    ($result->nilai_hafalan * ($weights['hafalan'] ?? 30)) +
                    ($result->nilai_wawancara * ($weights['wawancara'] ?? 20)) +
                    ($result->nilai_calistung * ($weights['calistung'] ?? 20)) +
                    ($result->nilai_tasmi * ($weights['tasmi'] ?? 15)) +
                    ($result->nilai_mandiri * ($weights['mandiri'] ?? 15))
                ) / 100;

                // Generate automatic narrative
                $scores = [
                    'hafalan' => $result->nilai_hafalan,
                    'wawancara' => $result->nilai_wawancara,
                    'calistung' => $result->nilai_calistung,
                    'tasmi' => $result->nilai_tasmi,
                    'mandiri' => $result->nilai_mandiri
                ];
                $result->catatan_otomatis = self::generateNarrative($scores, $config);
                $result->nilai_akhir = $nilaiAkhir;
                
                // Combine manual and automatic comments
                $manualNote = $result->catatan_manual ?: '';
                $result->catatan = $result->catatan_otomatis . ($manualNote ? "\n\nCatatan Penguji: " . $manualNote : "");
                $result->save();
            }

            // 2. Perform ranking & recommendations
            // Re-fetch sorted results
            $sortedResults = HasilWawancaraDanUjian::where('id_program', $program->id_program)
                ->orderBy('nilai_akhir', 'desc')
                ->get();

            $quota = $program->kuota_program ?: 10;

            foreach ($sortedResults as $index => $result) {
                $rank = $index + 1;
                
                // Find matching registration
                $pendaftaran = Pendaftaran::where('id_murid', $result->id_murid)->first();
                if ($pendaftaran) {
                    if ($rank <= $quota) {
                        $pendaftaran->status = 'Diterima di Program Pilihan';
                    } elseif ($result->nilai_akhir >= 60.0) {
                        $pendaftaran->status = 'Pindahkan ke Program Reguler';
                    } else {
                        $pendaftaran->status = 'Ditolak';
                    }
                    $pendaftaran->save();
                }
            }
        }
    }
}
