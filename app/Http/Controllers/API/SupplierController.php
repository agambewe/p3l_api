<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Supplier;

class SupplierController extends Controller
{
    public function tampil(){
        return Supplier::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $telepon = $request->input('telepon');

        $data = new Supplier();
        $data->nama = $nama;
        $data->alamat = $alamat;
        $data->telepon = $telepon;
        $data->updated_at = null;

        if($data->save()){
            $res['message'] = "Data supplier berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data supplier gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $telepon = $request->input('telepon');

        $data = Supplier::where('id',$id)->first();
        $data->nama = $nama;
        $data->alamat = $alamat;
        $data->telepon = $telepon;

        if($data->save()){
            $res['message'] = "Data supplier berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data supplier gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = Supplier::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data supplier berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data supplier gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Supplier::find($id);

        if (is_null($data)){
            $res['message'] = "Data supplier tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data supplier ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
