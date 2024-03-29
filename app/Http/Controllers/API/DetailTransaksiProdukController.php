<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\DetailTransaksiProduk;
use App\Transaksi;

class DetailTransaksiProdukController extends Controller
{
    public function tampil(){
        // return DetailTransaksiProduk::all();
        return DetailTransaksiProduk::with(['hewan','produk'])->get();
    }

    public function updateTotalHarga($id)
    {
        $data = Transaksi::where('id_transaksi',$id)->first();

        $sub = DB::table('detail_transaksi_produk AS d')
                ->join('transaksi AS t', 'd.id_transaksi', '=', 't.id_transaksi')
                ->where('d.id_transaksi',$data->id_transaksi)
                ->whereNull('d.deleted_at')
                ->whereNull('t.deleted_at')
                ->selectRaw('SUM(d.subtotal) as total')
                ->get();

        $data->total_harga = $sub[0]->total;

        if($data->save()){
            $res['message'] = "Berhasil!";
            return response($res);
        }else{
            $res['message'] = "Gagal!";
            return response($res);
        }
    }

    public function updateBarangMasuk($id){
        $produk = DB::table('detail_transaksi_produk')
            ->where('id_transaksi',$id)
            ->selectRaw('id_transaksi, id_produk, jumlah')
            ->get();
            // ->whereNull('deleted_at')

            foreach ($produk as $d) {
                DB::table('produk')->where('id',$d->id_produk)
                                ->increment('stok', $d->jumlah);
            }
    }

    public function updateBarangKeluar($id){
        $produk = DB::table('detail_transaksi_produk')
            ->where('id_transaksi',$id)
            ->selectRaw('id_transaksi, id_produk, jumlah')
            ->get();

            // ->whereNull('deleted_at')

            foreach ($produk as $d) {
                DB::table('produk')->where('id',$d->id_produk)
                                ->decrement('stok', $d->jumlah);
            }
    }

    public function tambah(Request $request)
    {

        $this->validateWith([
            // 'id_hewan' => 'required',
            'id_produk' => 'required',
            'jumlah' => 'required',
            'subtotal' => 'required'
        ]);

        $id_transaksi = $request->input('id_transaksi');
        $id_hewan = $request->input('id_hewan');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');

        $count = count($subtotal);
        for($i = 0; $i < $count; $i++){

            $data = new DetailTransaksiProduk();
            $data->id_transaksi = $id_transaksi;
            if($id_hewan!=null){
                $data->id_hewan = $id_hewan;
            }
            $data->id_produk = $id_produk[$i];
            $data->jumlah = $jumlah[$i];
            $data->subtotal = $subtotal[$i];
            $data->updated_at = null;
            if($data->save()){
                $res['message'] = "berhasil dimasukkan!";
                $res['id'] = $data->id;
                // return response($res);
            }else{
                $res['message'] = "gagal dimasukkan!";
                // return response($res);
            }
        }
        $this->updateBarangKeluar($id_transaksi);
        return response($res);
    }

    public function ubah(Request $request, $id)
    {
        $id_hewan = $request->input('id_hewan');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');
        $updated_by = $request->input('updated_by');

        $this->updateBarangMasuk($id);

        $dataDetil = DetailTransaksiProduk::onlyTrashed()->where('id_transaksi',$id);
        if($dataDetil->exists()){
            $dataDetil->forceDelete();
        }

        $transaksi = Transaksi::where('id_transaksi',$id)->first();
        $transaksi->updated_by = $updated_by;

        if($transaksi->save()){
            $data = DetailTransaksiProduk::where('id_transaksi',$id)->get();

            $count = count($data);
            for($i = 0; $i < $count; $i++){

                $data[$i]->id_hewan = $id_hewan;
                $data[$i]->id_produk = $id_produk[$i];
                $data[$i]->jumlah = $jumlah[$i];
                $data[$i]->subtotal = $subtotal[$i];

                if($data[$i]->save()){
                    $res['message'] = "Berhasil diubah!";
                    // return response($res);
                }else{
                    $res['message'] = "Gagal diubah!";
                    // return response($res);
                }
            }
            $this->updateBarangKeluar($id);
            $this->updateTotalHarga($id);
        }else{
            $res['message'] = "Gagal diubah!";
        }
        return response($res);
    }

