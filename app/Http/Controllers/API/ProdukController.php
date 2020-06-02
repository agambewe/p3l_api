<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Produk;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class ProdukController extends Controller
{
    public function produkMinimal(){
        // return Produk::where('stok','<=','minimal')
        //                 ->get();
        return DB::select('SELECT * FROM `produk` WHERE stok<=minimal');
        // $produk = DB::select('SELECT * FROM `produk` WHERE stok<=minimal');
        // $count = count($produk);
        // for($i = 0; $i < $count; $i++){
        //     $res[] = $produk[$i]->nama;
        // }
        // return response($res);
    }
    
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
        $data->updated_at = null;

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
        if($foto!=null){
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

    public function notifMinimal(){
        $tokens = ['c--bohH5nK-wfhN-7fTOJW:APA91bHjcV8BE9XwaQP3gwdKG9LgypaRsz15LvGkvRjI3B6gse7CR2FSkqN6UxtYF3tqBzj16LKKnX7NjZwg-bm4WrxPyLJaBfqoVMzJFtKeHXmXicBsZyehgD5FdiRR2XqNweHffj_B'];
	
        $header = [
            'Authorization: Key=' . env('FCM_SERVER_KEY'),
            'Content-Type: Application/json'
        ];

        $produk = DB::select('SELECT * FROM `produk` WHERE stok<=minimal');
        $count = count($produk);
        for($i = 0; $i < $count; $i++){
            // $res[] = ;
            $msg = [
                'title' => 'Peringatan!',
                'body' => 'Stok produk '.$produk[$i]->nama.' hampir habis..',
                // 'icon' => 'img/icon.png',
                // 'image' => 'img/d.png',
            ];
    
            $payload = [
                'registration_ids' 	=> $tokens,
                'data'				=> $msg
            ];
    
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode( $payload ),
                CURLOPT_HTTPHEADER => $header
            ));
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;   
            }
        }
    }
    
    public function produkSortByHargaDesc(){
        return DB::select('SELECT * FROM `produk` ORDER by harga DESC');
    }

    public function produkSortByHargaAsc(){
        return DB::select('SELECT * FROM `produk` ORDER by harga ASC');
    }

    public function produkSortByStokAsc(){
        return DB::select('SELECT * FROM `produk` ORDER by stok ASC');
    }

    public function produkSortByStokDesc(){
        return DB::select('SELECT * FROM `produk` ORDER by stok DESC');
    }
}
