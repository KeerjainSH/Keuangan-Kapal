<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajemen extends Model
{
    use HasFactory;
    protected $table = 'manajemen';

    protected $fillable = [
        'nama',
        'idParent',
    ];

    protected $hidden = [
    ];

    public function user(){
        return $this->hasMany('\App\Models\User', 'id_perusahaan');
    }

    public function invitation(){
        return $this->hasMany('\App\Models\Invitation', 'id_perusahaan');
    }

    public function catatan_transaksi_proyek(){
        return $this->hasMany('\App\Models\Catatan\TransaksiProyek', 'id', 'id_perusahaan');
    }
}
