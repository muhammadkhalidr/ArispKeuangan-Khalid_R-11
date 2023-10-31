{{-- @if (auth()->check())
    @if (auth()->user()->level == 1) --}}
@include('partials.header')
@include('partials.sidebar')

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $breadcrumb }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Orderan</h4>
                        <button type="button" class="btn btn-primary"
                            onclick="window.location='{{ url('orderan-baru') }}'">
                            <i class="fa fa-plus-circle"></i> Tambah Data Baru
                        </button>

                        <div class="pesan mt-2">
                            @if (session('msg'))
                                <div class="alert alert-primary alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                    </button> {{ session('msg') }}
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pemesan</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Total</th>
                                        <th>Jumlah Barang</th>
                                        <th>DP</th>
                                        <th>Sisa</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderans as $row)
                                        <tr>
                                            <th><span class="label label-info">{{ $loop->iteration }}</span>
                                            </th>
                                            <th>{{ $row->nama_pemesan }}</th>
                                            <th>{{ $row->nama_barang }}</th>
                                            <th>Rp. {{ number_format($row->harga_barang, 0, ',', '.') }}</th>
                                            <th>Rp. {{ number_format($row->jumlah_total, 0, ',', '.') }}</th>
                                            <th>{{ $row->jumlah_barang }} Pcs</th>
                                            <th>Rp. {{ number_format($row->uang_muka, 0, ',', '.') }}</th>
                                            <th>Rp. {{ number_format($row->sisa_pembayaran, 0, ',', '.') }}
                                            </th>
                                            <th>{{ $row->created_at }}</th>
                                            <th>
                                                <span
                                                    class="label {{ $row->keterangan == 'L' ? 'label-success' : 'label-warning' }}">
                                                    {{ $row->keterangan == 'L' ? 'Lunas' : 'Belum Lunas' }}
                                                </span>
                                            </th>
                                            <th>
                                                <button
                                                    onclick="window.location='{{ url('orderan/' . $row->id_keuangan) }}'"
                                                    class="btn btn-sm btn-info" title="Edit Data">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ 'orderan/' . $row->id_keuangan }}"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Data"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('orderan.print_invoice', $row->id_keuangan) }}"
                                                    class="btn btn-sm btn-primary mb-1" title="Print Invoice"
                                                    target="_blank">
                                                    <i class="fa fa-print"></i>
                                                </a>

                                            </th>
                                        </tr>
                                    @endforeach
                                <tfoot>
                                    <th colspan="4">Total</th>
                                    <th colspan="1">Rp. {{ number_format($total, 0, ',', '.') }}</th>
                                    <th></th>
                                    <th colspan="1">Rp. {{ number_format($totaldp, 0, ',', '.') }}</th>
                                    <th colspan="4">Rp. {{ number_format($totalsisa, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
@include('partials.footer')
{{-- @elseif (auth()->user()->level == 2)
        <script>
            window.location = "/home"
        </script>
    @endif
@endif --}}
