<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;
use Carbon\Carbon;
use App\Produk;
use App\OrderRestock;
use App\DetailOrderRestock;

class LaporanPengadaanController extends Controller
{
    public function laporanPengadaan_pdf($tahun)
    {
        $dt = Carbon::now()->translatedFormat('d F Y');
        $pengadaan = OrderRestock::whereYear('tanggal_restock', '=' , $tahun)
                         ->first();
        $detail = DetailOrderRestock::select(DB::raw('DATE_FORMAT(tanggal_restock, "%Y") as tahuntampil'),DB::raw('DATE_FORMAT(tanggal_restock, "%M") as bulan'),DB::raw('sum(total_bayar) as total_bayar'))
        ->join('order_restock AS T','T.id_po','=','detail_order_restock.id_po')
        ->join('produk AS P','P.id','=','detail_order_restock.id_produk')
        ->whereYear('tanggal_restock','=',$tahun)
        ->groupBy('total_bayar')
        ->groupBy('tahuntampil')
        ->groupBy('bulan')
        ->orderBy('tanggal_restock','asc')
        ->get();
         $produk = Produk::all();
        $pdf = PDF::loadview('laporan.pengadaan',
            [
                'pengadaan'=>$pengadaan,
                'details'=>$detail,
                'produk'=>$produk
            ]); 
        return $pdf;
    }

    public function tampil_pdf($tahun)
    {
        $filename = 'LAPORAN-'.$tahun.'.pdf';
        return $this->laporanPengadaan_pdf($tahun)
        ->setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper([0, 0, 600, 800])
        ->stream($filename);
    }

    public function cetak_pdf($tahun)
    {
        $filename = 'LAPORAN-'.$tahun.'.pdf';
        return $this->laporanPengadaan_pdf($tahun)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }
    
}