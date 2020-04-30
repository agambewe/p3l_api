<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRestock extends Model
{
    public $table = "order_restock";

    protected $fillable = [
        'id_po', 'tanggal_restock', 'total_bayar', 'status_order'
    ];

    // protected $primaryKey = "id";
    
    // protected $hidden = [
    // ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function supplier(){
        return $this->belongsTo(supplier::class, 'id_supplier', 'id');
    }
}
