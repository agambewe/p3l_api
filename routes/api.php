<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/login', 'Auth\LoginController@login');
Route::post('/login', 'API\PegawaiController@login');

//pegawai
Route::get('/pegawai', 'API\PegawaiController@tampil');
Route::get('/pegawai/terhapus', 'API\PegawaiController@sampah');
Route::post('/pegawai', 'API\PegawaiController@tambah');
Route::post('/pegawai/{id}', 'API\PegawaiController@ubah');
Route::delete('/pegawai/{id}', 'API\PegawaiController@hapus');
Route::get('/pegawai/{id}', 'API\PegawaiController@cari');

//customer
Route::get('/customer', 'API\CustomerController@tampil');
Route::get('/customer/terhapus', 'API\CustomerController@sampah');
Route::post('/customer', 'API\CustomerController@tambah');
Route::post('/customer/{id}', 'API\CustomerController@ubah');
Route::delete('/customer/{id}', 'API\CustomerController@hapus');
Route::post('/customer/by/{id}', 'API\CustomerController@hapusby');
Route::get('/customer/{id}', 'API\CustomerController@cari');
// Route::get('/customer/nama/{nama}', 'API\CustomerController@cariUser');

//hewan
Route::get('/hewan', 'API\HewanController@tampil');
Route::get('/hewan/terhapus', 'API\HewanController@sampah');
Route::post('/hewan', 'API\HewanController@tambah');
Route::post('/hewan/{id}', 'API\HewanController@ubah');
Route::delete('/hewan/{id}', 'API\HewanController@hapus');
Route::post('/hewan/by/{id}', 'API\HewanController@hapusby');
Route::get('/hewan/{id}', 'API\HewanController@cari');

//supplier
Route::get('/supplier', 'API\SupplierController@tampil');
Route::post('/supplier', 'API\SupplierController@tambah');
Route::post('/supplier/{id}', 'API\SupplierController@ubah');
Route::delete('/supplier/{id}', 'API\SupplierController@hapus');
Route::get('/supplier/{id}', 'API\SupplierController@cari');

//produk
Route::get('/produk', 'API\ProdukController@tampil');
Route::post('/produk', 'API\ProdukController@tambah');
Route::post('/produk/{id}', 'API\ProdukController@ubah');
Route::delete('/produk/{id}', 'API\ProdukController@hapus');
Route::get('/produk/{id}', 'API\ProdukController@cari');

//layanan
Route::get('/layanan', 'API\LayananController@tampil');
Route::post('/layanan', 'API\LayananController@tambah');
Route::post('/layanan/{id}', 'API\LayananController@ubah');
Route::delete('/layanan/{id}', 'API\LayananController@hapus');
Route::get('/layanan/{id}', 'API\LayananController@cari');

//ukuran hewan
Route::get('/ukuran-hewan', 'API\UkuranHewanController@tampil');
Route::post('/ukuran-hewan', 'API\UkuranHewanController@tambah');
Route::post('/ukuran-hewan/{id}', 'API\UkuranHewanController@ubah');
Route::delete('/ukuran-hewan/{id}', 'API\UkuranHewanController@hapus');
Route::get('/ukuran-hewan/{id}', 'API\UkuranHewanController@cari');

//jenis hewan
Route::get('/jenis-hewan', 'API\JenisHewanController@tampil');
Route::post('/jenis-hewan', 'API\JenisHewanController@tambah');
Route::post('/jenis-hewan/{id}', 'API\JenisHewanController@ubah');
Route::delete('/jenis-hewan/{id}', 'API\JenisHewanController@hapus');
Route::get('/jenis-hewan/{id}', 'API\JenisHewanController@cari');

//detail transaksi produk
Route::get('/detail-transaksi-produk', 'API\DetailTransaksiProdukController@tampil');
Route::post('/detail-transaksi-produk', 'API\DetailTransaksiProdukController@tambah');
Route::post('/detail-transaksi-produk/{id}', 'API\DetailTransaksiProdukController@ubah');
Route::delete('/detail-transaksi-produk/{id}', 'API\DetailTransaksiProdukController@hapus');
Route::get('/detail-transaksi-produk/{id}', 'API\DetailTransaksiProdukController@cari');

//detail transaksi layanan
Route::get('/detail-transaksi-layanan', 'API\DetailTransaksiLayananController@tampil');
Route::post('/detail-transaksi-layanan', 'API\DetailTransaksiLayananController@tambah');
Route::post('/detail-transaksi-layanan/{id}', 'API\DetailTransaksiLayananController@ubah');
Route::delete('/detail-transaksi-layanan/{id}', 'API\DetailTransaksiLayananController@hapus');
Route::get('/detail-transaksi-layanan/{id}', 'API\DetailTransaksiLayananController@cari');

//detail order restock
Route::get('/detail-order-restock', 'API\DetailOrderRestockController@tampil');
Route::post('/detail-order-restock', 'API\DetailOrderRestockController@tambah');
Route::post('/detail-order-restock/{id}', 'API\DetailOrderRestockController@ubah');
Route::delete('/detail-order-restock/{id}', 'API\DetailOrderRestockController@hapus');
Route::get('/detail-order-restock/{id}', 'API\DetailOrderRestockController@cari');