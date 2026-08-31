<?php

namespace App\Models;

use App\Models\Concerns\TracksUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangBukti extends Model
{
    use TracksUserActivity;

    protected $table = 'barang_bukti';
    protected $primaryKey = 'id_bb';

    protected $fillable = ['nama'];

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'id_bb', 'id_bb');
    }
}
