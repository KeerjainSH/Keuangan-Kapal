<?php

namespace App\Http\Controllers\Proyek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\Proyek;

class ManajemenProyekController extends Controller
{
    //
    public function index(Request $request){
        $perusahaans = Perusahaan::all();
        $pemiliks = User::all();
        $proyeks = Proyek::all();
        return view('proyek.manajemen_proyek', compact('perusahaans', 'pemiliks', 'proyeks'));
    }

    public function insert (Request $request) {
        //dd($request->all());
        $perusahaan = Proyek::create([
            'kode_proyek' => $request->kodeproyek,
            'status' => $request->jenis_status,
            'jenis' => $request->jenisproyek,
            'id_perusahaan' => $request->nama_perusahaan,
            'id_pemilik' => $request->nama_pemilik,
        ]);

        return redirect()->back();
    }

    public function getById($id)
    {
        //dd(json_encode(Proyek::find($id)));
        return json_encode(Proyek::find($id));
    }

    public function edit(Request $request)
    {
        //dd($request);
        $proyek = Proyek::find($request->id);

        $proyek->id_pemilik = $request->nama_pemilik;
        $proyek->jenis = $request->jenisproyek;
        $proyek->status = $request->jenis_status;
        $proyek->id_perusahaan = $request->nama_perusahaan;
        $proyek->kode_proyek = $request->kodeproyek;

        $proyek->save();

        return redirect()->route('list_proyek');
    }

    public function delete(Request $request)
    {
        // dd($request);
        try {
            Proyek::find($request->id)->delete();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $request->id;
    }

    public function getPerusahaan(Request $request)
    {
        $pemiliks = User::find($request->id)->perusahaan;
        return $pemiliks;
    }
}