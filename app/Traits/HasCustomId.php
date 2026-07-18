<?php

namespace App\Traits;

trait HasCustomId
{
    /**
     * Boot the trait and register a creating event
     * to auto-generate a varchar primary key with the format:
     * [PREFIX][0001] — e.g. PMB0001, PRG0001, PDF0001
     */
    public static function bootHasCustomId()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $prefix = $model->getPrefix();
                $keyName = $model->getKeyName();

                $last = static::where($keyName, 'LIKE', $prefix . '%')
                    ->orderBy($keyName, 'desc')
                    ->first();

                if ($last) {
                    $lastNum = intval(substr($last->getKey(), strlen($prefix)));
                    $nextNum = $lastNum + 1;
                } else {
                    $nextNum = 1;
                }

                $model->{$keyName} = $prefix . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Indicate that the model's primary key is not auto-incrementing.
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Return the type of the primary key.
     */
    public function getKeyType()
    {
        return 'string';
    }
}
