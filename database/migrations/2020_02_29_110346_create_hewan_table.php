<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHewanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hewan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_customer');
            $table->foreign('id_customer')
                ->references('id')
                ->on('customer');
            $table->unsignedInteger('id_jenis');
            $table->foreign('id_jenis')
                ->references('id')
                ->on('jenis_hewan');
            $table->string('nama', 100);
            $table->date('tanggal_lahir');
            $table->string('created_by', 100);
            $table->string('updated_by', 100);
            $table->string('deleted_by', 100)->nullable();
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
        Schema::dropIfExists('hewan');
    }
}
