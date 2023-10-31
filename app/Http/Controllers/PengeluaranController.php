<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Requests\StorePengeluaranRequest;
use App\Http\Requests\UpdatePengeluaranRequest;
use App\Models\KasMasuk;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $pengeluarans = Pengeluaran::join('kas_masuks', 'pengeluarans.total', '=', 'kas_masuks.pengeluaran')
            ->select('pengeluarans.id_pengeluaran', 'pengeluarans.keterangan', 'pengeluarans.jumlah', 'pengeluarans.harga', 'kas_masuks.pengeluaran', 'kas_masuks.id', 'kas_masuks.created_at',)
            ->get();
        return view('pengeluaran.data', [
            'title' => 'Data Pengeluaran',
            'breadcrumb' => 'Pengeluaran',
            'user' => $user,
            'pengeluarans' => $pengeluarans,
        ]);
    }

    public function tambahPengeluaran()
    {
        $user = Auth::user();
        return view('pengeluaran.tambah', [
            'title' => 'Pengeluaran',
            'breadcrumb' => 'Pengeluaran',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengeluaranRequest $request)
    {
        $validate = $request->validated();

        $pengeluaran = new Pengeluaran;
        $kasMasuk = new KasMasuk;
        $pengeluaran->keterangan = $request->txtket;
        $pengeluaran->jumlah = $request->txtjumlah;
        $pengeluaran->harga = $request->txtharga;
        $pengeluaran->total = $request->txttotal;
        $pengeluaran->save();

        $kasMasuk->keterangan = $request->txtket;
        $kasMasuk->pengeluaran = $request->txttotal;
        $kasMasuk->save();

        return redirect('pengeluaran')->with('msg', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengeluaranRequest $request, Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengeluaran)
    {
        $pengeluaran = Pengeluaran::findOrFail($id_pengeluaran);
        $kasMasuk = KasMasuk::where('pengeluaran', $pengeluaran->total)->first();

        $pengeluaran->delete();
        $kasMasuk->delete();

        return redirect('pengeluaran')->with('msg', 'Data Berhasil Dihapus!');
    }
}
