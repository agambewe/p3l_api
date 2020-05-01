<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\OrderRestock;
use App\DetailOrderRestock;

class OrderRestockController extends Controller
{
    public function tampil(){
        // return OrderRestock::orderBy('status_order', 'asc')->get();
        return OrderRestock::with(['supplier'])->get();
    }

    public function idPoMaker(){
        $simpen = OrderRestock::orderBy('id', 'desc')
                        ->first();

        $sekarang = date('yy-m-d');
        if (!$simpen) {
            $res = "PO-".$sekarang."-01";
        }else{
            $id_po = $simpen->id_po;
            $id_po = explode("-", $id_po);

            $tanggalTerakhir = $id_po[1]."-".$id_po[2]."-".$id_po[3];
            $last = ++$id_po[4];
            if($sekarang==$tanggalTerakhir){
                if(9>=$id_po[4]){
                    $res = $id_po[0]."-".$tanggalTerakhir."-"."0".$last;
                }else{
                    $res = $id_po[0]."-".$tanggalTerakhir."-".$last;
                }
            }else{
                $res = $id_po[0]."-".$sekarang."-01";
            }
        }
        
        return response($res);
    }

    public function tambah(Request $request)
    {

        $this->validateWith([
            'id_supplier' => 'required',
        ]);

        $id_supplier = $request->input('id_supplier');
        $total_bayar = $request->input('total_bayar');
        $aidi = $this->idPoMaker();

        $data = new OrderRestock();
        $data->id_po = $aidi->original;
        $data->id_supplier = $id_supplier;
        $data->status_order = 0;
        $data->tanggal_restock = date('Y-m-d');

        if($data->save()){
            $res['message'] = "Berhasil diproses!";
            $res['value'] = $data->id_po;
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
        }
    }

    public function selesaiRestock(Request $request, $id)
    {

        $data = OrderRestock::where('id',$id)->first();
        $data->status_order = 1;

        $aidi = $data->id_po;
        if($data->save()){
            $this->updateBarangMasuk($aidi);
            $res['message'] = "Barang berhasil diterima!";
            return response($res);
        }else{
            $res['message'] = "Gagal diterima!";
            return response($res);
        }
    }

    public function updateBarangMasuk($id){
        $produk = DB::table('detail_order_restock')
            ->where('id_po',$id)
            ->whereNull('deleted_at')
            ->selectRaw('id_po, id_produk, jumlah')
            ->get();

            foreach ($produk as $d) {
                DB::table('produk')->where('id',$d->id_produk)
                                ->increment('stok', $d->jumlah);
            }
    }

    public function ubah(Request $request, $id)
    {
        $data = OrderRestock::where('id',$id)->first();
        $data->status_order = 1;

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
        $data = OrderRestock::where('id',$id)->first();

        if($data->delete()){
            $detail = DetailOrderRestock::where('id_po',$data->id_po);
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
        $data = OrderRestock::find($id);

        if (is_null($data)){
            $res['message'] = "Tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }

    public function cariPo($idPo){
        $data = OrderRestock::where('id_po',$idPo)->first();

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
