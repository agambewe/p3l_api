<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    public $table = "pegawai";

    protected $fillable = [
        'nama', 'alamat', 'tanggal_lahir', 'telepon', 'role', 'password',
    ];

    protected $primaryKey = "id";
    
    protected $hidden = [
        // 'password', 
        // 'remember_token',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
