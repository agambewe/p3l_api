<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Produk;

class ProdukController extends Controller
{
    public function tampil(){
        return Produk::all();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required',
            'satuan' => 'required',
            'stok' => 'required',
            'minimal' => 'required',
            'harga' => 'required',
            'foto' => 'required'
        ]);

        $nama = $request->input('nama');
        $satuan = $request->input('satuan');
        $stok = $request->input('stok');
        $minimal = $request->input('minimal');
        $harga = $request->input('harga');
        $foto = $request->file('foto');
            $nama_file = time()."_".$foto->getClientOriginalName();
            $tujuan_upload = 'uploads';
            $foto->move($tujuan_upload,$nama_file);

        $data = new Produk();
        $data->nama = $nama;
        $data->satuan = $satuan;
        $data->stok = $stok;
        $data->minimal = $minimal;
        $data->harga = $harga;
        $data->foto = $nama_file;

        if($data->save()){
            $res['message'] = "Data produk berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data produk gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');
        $satuan = $request->input('satuan');
        $stok = $request->input('stok');
        $minimal = $request->input('minimal');
        $harga = $request->input('harga');
        $foto = $request->file('foto');
        if($foto!=NULL){
            $nama_file = time()."_".$foto->getClientOriginalName();
            $tujuan_upload = 'uploads';
            $foto->move($tujuan_upload,$nama_file);
        }

        $data = Produk::where('id',$id)->first();
        $data->nama = $nama;
        $data->satuan = $satuan;
        $data->stok = $stok;
        $data->minimal = $minimal;
        $data->harga = $harga;
        if($foto!=NULL){
            $data->foto = $nama_file;
        }

        if($data->save()){
            $res['message'] = "Data produk berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data produk gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = Produk::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data produk berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data produk gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Produk::find($id);

        if (is_null($data)){
            $res['message'] = "Data produk tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data produk ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}
