<?php

namespace App\Models;

use App\Models\Concerns\TracksUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoBb extends Model
{
    use TracksUserActivity;

    protected $table = 'foto_bb';
    protected $primaryKey = 'id_fb';

    protected $fillable = ['id_surat', 'foto'];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'id_surat', 'id_surat');
    }

    public function fotoUrl(): string
    {
        return asset('storage/foto_bb/'.$this->foto);
    }
}
