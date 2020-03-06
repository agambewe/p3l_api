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
}
