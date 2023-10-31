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
                        <h4 class="card-title">Data Pengeluaran</h4>
                        <button type="button" class="btn btn-primary"
                            onclick="window.location='{{ url('pengeluaranbaru') }}'">
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
                                        <th>Keterangan</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengeluarans as $row)
                                        <tr>
                                            <th><span class="label label-info">{{ $loop->iteration }}</span></th>
                                            <th>{{ $row->keterangan }}</th>
                                            <th>{{ $row->jumlah }}</th>
                                            <th>Rp. {{ number_format($row->harga, 0, ',', '.') }}</th>
                                            <th>Rp. {{ number_format($row->pengeluaran, 0, ',', '.') }}</th>
                                            <th>{{ $row->created_at }}</th>
                                            <th>
                                                <form method="POST"
                                                    action="{{ 'pengeluaran/' . $row->id_pengeluaran }}"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Data"
                                                        class="btn btn-sm btn-danger hapus-btn"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </th>
                                        </tr>
                                    @endforeach

                                <tfoot>
                                    <tr>
                                        {{-- <th colspan="4">Total</th>
                                        <th colspan="1">Rp. {{ number_format($total, 0, ',', '.') }}</th>
                                        <th></th>
                                        <th colspan="1">Rp. {{ number_format($totaldp, 0, ',', '.') }}</th>
                                        <th colspan="4">Rp. {{ number_format($totalsisa, 0, ',', '.') }}</th> --}}
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
