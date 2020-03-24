<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailOrderRestock;

class DetailOrderRestockController extends Controller
{
    public function tampil(){
        // return DetailOrderRestock::all();
        $query = DB::select('SELECT * from order_restock 
                JOIN detail_order_restock ON order_restock.id = detail_order_restock.id_order_restock
                ORDER BY order_restock.id_po DESC ');
        return $query;
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'id_order_restock' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
            'subtotal' => 'required'
        ]);

        $id_order_restock = $request->input('id_order_restock');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');
        $total = 0;

        $count = count($id_produk);
        for($i = 0; $i < $count; $i++){
            $id = DB::table('detail_order_restock')->insertGetId(
                [
                    'id_order_restock' => $id_order_restock[$i], 
                    'id_produk' => $id_produk[$i],
                    'jumlah' => $jumlah[$i],
                    'subtotal' => $subtotal[$i]
                ]
            );
            $total = $total + $subtotal[$i];
        }

        //update TOTAL
        DB::table('order_restock')
            ->where('id', $id_order_restock[0])
            ->update(['total_bayar' => $total]);

        if(!empty($id)){
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

        $data = DetailOrderRestock::where('id',$id)->first();
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
        $data = DetailOrderRestock::where('id',$id)->first();

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
        $data = DetailOrderRestock::find($id);

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
