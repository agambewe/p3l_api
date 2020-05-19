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
                ->setOptions([
                    'isHtml5ParserEnabled' => true, 
                    'isRemoteEnabled' => true])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }
    
    // public function notaLayanan($id_transaksi)
    // {
    //     $transaksi = Transaksi::where('id_transaksi', $id_transaksi)->get();
    //     return $this->buatNota($data, 'notaLayanan');
    // }

    // public function buatNota($data, $report)
    // {
    //     $fileName = $report;
    //     $viewName = 'nota.' . $report;
    //     $json = json_encode($data);
    //     view()->share(['data' => json_decode($json)]);
    //     $pdf = PDF::loadView($viewName);
    //     $pdf->setPaper([0, 0, 600, 800])->save(public_path('/pdf/') . '/' . $fileName . '.pdf');
    //     $path = $fileName . '.pdf';
    //     return response()->json(['status' => 200, 'path' => $path]);
    // }
}
