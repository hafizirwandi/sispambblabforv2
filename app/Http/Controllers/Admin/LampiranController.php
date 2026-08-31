<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\View\View;

class LampiranController extends Controller
{
    public function show(Surat $surat): View
    {
        $surat->load('fotoBb');

        return view('admin.lampiran.show', compact('surat'));
    }
}
