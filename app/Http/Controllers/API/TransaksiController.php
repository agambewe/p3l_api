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

    public function tlayananCS(){
        return Transaksi::whereNull('kasir')
                        ->where('status_layanan',0)
                        ->get();
    }

    // public function tlayananKasir(){
    //     return Transaksi::whereNotNull('kasir')
    //                     ->where('status_layanan',1)
    //                     ->get();
    // }

    public function idTransaksiMaker(){
        $simpen = Transaksi::whereNotNull('status_layanan')
                        ->orderBy('id', 'desc')
                        ->first();

        $sekarang = date('ymd');
        if (!$simpen) {
            $res = "LY-".$sekarang."-01";
        }else{
            $id_transaksi = $simpen->id_transaksi;
            $id_transaksi = explode("-", $id_transaksi);

            $last = ++$id_transaksi[2];
            if($sekarang==$id_transaksi[1]){
                if(9>$id_transaksi[2]){
                    $res = $id_transaksi[0]."-".$id_transaksi[1]."-"."0".$last;
                }else{
                    $res = $id_transaksi[0]."-".$id_transaksi[1]."-".$last;
                }
            }else{
                $res = $id_transaksi[0]."-".$sekarang."-01";
            }
        }
        
        return response($res);
    }
    
    public function tambah(Request $request)
    {

        $this->validateWith([
            'cs' => 'required',
        ]);

        $cs = $request->input('cs');
        $aidi = $this->idTransaksiMaker();

        $data = new Transaksi();
        $data->id_transaksi = $aidi->original;
        $data->cs = $cs;
        $data->status_bayar = 0;
        $data->status_layanan = 0;
        $data->tanggal_transaksi = date('Y-m-d');

        if($data->save()){
            $res['message'] = "Berhasil diproses!";
            $res['id'] = $data->id_transaksi;
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $data = Transaksi::where('id',$id)->first();
        $data->status_layanan = 1;

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
