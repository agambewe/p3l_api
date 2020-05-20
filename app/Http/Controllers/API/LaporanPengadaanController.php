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
use App\Suplier;

class LaporanPengadaanController extends Controller
{
    public function cetak_pdf($tahun)
    {
        // get Sekarang buat tanggal transaksi
        $dt = Carbon::now()->translatedFormat('d F Y');
        $pengadaan = DetailOrderRestock::
        select(DB::raw('sum(subtotal) as subtotal'),DB::raw('DATE_FORMAT(tanggal_restock, "%M") as bulan'))
        ->join('order_restock AS T','T.id_po','=','detail_order_restock.id_po')
        ->join('produk AS P','P.id','=','detail_order_restock.id_produk')
        //Tahun Sesuai input
        ->whereYear('tanggal_restock','=',$tahun)
        //Grouping berdasarkan bulan
        ->groupBy('bulan')
        ->orderBy('tanggal_restock','asc')
        ->get();
        $pdf = PDF::loadview('laporan.pengadaan', ['pengadaan' => $pengadaan]);
        return $pdf->download('laporan-pengadaan-pdf.pdf', compact('dt','pengadaan','tahun'));
    }

    public function tampil_pdf($tahun)
    {
        // get Sekarang buat tanggal transaksi
        $dt = Carbon::now()->translatedFormat('d F Y');
        $pengadaan = DetailOrderRestock::
        select(DB::raw('sum(subtotal) as subtotal'),DB::raw('DATE_FORMAT(tanggal_restock, "%M") as bulan'))
        ->join('order_restock AS T','T.id_po','=','detail_order_restock.id_po')
        ->join('produk AS P','P.id','=','detail_order_restock.id_produk')
        //Tahun Sesuai input
        ->whereYear('tanggal_restock','=',$tahun)
        //Grouping berdasarkan bulan
        ->groupBy('bulan')
        ->orderBy('tanggal_restock','asc')
        ->get();
        $pdf = PDF::loadview('laporan.pengadaan', ['pengadaan' => $pengadaan]);
        return $pdf->stream('laporan-pengadaan-pdf.pdf', compact('dt','pengadaan','tahun'));
    }
    
}