@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Laporan Ship Owner')

@section('content_header')
<h5 class="pl-3">LAPORAN SHIPOWNER</h5>
@endsection

@section('content')

@php
    $totalPercentage = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        9 => 0,
        8 => 0,
        10 => 0,
        11 => 0,
        12 => 0,
    ); 
    $cummulativePercentage = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        9 => 0,
        8 => 0,
        10 => 0,
        11 => 0,
        12 => 0,
    ); 
    $realisasi_total = \App\Models\Catatan\TransaksiProyek::where('id_perusahaan', Auth::user()->id_perusahaan)
    ->where('jenis2', 'Keluar');
@endphp
@if(!(is_null($curr_proyek)))
    @php $realisasi_total = $realisasi_total->where('id_proyek', $curr_proyek->id) @endphp
@endif
@php
    $realisasi_total = $realisasi_total->sum('jumlah');
@endphp
@php $realisasi_kantor = 0; @endphp
@php
    $biaya_all = $realisasi_total + $realisasi_kantor;
@endphp


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
                            <!-- <button class="btn btn-sm btn-primary" type="button" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-print">
                <div class="col">
                    <div class="float-right">
                        
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
            <!-- <input name="daterange" value="{{ $date_range ?? '-- pilih tanggal --' }}" type="text" style="width: 250px;" class="form-control  text-center"> -->
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <div class="dataTables_wrapper">
            <table id="table-laba-rugi-proyek"class="table table-striped table-bordered table-condensed table-sm dataTable">
                <thead class="thead-light">
                    <tr>
                        <th >Keterangan</th>
                        <!-- <th >Realisasi</th> -->
                        <th >Percentage</th>
                        <th >Month 1</th>
                        <th >Month 2</th>
                        <th >Month 3</th>
                        <th >Month 4</th>
                        <th >Month 5</th>
                        <th >Month 6</th>
                        <th >Month 7</th>
                        <th >Month 8</th>
                        <th >Month 9</th>
                        <th >Month 10</th>
                        <th >Month 11</th>
                        <th >Month 12</th>
                        <th >Total %</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($biayas as $biaya)
                    <tr>
                        <td>{{ $biaya->namaManajemen }}</td>
                        <!-- <td> -->
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
                        @php
                            $realisasi = $realisasi->sum('jumlah');
                        @endphp
                        <!-- </td> -->
                        @if($biaya_all == 0)
                        <td>
                            100%
                        </td>
                        @else
                        <td>
                            {{number_format($realisasi / $biaya_all * 100, 2 , '.' , ',')}}%
                        </td>
                        @endif
                        @php
                            $biaya_totalll = 0
                        @endphp
                        @for($i = 1; $i < 13 ; $i++)
                            @php
                                $biaya_totalll += $biaya->detail[$i]
                            @endphp
                            @if($biaya->detail[$i] == 0)
                                <td>{{$biaya->detail[$i]}} </td>
                            @elseif($realisasi == 0)
                            <td>
                                100%
                            </td>
                            @else
                            @php
                                if($realisasi != 0 && $biaya_all != 0)
                                $totalPercentage[$i] += $biaya->detail[$i] / $realisasi * 100 * $realisasi / $biaya_all * 100;
                            @endphp
                            <td>
                                {{number_format($biaya->detail[$i] / $realisasi * 100, 0 , '.' , ',')}}%
                            </td>
                            @endif
                        @endfor
                        @if($biaya_totalll == 0 && $realisasi != 0)
                            <td>0% </td>
                        @elseif($realisasi == 0)
                        <td>
                            100%
                        </td>
                        @else
                        <td>
                            {{number_format($biaya_totalll / $realisasi * 100, 0 , '.' , ',')}}%
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <tr>
                        <td class="right" ><b>Jumlah Biaya</b></td>
                        <td>100%</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><b>TOTAL PERCENTAGE (%)</b></td>
                        @foreach($totalPercentage as $totalP => $key) 
                            <td>{{number_format($key/100, 0 , '.' , ',')}}%</td>
                        @endforeach
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center"><b>CUMMULATIVE PERCENTAGE (%)</b></td>
                        @php
                            $totalkey = 0;
                        @endphp
                        @foreach($totalPercentage as $totalP => $key) 
                        @php
                            $totalkey += $key/100;
                            $cummulativePercentage[$totalP] = $totalkey;
                        @endphp
                            <td>{{number_format($totalkey, 0 , '.' , ',')}}%</td>
                        @endforeach
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h1>Cost vs Time S-Curve</h1>
        </div>
    </div>
    <canvas id="myChart" width="150"></canvas>
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
<script src="{{ asset('vendor/chart.js/Chart.js') }}"></script>
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
        $('#table-laba-rugi-proye').DataTable({
            'paging'      : false,
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

        // var date_range = $('input[name="daterange"]').val();

        // if(date_range == '-- pilih tanggal --') date_range = 'all';
        // else date_range = date_range.replaceAll('/', '-');

        var url = '/laporan_ship_owner/' + id_proyek ;
        window.location.href = url;

        console.log(url);
    }
    let labelss = []
    let valuee = []
    var words = <?php echo json_encode($cummulativePercentage) ?>;// don't use quotes
    $.each(words, function(key, value) {
        labelss.push(key)
        valuee.push(value)
        console.log('stuff : ' + key + ", " + value);
    });

    var canvas = document.getElementById('myChart');
    var data = {
        labels: labelss,
        datasets: [
            {
                label: "Cummulative Cost Percentage",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: valuee,
            }
        ]
    };

    var option = {
        showLines: true
    };
    var myLineChart = Chart.Line(canvas,{
        data:data,
    options:option
    });

</script>
@endsection