    public function ubahCS(Request $request, $id)
    {
        $id_hewan = $request->input('id_hewan');
        $id_produk = $request->input('id_produk');
        $jumlah = $request->input('jumlah');
        $subtotal = $request->input('subtotal');
        $updated_by = $request->input('updated_by');

        $this->updateBarangMasuk($id);

        $dataDetil = DetailTransaksiProduk::onlyTrashed()->where('id_transaksi',$id);
        if($dataDetil->exists()){
            $dataDetil->forceDelete();
        }

        $transaksi = Transaksi::where('id_transaksi',$id)->first();
        $transaksi->updated_by = $updated_by;

        if($transaksi->save()){
            $data = DetailTransaksiProduk::where('id_transaksi',$id)->get();

            $count = count($data);
            for($i = 0; $i < $count; $i++){

                $data[$i]->id_hewan = $id_hewan;
                $data[$i]->id_produk = $id_produk[$i];
                $data[$i]->jumlah = $jumlah[$i];
                $data[$i]->subtotal = $subtotal[$i];

                if($data[$i]->save()){
                    $res['message'] = "Berhasil diubah!";
                    // return response($res);
                }else{
                    $res['message'] = "Gagal diubah!";
                    // return response($res);
                }
            }
            $this->updateBarangKeluar($id);
        }else{
            $res['message'] = "Gagal diubah!";
        }
        return response($res);
    }

    public function hapus($id)
    {
        $data = DetailTransaksiProduk::where('id',$id)->first();

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
        $data = DetailTransaksiProduk::find($id);

        if (is_null($data)){
            $res['message'] = "tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "ditemukan!";
            $res['value'] = "$data";
            return response($data);
        }
    }

    public function cariTransaksi($id){
        $data = DetailTransaksiProduk::with(['hewan','produk'])
                ->where('id_transaksi', $id)->get();
        if (empty($data)){
            $res['message'] = "tidak ditemukan!";
            return response($res);
        }else{
            $res['message'] = "ditemukan!";
            $res['value'] = $data;
            return response($data);
        }
    }

    public function hapusTransaksi(Request $request, $id){
        $index = $request->input('index');

        $data = DetailTransaksiProduk::where('id_transaksi', $id)
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
        $data = DetailTransaksiProduk::onlyTrashed()->where('id_transaksi',$id);
        if($data->restore()){
            $res['message'] = "Berhasil restore!";
            return response($res);
        }
        else{
            $res['message'] = "Gagal restore!";
            return response($res);
        }
    }
    //edit android
     public function ubahId(Request $request, $id)
     {
         $id_hewan = $request->input('id_hewan');
         $id_produk = $request->input('id_produk');
         $jumlah= $request->input('jumlah');
         $subtotal = $request->input('subtotal');
         $this->updateBarangMasuk($id);
         $data = DetailTransaksiProduk::where('id',$id)->first();
 
        // $count = count($data);
        $dataDetil = DetailTransaksiProduk::onlyTrashed()->where('id_transaksi',$id);
        if($dataDetil->exists()){
            $dataDetil->forceDelete();
        }
       // $data = DetailTransaksiProduk::where('id_transaksi',$id)->get();
 
             if($id_hewan!=0){
                 $data->id_hewan = $id_hewan;
             }
             else if($id_hewan!=null){
                 $data->id_hewan = $id_hewan;
             }
             $data->id_produk = $id_produk;
             $data->jumlah = $jumlah;
             $data->subtotal = $subtotal;
             $data->updated_at = null;
 
             if($data->save()){
                 $res['message'] = "Data customer berhasil diubah!";
                 return response($res);
             }else{
                 $res['message'] = "Data customer gagal diubah!";
                 return response($res);
             }
             $this->updateBarangKeluar($id);
             $this->updateTotalHarga($id);
             
         
         return response($res);
     }
    
}
