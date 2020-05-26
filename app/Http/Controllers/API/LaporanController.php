<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use PDF;
use Carbon\Carbon;
use Dompdf\Options;
use App\Hewan;
use App\Layanan;
use App\Produk;
use App\Supplier;
use App\Transaksi;
use App\OrderRestock;
use App\DetailOrderRestock;
use App\DetailTransaksiProduk;
use App\DetailTransaksiLayanan;

class LaporanController extends Controller
{
    //Laporan Pengadaan Tahunan
    public function laporanPengadaan_pdf($tahun)
    {
        $dt = Carbon::now()->translatedFormat('d F Y');
        $data = DB::select("
        SELECT MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) AS Bulan, 
        COALESCE(sum(restock),0) AS total_bayar
        FROM (
        SELECT '2000-01-01 00:00:00' as bulan UNION
        SELECT '2000-02-01 00:00:00' as bulan UNION
        SELECT '2000-03-01 00:00:00' as bulan UNION
        SELECT '2000-04-01 00:00:00' as bulan UNION
        SELECT '2000-05-01 00:00:00' as bulan UNION
        SELECT '2000-06-01 00:00:00' as bulan UNION
        SELECT '2000-07-01 00:00:00' as bulan UNION
        SELECT '2000-08-01 00:00:00' as bulan UNION
        SELECT '2000-09-01 00:00:00' as bulan UNION
        SELECT '2000-10-01 00:00:00' as bulan UNION
        SELECT '2000-11-01 00:00:00' as bulan UNION
        SELECT '2000-12-01 00:00:00' as bulan 
        )AS m 
        LEFT JOIN (
            SELECT
                tanggal_restock,
                subtotal restock
            FROM order_restock JOIN detail_order_restock USING (id_po)
            WHERE year(tanggal_restock) = $tahun
        ) p ON MONTHNAME(p.tanggal_restock) = MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) 
        GROUP BY YEAR(p.tanggal_restock) = $tahun,m.bulan
        ORDER by m.bulan ASC");
        $pdf = PDF::loadview('laporan.pengadaanTahunan',
            [
                'tahun'=>$tahun,
                'data' =>$data
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

    //Laporan Pengadaan Bulanan
    public function laporanPengadaanBulanan_pdf($tahun,$bulan)
    {
        if($bulan==1){
            $bulan = 'January'; 
        }else if($bulan==2){
            $bulan = 'February'; 
        }else if($bulan==3){
            $bulan = 'May'; 
        }
        else if($bulan==3){
            $bulan = 'March'; 
        }
        else if($bulan==4){
            $bulan = 'April'; 
        }
        else if($bulan==5){
            $bulan = 'May'; 
        }
        else if($bulan==6){
            $bulan = 'June'; 
        }
        else if($bulan==7){
            $bulan = 'July'; 
        }
        else if($bulan==8){
            $bulan = 'August'; 
        }
        else if($bulan==9){
            $bulan = 'September'; 
        }
        else if($bulan==10){
            $bulan = 'October'; 
        }
        else if($bulan==11){
            $bulan = 'November'; 
        }
        else if($bulan==12){
            $bulan = 'December'; 
        }
        $dt = Carbon::now()->translatedFormat('d F Y');
        $data = DB::select(
            "SELECT o.tanggal_restock, p.nama, sum(d.subtotal) AS subtotal
            FROM order_restock o
            join detail_order_restock d on o.id_po = d.id_po
            JOIN produk p on p.id = d.id_produk
            WHERE monthname(o.tanggal_restock) = '$bulan'
            AND year(o.tanggal_restock) = $tahun
            GROUP BY p.id"
        );
       
        $pdf = PDF::loadview('laporan.pengadaanBulanan',
            [
                'tahun'=>$tahun,
                'bulan'=>$bulan,
                'data'=>$data,
            ]); 
        return $pdf;
    }

    public function tampilBulanan_pdf($tahun,$bulan)
    {
        $filename = 'LAPORAN-'.$tahun.'-'.$bulan.'.pdf';
        return $this->laporanPengadaanBulanan_pdf($tahun,$bulan)
        ->setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper([0, 0, 600, 800])
        ->stream($filename);
    }

    public function cetakBulanan_pdf($tahun,$bulan)
    {
        $filename = 'LAPORAN-'.$tahun.'-'.$bulan.'.pdf';
        return $this->laporanPengadaanBulanan_pdf($tahun,$bulan)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->download($filename);
    }

    //Laporan Layanan Terlaris
    public function LaporanLayananTerlaris($tahun)
    {
        set_time_limit(300);
        $data = DB::select("SELECT MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) AS Bulan, 
        COALESCE(nama,'-') AS layanan,
        COALESCE(max(total),0) max
        FROM (
            SELECT '2000-01-01 00:00:00' as bulan UNION
            SELECT '2000-02-01 00:00:00' as bulan UNION
            SELECT '2000-03-01 00:00:00' as bulan UNION
            SELECT '2000-04-01 00:00:00' as bulan UNION
            SELECT '2000-05-01 00:00:00' as bulan UNION
            SELECT '2000-06-01 00:00:00' as bulan UNION
            SELECT '2000-07-01 00:00:00' as bulan UNION
            SELECT '2000-08-01 00:00:00' as bulan UNION
            SELECT '2000-09-01 00:00:00' as bulan UNION
            SELECT '2000-10-01 00:00:00' as bulan UNION
            SELECT '2000-11-01 00:00:00' as bulan UNION
            SELECT '2000-12-01 00:00:00' as bulan 
        )AS m 
        LEFT JOIN (
            SELECT t.tanggal_transaksi, concat(l.nama, concat(' ', u.nama)) AS nama, SUM(1) AS total
            FROM transaksi t
            JOIN detail_transaksi_layanan d ON t.id_transaksi = d.id_transaksi
            join layanan l on l.id = d.id_layanan
            JOIN ukuran_hewan u on u.id = l.id_ukuran
            WHERE YEAR(t.tanggal_transaksi) = $tahun
            GROUP BY l.id
        ) p ON MONTHNAME(p.tanggal_transaksi) = MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) 
        GROUP BY YEAR(p.tanggal_transaksi) = $tahun,m.bulan
        ORDER by m.bulan ASC");
        $pdf = PDF::loadview('laporan.LTerlaris',
                        [
                            'tahun'=>$tahun,
                           'data'=>$data,
                        ]);
        return $pdf;
    }

    public function lTerlarisShowa($id)
    {
        return $this->LaporanLayananTerlaris($id)
                ->setOptions(['isRemoteEnabled' => TRUE])
                ->setPaper([0, 0, 600, 800])
                ->stream();
    }

    //Laporan Produk Terlaris
    public function laporanProdukTerlaris($tahun){
        set_time_limit(300);
        $data = DB::select("
        SELECT MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) AS Bulan, 
            COALESCE(nama,'-') AS produk,
            COALESCE(max(total),0) max
            FROM (
                SELECT '2000-01-01 00:00:00' as bulan UNION
                SELECT '2000-02-01 00:00:00' as bulan UNION
                SELECT '2000-03-01 00:00:00' as bulan UNION
                SELECT '2000-04-01 00:00:00' as bulan UNION
                SELECT '2000-05-01 00:00:00' as bulan UNION
                SELECT '2000-06-01 00:00:00' as bulan UNION
                SELECT '2000-07-01 00:00:00' as bulan UNION
                SELECT '2000-08-01 00:00:00' as bulan UNION
                SELECT '2000-09-01 00:00:00' as bulan UNION
                SELECT '2000-10-01 00:00:00' as bulan UNION
                SELECT '2000-11-01 00:00:00' as bulan UNION
                SELECT '2000-12-01 00:00:00' as bulan 
            )AS m 
            LEFT JOIN (
         SELECT t.tanggal_transaksi,  p.nama AS nama, SUM(1) AS total
        FROM transaksi t 
        JOIN detail_transaksi_produk d on t.id_transaksi = d.id_transaksi 
        join produk p on p.id = d.id_produk
        WHERE YEAR(t.tanggal_transaksi) = $tahun
        GROUP BY p.id
    ) p ON
    MONTHNAME(p.tanggal_transaksi) = MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) 
            GROUP BY YEAR(p.tanggal_transaksi) = $tahun,m.bulan
            ORDER by m.bulan ASC
    "); 
    $pdf = PDF::loadview('laporan.PTerlaris',
    [
        'tahun'=>$tahun,
       'data'=>$data,
    ]);
return $pdf;
}

public function PTerlarisShowa($id)
{
    return $this->laporanProdukTerlaris($id)
            ->setOptions(['isRemoteEnabled' => TRUE])
            ->setPaper([0, 0, 600, 800])
            ->stream();
}

//Pendapatan Pendapatan Bulanan
public function laporanPendapatanProduk($tahun,$bulan){
    // $bulan = 'May';
    if($bulan==1){
        $bulan = 'January'; 
    }else if($bulan==2){
        $bulan = 'February'; 
    }else if($bulan==3){
        $bulan = 'May'; 
    }
    else if($bulan==3){
        $bulan = 'March'; 
    }
    else if($bulan==4){
        $bulan = 'April'; 
    }
    else if($bulan==5){
        $bulan = 'May'; 
    }
    else if($bulan==6){
        $bulan = 'June'; 
    }
    else if($bulan==7){
        $bulan = 'July'; 
    }
    else if($bulan==8){
        $bulan = 'August'; 
    }
    else if($bulan==9){
        $bulan = 'September'; 
    }
    else if($bulan==10){
        $bulan = 'October'; 
    }
    else if($bulan==11){
        $bulan = 'November'; 
    }
    else if($bulan==12){
        $bulan = 'December'; 
    }
    $dLananan =  DB::select("
    SELECT DISTINCT concat(l.nama, concat(' ', u.nama)) as nama, sum(d.subtotal) as harga FROM transaksi t JOIN detail_transaksi_layanan d ON d.id_transaksi = t.id_transaksi JOIN layanan l ON l.id = d.id_layanan JOIN ukuran_hewan u ON u.id = l.id_ukuran WHERE monthname(t.tanggal_transaksi) = '$bulan' AND year(t.tanggal_transaksi) = $tahun GROUP BY l.id
");
    $data = DB::select("
    SELECT p.nama, sum(d.subtotal) as harga FROM transaksi t JOIN detail_transaksi_produk d ON d.id_transaksi = t.id_transaksi JOIN produk p ON p.id = d.id_produk WHERE monthname(t.tanggal_transaksi) = '$bulan' AND year(t.tanggal_transaksi) = $tahun GROUP BY p.id");
    $pdf = PDF::loadview('laporan.pBulananProduk',
    [
        'tahun'=>$tahun,
        'bulan'=>$bulan,
       'data'=>$data,
       'dLananan'=>$dLananan
    ]);
    return $pdf;
}
public function PProdukBulanShow($id,$bulan)
{
    return $this->laporanPendapatanProduk($id,$bulan)
            ->setOptions(['isRemoteEnabled' => TRUE])
            ->setPaper([0, 0, 600, 800])
            ->stream();
}

//Laporan Pendapatan Tahunan
public function laporanPendapatanTahunan($tahun){
    $data = DB::select("
    SELECT MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) AS Bulan, 
    COALESCE(sum(layanan),0) - COALESCE(sum(dip),0) AS Layanan,
    COALESCE(sum(produk),0) - COALESCE(sum(dis),0) AS Produk,
    COALESCE(sum(layanan),0) + COALESCE(sum(produk),0) - COALESCE(sum(dip),0) - COALESCE(sum(dis),0)  AS Total
    FROM (
        SELECT '2000-01-01 00:00:00' as bulan UNION
        SELECT '2000-02-01 00:00:00' as bulan UNION
        SELECT '2000-03-01 00:00:00' as bulan UNION
        SELECT '2000-04-01 00:00:00' as bulan UNION
        SELECT '2000-05-01 00:00:00' as bulan UNION
        SELECT '2000-06-01 00:00:00' as bulan UNION
        SELECT '2000-07-01 00:00:00' as bulan UNION
        SELECT '2000-08-01 00:00:00' as bulan UNION
        SELECT '2000-09-01 00:00:00' as bulan UNION
        SELECT '2000-10-01 00:00:00' as bulan UNION
        SELECT '2000-11-01 00:00:00' as bulan UNION
        SELECT '2000-12-01 00:00:00' as bulan 
    )AS m 
    LEFT JOIN (
        SELECT
                id_transaksi,
                tanggal_transaksi,
                subtotal layanan,
                0 produk,
                0 dip,
                0 dis
            FROM
                transaksi
            JOIN detail_transaksi_layanan USING(id_transaksi)
            WHERE year(tanggal_transaksi) = $tahun
            UNION ALL
            SELECT
                id_transaksi,
                tanggal_transaksi,
                0 layanan,
                subtotal produk,
                0 dip,
                0 dis
            FROM
                transaksi
            JOIN detail_transaksi_produk USING(id_transaksi)
            WHERE year(tanggal_transaksi) = $tahun
            UNION ALL
            SELECT
                id_transaksi,
                tanggal_transaksi,
                0 layanan,
                0 produk,
                diskon dis,
                0 dip
            FROM transaksi
            WHERE year(tanggal_transaksi) = $tahun
            AND status_layanan is not null
            UNION ALL
            SELECT
                id_transaksi,
                tanggal_transaksi,
                0 layanan,
                0 produk,
                0 dis,
                diskon dip
            FROM transaksi
            WHERE year(tanggal_transaksi) = $tahun
            AND status_layanan is null
    ) p ON MONTHNAME(p.tanggal_transaksi) = MONTHNAME(STR_TO_DATE(m.bulan, '%Y-%m-%d %H:%i:%s')) 
    GROUP BY YEAR(p.tanggal_transaksi) = $tahun,m.bulan
    ORDER by m.bulan");
    $pdf = PDF::loadview('laporan.pBTahunan',
    [
        'tahun'=>$tahun,
       'data'=>$data,
    ]);
    return $pdf;
}
public function PendapatanTahunanShow($id)
{
    return $this->laporanPendapatanTahunan($id)
            ->setOptions(['isRemoteEnabled' => TRUE])
            ->setPaper([0, 0, 600, 800])
            ->stream();
}


}

