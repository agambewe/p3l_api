<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use PDF;
use Dompdf\Options;
use App\Hewan;
use App\Layanan;
use App\Supplier;
use App\Transaksi;
use App\OrderRestock;
use App\DetailOrderRestock;
use App\DetailTransaksiProduk;
use App\DetailTransaksiLayanan;

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

        $pdf = PDF::loadview('nota.produk',
                        [
                            'transaksi'=>$transaksi,
                            'details'=>$detail,
                            'hewan'=>$hewan
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

    public function notaRestock($id)
    {
        $po = OrderRestock::where('id_po', $id)->first();
        $detail = DetailOrderRestock::with(['supplier','produk'])
                    ->where('id_po', $id)->get();
        $supplier = Supplier::where('id', $detail[0]->id_supplier)->first();

        $pdf = PDF::loadview('nota.restock',
                        [
                            'po'=>$po,
                            'details'=>$detail,
                            'supplier'=>$supplier
                        ]);
        return $pdf;
    }

    public function notaRestockShow($id)
    {
        $filename = 'NOTA-'.$id.'.pdf';
        return $this->notaRestock($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                // ->save(public_path('/pdf/').$filename)
                ->stream($filename);
    }

    public function notaRestockDownload($id)
    {
        $filename = 'NOTA-'.$id.'.pdf';
        // $output = $this->notaRestock($id)->output();

        // return new Response($output, 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' =>  'inline; filename="myfilename.pdf"',
        // ]);
        return $this->notaRestock($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }
}
