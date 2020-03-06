<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Transaksi;

class TransaksiController extends Controller
{
    public function tampil(){
        return Transaksi::all();
    }
    
    public function tambah(Request $request)
    {

        $this->validateWith([
        ]);

        // $cs = $request->input('cs');
        // $kasir = $request->input('kasir');
        // $status_order = $request->input('status_order');

        $data = new Transaksi();
        // $data->tanggal_restock = $tanggal_restock;
        // $data->total_bayar = $total_bayar;
        // $data->status_order = $status_order;

        if($data->save()){
            $res['message'] = "Berhasil diproses!";
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        // $tanggal_restock = $request->input('tanggal_restock');
        // $total_bayar = $request->input('total_bayar');
        // $status_order = $request->input('status_order');

        $data = Transaksi::where('id',$id)->first();
        // $data->tanggal_restock = $tanggal_restock;
        // $data->total_bayar = $total_bayar;
        // $data->status_order = $status_order;

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
        $data = Transaksi::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Transaksi::find($id);

        if (is_null($data)){
            $res['message'] = "Tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
