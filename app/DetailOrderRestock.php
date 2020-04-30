<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailOrderRestock extends Model
{
    public $table = "detail_order_restock";

    protected $fillable = [
        'jumlah', 'subtotal',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function produk(){
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }

    public function supplier(){
        return $this->belongsTo(supplier::class, 'id_supplier', 'id');
    }
}
