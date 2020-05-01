<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailOrderRestock;
use App\OrderRestock;
use App\Produk;

class DetailOrderRestockController extends Controller
{
    public function tampil(){
        // return DetailOrderRestock::all();
        return DetailOrderRestock::with(['produk'])->get();
    }

    public function updateSupplier($id, $id_supplier)
    {
        $data = OrderRestock::where('id_po',$id)->first();
        $data->id_supplier = $id_supplier;

        if($data->save()){
            $res['message'] = "Berhasil!";
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }
    }

    public function updateTotalHarga($id)
    {
        $data = OrderRestock::where('id_po',$id)->first();

        $sub = DB::table('detail_order_restock AS d')
                ->join('order_restock AS o', 'd.id_po', '=', 'o.id_po')
                ->where('d.id_po',$data->id_po)
                ->whereNull('d.deleted_at')
                ->whereNull('o.deleted_at')
                ->selectRaw('SUM(d.subtotal) as total')
                ->get();

        $data->total_bayar = $sub[0]->total;

        if($data->save()){
            $res['message'] = "Berhasil!";
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }
    }

    public function tambah(Request $request)
    {

        $this->validateWith([
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        $id_po = $request->input('id_po');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');

        $count = count($id_produk);
        for($i = 0; $i < $count; $i++){

            $data = new DetailOrderRestock();
            $data->id_po = $id_po;
            $data->id_produk = $id_produk[$i];
            $data->jumlah = $jumlah[$i];
                $produk = Produk::where('id',$id_produk[$i])->first();
            $data->subtotal = $produk->harga*$jumlah[$i];
            if($data->save()){
                $res['message'] = "Berhasil dipesan!";
                $res['id'] = $data->id;
            }else{
                $res['message'] = "Gagal dipesan!";
            }
        }
        $this->updateTotalHarga($id_po);
        return response($res);
    }

    public function ubah(Request $request, $id)
    {
        $id_supplier = $request->input('id_supplier');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');

        $data = DetailOrderRestock::where('id_po',$id)->get();

        $count = count($data);
        for($i = 0; $i < $count; $i++){

            $data[$i]->id_produk = $id_produk[$i];
            $data[$i]->jumlah = $jumlah[$i];
                $produk = Produk::where('id',$id_produk[$i])->first();
            $data[$i]->subtotal = $produk->harga*$jumlah[$i];

            if($data[$i]->save()){
                $res['message'] = "Berhasil diubah!";
            }else{
                $res['message'] = "Gagal diubah!";
            }
        }
        $this->updateSupplier($id, $id_supplier);
        $this->updateTotalHarga($id);
        return response($res);
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

    public function cariPo($id){
        $data = DetailOrderRestock::with(['supplier','produk'])
                ->join('order_restock AS o', 'detail_order_restock.id_po', '=', 'o.id_po')
                ->where('detail_order_restock.id_po',$id)
                ->whereNull('detail_order_restock.deleted_at')
                ->whereNull('o.deleted_at')
                ->get();
        if (empty($data)){
            $res['message'] = "Tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Ditemukan!";
            $res['value'] = $data;
            return response($data);
        }
    }

    public function hapusPo(Request $request, $id){
        $index = $request->input('index');

        $data = DetailOrderRestock::where('id_po', $id)
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

    public function restoreList($id){
        $data = DetailOrderRestock::onlyTrashed()->where('id_po',$id);
        if($data->restore()){
            $res['message'] = "Berhasil restore!";
            return response($res);
        }
        else{
            $res['message'] = "Gagal restore!";
            return response($res);
        }
    }
}
