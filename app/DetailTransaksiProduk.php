<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksiProduk extends Model
{
    public $table = "detail_transaksi_produk";

    protected $fillable = [
        'jumlah', 'subtotal',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }

    public function hewan(){
        return $this->belongsTo(Hewan::class, 'id_hewan', 'id');
    }
}
