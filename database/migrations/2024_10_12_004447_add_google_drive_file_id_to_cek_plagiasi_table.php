<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleDriveFileIdToCekPlagiasiTable extends Migration
{
    public function up()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->string('google_drive_file_id')->nullable()->after('link_dokumen');
        });
    }

    public function down()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->dropColumn('google_drive_file_id');
        });
    }
}
