@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Biaya Projek')

@section('content_header')
<h5 class="pl-3"><b>BIAYA PROYEK</b></h5>
@endsection

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
<style>
.content {
    font-size: 12px;
}
</style>
<!-- <meta name="csrf-token" content="{{ Session::token() }}"> -->
@endsection

@section('content')
<!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if(!empty(Auth::user()->id_perusahaan))
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm">
                    <div class="row justify-content-start pl-2 pt-2">
                        <a href="{{ route('list_proyek') }}"><button type="button" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body ">
                <table id="myTable" class="display table table-stripped table-hover table-condensed table-sm dataTable" style="width:100%">
                    <thead>
                        <tr style="text-align: center">
                            {{-- <th scope="col">Aksi</th> --}}
                            <th scope="col">Tes</th>
                            <th scope="col">Tes</th>
                            <th scope="col">Tes</th>
                            <th scope="col">Kode Proyek</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Ukuran</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Volume</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody >
                    <tr style="text-align: center">
                            <td>
                                Biaya Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Material Langsung<button type="button" class="btn btn-sm px-1 mx-1"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                &nbsp &nbsp Biaya Konstruksi Kasko Kapal<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#contohModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td >

                            </td>
                            <td >
                                Kayu Lunas
                            </td>
                            <td>
                                0.20 x 0.20 x 16 m
                            </td>
                            <td>
                                Meranti/Seumantok
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                Batang
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal" data-target="#editModal"><i class="fas fa-pencil-alt" > </i></button>
                                <button id="bElim" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-trash-alt" > </i></button>
                            </td>
                        </tr>
                        <tr style="text-align: center">
                            <td>
                                Biaya Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Material Langsung<button type="button" class="btn btn-sm px-1 mx-1"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                &nbsp &nbsp Biaya Mesin dan Perlengkapannya<button type="button" class="btn btn-sm px-1 mx-1"><i class="fas fa-plus"></i></button>
                            </td>
                            <td >

                            </td>
                            <td >
                                Kayu Belum Lunas
                            </td>
                            <td>
                                0.20 x 0.20 x 16 m
                            </td>
                            <td>
                                Meranti/Seumantok
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                Batang
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-pencil-alt" > </i></button>
                                <button id="bElim" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-trash-alt" > </i></button>
                            </td>
                        </tr>
                        <tr style="text-align: center">
                            <td>
                                Biaya Tidak Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Material Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                &nbsp &nbsp Biaya Konstruksi Kasko Kapal<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td >
                            </td>
                            <td >
                                Kayu Sudah Lunas
                            </td>
                            <td>
                                0.20 x 0.20 x 16 m
                            </td>
                            <td>
                                Meranti/Seumantok
                            </td>
                            <td>
                                1
                            </td>
                            <td>
                                Batang
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                Rp 1,600,000.00
                            </td>
                            <td>
                                <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-pencil-alt" > </i></button>
                                <button id="bElim" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-trash-alt" > </i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                <form id="add-transaksi" method="post" action="{{ route('list_proyek') }}">
                    @csrf
                    <div class="form-group">
                        <label for="jenis-akun">Biaya</label>
                        <select class="form-control" id="jenis-status" name="jenis_status" required>
                        <option disabled selected value> -- pilih biaya -- </option>
                        <option value="Biaya Langsung">Biaya Langsung</option>
                        <option value="Biaya Tidak Langsung">Biaya Tidak Langsung</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis-akun">Jenis Biaya</label>
                        <select class="form-control" id="jenis-status" name="jenis_status" required>
                        <option disabled selected value> -- pilih jenis biaya -- </option>
                        <option value="Biaya Langsung">Biaya Langsung</option>
                        <option value="Biaya Tidak Langsung">Biaya Tidak Langsung</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="kodeproyek">Nama Biaya</label>
                        <input autocomplete="off" type="text" id="kodeproyek" name="kodeproyek" class="form-control">
                    </div>
                </form>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="add-transaksi">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contohModal" tabindex="-1" role="dialog" aria-labelledby="contohModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contohModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                <form id="add-transaksi" method="post" action="{{ route('list_proyek') }}">
                    @csrf
                    <div class="form-group">
                        <label for="edit-keterangan">Keterangan</label>
                        <input autocomplete="off" type="text" id="edit-keterangan" name="keterangan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-ukuran">Pendapatan Proyek</label>
                        <input autocomplete="off" type="number" id="edit-ukuran" name="ukuran" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-jenis">Jenis</label>
                        <input autocomplete="off" type="text" id="edit-jenis" name="jenis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-volume">Volume</label>
                        <input autocomplete="off" type="text" id="edit-volume" name="volume" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-satuan">Satuan</label>
                        <input autocomplete="off" type="text" id="edit-satuan" name="satuan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit-hargasatuan">Harga Satuan</label>
                        <input autocomplete="off" type="number" id="edit-hargasatuan" name="hargasatuan" class="form-control">
                    </div>
                </form>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="add-transaksi">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit detail biaya --}}
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Biaya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-transaksi" method="post" action="{{ route('update_list_proyek') }}">
                            @csrf
                            <input id="edit-id" name="id" type="hidden" class="form-control">
                            <div class="form-group">
                                <label for="edit-keterangan">Keterangan</label>
                                <input autocomplete="off" type="text" id="edit-keterangan" name="keterangan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-ukuran">Pendapatan Proyek</label>
                                <input autocomplete="off" type="number" id="edit-ukuran" name="ukuran" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-jenis">Jenis</label>
                                <input autocomplete="off" type="text" id="edit-jenis" name="jenis" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-volume">Volume</label>
                                <input autocomplete="off" type="text" id="edit-volume" name="volume" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-satuan">Satuan</label>
                                <input autocomplete="off" type="text" id="edit-satuan" name="satuan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="edit-hargasatuan">Harga Satuan</label>
                                <input autocomplete="off" type="number" id="edit-hargasatuan" name="hargasatuan" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="edit-transaksi">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable( {

            order: [[0, 'asc'], [1, 'asc'], [2, 'asc']],
            rowGroup: {
                dataSrc: [ 0, 1, 2 ] //parents
            },
            columnDefs: [ {
                targets: [ 0, 1, 2], //hiden header coloum (dibalik" sama aja)
                visible: false
            } ]
        } );
    } );
</script>
@endsection