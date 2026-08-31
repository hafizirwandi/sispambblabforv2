<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Auth;

trait TracksUserActivity
{
    public static function bootTracksUserActivity(): void
    {
        static::creating(function ($model) {
            $model->created_by = Auth::id();
            $model->updated_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
