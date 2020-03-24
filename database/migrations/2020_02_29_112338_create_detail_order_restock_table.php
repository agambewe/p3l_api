<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrderRestockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_order_restock', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_produk');
            $table->foreign('id_produk')
                ->references('id')
                ->on('produk');
            $table->unsignedInteger('id_order_restock');
            $table->foreign('id_order_restock')
                ->references('id')
                ->on('order_restock');
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
        Schema::dropIfExists('detail_order_restock');
    }
}
