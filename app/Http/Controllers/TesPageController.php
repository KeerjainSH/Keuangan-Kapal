<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesPageController extends Controller
{

    public function list_projek()
    {
        return view('projek.list_proyek');
    }

    public function management_projek($id_projek)
    {
        return view('proyek\managemen-projek\index');
    }

    // pendapatan
    public function list_pendapatan($id_projek)
    {
        return view('proyek\managemen-projek\pendapatan\index');
    }

    public function detail_pendapatan($id_projek, $id_pendapatan)
    {
        return view('proyek\managemen-projek\pendapatan\show');
    }

    // biaya
    public function list_jenis($id_projek, $flag)
    {
        return view('proyek\managemen-projek\jenis\index');
    }

    public function list_biaya($id_projek, $flag, $id_jenis)
    {
        return view('proyek\managemen-projek\jenis\biaya\index');
    }

    public function detail_biaya($id_projek, $flag, $id_jenis,$id_biaya)
    {
        return view('proyek\managemen-projek\jenis\biaya\show');
    }
}
