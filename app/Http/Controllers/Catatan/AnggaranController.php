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
use App\Models\Comments;
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

        // $proyeks = Proyek::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        // foreach($proyeks as $proyek)
        // {
        //     if($proyek->id == $request->id_proyek)
        //         continue;
        //     Anggaran::create([
        //         'id_akun_tr_proyek' => $akun->id,
        //         'id_perusahaan' => Auth::user()->id_perusahaan,
        //         'id_proyek' => $proyek->id,
        //         'nominal' => 0,
        //     ]);
        // }

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


    public function edit(Request $request, $id_proyek)
    {
        $anggaran = Anggaran::find($request->id);
        $jumlah = $request->volume * $request->hargasatuan;

        // dd($jumlah);
        $anggaran->id = $request->id;
        $anggaran->ukuran = $request->ukuran;
        $anggaran->jenisAnggaran = $request->jenisAnggaran;
        $anggaran->volume = $request->volume;
        $anggaran->satuan = $request->satuan;
        $anggaran->hargasatuan = $request->hargasatuan;
        $anggaran->nominal = $jumlah;

        $anggaran->save();

        return redirect()->back();
    }

    public function delete($id_proyek, $anggaran)
    {
        // dd($request);
        try {
            $anggarans = Anggaran::find($anggaran);
            $akuntrproyek = AkunTransaksiProyek::find($anggarans->id_akun_tr_proyek)->delete();
            $anggarans->delete();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return redirect()->back();
    }

    public function list_biaya($id_proyek)
    {
        $anggarans = Anggaran::where('id', '=', 'proyeks.id')->get();
        $akun_neraca_saldos = AkunNeracaSaldo::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
        $jenisBiaya = Manajemen::whereNull('idParent')->get();
        $jenisBiayaChild = Manajemen::whereNotNull('idParent')->get();
        $akunTransaksiProjeks = AkunTransaksiProyek::where([['akun_transaksi_proyeks.jenis', 'Keluar'],['akun_transaksi_proyeks.id_perusahaan', Auth::user()->id_perusahaan]])
            ->join('anggaran_proyek','anggaran_proyek.id_akun_tr_proyek','=','akun_transaksi_proyeks.id')
                // ->join('manajemen', 'manajemen.id', '=', 'akun_transaksi_proyeks.idmanajemen')
                    ->where('anggaran_proyek.id_proyek', '=', $id_proyek)
                        ->whereNotNull('akun_transaksi_proyeks.idmanajemen')->get();
        foreach($akunTransaksiProjeks as $projek){
            $manajemens = Manajemen::select('id as idmanajemen', 'namaManajemen', 'idParent', 'flag')
                ->where("id", '=', $projek->idmanajemen)->get();
            foreach ($manajemens as $manajemen) {
                //dd($manajemen);
                $projek->namaManajemen = $manajemen->namaManajemen;
                //$projek->idParent = $manajemen->idParent;
                $projek->flag = $manajemen->flag;
                $namaprojek = Manajemen::select('namaManajemen')->where("id", '=', $manajemen->idParent)->first()->toArray();
                $projek->parent = $namaprojek['namaManajemen'];
            }
        }
        $comment = Comments::where('place', 1)->first();
        // dd($akunTransaksiProjeks);
        //dd($jenisBiaya);
        return view('proyek.biaya.index', compact('comment','akunTransaksiProjeks', 'anggarans', 'jenisBiaya', 'id_proyek', 'jenisBiayaChild', 'akun_neraca_saldos'));
    }

    public function list_pendapatan($id_projek)
    {
        return view('proyek.pendapatan.index');
    }
    
    public function insertComment(Request $request, $id_proyek)
    {
        $comment = Comments::where('place', 1)->first();
        $comment->comment = $request->comment;

        $comment->save();

        return redirect()->back();
    }
}
