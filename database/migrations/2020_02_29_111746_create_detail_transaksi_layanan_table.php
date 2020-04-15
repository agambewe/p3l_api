<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_layanan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_transaksi');
            $table->unsignedInteger('id_hewan');
            $table->foreign('id_hewan')
                ->references('id')
                ->on('hewan');
            $table->unsignedInteger('id_layanan');
            $table->foreign('id_layanan')
                ->references('id')
                ->on('layanan');
            // $table->integer('jumlah');
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
        Schema::dropIfExists('detail_transaksi_layanan');
    }
}
