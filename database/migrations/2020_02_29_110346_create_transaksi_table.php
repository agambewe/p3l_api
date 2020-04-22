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
            $table->string('id_transaksi');
            $table->string('cs', 100);
            $table->string('kasir', 100)->nullable();
            $table->decimal('total_harga', 18, 2)->nullable();
            $table->integer('status_bayar')->default(0);
            $table->integer('status_layanan')->nullable();
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