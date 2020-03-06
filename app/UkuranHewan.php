<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UkuranHewan extends Model
{
    public $table = "ukuran_hewan";

    protected $fillable = [
        'nama',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
