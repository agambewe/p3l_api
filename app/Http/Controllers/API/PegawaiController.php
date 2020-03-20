<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Hash;
use App\Pegawai;

class PegawaiController extends Controller
{
    public function login(Request $request)
    {
        $this->validateWith([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $users = Pegawai::where('username',$username)->first();
        if(!$users){
            return response()->json([
                'status' => 'failed',
                'message' => 'username tidak terdaftar!'
            ]);
        }
        if ($username === $users->username && Hash::check($password,  $users->password)) {
            return response()->json([
                'status' => 'success', 
                'user' => $username,
                'message' => 'sukses login'
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failed',
                'message' => 'username password tidak cocok!'
                ]);
        }
    }
    public function tampil(){
        return Pegawai::all();
    }

    public function sampah(){
        return Pegawai::onlyTrashed()->get();
    }

    public function tambah(Request $request)
    {
        $this->validateWith([
            'nama' => 'required',
            'username' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'telepon' => 'required',
            'role' => 'required'
        ]);

        $nama = $request->input('nama');
        $username = $request->input('username');
        $alamat = $request->input('alamat');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $telepon = $request->input('telepon');
        $role = $request->input('role');
        $password = $request->input('password');

        $data = new Pegawai();
        $data->nama = $nama;
        $data->username = $username;
        $data->alamat = $alamat;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->telepon = $telepon;
        $data->role = $role;
        $data->password = bcrypt($password);

        if($data->save()){
            $res['message'] = "Data pegawai berhasil dimasukkan!";
            return response($res);
        }else{
            $res['message'] = "Data pegawai gagal dimasukkan!";
            return response($res);
        }
    }

    public function ubah(Request $request, $id)
    {
        $nama = $request->input('nama');
        $username = $request->input('username');
        $alamat = $request->input('alamat');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $telepon = $request->input('telepon');
        $role = $request->input('role');
        $password = $request->input('password');

        $data = Pegawai::where('id',$id)->first();
        $data->nama = $nama;
        $data->username = $username;
        $data->alamat = $alamat;
        $data->tanggal_lahir = $tanggal_lahir;
        $data->telepon = $telepon;
        $data->role = $role;
        if($password!=null){
            $password = Hash::make($password);
            $data->password = $password;
        }

        if($data->save()){
            $res['message'] = "Data pegawai berhasil diubah!";
            return response($res);
        }else{
            $res['message'] = "Data pegawai gagal diubah!";
            return response($res);
        }
    }

    public function hapus($id)
    {
        $data = Pegawai::where('id',$id)->first();

        if($data->delete()){
            $res['message'] = "Data pegawai berhasil dihapus!";
            return response($res);
        }
        else{
            $res['message'] = "Data pegawai gagal dihapus!";
            return response($res);
        }
    }

    public function cari($id){
        $data = Pegawai::find($id);

        if (is_null($data)){
            $res['message'] = "Data pegawai tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "Data pegawai ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }
}