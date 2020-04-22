<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Hewan;
use App\DetailTransaksiLayanan;

class HewanController extends Controller
{
    public function tampil(){
        // return Hewan::all();
        return Hewan::with(['customer','jenisHewan'])->get();
        // $a = DetailTransaksiLayanan::where('id_transaksi',"LY-200421-01")->get();
        // dd($a);
        // return $a;
    }

    public function sampah(){
        return Hewan::onlyTrashed()->get();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'id_customer' => 'required',
            'id_jenis' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'created_by' => 'required',
        ]);

        $id_customer = $request->input('id_customer');
        $id_jenis = $request->input('id_jenis');
        $nama = $request->input('nama');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $created_by = $request->input('created_by');

        $data = new Hewan();
        $data->id_customer = $id_customer;
        $data->id_jenis = $id_jenis;
        $data->nama = $nama;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->created_by = $created_by;
        $data->updated_by = $created_by;

        if($data->save()){
            $res['message'] = "Data hewan berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data hewan gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $id_customer = $request->input('id_customer');
        $id_jenis = $request->input('id_jenis');
        $nama = $request->input('nama');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $updated_by = $request->input('updated_by');

        $data = Hewan::where('id',$id)->first();
        $data->id_customer = $id_customer;
        $data->id_jenis = $id_jenis;
        $data->nama = $nama;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->updated_by = $updated_by;

        if($data->save()){
            $res['message'] = "Data hewan berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data hewan gagal diubah!";
            return response($res);
        }
    }

    public function hapusby(Request $request, $id)
    {
        $deleted_by = $request->input('deleted_by');
        $data = Hewan::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data hewan berhasil dihapus!";
                $data = Hewan::onlyTrashed()->where('id',$id)->first();
                $data->deleted_by = $deleted_by;

                if($data->save()){
                    $res['message'] = "Data hewan berhasil dihapus!";
                    return response($res);
                }else{
                    $res['message'] = "Data hewan gagal dihapus!";
                    return response($res);
                }
            return response($res);
        }
        else{
            $res['message'] = "Data hewan gagal dihapus!";
            return response($res);
        }
    }

    // public function hapus($id)
    // {
    //     $data = Hewan::where('id',$id)->first();

    //     if($data->delete()){
    //         $res['message'] = "Data hewan berhasil dihapus!";
    //         return response($res);
    //     }
    //     else{
    //         $res['message'] = "Data hewan gagal dihapus!";
    //         return response($res);
    //     }
    // }
    
    public function cariPunyaSiapa($id){
        $data = Hewan::where('id_customer',$id)->get();

        if (is_null($data)){
            $res['message'] = "Data hewan tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data hewan ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }

    public function cari($id){
        // return Hewan::find($id);

        $sub = DB::select('SELECT h.nama, j.nama "jenis" FROM hewan h 
                JOIN jenis_hewan j ON h.id_jenis=j.id
                WHERE h.id = ?',[$id]);

        $data = $sub[0];
        // return response()->json($data);

        if (empty($data)){
            $res['message'] = "Data hewan tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data hewan ditemukan!";
            $res['value'] = $data;
            // return response($data);
            return response()->json($data);
        }
    }
}
