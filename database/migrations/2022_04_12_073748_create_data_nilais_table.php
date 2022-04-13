<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_nilais', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->foreignId('dosen_id')->constrained('dosens')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('matkul_id')->constrained('mata_kuliahs')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('nilai');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_nilais');
    }
}
