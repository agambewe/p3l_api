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

    public function cariPo($id){
        $data = DetailOrderRestock::with(['produk'])
                ->where('id_po', $id)->get();
        if (empty($data)){
            $res['message'] = "Tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Ditemukan!";
            $res['value'] = $data;
            return response($data);
        }
    }
}
