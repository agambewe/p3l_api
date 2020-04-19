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

    // public function transaksi()
    // {
    //     return $this->belongsTo('App\Models\Transaksi');
    // }
}
