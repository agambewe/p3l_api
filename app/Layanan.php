<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    public $table = "layanan";

    protected $fillable = [
        'nama', 'harga',
    ];

    use SoftDeletes;
    protected $dates =['deleted_at'];

    public function ukuranHewan(){
        return $this->belongsTo(UkuranHewan::class, 'id_ukuran', 'id');
    }
}
