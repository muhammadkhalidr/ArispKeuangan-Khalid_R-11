<?php

namespace App\Http\Controllers;

use App\Models\Orderan;
use App\Http\Requests\StoreOrderanRequest;
use App\Http\Requests\UpdateOrderanRequest;
use App\Models\KasMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use PDF;
use PHPUnit\Framework\Constraint\LessThan;

class OrderanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $datas = Orderan::all();
        return view('orderan.data', [
            'title' => 'Data Orderan',
            'breadcrumb' => 'Data Orderan',
            'user' => $user,
            'orderans' => $datas,
            'total' => $datas->sum('jumlah_total'),
            'totaldp' => $datas->sum('uang_muka'),
            'totalsisa' => $datas->sum('sisa_pembayaran'),
        ]);
    }

    public function tambahOrderan()
    {
        $user = Auth::user();
        return view('orderan.tambah', [
            'title' => 'Tambah Orderan',
            'breadcrumb' => 'Orderan',
            'user' => $user,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderanRequest $request)
    {
        $validate = $request->validated();

        $orderans = new Orderan;
        $kasMasuk = new KasMasuk;

        $orderans->nama_pemesan = $request->txtnama;
        $orderans->nama_barang = $request->txtbarang;
        $orderans->harga_barang = $request->txtharga;
        $orderans->jumlah_barang = $request->txtjumlah;
        $orderans->jumlah_total = $request->txttotal;
        $orderans->keterangan = $request->txtket;
        $orderans->uang_muka = $request->txtdp;
        $orderans->sisa_pembayaran = $request->txtsisa;
        $orderans->save();

        if ($request->txtket === 'BL') {
            $kasMasuk->keterangan = $request->txtbarang;
            $kasMasuk->pemasukan = $request->txtdp;
        } elseif ($request->txtket === 'L') {
            $kasMasuk->keterangan = $request->txtbarang;
            $kasMasuk->pemasukan = $request->txttotal;
        }

        $kasMasuk->save();

        return redirect('orderan')->with('msg', 'Data Berhasil Ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id_keuangan)
    {
        $user = Auth::user();
        $orderan = Orderan::findOrFail($id_keuangan);

        return view('orderan.edit', data: [
            'title' => 'Edit Orderan',
            'breadcrumb' => 'Data Orderan',
            'user' => $user,
            ])->with([
            'txtid' => $id_keuangan,
            'txtnama' => $orderan->nama_pemesan,
            'txtbarang' => $orderan->nama_barang,
            'txtharga' => $orderan->harga_barang,
            'txtjumlah' => $orderan->jumlah_barang,
            'txttotal' => $orderan->jumlah_total,
            'txtket' => $orderan->keterangan,
            'txtdp' => $orderan->uang_muka,
            'txtsisa' => $orderan->sisa_pembayaran,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderanRequest $request, $id_keuangan)
    {
        $data = Orderan::findOrFail($id_keuangan);

        $data->nama_pemesan = $request->txtnama;
        $data->nama_barang = $request->txtbarang;
        $data->harga_barang = $request->txtharga;
        $data->jumlah_barang = $request->txtjumlah;
        $data->jumlah_total = $request->txttotal;
        $data->keterangan = $request->txtket;
        $data->uang_muka = $request->txtdp;
        $data->sisa_pembayaran = $request->txtsisa;
        $data->save();

        $kasMasuk = KasMasuk::where('keterangan', $data->nama_barang)->first();

        if ($kasMasuk) {
            if ($data->keterangan === 'BL') {
                $kasMasuk->pemasukan = $request->txtdp;
            } elseif ($data->keterangan === 'L') {
                $kasMasuk->pemasukan = $request->txttotal;
            }
            $kasMasuk->save();
        }

        return redirect('orderan')->with('msg', 'Data Berhasil Diubah!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_keuangan)
    {
        $orderan = Orderan::find($id_keuangan);

        if (!$orderan) {
            return redirect('orderan')->with('error', 'Data not found.');
        }

        $orderan->delete();

        return redirect('orderan')->with('msg', 'Data Berhasil Di-hapus!');
    }

    public function printInvoice($id_keuangan)
    {
        $orderan = Orderan::find($id_keuangan);
        if (!$orderan) {
            return abort(404);
        }

        $pdf = PDF::loadView('orderan.print_invoice', compact('orderan'));

        return $pdf->download($orderan->nama_pemesan . '' . 'invoice.pdf');
    }
}
