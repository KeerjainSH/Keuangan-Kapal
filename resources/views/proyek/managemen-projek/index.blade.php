@extends('adminlte::page')

@section('title', 'Keuangan Kapal | Management Proyek')

@section('content_header')
<h5 class="pl-3"><b>MANAGEMENT PROYEK</b></h5>
@endsection

@section('content')
<!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if(!empty(Auth::user()->id_perusahaan))
<div class="card">
    <div class="card-header">
        <!-- <div class="row">
            <div class="col-sm">
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button></a>
                </div>
                @endif
            </div>
        </div> -->
    </div>
    <!-- /.card-header -->

    <div class="card-body ">
        <div class="dataTables_wrapper">
            <table id="table-transaksi-kantor" class="display table table-stripped table-hover table-condensed table-sm dataTable">
                <thead>
                    <tr>
                        <th scope="col">Management projek</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Pendapatan
                        </td>
                        <td>
                            <a href="{{ route('management_projek.pendapatan.index', ['id_projek' => 1]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-eye" > </i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Biaya Langsung
                        </td>
                        <td>
                            <a href="{{ route('management_projek.jenis.index', ['id_projek' => 1,'flag' => 1]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-eye" > </i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Biaya Tidak Langsung
                        </td>
                        <td>
                            <a href="{{ route('management_projek.jenis.index', ['id_projek' => 1,'flag' => 2]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-eye" > </i></a>
                        </td>
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
    const pemilik=document.getElementById('nama-pemilik');
    //console.log(pemilik);
    pemilik.addEventListener('change', (e)=>{
        $.ajax({
            url: '{{route("get_perusahaan")}}',
            data: {
                '_token':"{{csrf_token()}}",
                'id':e.srcElement.value
            },
            error: function(xhr,status,error) {

            },
            success: function(data) {
                let newOption = '<option disabled selected value> -- pilih perusahaan -- </option>';
                newOption+=`<option value=${data.id}>${data.nama_perusahaan}</option>`
                const perusahaan = document.querySelector('#nama-perusahaan');
                perusahaan.innerHTML = newOption;
            },
            type: 'POST',
            async: true
        });
    })
    $(document).ready(function() {
        var role = <?php echo Auth::user()->role; ?>;

        if(role == 1)
        {
            $('table').SetEditable();
        }

        if(role == 1 || role == 2)
        {
            new AutoNumeric('#jumlah-transaksi');
        }

        var columnDefs = [];
        if(role == 1){
            columnDefs = [
                { "width": "20px", "targets": [4,5,6,8,9,13] },
                { "targets": [2, 3, 4, 5, 6, 7, 8], "orderable": false }
            ]
        }
        else{
            columnDefs = [
                { "width": "20px", "targets": [3,4,5,7,8,12] },
                { "targets": [1, 2, 3, 4, 5, 6, 7], "orderable": false }
            ]
        }

        $('#table-transaksi-kantor').DataTable({
            'columnDefs': columnDefs,
            'paging': false,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': false,
            'scrollY': 700,
            'scrollCollapse': true,
        });
    });
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
            var url = '/transaksi_kantor/' + encodeURIComponent(all);
            console.log(all);
            console.log(url);
            window.location.href = url;
            // console.log("A new date selection was made: " + start + ' to ' + end);
        });
        $('input[name="tgl_transaksi"]').daterangepicker({
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

<script src="{{ asset('js/bootstable-list-proyek.js') }}"></script>

@endsection