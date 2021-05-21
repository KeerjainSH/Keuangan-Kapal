@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Transaksi Kantor')

@section('content_header')
<h5 class="pl-3"><b>MANAJEMEN PROYEK</b></h5>
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
                        </tr>
                    </thead>
                    <tbody >
                    <tr style="text-align: center">
                            <td>
                                Biaya Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
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
                        </tr>
                        <tr style="text-align: center">
                            <td>
                                Biaya Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Material Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                &nbsp &nbsp Biaya Mesin dan Perlengkapannya<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
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
                        </tr>
                        <tr style="text-align: center">
                            <td>
                                Biaya Tidak Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Material Langsung<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                            </td>
                            <td>
                                Biaya Konstruksi Kasko Kapal<button type="button" class="btn btn-sm px-1 mx-1" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></button>
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
                        </tr>
                    </tbody>
                </table>
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