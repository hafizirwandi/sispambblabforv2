<?php

namespace App\Http\Controllers;

use App\Models\BarangBukti;
use App\Models\PenanggungJawab;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $stats = [
                'menunggu' => Surat::where('status', Surat::STATUS_TERKIRIM)->count(),
                'selesai' => Surat::where('status', Surat::STATUS_SELESAI)->count(),
                'barang_bukti' => BarangBukti::count(),
                'penanggung_jawab' => PenanggungJawab::count(),
            ];

            return view('dashboard.admin', compact('stats'));
        }

        $stats = [
            'draft' => Surat::where('status', Surat::STATUS_DRAFT)->where('created_by', $user->id)->count(),
            'terkirim' => Surat::where('status', Surat::STATUS_TERKIRIM)->where('created_by', $user->id)->count(),
        ];

        return view('dashboard.operator', compact('stats'));
    }
}
