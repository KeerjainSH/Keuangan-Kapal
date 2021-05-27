<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajemen extends Model
{
    use HasFactory;
    protected $table = 'manajemen';

    protected $fillable = [
        'namaManajemen',
        'idParent',
        'flag',
    ];

    protected $hidden = [
    ];}
