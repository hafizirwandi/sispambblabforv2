<?php

namespace App\Models;

use App\Models\Concerns\TracksUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surat extends Model
{
    use TracksUserActivity;

    public const STATUS_DRAFT = '0';
    public const STATUS_TERKIRIM = '1';
    public const STATUS_SELESAI = '2';

    protected $table = 'surat';
    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'no_surat',
        'id_bb',
        'id_pj',
        'tgl_surat',
        'tersangka',
        'lokasi_penangkapan',
        'waktu_penangkapan',
        'status',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
    ];

    public function barangBukti(): BelongsTo
    {
        return $this->belongsTo(BarangBukti::class, 'id_bb', 'id_bb');
    }

    public function penanggungJawab(): BelongsTo
    {
        return $this->belongsTo(PenanggungJawab::class, 'id_pj', 'id_pj');
    }

    public function fotoBb(): HasMany
    {
        return $this->hasMany(FotoBb::class, 'id_surat', 'id_surat');
    }

    public function tglSuratFormatted(): string
    {
        return $this->tgl_surat->locale('id')->translatedFormat('d F Y');
    }

    public function qrToken(): string
    {
        return base64_encode((string) $this->id_surat);
    }

    /**
     * Operator hanya mengisi no_surat + foto BB; field lain masih placeholder
     * (id_bb/id_pj = 0, tersangka/lokasi_penangkapan = '') sampai admin melengkapi.
     */
    public function isDataComplete(): bool
    {
        return (int) $this->id_bb !== 0
            && (int) $this->id_pj !== 0
            && $this->tersangka !== ''
            && $this->lokasi_penangkapan !== '';
    }
}
