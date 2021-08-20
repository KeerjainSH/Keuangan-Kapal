@extends('adminlte::page')

@section('title', 'Gudang')

@section('content_header')
<div class="row">
    <div class="col-6">
        <h5 class="pl-3"><b>GUDANG</b></h5>
    </div>
    {{-- <div class="col-6">
        <input name="daterange" type="text" value="{{ $date_range ?? '-- pilih tanggal --' }}" style="width: 250px; height: 30px;" class="form-control text-center float-right">
    </div> --}}
</div>
@endsection

@section('content')
<div class="card">
    {{-- <div class="card-header bg-transparent">
        <div class="row">
            <div class="col-sm">
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Pemakaian Material</button></a>
                    @endif
                </div>
                <div class="col-sm">
                    <div class="d-flex justify-content-center">
                        <input name="daterange" value="{{ $date_range ?? '-- pilih tanggal --' }}" type="text" style="width: 250px;" class="form-control text-center">
                    </div>
                </div>
                <!-- <a href="#"><button type="button" class="btn btn-primary"><i class="fas fa-save"></i> Save</button></a> -->
            </div>
        </div>
    </div> --}}
    <div class="card-header bg-transparent">
        <div class="row">
            <div class="col-sm">
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah Pemakaian Material</button></a>
                </div>
                @endif
            </div>
            <div class="col-sm">
                <div class="d-flex justify-content-center">
                    <input name="daterange" value="{{ $date_range ?? '-- pilih tanggal --' }}" type="text" style="width: 250px;" class="form-control text-center">
                </div>
            </div>
            <div class="col-sm">
            </div>
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body" style="max-width: 1200px;">
        <div class="dataTables_wrapper">
            <table id="table1" class="table table-stripped table-hover dataTable table-condensed table-sm">
                <thead class="thead-light">
                    <th>Tanggal</th>
                    <th style="width: 10%">Id Proyek</th>
                    <th style="width: 40%">Nama Barang</th>
                    <th style="width: 30%">Satuan</th>
                    <th style="width: 20%">Jumlah</th>
                    <th style="width: 10%">Jenis</th>
                    <th style="width: 10%">Sisa</th>
                    <th style="width: 30%">Keterangan</th>
                    <th style="text-align: center">Aksi</th>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->tanggal_transaksi_gudang}}</td>
                        <td>{{$item->kode_proyek}}</td>
                        <td>{{$item->nama_material}}</td>
                        <td>{{$item->satuan_material}}</td>
                        <td>{{$item->jumlah}}</td>
                        <td>{{$item->jenis}}</td>
                        <td>{{$item->sisa}}</td>
                        <td>{{$item->keterangan}}</td>
                        <td>
                        <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal" data-target="#editModal{{$item->id}}"><i class="fas fa-pencil-alt" > </i></button>
                        <a href="{{ route('gudang.delete', ['id' => $item->id]) }}" class="btn btn-sm btn-link p-0 mx-1" onclick="return confirm('Apakah anda ingin menghapus data ini?')"><i class="fas fa-trash-alt" > </i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <div class="card-body mb-3">
                <div class="row">
                    <div class="col-12 h4">
                    Komentar
                    </div>
                    <div class="col-11">
                        {{$comment->comment}}
                    </div>
                    <div class="col-1">
                        @if(Auth::user()->role == 3)
                            <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal" data-target="#editCommentModal"><i class="fas fa-pencil-alt" > </i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCommentModalLabel">Edit Komentar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form id="edit-comment-transaksi" method="post" action="{{ route('insertComment',  ['place' => 6]) }}">
                        @csrf
                            <div class="form-group">
                                <label for="edit-komentar">Komentar</label>
                                <input autocomplete="off" type="text" id="edit-komentar" name="comment" class="form-control" value="{{$comment->comment}}" >
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="edit-comment-transaksi">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-footer -->
</div>

@if(Auth::user()->role == 1 || Auth::user()->role == 2)
<!-- Modal create gudang-->
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
                <form id="form-gudang" method="POST" action="{{route ('create_gudang')}}">
                    @csrf
                    <div class="form-group">
                        <label for="nama-akun">Tanggal</label>
                        <input id="daterange-form" name="tanggal_transaksi_gudang" value="01/01/2018" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang1">Nama Barang - id proyek - id transaksi</label>
                        <select class="form-control" id="nama_barang1" name="id_parent">
                            @foreach($inventoris as $inventori)
                            <option value="{{ $inventori->nama_barang.'-'.$inventori->id_proyek. '-' .$inventori->id_transaksi}}">{{$inventori->nama_barang." - ".$inventori->id_proyek. " - " .$inventori->id_transaksi}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input autocomplete="off" type="number" id="jumlah1" class="form-control" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan1" cols="30" rows="5" class="form-control" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-gudang">Save changes</button>
            </div>
        </div>
    </div>
</div>

@foreach ($items as $item)
{{-- Edit detail biaya --}}
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-transaksi{{$item->id}}" method="post" action="{{ route('gudang.edit', ['id' => $item->id]) }}">
                    @csrf
                    <input id="edit-id" name="id" type="hidden" class="form-control" value="{{$item->id}}">
                    <div class="form-group">
                        <label for="nama-akun">Tanggal</label>
                        <input id="daterange-edit" name="edit_tanggal_transaksi_gudang" type="text" class="form-control" value="{{date('d/m/Y',strtotime($item->tanggal_transaksi_gudang))}}">
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang - id proyek - id transaksi</label>
                        <select class="form-control" id="nama_barang" name="edit_id_parent" disabled>
                            @foreach($items as $inventori)
                            <option value="{{ $inventori->nama_material.'-'.$inventori->id_proyek. '-' .$inventori->id_transaksi}}"
                            @php
                                $cek = $inventori->nama_material;
                                if($cek == $item->nama_material){
                                    echo 'selected';
                                }
                            @endphp   >{{$inventori->nama_material." - ".$inventori->id_proyek. " - " .$inventori->id_transaksi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input autocomplete="off" type="number" id="jumlah" class="form-control" name="edit_jumlah" value="{{$item->jumlah}}">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="edit_keterangan" id="keterangan" cols="30" rows="5" class="form-control" >{{$item->keterangan}}</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="edit-transaksi{{$item->id}}">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach
@endif
@endsection

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
<style>
    .content {
        font-size: 12px;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        var role = <?php echo Auth::user()->role; ?>;

        if (role == 1) {
            $('table').SetEditable();
        }
        $('#table1').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            autoWidth: false,
            //            'scrollX': true,
            scrollY: 300,
            scrollCollapse: true,
        });
    });
    console.log('Hi!');
</script>
<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'center',
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
            },
        }, function(start, end, label) {
            start = start.format('DD-MM-YYYY');
            end = end.format('DD-MM-YYYY');
            var all = start + ' - ' + end;
            var url = '/gudang/' + encodeURIComponent(all);
            console.log(all);
            console.log(url);
            window.location.href = url;
            // console.log("A new date selection was made: " + start + ' to ' + end);
        });
        $('input[name="tanggal_transaksi_gudang"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: 'DD/MM/YYYY',
            }
        });
        $('input[name="edit_tanggal_transaksi_gudang"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: 'DD/MM/YYYY',
            }
        });
    });
</script>
<script src="{{ asset('js/bootstable-gudang.js') }}"></script>
@endsection