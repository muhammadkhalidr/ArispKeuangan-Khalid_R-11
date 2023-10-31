<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Http\Requests\StoreHutangRequest;
use App\Http\Requests\UpdateHutangRequest;
use App\Models\KasMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = Hutang::all();

        return view('hutang.index', [
            'title' => 'Hutang',
            'breadcrumb' => 'Hutang',
            'hutangs' => $data,
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
    public function store(StoreHutangRequest $request)
    {
        $validated = $request->validated();

        $hutang = new Hutang;

        $hutang->nama = $request->nama;
        $hutang->jumlah = $request->jumlah;
        $hutang->total = $request->total;
        $hutang->save();

        $kasMasuk = new KasMasuk;

        $kasMasuk->keterangan = "Hutang " . $request->nama;
        $kasMasuk->pengeluaran = $request->total;
        $kasMasuk->save();

        return redirect('hutang')->with('msg', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_hutang)
    {

        // $hutang = Hutang::findOrFail($id_hutang);

        // return view('hutang.index')->with([
        //     'id_hutang' => $id_hutang,
        //     'nama' => $hutang->nama,
        //     'jumlah' => $hutang->jumlah,
        //     'total' => $hutang->total,

        // ]);
    }

    public function bayarHutang(Request $request)
    {
        $request->validate([
            'id_hutang' => 'required|exists:hutangs,id_hutang',
            'jml_bayar' => 'required|numeric|min:0',
        ]);

        $id_hutang = $request->id_hutang;
        $jml_bayar = $request->jml_bayar;

        $hutang = Hutang::findOrFail($id_hutang);

        // Mengambil total hutang sebelumnya
        $total_hutang_sebelumnya = $hutang->total;

        if ($jml_bayar > $total_hutang_sebelumnya) {
            return redirect('hutang')->with('error', 'Jumlah pembayaran melebihi total hutang!');
        }

        DB::beginTransaction();

        try {
            // Mengurangi total hutang dengan jumlah pembayaran
            $hutang->total = $total_hutang_sebelumnya - $jml_bayar;
            $hutang->save();

            // Mencari entri kas_masuks yang terkait dengan hutang ini
            $kasMasuk = KasMasuk::where('keterangan', 'Hutang ' . $hutang->nama)->first();

            if ($kasMasuk) {
                // Jika entri ditemukan, update jumlah pemasukan (representasi pembayaran hutang)
                $kasMasuk->pemasukan += $jml_bayar;
                $kasMasuk->save();
            } else {
                // Jika entri tidak ditemukan, tambahkan entri baru ke tabel kas_masuks
                $newKasMasuk = new KasMasuk();
                $newKasMasuk->keterangan = 'Hutang ' . $hutang->nama;
                $newKasMasuk->pemasukan = $jml_bayar;
                $newKasMasuk->save();
            }

            DB::commit();

            return redirect('hutang')->with('msg', 'Pembayaran hutang berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('hutang')->with('error', 'Terjadi kesalahan, pembayaran dibatalkan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHutangRequest $request, $id_hutang)
    {
        $hutang = Hutang::findOrFail($id_hutang);

        $hutang->nama = $request->nama;
        $hutang->jumlah = $request->jumlah;
        $hutang->total = $request->total;
        $hutang->save();

        return redirect('hutang')->with('msg', 'Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_hutang)
    {
        $hutang = Hutang::findOrFail($id_hutang);
        $kasMasuk = KasMasuk::where('pengeluaran', $hutang->total)->first();

        $hutang->delete();
        $kasMasuk->delete();

        return redirect('hutang')->with('msg', 'Data Berhasil Dihapus!');
    }
}
