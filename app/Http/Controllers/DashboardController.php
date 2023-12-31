<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Models\Pengeluaran;
use App\Models\KasMasuk;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $filterDate = $request->date ?? now();

        $kasMasuks = KasMasuk::whereDate('created_at', $filterDate)
            ->select(DB::raw('SUM(pemasukan) as total_pendapatan'), DB::raw('SUM(pengeluaran) as total_pengeluaran'))
            ->first();

        $datas = Orderan::all();
        $pengeluaran = Pengeluaran::all();
        $pembelian = Pembelian::all();

        // Menghitung jumlah total dan uang muka berdasarkan keterangan
        $totalUangMuka = Orderan::where('keterangan', 'BL')->sum('uang_muka');
        $totalJumlahTotal = Orderan::where('keterangan', 'BL')->sum('jumlah_total');

        // Menghitung jumlah total berdasarkan keterangan Lunas
        $totalJumlahTotalLunas = Orderan::where('keterangan', 'L')->sum('jumlah_total');

        $kasKeluar = $pengeluaran->sum('total') + $pembelian->sum('total');

        return view('layout.home', [
            'totalOrderan' => $datas->count(),
            'totalPendapatan' => $totalUangMuka + $totalJumlahTotalLunas,
            'totalPengeluaran' => $kasKeluar,
            'title' => 'Dashboard | Home',
            'user' => $user,
            'totalPendapatanG' => $kasMasuks->total_pendapatan ?? 0,
            'totalPengeluaranG' => $kasMasuks->total_pengeluaran ?? 0,
            'filterDate' => $filterDate,


        ]);
    }
}
