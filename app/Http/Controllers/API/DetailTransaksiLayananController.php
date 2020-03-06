<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailTransaksiLayanan;

class DetailTransaksiLayananController extends Controller
{
    public function tampil(){
        return DetailTransaksiLayanan::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'jumlah' => 'required',
            'subtotal' => 'required'
        ]);

        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $data = new DetailTransaksiLayanan();
        $data->jumlah = $jumlah;
        $data->subtotal = $subtotal;

        if($data->save()){
            $res['message'] = "berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $data = DetailTransaksiLayanan::where('id',$id)->first();
        $data->jumlah = $jumlah;
        $data->subtotal = $subtotal;

        if($data->save()){
            $res['message'] = "berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = DetailTransaksiLayanan::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = DetailTransaksiLayanan::find($id);

        if (is_null($data)){
            $res['message'] = "tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
