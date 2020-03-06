<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Customer;

class CustomerController extends Controller
{
    public function tampil(){
        return Customer::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'telepon' => 'required',
            'created_by' => 'required',
            'updated_by' => 'required',
        ]);

        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $telepon = $request->input('telepon');
        $created_by = $request->input('created_by');
        $updated_by = $request->input('updated_by');
        // $deleted_by = $request->input('deleted_by');

        $data = new Customer();
        $data->nama = $nama;
        $data->alamat = $alamat;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->telepon = $telepon;
        $data->created_by = $created_by;
        $data->updated_by = $updated_by;
        // $data->deleted_by = $deleted_by;

        if($data->save()){
            $res['message'] = "Data customer berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data customer gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $telepon = $request->input('telepon');
        $updated_by = $request->input('updated_by');

        $data = Customer::where('id',$id)->first();
        $data->nama = $nama;
        $data->alamat = $alamat;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->telepon = $telepon;
        $data->updated_by = $updated_by;

        if($data->save()){
            $res['message'] = "Data customer berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data customer gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = Customer::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data customer berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data customer gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Customer::find($id);

        if (is_null($data)){
            $res['message'] = "Data customer tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data customer ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
