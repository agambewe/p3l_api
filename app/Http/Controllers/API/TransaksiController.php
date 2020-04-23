<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Transaksi;
use App\DetailTransaksiLayanan;
use App\DetailTransaksiProduk;

class TransaksiController extends Controller
{
    public function tampil(){
        return Transaksi::all();
    }

    public function tlayananCS(){
        return Transaksi::whereNull('kasir')
                        ->where('status_layanan',0)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function tprodukCS(){
        return Transaksi::whereNull('kasir')
                        ->whereNull('status_layanan')
                        ->orderBy('created_at', 'desc')
                        ->get();
    }

    public function tlayananKasir(){
        return Transaksi::where('status_layanan',1)
                        ->orderBy('created_at', 'desc')
                        ->get();
        // return DB::select('SELECT SUM(d.subtotal) "total" FROM detail_transaksi_layanan d 
        //         JOIN transaksi t USING(id_transaksi)
        //         WHERE id_transaksi = "LY-200120-01"');
        
    }

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
                if(9>=$id_transaksi[2]){
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

    public function idTransaksiProdukMaker(){
        $simpen = Transaksi::whereNull('status_layanan')
                        ->orderBy('id', 'desc')
                        ->first();

        $sekarang = date('ymd');
        if (!$simpen) {
            $res = "PR-".$sekarang."-01";
        }else{
            $id_transaksi = $simpen->id_transaksi;
            $id_transaksi = explode("-", $id_transaksi);

            $last = ++$id_transaksi[2];
            if($sekarang==$id_transaksi[1]){
                if(9>=$id_transaksi[2]){
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
    
    public function tambahLayanan(Request $request)
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
            $res['value'] = $data->id_transaksi;
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
        }
    }

    public function tambahProduk(Request $request)
    {

        $this->validateWith([
            'cs' => 'required',
        ]);

        $cs = $request->input('cs');
        $aidi = $this->idTransaksiProdukMaker();

        $data = new Transaksi();
        $data->id_transaksi = $aidi->original;
        $data->cs = $cs;
        $data->status_bayar = 0;
        $data->tanggal_transaksi = date('Y-m-d');

        if($data->save()){
            $res['message'] = "Berhasil diproses!";
            $res['value'] = $data->id_transaksi;
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
        }
    }

    public function selesaiLayanan(Request $request, $id)
    {
        $data = Transaksi::where('id',$id)->first();
        $data->status_layanan = 1;

        $sub = DB::select('SELECT SUM(d.subtotal) "total" 
                    FROM detail_transaksi_layanan d 
                    JOIN transaksi t USING(id_transaksi)
                    WHERE id_transaksi = ?',[$data->id_transaksi]);

        $data->total_harga = $sub[0]->total;

        if($data->save()){
            $res['message'] = "Berhasil dipindahkah kemenu kasir!";
            return response($res);
        }else{
            $res['message'] = "Gagal dipindahkan kemenu kasir!";
            return response($res);
        }
    }

    public function bayarLayanan(Request $request, $id)
    {
        $kasir = $request->input('kasir');
        $diskon = $request->input('diskon');

        $data = Transaksi::where('id',$id)->first();
        $data->status_bayar = 1;
        $data->kasir = $kasir;
        $data->diskon = $diskon;

        if($data->save()){
            $res['message'] = "Berhasil dibayar!";
            return response($res);
        }else{
            $res['message'] = "Gagal dibayar!";
            return response($res);
        }
    }

    public function hapusLayanan($id)
    {
        $data = Transaksi::where('id',$id)->first();

        if($data->delete()){
            $detail = DetailTransaksiLayanan::where('id_transaksi',$data->id_transaksi);
            if($detail->delete()){
                $res['message'] = "Berhasil dibatalkan!";
                return response($res);
            }
            else{
                $res['message'] = "Gagal dibatalkan!";
                return response($res);
            }
        }
        else{
            $res['message'] = "Gagal dibatalkan!";
            return response($res);
        }
    }

    public function hapusProduk($id)
    {
        $data = Transaksi::where('id',$id)->first();

        if($data->delete()){
            $detail = DetailTransaksiProduk::where('id_transaksi',$data->id_transaksi);
            if($detail->delete()){
                $res['message'] = "Berhasil dibatalkan!";
                return response($res);
            }
            else{
                $res['message'] = "Gagal dibatalkan!";
                return response($res);
            }
        }
        else{
            $res['message'] = "Gagal dibatalkan!";
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
