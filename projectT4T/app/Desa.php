<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desas';
    protected $fillable = ['kode_desa', 'name', 'kode_kecamatan', 'created_at','updated_at'];
}
