<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    public $table = "pegawai";

    protected $fillable = [
        'nama', 'satuan', 'stok', 'minimal', 'harga',
        // 'foto',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
