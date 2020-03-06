<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRestockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_restock', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_supplier');
            $table->foreign('id_supplier')
                ->references('id')
                ->on('supplier');
            $table->unsignedInteger('id_detail_order_restock');
            $table->foreign('id_detail_order_restock')
                ->references('id')
                ->on('detail_order_restock');
            $table->date('tanggal_restock');
            $table->decimal('total_bayar', 18, 2)->nullable();
            $table->integer('status_order')->default(0);
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
        Schema::dropIfExists('order_restock');
    }
}
