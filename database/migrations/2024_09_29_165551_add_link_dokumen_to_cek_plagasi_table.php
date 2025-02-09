<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkDokumenToCekPlagasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->string('link_dokumen')->nullable()->after('dokumen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->dropColumn('link_dokumen');
        });
    }
}
