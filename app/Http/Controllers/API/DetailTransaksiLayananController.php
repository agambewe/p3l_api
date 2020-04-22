<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailTransaksiLayanan;

class DetailTransaksiLayananController extends Controller
{
    public function tampil(){
        return DetailTransaksiLayanan::with(['hewan','layanan'])->get();
    }

    public function tambah(Request $request)
    {

        $this->validateWith([
            'id_hewan' => 'required',
            'id_layanan' => 'required',
            'subtotal' => 'required'
        ]);

        $id_transaksi = $request->input('id_transaksi');
        $id_hewan = $request->input('id_hewan');
        $id_layanan = $request->input('id_layanan');
        $subtotal = $request->input('subtotal');

        $count = count($subtotal);
        for($i = 0; $i < $count; $i++){

            $data = new DetailTransaksiLayanan();
            $data->id_transaksi = $id_transaksi;
            $data->id_hewan = $id_hewan;
            $data->id_layanan = $id_layanan[$i];
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

    // public function cariTransaksi($id){
    //     $data = DetailTransaksiLayanan::where('id_transaksi',$id)->get();

    //     if (is_null($data)){
    //         $res['message'] = "tidak ditemukan!";
    //         return response($res);
    //     }else{
    //         $res['message'] = "ditemukan!";
    //         $res['value'] = "$data";
    //         return response($data);
    //     }
    // }

    public function cariTransaksi($id){
        // $data = DetailTransaksiLayanan::where('id_transaksi',$id)->get();
	
        // $data = DB::select('SELECT d.id, d.id_transaksi, c.id "id_customer", 
        //                     c.nama, d.id_hewan, d.id_layanan, d.subtotal 
        //                     FROM detail_transaksi_layanan d 
        //                     JOIN hewan h ON d.id_hewan=h.id
        //                     JOIN customer c ON h.id_customer=c.id
        //                     WHERE id_transaksi = ?',[$id]);
        // $data = DB::table('detail_transaksi_layanan')
        //     ->join('hewan', 'detail_transaksi_layanan.id_hewan', 'hewan.id')
        //     ->join('customer', 'hewan.id_customer', 'customer.id')
        //     ->where('detail_transaksi_layanan.id_transaksi', $id)
        //     ->get();

        $data = DetailTransaksiLayanan::with(['hewan','layanan'])
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
}
