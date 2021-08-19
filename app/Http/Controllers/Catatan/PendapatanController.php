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
use App\Models\Comments;



class PendapatanController extends Controller
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

    public function insertPendapatan (Request $request) {
        // dd($request->all());

        // $jumlah = $request->biaya_volume * $request->biaya_hargasatuan;

        $akun = AkunTransaksiProyek::create([
            'nama' => $request->namaPendapatan,
            'jenis' => $request->at_jenis,
            'id_perusahaan' => (User::find(Auth::user()->id))->id_perusahaan,
            'jenis_neraca' => $request->jenis_neraca,
            'jenis' => 'Masuk',
        ]);

        $anggaran = Anggaran::create([
            'id_akun_tr_proyek' => $akun->id,
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_proyek' => $request->id_proyek,
            'nominal' => $request->jumlahPendapatan,
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



    public function edit(Request $request, $id_proyek)
    {
        $anggaran = Anggaran::find($request->id);
        // dd($anggaran->id_akun_tr_proyek);
        $akuntrproyek = AkunTransaksiProyek::find($anggaran->id_akun_tr_proyek);
        $anggaran->id = $request->id;
        $akuntrproyek->nama = $request->namapendapatan;
        $anggaran->nominal = $request->pendapatanproyek;

        // dd($request->all());

        $anggaran->save();
        $akuntrproyek->save();

        return redirect()->back();
    }

    public function delete($id_proyek, $anggaran)
    {
        // dd($request);
        try {
            $anggarans = Anggaran::find($anggaran);
            $akuntrproyek = AkunTransaksiProyek::find($anggarans->id_akun_tr_proyek)->delete();
            $anggarans->delete();
            // $akuntrproyek->delete()
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return redirect()->back();
    }

    public function list_pendapatan($id_proyek)
    {
        $anggarans = Anggaran::where('id', '=', 'proyeks.id')->get();
        $akun_neraca_saldos = AkunNeracaSaldo::where('id_perusahaan', '=', Auth::user()->id_perusahaan)->get();
        $akunTransaksiProjeks = AkunTransaksiProyek::where([['akun_transaksi_proyeks.jenis', 'Masuk'],['akun_transaksi_proyeks.id_perusahaan', Auth::user()->id_perusahaan]])
            ->join('anggaran_proyek','anggaran_proyek.id_akun_tr_proyek','=','akun_transaksi_proyeks.id')
                // ->join('manajemen', 'manajemen.id', '=', 'akun_transaksi_proyeks.idmanajemen')
                    ->where('anggaran_proyek.id_proyek', '=', $id_proyek)->get();
        // dd($akunTransaksiProjeks);
        // dd($request->all());
        $comment = Comments::where('place', 2)->first();

        return view('proyek.pendapatan.index', compact('comment','akunTransaksiProjeks', 'anggarans', 'id_proyek', 'akun_neraca_saldos'));
    }

    // public function list_pendapatan($id_projek)
    // {
    //     return view('proyek\pendapatan\index');
    // }

    public function insertComment(Request $request, $place)
    {


        $comment = Comments::where('place', $place)->first();

        $comment->comment =  $request->comment;

        $comment->save();

        return redirect()->back();
    }
}
