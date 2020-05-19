<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;
use Dompdf\Options;
use App\Hewan;
use App\Layanan;
use App\Transaksi;
use App\DetailTransaksiLayanan;
use App\DetailTransaksiProduk;

class LaporanNotaController extends Controller
{
    public function notaLayanan($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        $detail = DetailTransaksiLayanan::with(['hewan','layanan'])
                    ->where('id_transaksi', $id)->get();
        $hewan = Hewan::with(['customer','jenisHewan'])
                    ->where('id', $detail[0]->id_hewan)->first();
        $layanan = Layanan::with(['ukuranHewan'])
                    ->where('id', $detail[0]->layanan->id_ukuran)->first();

        $pdf = PDF::loadview('nota.layanan',
                        [
                            'transaksi'=>$transaksi,
                            'details'=>$detail,
                            'hewan'=>$hewan,
                            'layanan'=>$layanan
                        ]);
        return $pdf;
    }

    public function notaLayananShow($id)
    {
        return $this->notaLayanan($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->stream();
    }

    public function notaLayananDownload($id)
    {
        $filename = 'NOTA-'.$id.'.pdf';
        return $this->notaLayanan($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }
    
    public function notaProduk($id)
    {
        $transaksi = Transaksi::where('id_transaksi', $id)->first();
        $detail = DetailTransaksiProduk::with(['hewan','produk'])
                    ->where('id_transaksi', $id)->get();
        $hewan = Hewan::with(['customer','jenisHewan'])
                    ->where('id', $detail[0]->id_hewan)->first();
        $produk = Layanan::where('id', $detail[0]->produk->id_produk)->first();

        $pdf = PDF::loadview('nota.produk',
                        [
                            'transaksi'=>$transaksi,
                            'details'=>$detail,
                            'hewan'=>$hewan,
                            'produk'=>$produk
                        ]);
        return $pdf;
    }

    public function notaProdukShow($id)
    {
        return $this->notaProduk($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->stream();
    }

    public function notaProdukDownload($id)
    {
        $filename = 'NOTA-'.$id.'.pdf';
        return $this->notaProduk($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }
}
