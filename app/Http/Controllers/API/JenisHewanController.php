<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\JenisHewan;

class JenisHewanController extends Controller
{
    public function tampil(){
        return JenisHewan::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required'
        ]);

        $nama = $request->input('nama');

        $data = new JenisHewan();
        $data->nama = $nama;
        $data->updated_at = null;

        if($data->save()){
            $res['message'] = "Data jenis hewan berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data jenis hewan gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');

        $data = JenisHewan::where('id',$id)->first();
        $data->nama = $nama;

        if($data->save()){
            $res['message'] = "Data jenis hewan berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data jenis hewan gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = JenisHewan::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data jenis hewan berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data jenis hewan gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = JenisHewan::find($id);

        if (is_null($data)){
            $res['message'] = "Data jenis hewan tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data jenis hewan ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
