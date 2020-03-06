<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    public $table = "customer";

    protected $fillable = [
        'nama', 'alamat', 'tanggal_lahir', 'telepon', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $primaryKey = "id";
    
    protected $hidden = [
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];
}
