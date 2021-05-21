@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Pendapatan')

@section('content_header')
<h5 class="pl-3"><b>Pendapatan</b></h5>
@endsection

@section('content')
<!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if(!empty(Auth::user()->id_perusahaan))
<div class="card">
    {{-- <div class="card-header">
        <div class="row">
            <div class="col-sm">
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button></a>
                </div>
                @endif
            </div>
        </div>
    </div> --}}
    <!-- /.card-header -->

    <div class="card-body ">
        <div class="dataTables_wrapper">
            <table id="myTable" class="display table table-stripped table-hover table-condensed table-sm dataTable">
                <thead>
                    <tr style="text-align: center">
                        <th scope="col">Tes</th>
                        <th scope="col">Tes</th>
                        <th scope="col">Tes</th>
                        <th scope="col">Jenis Proyek</th>
                        <th scope="col">Pendapatan</th>
                        <th scope="col">Pendapatan Proyek</th>
                        <!-- <th scope="col">Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center">
                        <td>
                            Proyek ABC
                        </td>
                        <td>
                            Pendapatan
                        </td>
                        <td>
                            &nbsp &nbsp Pendapatan Proyek
                        </td>
                        <td>

                        </td>
                        <td>
                            Rp 2.000.000
                        </td>
                        <td>
                            Rp 2.000.000
                        </td>
                        <!-- <td>
                            <a href="{{ route('management_projek.pendapatan.show', ['id_projek' => 1,'id_pendapatan' => 1]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-eye" > </i></a>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
    </div>
    <!-- /.card-footer -->
</div>
@endif
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
.content {
    font-size: 12px;
}
</style>
<meta name="csrf-token" content="{{ Session::token() }}">
@endsection

@section('js')
<script src="https://unpkg.com/autonumeric"></script>
<script type="text/javascript">
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

<script src="{{ asset('js/bootstable-list-proyek.js') }}"></script>

@endsection