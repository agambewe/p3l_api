<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisHewan extends Model
{
    public $table = "jenis_hewan";

    protected $fillable = [
        'nama',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
