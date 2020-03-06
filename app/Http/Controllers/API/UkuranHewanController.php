<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\UkuranHewan;

class UkuranHewanController extends Controller
{
    public function tampil(){
        return UkuranHewan::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required'
        ]);

        $nama = $request->input('nama');

        $data = new UkuranHewan();
        $data->nama = $nama;

        if($data->save()){
            $res['message'] = "Data ukuran hewan berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data ukuran hewan gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');

        $data = UkuranHewan::where('id',$id)->first();
        $data->nama = $nama;

        if($data->save()){
            $res['message'] = "Data ukuran hewan berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data ukuran hewan gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = UkuranHewan::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data ukuran hewan berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data ukuran hewan gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = UkuranHewan::find($id);

        if (is_null($data)){
            $res['message'] = "Data ukuran hewan tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data ukuran hewan ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
