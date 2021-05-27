<?php

namespace App\Http\Controllers\Catatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Catatan\Anggaran;
use App\Models\Perusahaan;
use App\Models\AkunTransaksiKantor;
use App\Models\AkunTransaksiProyek;
use App\Models\Manajemen;
use App\Models\AkunNeracaSaldo;
use App\Models\User;
use App\Models\Proyek;


class AnggaranController extends Controller
{
    //
    public function index($id_proyek){
        // $perusahaans = Perusahaan::all();
        // $pemiliks = User::all();
        // $proyeks = Proyek::all();
        // $anggarans = Anggaran::all();
        // $akuntransaksikantors = AkunTransaksiKantor::where('jenis', 'Keluar');
        // dd($akuntransaksikantors);
        // return view('proyek.biaya.index', compact('perusahaans', 'pemiliks', 'proyeks', 'akuntransaksikantors', 'anggarans'));
    }

    public function insertBiaya (Request $request) {
        // dd($request->all());

        $jumlah = $request->biaya_volume * $request->biaya_hargasatuan;

        $akun = AkunTransaksiProyek::create([
            'nama' => $request->nama,
            'jenis' => $request->at_jenis,
            'id_perusahaan' => (User::find(Auth::user()->id))->id_perusahaan,
            'jenis_neraca' => $request->jenis_neraca,
            'idmanajemen' => $request->idParentChild,
            'jenis' => 'Keluar',
            ]);

            $anggaran = Anggaran::create([
                'id_akun_tr_proyek' => $akun->id,
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_proyek' => $request->id_proyek,
                'ukuran' => $request->biaya_ukuran,
                'jenisAnggaran' => $request->biaya_jenis,
                'volume' => $request->biaya_volume,
                'satuan' => $request->biaya_satuan,
                'hargasatuan' => $request->biaya_hargasatuan,
                'nominal' => $jumlah,
            ]);

        $proyeks = Proyek::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        foreach($proyeks as $proyek)
        {
            if($proyek->id == $request->id_proyek)
                continue;
            Anggaran::create([
                'id_akun_tr_proyek' => $akun->id,
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_proyek' => $proyek->id,
                'nominal' => 0,
            ]);
        }

        return redirect()->back();
    }

    public function insertJenisBiaya (Request $request) {
        $manajemen = Manajemen::create([
            'namaManajemen' => $request->namaManajemen,
            'idParent' => $request->idParent,
            'flag' => $request->flag,
            ]);

            //dd($manajemen);
        return redirect()->back();
    }
    public function edit(Request $request)
    {
        //dd($request->all());
        $anggaran = Anggaran::find($request->id);

        $anggaran->id_pemilik = $request->nama_pemilik;
        $anggaran->ukuran = $request->biaya_ukuran;
        $anggaran->status = $request->biaya_jenisAnggaran;
        $anggaran->id_perusahaan = $request->biaya_volume;
        $anggaran->kode_anggaran = $request->biaya_satuan;
        $anggaran->hargasatuan = $request->biaya_hargasatuan;
        $anggaran->nominal = $request->biaya_nominal;

        $anggaran->save();

        return redirect()->route('proyek.biaya.index');
    }

    public function list_biaya($id_proyek)
    {
        $akun_neraca_saldos = AkunNeracaSaldo::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
        $jenisBiaya = Manajemen::whereNull('idParent')->get();
        $jenisBiayaChild = Manajemen::whereNotNull('idParent')->get();
        $akunTransaksiProjeks = AkunTransaksiProyek::where([['akun_transaksi_proyeks.jenis', 'Keluar'],['akun_transaksi_proyeks.id_perusahaan', Auth::user()->id_perusahaan]])->join('anggaran_proyek','anggaran_proyek.id_akun_tr_proyek','=','akun_transaksi_proyeks.id')->join('manajemen', 'manajemen.id', '=', 'akun_transaksi_proyeks.idmanajemen')->where('anggaran_proyek.id_proyek', '=', $id_proyek)->get();
        foreach($akunTransaksiProjeks as $projek){
            $namaprojek = Manajemen::select('namaManajemen')->where("id",$projek->idParent)->first()->toArray();
            $projek->parent = $namaprojek['namaManajemen'];
        }
       //dd($jenisBiaya);
        return view('proyek\biaya\index', compact('akunTransaksiProjeks', 'jenisBiaya', 'id_proyek', 'jenisBiayaChild', 'akun_neraca_saldos'));
    }

    public function list_pendapatan($id_projek)
    {
        return view('proyek\pendapatan\index');
    }
}
