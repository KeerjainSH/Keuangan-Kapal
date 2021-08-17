<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AkunTransaksiProyek;
use App\Models\Proyek;
use App\Models\Perusahaan;
use App\Models\Catatan\TransaksiProyek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanShipOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_proyek = null)
    {
        if(Auth::user()->role == 4)
        {
            $proyeks = Proyek::where('id_pemilik', Auth::user()->id)->get();
        }
        else
        {
            $proyeks = Proyek::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        }

        $curr_proyek = null;
        if(!(is_null($id_proyek)) && $id_proyek != 'all')
        {
            $curr_proyek = Proyek::where('id_perusahaan', Auth::user()->id_perusahaan)
                                ->where('id', $id_proyek)
                                ->first();
        }

        $biayas1 = AkunTransaksiProyek::select('manajemen.*','akun_transaksi_proyeks.created_at')
                ->where('akun_transaksi_proyeks.id_perusahaan', Auth::user()->id_perusahaan)
                ->where('akun_transaksi_proyeks.jenis', 'Keluar')
                ->join("manajemen","manajemen.id","akun_transaksi_proyeks.idManajemen")
                // ->groupBy("manajemen.id")
                ->get();
        // dd($biayas);
        
        foreach($biayas1 as $biaya){   
            $bulanDetail = array(
                    1 => 0.0,
                    2 => 0.0,
                    3 => 0.0,
                    4 => 0.0,
                    5 => 0.0,
                    6 => 0.0,
                    7 => 0.0,
                    8 => 0.0,
                    9 => 0.0,
                    10 => 0.0,
                    11 => 0.0,
                    12 => 0.0,
                ); 
            
            $biayaDetails = TransaksiProyek::select(DB::raw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month'))
                    ->selectRaw("SUM(jumlah) as total_jumlah")
                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->where('id_akun_tr_proyek', $biaya->id)
                    ->groupby('month')
                    ->get();
            
            foreach ($biayaDetails as $biayaDetail) {
                // var_dump($biaya->detail[$biayaDetail->month]);
                // var_dump($biayaDetail->total_jumlah);
                // die;
                // dd($biayaDetail->total_jumlah);
                $bulanDetail[$biayaDetail->month] = $biayaDetail->total_jumlah;                
            }

            $biaya->detail = $bulanDetail;
            
        }
        
        $biayas = AkunTransaksiProyek::select('manajemen.*','akun_transaksi_proyeks.created_at')
                ->where('akun_transaksi_proyeks.id_perusahaan', Auth::user()->id_perusahaan)
                ->where('akun_transaksi_proyeks.jenis', 'Keluar')
                ->join("manajemen","manajemen.id","akun_transaksi_proyeks.idManajemen")
                ->groupBy("manajemen.id")
                ->get();

        foreach( $biayas as $biaya){
            foreach( $biayas1 as $biaya1){
                if($biaya->id == $biaya1->id){
                    $biaya->detail = $biaya1->detail;
                }
                // $biaya->detail 
            }
        }

        $perusahaan = Perusahaan::with('user')->get()->where('kode_perusahaan', '=', Auth::user()->kode_perusahaan)->first();
        // dd($biayas);
        // dd($anggarans, $realisasis);
        return view('laporan/laporan_ship_owner', compact('proyeks', 'curr_proyek',
        'pendapatans', 'biayas', 'perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
