@extends('layout.main')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center mb-4">
                            <img class="mr-3" src="{{ asset('/') }}assets/images/avatar/1.png" width="80"
                                height="80" alt="">
                            <div class="media-body">
                                @foreach ($data as $user)
                                    <h3 class="mb-0">{{ $user->name }}</h3>
                                @endforeach
                            </div>
                        </div>
                        <div class="pesan mt-2">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{ session('success') }}
                                </div>
                            @endif
                        
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        @foreach ($data as $item)   
                        <ul class="card-profile__info">
                            <li class="mb-1"><strong class="text-dark mr-4">Username</strong> <span>{{ $item->username }}</span>
                            </li>
                            <li><strong class="text-dark mr-4">Email</strong> <span>{{ $item->email }}</span></li>
                        </ul>
                        @endforeach
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modalUbahPw"><i class="fa fa-cog"></i> Ubah Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Hutang -->
    <div class="modal fade" id="modalUbahPw">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" class="form-control" name="passwordLama">
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control" name="passwordBaru">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="konfirmasiPassword">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- #/ container -->
