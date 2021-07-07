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
    <div class="card-header">
        <div class="row">
            <div class="col-sm">
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="{{ route('list_proyek') }}"><button type="button" class="btn btn-sm btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Pendapatan</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
                        <th scope="col">Jenis Proyek</th>
                        <th scope="col">Nama Pendapatan</th>
                        <th scope="col">Pendapatan Proyek</th>
                        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                        <th scope="col">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($akunTransaksiProjeks as $projeks)
                    <tr style="text-align: center">
                        <td>
                            Pendapatan
                        </td>
                        <td>
                            {{ $projeks->nama }}
                        </td>
                        <td>
                            {{
                                number_format($projeks->nominal, 2, '.', ',')
                            }}
                            {{-- {{ $projeks->nominal }} --}}
                        </td>
                        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                        <td>
                            <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal" data-target="#editModal{{$projeks->id}}"><i class="fas fa-pencil-alt" > </i></button>
                            <a href="{{ route('management_projek.pendapatan.delete', ['id_proyek' => $id_proyek, 'id' => $projeks->id]) }}" class="btn btn-sm btn-link p-0 mx-1" onclick="return confirm('Apakah anda ingin menghapus data ini?')"><i class="fas fa-trash-alt" > </i></a>
                            {{-- <button id="bElim" type="button" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-trash-alt" > </i></button> --}}
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-body ">
        <div class="mx-auto float-right"><strong>Total Pendapatan Proyek</strong>
            <p class="mx-3">&nbsp {{number_format($akunTransaksiProjeks->sum('nominal'), 2, '.', ',')}}</p>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Jenis Biaya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
            <form id="add-transaksi" method="post" action="{{ route('management_projek.pendapatan.insertPendapatan',['id_proyek' => $id_proyek]) }}">
                @csrf
                <div class="form-group">
                    <label for="namaPendapatan">Nama Pendapatan</label>
                    <input autocomplete="off" type="text" id="namaPendapatan" name="namaPendapatan" class="form-control">
                </div>
                <div id="jenis_neraca" class="form-group">
                    <label>Jenis Neraca</label>
                    <select class="form-control" name="jenis_neraca">
                    <option value="Aset Lancar">Aset Lancar</option>
                    <option value="Aset Tetap">Aset Tetap</option>
                    <option value="Kewajiban Lancar">Kewajiban Lancar</option>
                    <option value="Kewajiban Panjang">Kewajiban Jangka Panjang</option>
                    <option value="Ekuitas">Ekuitas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlahPendapatan">Jumlah Pendapatan</label>
                    <input autocomplete="off" type=number step=0.001 id="jumlahPendapatan" name="jumlahPendapatan" class="form-control">
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
    <!-- /.card-body -->
    @foreach ($akunTransaksiProjeks as $projeks)
    <div class="modal fade" id="editModal{{$projeks->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pendapatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-transaksi{{$projeks->id}}" method="post" action="{{ route('management_projek.pendapatan.edit',['id_proyek' => $id_proyek]) }}">
                        @csrf
                        <input id="edit-id" name="id" type="hidden" class="form-control" value="{{$projeks->id}}">
                        <div class="form-group">
                            <label for="edit-namapendapatan">Nama Pendapatan</label>
                            <input autocomplete="off" type="text" id="edit-namapendapatan" name="namapendapatan" class="form-control" value="{{$projeks->nama}}">
                        </div>
                        <div class="form-group">
                            <label for="edit-pendapatanproyek">Pendapatan Proyek</label>
                            <input autocomplete="off" type="number" id="edit-pendapatanproyek" name="pendapatanproyek" class="form-control" value="{{$projeks->nominal}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="edit-transaksi{{$projeks->id}}">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
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
                    dataSrc: [ 0 ] //parents
                },
                columnDefs: [ {
                    targets: [ 0 ], //hiden header coloum (dibalik" sama aja)
                    visible: false
                } ]
            } );
        } );
</script>

<script src="{{ asset('js/bootstable-list-proyek.js') }}"></script>

@endsection