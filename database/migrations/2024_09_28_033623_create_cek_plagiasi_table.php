<?php

// database/migrations/xxxx_xx_xx_create_cek_plagiasi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekPlagiasiTable extends Migration
{
    public function up()
    {
        Schema::create('cek_plagiasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_hp');
            $table->boolean('exclude_daftar_pustaka')->default(false);
            $table->boolean('exclude_kutipan')->default(false);
            $table->boolean('exclude_match')->default(false);
            $table->string('dokumen');
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cek_plagiasi');
    }
}
