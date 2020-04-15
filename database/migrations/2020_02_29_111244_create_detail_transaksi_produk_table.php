<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_produk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transaksi');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk');
            $table->integer('jumlah');
            $table->decimal('subtotal', 18, 2);
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
        Schema::dropIfExists('detail_transaksi_produk');
    }
}
