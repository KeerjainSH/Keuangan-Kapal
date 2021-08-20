@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Hutang Piutang')

@section('content_header')
<h5 class="pl-3"><b>HUTANG PIUTANG</b></h5>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Rincian Piutang</h5>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <div class="dataTables_wrapper">
            <table id="table-piutang" class="table table-bordered table-condensed table-sm dataTable">
            <thead class="thead-light">
                <tr>
                    <th>Proyek</th>
                    <th>Konsumen</th>
                    <th>Pemasok</th>
                    <th>Transaksi</th>
                    <th>Diterima</th>
                    <th>Piutang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($piutangs as $piutang)
                <tr>
                    <td>{{$piutang->proyek->jenis ?? ''}}</td>
                    <td>{{$piutang->proyek->user->name ?? ''}}</td>
                    <td>{{$piutang->pemasok->nama ?? ''}}</td>
                    <td>{{ number_format($piutang->jumlah, 2, '.', ',') }}</td>
                    <td>{{ number_format($piutang->terbayar, 2, '.', ',') }}</td>
                    <td>{{ number_format($piutang->sisa, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
                <tr>
                    <!--<td></td>-->
                    <td colspan="3" class="font-weight-bold">Jumlah</td>
                    <td class="font-weight-bold">{{ number_format($piutang_sum->jumlah, 2, '.', ',') }}</td>
                    <td class="font-weight-bold">{{ number_format($piutang_sum->terbayar, 2, '.', ',') }}</td>
                    <td class="font-weight-bold">{{ number_format($piutang_sum->sisa, 2, '.', ',') }}</td>
                </tr>
            </table>    
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-header">
        <h5>Rincian Utang</h5>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <div class="dataTables_wrapper">
            <table id="table-utang" class="table table-bordered table-condensed table-sm dataTable">
            <thead class="thead-light">
                <tr>
                    <th>Proyek</th>
                    <th>Konsumen</th>
                    <th>Pemasok</th>
                    <th>Transaksi</th>
                    <th>Dibayar</th>
                    <th>Utang</th>
                </tr>
            </thead>
            <tbody>
                @foreach($utangs as $utang)
                <tr>
                    <td>{{$utang->proyek->jenis ?? ''}}</td>
                    <td>{{$utang->proyek->user->name ?? ''}}</td>
                    <td>{{$utang->pemasok->nama ?? ''}}</td>
                    <td>{{ number_format($utang->jumlah, 2, '.', ',') }}</td>
                    <td>{{ number_format($utang->terbayar, 2, '.', ',')}}</td>
                    <td>{{ number_format($utang->sisa, 2, '.', ',')}}</td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="3" class="font-weight-bold">Jumlah</td>
                <td class="font-weight-bold">{{ number_format($utang_sum->jumlah, 2, '.', ',') }}</td>
                <td class="font-weight-bold">{{ number_format($utang_sum->terbayar, 2, '.', ',') }}</td>
                <td class="font-weight-bold">{{ number_format($utang_sum->sisa, 2, '.', ',') }}</td>
            </tr>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="card-body">
                <div class="row">
                    <div class="col-12 h6">
                        <b>
                            Komentar
                        </b>
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
                    <form id="edit-comment-transaksi" method="post" action="{{ route('insertComment',  ['place' => 5]) }}">
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
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .content {
        font-size: 12px;
    }
    * {
        box-sizing: border-box;
    }

    .row {
        margin-left: -5px;
        margin-right: -5px;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th,
    td {
        text-align: left;
        padding: 16px;
    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other on screens that are smaller than 600 px */
    @media screen and (max-width: 600px) {
        .column {
            width: 100%;
        }
    }
</style>
@endsection

@section('js')
<script type="text/javascript">
     $(document).ready(function() {
        $('#table-piutang').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false
        });
    } );
     $(document).ready(function() {
        $('#table-utang').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false
        });
    } );
</script> 
@endsection