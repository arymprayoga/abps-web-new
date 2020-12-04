@extends('layouts.master-admin')

@section('content')
<br>
{{-- Verifikasi Modal --}}
<div class="modal modal-danger fade" id="verifikasiPembeliModal" tabindex="-1" role="dialog"
    aria-labelledby="verifikasiPembeliModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiPembeliModalLabel">Konfirmasi Verifikasi Pembeli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('verifikasi-pembeli') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h5 class="text-center"> Yakin akan memverifikasi pembeli ini?</h5>
                    <input type="hidden" name="id" id="idVerifikasi" value="">
                </div>
                <div class="modal-footer">
                    <button button type="button" class="btn btn-secondary">Tidak</button>
                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Of Delete Modal --}}

<br><br>
<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <form action="{{route('user.search-admin') }}" method="get">
            <div class="card-header">
                <h3 class="card-title">Daftar Admin</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            </form> --}}
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status Verifikasi</th>
                            <th>Lokasi</th>
                            <th>No Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembeli as $item)
                            <tr>
                                <td>{{ $item->id() }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['statusVerifikasi'] }}</td>
                                <td>{{ $item['lokasi']->latitude().' , '.$item['lokasi']->longitude() }}
                                </td>
                                <td>{{ $item['noTelp'] }}</td>
                                <td>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#verifikasiPembeliModal"
                                        data-id="{{ $item->id() }}">Verifikasi</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="container">
            {{-- {{$admin->links() }} --}}
        </div>
    </div>
</div>
@endsection
