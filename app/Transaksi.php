<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    public $table = "transaksi";

    protected $fillable = [
        'cs', 'kasir', 'total_harga', 'status_bayar', 'status_layanan', 'diskon'
    ];

    protected $primaryKey = "id";
    
    protected $hidden = [
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    // public function details()
    // {
    //     return $this->hasMany('App\Models\DetailTransaksiLayanan');
    // }
}
