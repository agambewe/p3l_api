<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Layanan;

class LayananController extends Controller
{
    public function tampil(){
        return Layanan::with(['ukuranHewan'])->get();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'id_ukuran' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);

        $id_ukuran = $request->input('id_ukuran');
        $nama = $request->input('nama');
        $harga = $request->input('harga');

        $data = new Layanan();
        $data->id_ukuran = $id_ukuran;
        $data->nama = $nama;
        $data->harga = $harga;
        $data->updated_at = null;

        if($data->save()){
            $res['message'] = "Data layanan berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data layanan gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $id_ukuran = $request->input('id_ukuran');
        $nama = $request->input('nama');
        $harga = $request->input('harga');

        $data = Layanan::where('id',$id)->first();
        $data->id_ukuran = $id_ukuran;
        $data->nama = $nama;
        $data->harga = $harga;

        if($data->save()){
            $res['message'] = "Data layanan berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data layanan gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = Layanan::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data layanan berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data layanan gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Layanan::find($id);

        if (is_null($data)){
            $res['message'] = "Data layanan tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data layanan ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
