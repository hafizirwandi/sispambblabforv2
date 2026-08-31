<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SuratService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageStorageController extends Controller
{
    public function __construct(private readonly SuratService $suratService)
    {
    }

    public function index(): View
    {
        return view('admin.manage-storage.index');
    }

    public function preview(Request $request): JsonResponse
    {
        [$fromDate, $toDate] = $this->resolveRange($request);

        return response()->json($this->suratService->countByPeriod($fromDate, $toDate));
    }

    public function destroy(Request $request): RedirectResponse
    {
        [$fromDate, $toDate] = $this->resolveRange($request);

        $deleted = $this->suratService->deleteByPeriod($fromDate, $toDate);

        return redirect()->route('admin.manage-storage.index')
            ->with('success', "Berhasil menghapus {$deleted} surat beserta barang bukti pada periode yang dipilih.");
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function resolveRange(Request $request): array
    {
        $data = $request->validate([
            'from_month' => ['required', 'integer', 'between:1,12'],
            'from_year' => ['required', 'integer', 'digits:4'],
            'to_month' => ['required', 'integer', 'between:1,12'],
            'to_year' => ['required', 'integer', 'digits:4'],
        ]);

        $from = \Illuminate\Support\Carbon::create($data['from_year'], $data['from_month'], 1)->startOfMonth();
        $to = \Illuminate\Support\Carbon::create($data['to_year'], $data['to_month'], 1)->endOfMonth();

        abort_if($from->gt($to), 422, 'Periode "dari" tidak boleh setelah periode "sampai".');

        return [$from->toDateString(), $to->toDateString()];
    }
}
