@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Laporan & Realisasi Anggaran Proyek')

@section('content_header')
<h5 class="pl-3">LAPORAN ANGGARAN & REALISASI PROYEK</h5>
@endsection

@section('content')
<style type="text/css" media="print">
   .no-print { display: none; }
</style>
<div class="card">
    <div class="card-header">
        <div class="text-center pt-3">
            <div class="row no-print">
                <div class="col-6">
                    <div class="float-left">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary" type="button" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-print">
                <div class="col">
                    <div class="float-right">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(is_null($curr_proyek))
                                    Semua Proyek
                                @else
                                {{ $curr_proyek->kode_proyek }}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right checkbox-menu">
                                <a class="dropdown-item {{ is_null($curr_proyek) ? 'active' : '' }}" style="font-size: 12px;" onclick="tes(this)">
                                Semua Proyek
                                </a>
                                @foreach($proyeks as $proyek)
                                @php
                                    $active = '';
                                @endphp
                                @if(!(is_null($curr_proyek)) && $curr_proyek->id == $proyek->id)
                                    @php $active = 'active'; @endphp
                                @endif
                                <a class="dropdown-item {{ $active }}" id="{{ $proyek->id }}" style="font-size: 12px;" onclick="tes(this)">
                                {{ $proyek->kode_proyek }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5>{{ $perusahaan->nama_perusahaan}}</h5>
                    <h6>Laporan Anggaran & Realisasi</h6>
                    @if(is_null($curr_proyek))
                    <h6>Semua Aktivitas</h6>
                    @else
                    <h6>{{$curr_proyek->jenis}}</h6>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <input name="daterange" value="{{ $date_range ?? '-- pilih tanggal --' }}" type="text" style="width: 250px;" class="form-control  text-center">
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <div class="dataTables_wrapper">
            <table id="table-laba-rugi-proyek"class="table table-striped table-bordered table-condensed table-sm dataTable">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 25%">Keterangan</th>
                        <th style="width: 18%">Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6"><b>Pendapatan</b></td>
                    </tr>
                    @foreach($pendapatans as $pendapatan)
                    <tr>
                        <td>{{$pendapatan->nama}}</td>
                        <!-- Kolom Anggaran -->
                        <td>
                        @php
                            $realisasi = \App\Models\Catatan\TransaksiProyek::with('proyek')
                                        ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                        ->where('id_akun_tr_proyek', $pendapatan->id)
                                        ->where('jenis2','Masuk')
                        @endphp
                        @if(!(is_null($curr_proyek)))
                            @php $realisasi = $realisasi->where('id_proyek', $curr_proyek->id) @endphp
                        @endif
                        @if(!(is_null($start_date)) && !(is_null($end_date)))
                            @php $realisasi = $realisasi->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                        @endif
                        @php
                            $realisasi = $realisasi->sum('terbayar');
                        @endphp
                        {{
                            number_format($realisasi, 2, '.', ',')
                        }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="right" ><b>Jumlah Pendapatan</b></td>
                        <td class="end-row">
                        @php
                            $pendapatan_all = \App\Models\Catatan\TransaksiProyek::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->where('jenis2', 'Masuk');
                        @endphp
                        @if(!(is_null($curr_proyek)))
                            @php $pendapatan_all = $pendapatan_all->where('id_proyek', $curr_proyek->id) @endphp
                        @endif
                        @if(!(is_null($start_date)) && !(is_null($end_date)))
                            @php $pendapatan_all = $pendapatan_all->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                        @endif
                        @php
                            $pendapatan_all = $pendapatan_all->sum('jumlah');
                        @endphp
                        {{
                            number_format($pendapatan_all, 2, '.', ',')
                        }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"><b>Biaya</b></td>
                    </tr>
                    @foreach($biayas as $biaya)
                    <tr>
                        <td>{{ $biaya->namaManajemen }}</td>
                        <td>
                        @php
                            $realisasi = \App\Models\Catatan\TransaksiProyek::where('id_perusahaan', Auth::user()->id_perusahaan)
                                        ->where('id_akun_tr_proyek', $biaya->id);
                        @endphp
                        @if(Auth::user()->role == 4)
                            @php
                            $realisasi = $realisasi->whereHas('proyek', function($query){
                                return $query->where('id_pemilik', Auth::user()->id);
                            })
                            @endphp
                        @endif
                        @if(!(is_null($curr_proyek)))
                            @php $realisasi = $realisasi->where('id_proyek', $curr_proyek->id) @endphp
                        @endif
                        @if(!(is_null($start_date)) && !(is_null($end_date)))
                            @php $realisasi = $realisasi->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                        @endif
                        @php
                            $realisasi = $realisasi->sum('jumlah');
                        @endphp
                        {{
                            number_format($realisasi, 2, '.', ',')
                        }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>Biaya Kantor</td>
                        <td>
                        @if(is_null($curr_proyek))
                            @php
                                $realisasi = \App\Models\Catatan\TransaksiKantor::where('id_perusahaan', Auth::user()->id_perusahaan);
                            @endphp
                            @if(!(is_null($start_date)) && !(is_null($end_date)))
                                @php $realisasi = $realisasi->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                            @endif
                            @php
                                $realisasi = $realisasi->sum('jumlah');
                            @endphp
                            {{
                                number_format($realisasi, 2, '.', ',')
                            }}
                        @else
                            {{
                                number_format(0, 2, '.', ',')
                            }}
                        @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="right" ><b>Jumlah Biaya</b></td>
                        <td class="end-row">
                        @php
                            $realisasi = \App\Models\Catatan\TransaksiProyek::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->where('jenis2', 'Keluar');
                        @endphp
                        @if(!(is_null($curr_proyek)))
                            @php $realisasi = $realisasi->where('id_proyek', $curr_proyek->id) @endphp
                        @endif
                        @if(!(is_null($start_date)) && !(is_null($end_date)))
                            @php $realisasi = $realisasi->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                        @endif
                        @php
                            $realisasi = $realisasi->sum('jumlah');
                        @endphp
                        @if(is_null($curr_proyek))
                            @php
                                $realisasi_kantor = \App\Models\Catatan\TransaksiKantor::where('id_perusahaan', Auth::user()->id_perusahaan);
                            @endphp
                            @if(!(is_null($start_date)) && !(is_null($end_date)))
                                @php $realisasi_kantor = $realisasi_kantor->whereBetween('tanggal_transaksi', [$start_date, $end_date]) @endphp
                            @endif
                            @php
                                $realisasi_kantor = $realisasi_kantor->sum('jumlah');
                            @endphp
                        @else
                            @php $realisasi_kantor = 0; @endphp
                        @endif
                        @php
                            $biaya_all = $realisasi + $realisasi_kantor;
                        @endphp
                        {{
                            number_format($biaya_all, 2, '.', ',')
                        }}
                        </td>
                    </tr>
                    <tr>
                        <td class="right"><b>Laba/Rugi</b></td>
                        <td class="end-row">
                            @php
                                $realisasi = $pendapatan_all - $biaya_all;
                            @endphp
                            {{ number_format($realisasi, 2, '.', ',') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->

    {{-- <div class="card-footer">
        <button onclick="window.print()" type="button" class="btn btn-sm btn-primary mr-2 "><i class="fas fa-print"></i> Cetak</button>
    </div> --}}
    <!-- /.card-footer -->
</div>
<!-- /.card -->
@endsection

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<style>
    .content {
        font-size: 12px;
    }
    td.right {
        float: right;
    }
    td.end-row {
        border-top: 2px solid;
    }
    .table td,
    .table th
    {
        text-align:left;
    }
    .table td + td,
    .table th + th
    {
        text-align:right
    }
    h5 {
        font-weight: 600;
    }
    .col h6
    {
        text-transform: uppercase;
    }
    .center-block {
        display: block;
        margin: auto;
    }
    .form-control {
        width: 160px;
    }
    .fa-arrow-alt-circle-up{
        color : green;
    }
    .fa-arrow-alt-circle-down{
        color : red;
    }
</style>
@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'center',
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function(start, end, label) {
            start = start.format('DD-MM-YYYY');
            end = end.format('DD-MM-YYYY');

            var id_proyek = $('.dropdown-menu').children('a.active').attr('id');
            id_proyek = id_proyek ? id_proyek : 'all';
            console.log(id_proyek);
            var date_range = start + ' - ' + end;
            var url = '/laba_rugi/' + id_proyek + '/' + encodeURIComponent(date_range);

            console.log(date_range);
            console.log(url);
            window.location.href = url;
            // console.log("A new date selection was made: " + start + ' to ' + end);
        });
    });
     $(document).ready(function() {
        $('#table-laba-rugi-proyek').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : false,
            'autoWidth'   : false
        });

    } );
    function tes(el){
        console.log('tes');
        var id_proyek =$(el).attr('id');
        id_proyek = id_proyek ? id_proyek : 'all';

        var date_range = $('input[name="daterange"]').val();

        if(date_range == '-- pilih tanggal --') date_range = 'all';
        else date_range = date_range.replaceAll('/', '-');

        var url = '/laba_rugi/' + id_proyek + '/' + encodeURIComponent(date_range);
        window.location.href = url;

        console.log(url);
    }
</script>
@endsection