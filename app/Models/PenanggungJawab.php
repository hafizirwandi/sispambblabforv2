<?php

namespace App\Models;

use App\Models\Concerns\TracksUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenanggungJawab extends Model
{
    use TracksUserActivity;

    protected $table = 'penanggung_jawab';
    protected $primaryKey = 'id_pj';

    protected $fillable = ['nama', 'nrp', 'jabatan', 'ttd'];

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'id_pj', 'id_pj');
    }

    public function ttdUrl(): ?string
    {
        return $this->ttd ? asset('storage/ttd/'.$this->ttd) : null;
    }
}
