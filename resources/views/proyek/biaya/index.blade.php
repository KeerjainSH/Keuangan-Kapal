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
                        <a href="{{ route('list_proyek') }}"><button type="button" class="btn btn-sm btn-secondary mr-2"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                        <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Jenis Biaya</button></a>
                        <a href="#"><button type="button" class="btn btn-sm btn-primary mr-2 " data-toggle="modal" data-target="#contohModal"><i class="fas fa-plus"></i> Detail Biaya</button></a>
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
                        @foreach ($akunTransaksiProjeks as $projeks)
                        <tr style="text-align: center">
                                <td>
                                    @if ($projeks->flag == '1')
                                        Biaya Langsung
                                    @elseif ($projeks->flag == '2')
                                        Biaya Tidak Langsung
                                    @else
                                        Biaya Overhead
                                    @endif
                                </td>
                                <td>
                                    {{ $projeks->parent}}
                                </td>
                                <td>
                                    &nbsp &nbsp {{ $projeks->namaManajemen }}
                                </td>
                                <td >
                                </td>
                                <td >
                                {{ $projeks->nama }}
                                </td>
                                <td>
                                    {{ $projeks->ukuran }}
                                </td>
                                <td>
                                    {{ $projeks->jenisAnggaran }}
                                </td>
                                <td>
                                    {{ $projeks->volume }}
                                </td>
                                <td>
                                    {{ $projeks->satuan }}
                                </td>
                                <td>
                                    {{
                                        number_format($projeks->hargasatuan, 2, '.', ',')
                                    }}
                                    {{-- {{ $projeks->hargasatuan }} --}}
                                </td>
                                <td>
                                    {{
                                        number_format($projeks->nominal, 2, '.', ',')
                                    }}
                                    {{-- {{ $projeks->nominal }} --}}
                                </td>
                                <td>
                                    <button id="bEdit" type="button" class="btn btn-sm btn-link p-0 mx-1" data-toggle="modal" data-target="#editModal{{$projeks->id}}"><i class="fas fa-pencil-alt" > </i></button>
                                    <a href="{{ route('management_projek.biaya.delete', ['id_proyek' => $id_proyek, 'id' => $projeks->id]) }}" class="btn btn-sm btn-link p-0 mx-1" onclick="return confirm('Apakah anda ingin menghapus data ini?')"><i class="fas fa-trash-alt" > </i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body ">
                <div class="float-right"><strong>&nbsp &nbspTotal Jumlah</strong>
                    <p>&nbsp {{number_format($akunTransaksiProjeks->sum('nominal'), 2, '.', ',')}}</p>
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
                <form id="add-transaksi" method="post" action="{{ route('management_projek.biaya.insertJenisBiaya',['id_proyek' => $id_proyek]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="flag">Biaya</label>
                        <select class="form-control" id="flag" name="flag" required>
                        <option disabled selected value> -- pilih biaya -- </option>
                        <option value="1">Biaya Langsung</option>
                        <option value="2">Biaya Tidak Langsung</option>
                        <option value="3">Biaya Overhead</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idParent">Jenis Biaya</label>
                        <select class="form-control" id="idParent" name="idParent">
                        <option selected value=""> Tidak ada </option>
                        @foreach ($jenisBiaya as $jenisB)
                        <option value="{{$jenisB->id}}"> {{$jenisB->namaManajemen}}</option>
                        @endforeach
                        {{-- <option value="Biaya Tidak Langsung">Biaya Tidak Langsung</option>
                        <option value="Biaya Langsung"></option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="namaManajemen">Nama Biaya</label>
                        <input autocomplete="off" type="text" id="namaManajemen" name="namaManajemen" class="form-control">
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
                        <h5 class="modal-title" id="contohModalLabel">Detail Biaya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body">
                <form id="add-detailBiaya" method="post" action="{{ route('management_projek.biaya.insertBiaya',['id_proyek' => $id_proyek]) }}">
                    @csrf
                    <input id="add-idproyek" name="id_proyek" type="hidden" class="form-control" value="{{$id_proyek}}">
                    <div class="form-group">
                        <label for="idParentChild">Jenis Biaya</label>
                        <select class="form-control" id="idParentChild" name="idParentChild" required>
                        <option disabled selected value> -- pilih jenis biaya --</option>
                        @foreach ($jenisBiayaChild as $jenisBC)
                        <option value="{{$jenisBC->id}}"> {{$jenisBC->namaManajemen}}</option>
                        @endforeach
                        {{-- <option value="Biaya Tidak Langsung">Biaya Tidak Langsung</option>
                        <option value="Biaya Langsung"></option> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add-keterangan">Keterangan</label>
                        <input autocomplete="off" type="text" id="add-keterangan" name="nama" class="form-control">
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
                        <label for="add-ukuran">Ukuran</label>
                        <input autocomplete="off" type="text" id="add-ukuran" name="biaya_ukuran" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="add-jenis">Jenis</label>
                        <input autocomplete="off" type="text" id="add-jenis" name="biaya_jenis" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="add-volume">Volume</label>
                        <input autocomplete="off" type=number step=0.001 id="add-volume" name="biaya_volume" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="add-satuan">Satuan</label>
                        <input autocomplete="off" type="text" id="add-satuan" name="biaya_satuan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="add-hargasatuan">Harga Satuan</label>
                        <input autocomplete="off" type="number" id="add-hargasatuan" name="biaya_hargasatuan" class="form-control" required>
                    </div>
                </div>
            </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="add-detailBiaya">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($akunTransaksiProjeks as $projeks)
        {{-- Edit detail biaya --}}
        <div class="modal fade" id="editModal{{ $projeks->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Biaya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-transaksi{{$projeks->id}}" method="post" action="{{ route('management_projek.biaya.edit', ['id_proyek' => $id_proyek]) }}">
                            @csrf
                            <input id="edit-id" name="id" type="hidden" class="form-control" value="{{$projeks->id}}">
                            <div class="form-group">
                                <label for="edit-keterangan">Keterangan</label>
                                <input autocomplete="off" type="text" id="edit-keterangan" name="keterangan" class="form-control" value="{{$projeks->nama}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="edit-ukuran">Ukuran</label>
                                <input autocomplete="off" type="text" id="edit-ukuran" name="ukuran" class="form-control" value="{{$projeks->ukuran}}">
                            </div>
                            <div class="form-group">
                                <label for="edit-jenis">Jenis</label>
                                <input autocomplete="off" type="text" id="edit-jenis" name="jenisAnggaran" class="form-control" value="{{$projeks->jenisAnggaran}}">
                            </div>
                            <div class="form-group">
                                <label for="edit-volume">Volume</label>
                                <input autocomplete="off" type=number step=0.001 id="edit-volume" name="volume" class="form-control" value="{{$projeks->volume}}">
                            </div>
                            <div class="form-group">
                                <label for="edit-satuan">Satuan</label>
                                <input autocomplete="off" type="text" id="edit-satuan" name="satuan" class="form-control" value="{{$projeks->satuan}}">
                            </div>
                            <div class="form-group">
                                <label for="edit-hargasatuan">Harga Satuan</label>
                                <input autocomplete="off" type="number" id="edit-hargasatuan" name="hargasatuan" class="form-control" value="{{$projeks->hargasatuan}}">
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
    </div>
    @endforeach
    @endif
    @endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable( {
            paging:   false,
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

<script src="{{ asset('js/bootstable-biaya.js') }}"></script>


@endsection