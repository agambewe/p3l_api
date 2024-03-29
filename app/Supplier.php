<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    public $table = "supplier";

    protected $fillable = [
        'nama', 'alamat', 'telepon',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
