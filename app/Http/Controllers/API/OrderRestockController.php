<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\OrderRestock;

class OrderRestockController extends Controller
{
    public function tampil(){
        // return OrderRestock::orderBy('status_order', 'asc')->get();
        return OrderRestock::all();
    }

    public function tambah(Request $request)
    {

        $this->validateWith([
            'id_po' => 'required',
            'id_supplier' => 'required',
            'tanggal_restock' => 'required',
            'total_bayar' => 'required',
        ]);

        $id_po = $request->input('id_po');
        $id_supplier = $request->input('id_supplier');
        $tanggal_restock = $request->input('tanggal_restock');
        $total_bayar = $request->input('total_bayar');
        $status_order = 0;
        // $data = new OrderRestock();
        // $data->id_po = $id_po;
        // $data->id_supplier = $id_supplier;
        // $data->tanggal_restock = $tanggal_restock;
        // $data->total_bayar = $total_bayar;
        // $data->status_order = $status_order;

        $id = DB::table('order_restock')->insertGetId(
            [
                'id_po' => $id_po, 
                'id_supplier' => $id_supplier,
                'tanggal_restock' => $tanggal_restock,
                'total_bayar' => $total_bayar,
                'status_order' => $status_order
            ]
        );

        if(!empty($id)){
            $res['message'] = "Berhasil diproses!";
            $res['id'] = $id;
            return response($res);
        }else{
            $res['message'] = "Gagal diproses!";
            return response($res);
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
            $res['message'] = "Berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Gagal dihapus!";
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
