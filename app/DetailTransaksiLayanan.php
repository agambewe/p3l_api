<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksiLayanan extends Model
{
    public $table = "detail_transaksi_layanan";

    protected $fillable = [
        'jumlah', 'subtotal',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function layanan(){
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id');
    }

    public function hewan(){
        return $this->belongsTo(Hewan::class, 'id_hewan', 'id');
    }
}
