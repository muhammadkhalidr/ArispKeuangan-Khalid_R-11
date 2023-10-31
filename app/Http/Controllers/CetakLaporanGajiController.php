<?php

namespace App\Http\Controllers;

use App\Models\GajiKaryawan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CetakLaporanGajiController extends Controller
{
    public function index()
    {

        return view('laporan.gaji.cetak', [
            'title' => 'Laporan Gaji Karyawan',
            'breadcrumb' => 'Laporan',
        ]);
    }

    public function records_gaji(Request $request)
    {
        if ($request->ajax()) {

            if ($request->input('start_date') && $request->input('end_date')) {

                $start_date = Carbon::parse($request->input('start_date'));
                $end_date = Carbon::parse($request->input('end_date'));

                if ($end_date->greaterThan($start_date)) {
                    $gajis = GajiKaryawan::whereBetween('created_at', [$start_date, $end_date])->get();
                } else {
                    $gajis = GajiKaryawan::latest()->get();
                }
            } else {
                $gajis = GajiKaryawan::latest()->get();
            }

            return response()->json([
                'gajis' => $gajis
            ]);
        } else {
            abort(403);
        }
    }
}
