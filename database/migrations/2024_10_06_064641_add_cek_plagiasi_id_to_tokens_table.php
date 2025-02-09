<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCekPlagiasiIdToTokensTable extends Migration
{
    public function up()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('cek_plagiasi_id')->nullable()->after('id');
            $table->foreign('cek_plagiasi_id')->references('id')->on('cek_plagiasi')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropForeign(['cek_plagiasi_id']);
            $table->dropColumn('cek_plagiasi_id');
        });
    }
}
