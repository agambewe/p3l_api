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
            'id_hewan' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
            'subtotal' => 'required'
        ]);

        $id_transaksi = $request->input('id_transaksi');
        $id_hewan = $request->input('id_hewan');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $count = count($subtotal);
        for($i = 0; $i < $count; $i++){

            $data = new DetailTransaksiProduk();
            $data->id_transaksi = $id_transaksi;
            $data->id_hewan = $id_hewan;
            $data->id_produk = $id_produk[$i];
            $data->jumlah = $jumlah[$i];
            $data->subtotal = $subtotal[$i];
            if($data->save()){
                $res['message'] = "berhasil dimasukkan!";
                $res['id'] = $data->id;
                // return response($res);
            }else{
                $res['message'] = "gagal dimasukkan!";
                // return response($res);
            }
        }
    }

    public function ubah(Request $request, $id)
    {
        $id_hewan = $request->input('id_hewan');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $data = DetailTransaksiProduk::where('id_transaksi',$id)->get();

        $count = count($data);
        for($i = 0; $i < $count; $i++){

            $data[$i]->id_hewan = $id_hewan;
            $data[$i]->id_produk = $id_produk[$i];
            $data[$i]->jumlah = $jumlah[$i];
            $data[$i]->subtotal = $subtotal[$i];

            if($data[$i]->save()){
                $res['message'] = "Berhasil diubah!";
                // return response($res);
            }else{
                $res['message'] = "Gagal diubah!";
                // return response($res);
            }
        }
        return response($res);
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

    public function cariTransaksi($id){
        $data = DetailTransaksiProduk::with(['hewan','produk'])
                ->where('id_transaksi', $id)->get();
        if (empty($data)){
            $res['message'] = "tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "ditemukan!";
            $res['value'] = $data;
            return response($data);
        }
    }

    public function hapusTransaksi(Request $request, $id){
        $index = $request->input('index');

        $data = DetailTransaksiProduk::where('id_transaksi', $id)
                                    ->skip($index)
                                    ->first();
        if($data->delete()){
            $res['message'] = "Berhasil dibatalkan!";
            return response($res);
        }
        else{
            $res['message'] = "Gagal dihapus!";
            return response($res);
        }
    }
}
