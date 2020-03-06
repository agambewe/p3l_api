<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_hewan')->nullable();
            $table->foreign('id_hewan')
                ->references('id')
                ->on('hewan');
            $table->unsignedInteger('id_detail_transaksi_layanan')->nullable();
            $table->foreign('id_detail_transaksi_layanan')
                ->references('id')
                ->on('detail_transaksi_layanan');
            $table->unsignedInteger('id_detail_transaksi_produk')->nullable();
            $table->foreign('id_detail_transaksi_produk')
                ->references('id')
                ->on('detail_transaksi_produk');
            $table->string('cs', 100);
            $table->string('kasir', 100)->nullable();
            $table->decimal('total_harga', 18, 2)->nullable();
            $table->integer('status_bayar')->default(0);
            $table->integer('status_layanan')->default(0);
            $table->decimal('diskon', 18, 2)->default(0);
            $table->date('tanggal_transaksi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}