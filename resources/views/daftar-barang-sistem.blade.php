@extends('layouts.master-admin')

@section('content')
<br>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangSistemModal">
    Tambah Barang Sistem
</button>
<!-- Add Modal -->
<div class="modal fade" id="tambahBarangSistemModal" tabindex="-1" role="dialog" aria-labelledby="tambahBarangSistemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangSistemModalLabel">Tambah Barang Sistem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" action="{{ route('tambah-barang-sistem') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaBarang">Nama Barang</label>
                        <input type="text" class="form-control" name="namaBarang" required id="namaBarang">
                    </div>
                    <div class="form-group">
                        <label for="hargaBarang">Harga Barang</label>
                        <input type="number" class="form-control" required name="hargaBarang" id="hargaBarang">
                    </div>
                    <div class="form-group">
                        <label for="fotoBarang">Foto Barang</label>
                        <input type="file" name="fotoBarang" required id="fotoBarang" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Of Add Modal --}}

{{-- Edit Modal --}}
<div class="modal fade" id="editBarangSistemModal" tabindex="-1" role="dialog" aria-labelledby="editBarangSistemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangSistemModalLabel">Edit Barang Sistem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" action="{{ route('edit-barang-sistem') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="text" class="form-control" name="fotoBarangLama" hidden id="fotoBarangLamaEdit"> 
                    <div class="form-group">
                        <label for="idEdit">ID</label>
                        <input type="text" class="form-control" name="id" readonly id="idEdit">
                    </div>
                    <div class="form-group">
                        <label for="namaEdit">Nama Barang</label>
                        <input type="text" class="form-control" name="namaBarang" required id="namaBarangEdit">
                    </div>
                    <div class="form-group">
                        <label for="hargaBarangEdit">Harga Barang</label>
                        <input type="number" class="form-control" required name="hargaBarang" id="hargaBarangEdit">
                    </div>
                    <div class="form-group">
                        <label for="fotoBarangEdit">FotoBarang</label>
                        <input type="file" class="form-control" required name="fotoBarang" id="fotoBarangEdit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Of Edit Modal --}}

{{-- Delete Modal --}}
<div class="modal modal-danger fade" id="deleteBarangSistemModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteBarangSistemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBarangSistemModalLabel">Konfirmasi Hapus Barang Sistem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('hapus-barang-sistem') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h5 class="text-center"> Yakin akan menghapus barang ini?</h5>
                    <input type="hidden" name="id" id="idDelete" value="">
                </div>
                <div class="modal-footer">
                    <button button type="button" class="btn btn-secondary">Tidak</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
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
                <h3 class="card-title">Daftar Barang Sistem</h3>
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
                            <th>Nama Barang</th>
                            <th>Harga Barang</th>
                            <th>Foto Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangSistem as $item)
                            @php
                                $expiresAt = new \DateTime('tomorrow');
                                $imageReference = app('firebase.storage')->getBucket()->object($item['fotoBarang']);
                                if($imageReference->exists()){
                                    $image = $imageReference->signedUrl($expiresAt);
                                }                            
                            @endphp
                            <tr>
                                <td>{{ $item->id() }}</td>
                                <td>{{ $item['namaBarang'] }}</td>
                                <td>{{ $item['hargaBarang'] }}</td>
                                <td><img src="{{$image}}" style="width: 80px" alt=""></td>
                                <td>
                                    <button class="btn btn-info" data-toggle="modal" data-id="{{ $item->id() }}"
                                        data-namabarang="{{ $item['namaBarang'] }}"
                                        data-hargabarang="{{ $item['hargaBarang'] }}"
                                        data-fotobarang="{{ $item['fotoBarang'] }}"
                                        data-target="#editBarangSistemModal">Edit</button>
                                    /
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteBarangSistemModal"
                                        data-id="{{ $item->id() }}">Hapus</button>
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
