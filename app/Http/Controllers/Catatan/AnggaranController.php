<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Catatan\Anggaran;
use App\Models\Perusahaan;
use App\Models\AkunTransaksiKantor;

class AnggaranController extends Controller
{
    //
    public function index(Request $request){
        $perusahaans = Perusahaan::all();
        $pemiliks = User::all();
        $proyeks = Proyek::all();
        $anggarans = Anggaran::all();
        $akuntransaksikantors = AkunTransaksiKantor::all();
        return view('proyek.biaya.index', compact('perusahaans', 'pemiliks', 'proyeks', 'akuntransaksikantors', 'anggarans'));
    }

    public function insertBiaya (Request $request) {
        //dd($request->all());
        $anggaran = Anggaran::create([
            'id_akun_tr_proyek' => $request->idakuntrproyek,
            'id_perusahaan' => $request->jenis_status,
            'id_proyek' => $request->jenisproyek,
            'ukuran' => $request->biaya_ukuran,
            'jenis' => $request->biaya_jenis,
            'volume' => $request->biaya_volume,
            'satuan' => $request->biaya_satuan,
            'hargasatuan' => $request->biaya_hargasatuan,
            'nominal' => $request->biaya_nominal,
        ]);

        return redirect()->back();
    }

    public function edit(Request $request)
    {
        //dd($request->all());
        $proyek = Anggaran::find($request->id);

        $proyek->id_pemilik = $request->nama_pemilik;
        $proyek->jenis = $request->jenisproyek;
        $proyek->status = $request->jenis_status;
        $proyek->id_perusahaan = $request->nama_perusahaan;
        $proyek->kode_proyek = $request->kodeproyek;

        $proyek->save();

        return redirect()->route('proyek.biaya.index');
    }

    public function list_biaya($id_projek)
    {
        return view('proyek\biaya\index');
    }

    public function list_pendapatan($id_projek)
    {
        return view('proyek\pendapatan\index');
    }
}
