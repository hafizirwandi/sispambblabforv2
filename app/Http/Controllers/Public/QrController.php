<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\View\View;

class QrController extends Controller
{
    public function show(string $token): View
    {
        $id = base64_decode($token, true);

        abort_unless($id !== false && ctype_digit($id), 404);

        $surat = Surat::with('fotoBb')->findOrFail((int) $id);

        return view('public.qr', compact('surat'));
    }
}
