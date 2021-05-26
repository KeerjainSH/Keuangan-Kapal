@extends('adminlte::page')

@section('title', 'Keuangan Kapal | List Proyek')

@section('content_header')
<h5 class="pl-3"><b>LIST PROYEK</b></h5>
@endsection

@section('content')
<!-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if(!empty(Auth::user()->id_perusahaan))
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm">
                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                <div class="row justify-content-start pl-2 pt-2">
                    <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Tambah</button></a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body ">
        <div class="dataTables_wrapper">
            <table id="table-transaksi-kantor" class="display table table-stripped table-hover table-condensed table-sm dataTable">
                <thead>
                    <tr>
                        <th scope="col">Nama Perusahaan</th>
                        <th scope="col">Nama Pemilik</th>
                        <th scope="col">Kode Proyek</th>
                        <th scope="col">Status Proyek</th>
                        <th scope="col">Jenis Proyek</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($proyeks as $proyek)
                            <tr id="{{ $proyek->id }}">
                                <td>
                                    {{$proyek->perusahaan->nama_perusahaan}}
                                </td>
                                <td>
                                    {{$proyek->user->name}}
                                </td>
                                <td>
                                    {{$proyek->kode_proyek}}
                                </td>
                                <td>
                                    {{$proyek->status}}
                                </td>
                                <td>
                                    {{$proyek->jenis}}
                                </td>
                                <td class="text-center">
                                    <button id="bEdit" type="button" onclick="rowEdit(this);" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal"><i class="fas fa-pencil-alt" > </i></button>
                                    <button id="bElim" type="button" onclick="rowElim(this);" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-trash-alt" > </i></button>
                                    <a href="{{ route('management_projek.pendapatan.index', ['id_projek' => 1]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-wallet" > </i></a>
                                    <a href="{{ route('management_projek.biaya.index', ['id_projek' => 1]) }}" class="btn btn-sm btn-link p-0 mx-1" ><i class="fas fa-shopping-cart" > </i></a>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
    </div>
    <!-- /.card-footer -->
</div>

@if(Auth::user()->role == 1 || Auth::user()->role == 2)
<!-- Modal -->
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
            <label for="kodeproyek">Kode Proyek</label>
                <input autocomplete="off" type="text" id="kodeproyek" name="kodeproyek" class="form-control">
            </div>
            <div class="form-group">
                <label for="jenis-akun">Status Proyek</label>
                <select class="form-control" id="jenis-status" name="jenis_status" required>
                <option disabled selected value> -- pilih status proyek -- </option>
                <option value="Aktif">Aktif</option>
                <option value="Selesai">Selesai</option>
                </select>
            </div>
            <div class="form-group">
                <label for="jenis-akun">Nama Perusahaan</label>
                <select class="form-control" id="nama-perusahaan" name="nama_perusahaan" required>

                {{-- @foreach ($perusahaans as $perusahaan)
                    <option value="{{$perusahaan->id}}">{{$perusahaan->nama_perusahaan}}</option>
                @endforeach --}}
                </select>
            </div>
            <div class="form-group">
                <label for="jenis-akun">Nama Pemilik</label>
                <select class="form-control" id="nama-pemilik" name="nama_pemilik" required>
                <option disabled selected value> -- pilih pemilik -- </option>
                @foreach ($pemiliks as $pemilik)
                    <option value="{{$pemilik->id}}">{{$pemilik->name}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenisproyek">Jenis Proyek</label>
                <input autocomplete="off" type="text" id="jenisproyek" name="jenisproyek"  class="form-control">
            </div>
            <!-- <div class="form-group">
                <label for="kas-bank">Kas/Bank</label>
                <select class="form-control" id="kas-bank" name="akun_neraca" required>
                <option disabled selected value> -- pilih akun -- </option>
                </select>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="jumlah-transaksi">Jumlah (Rp)</label>
                    <input type="text" id="jumlah-transaksi" class="form-control" name="jumlah_transaksi" required>
                </div>
            </div> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="add-transaksi">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-transaksi" method="post" action="{{ route('update_list_proyek') }}">
                    @csrf
                    <input id="edit-id" name="id" type="hidden" class="form-control">
                    <div class="form-group">
                        <label for="kodeproyek">Kode Proyek</label>
                        <input autocomplete="off" type="text" id="edit-kodeproyek" name="kodeproyek" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status-proyek">Status Proyek</label>
                        <select class="form-control" id="edit-jenis-status" name="jenis_status" required>
                            <option disabled selected value> -- pilih status proyek -- </option>
                            <option value="Aktif">Aktif</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis-akun">Nama Perusahaan</label>
                        <select class="form-control" id="edit-nama-perusahaan" name="nama_perusahaan" required>
                            <option disabled selected value> -- pilih perusahaan -- </option>
                            @foreach ($perusahaans as $perusahaan)
                            <option value="{{$perusahaan->id}}">{{$perusahaan->nama_perusahaan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis-akun">Nama Pemilik</label>
                        <select class="form-control" id="edit-nama-pemilik" name="nama_pemilik" required>
                            <option disabled selected value> -- pilih pemilik -- </option>
                            @foreach ($pemiliks as $pemilik)
                            <option value="{{$pemilik->id}}">{{$pemilik->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenisproyek">Jenis Proyek</label>
                        <input autocomplete="off" type="text" id="edit-jenisproyek" name="jenisproyek"  class="form-control" value="{{$proyek->jenis}}">
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
@endif
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