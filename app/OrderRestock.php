<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRestock extends Model
{
    public $table = "order_restock";

    protected $fillable = [
        'tanggal_restock', 'total_bayar', 'status_order'
    ];

    protected $primaryKey = "id";
    
    protected $hidden = [
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
