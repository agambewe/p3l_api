<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hewan extends Model
{
    public $table = "hewan";

    protected $fillable = [
        'nama', 'tanggal_lahir', 'created_by', 'updated_by', 'deleted_by'
    ];

    protected $primaryKey = "id";
    
    protected $hidden = [
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function jenisHewan(){
        return $this->belongsTo(JenisHewan::class, 'id_jenis', 'id');
        // return $this->hasMany(JenisHewan::class, 'id', 'id_jenis');
    }
    public function customer(){
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }
}
