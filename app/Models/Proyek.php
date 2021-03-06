<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pemilik', 'jenis', 'id_perusahaan', 'kode_proyek', 'status'
    ];

    public function user(){
        return $this->belongsTo('\App\Models\User', 'id_pemilik', 'id');
    }

    public function perusahaan(){
        return $this->belongsTo('\App\Models\Perusahaan', 'id_perusahaan', 'id');
    }

    public function catatan_transaksi_proyek(){
        return $this->hasMany('\App\Models\Catatan\TransaksiProyek', 'id', 'id_proyek');
    }

    public function anggaran(){
        return $this->hasMany('\App\Models\Catatan\Anggaran', 'id', 'id_proyek');
    }
}
