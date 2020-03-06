<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailTransaksiProduk;

class DetailTransaksiProdukController extends Controller
{
    public function tampil(){
        return DetailTransaksiProduk::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'jumlah' => 'required',
            'subtotal' => 'required'
        ]);

        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $data = new DetailTransaksiProduk();
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

        $data = DetailTransaksiProduk::where('id',$id)->first();
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
        $data = DetailTransaksiProduk::where('id',$id)->first();

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
        $data = DetailTransaksiProduk::find($id);

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
