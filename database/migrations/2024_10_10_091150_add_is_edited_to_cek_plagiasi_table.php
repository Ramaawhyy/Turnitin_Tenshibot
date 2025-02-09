<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_is_edited_to_cek_plagiasi_table.php

public function up()
{
    Schema::table('cek_plagiasi', function (Blueprint $table) {
        $table->boolean('is_edited')->default(false)->after('link_dokumen');
    });
}

public function down()
{
    Schema::table('cek_plagiasi', function (Blueprint $table) {
        $table->dropColumn('is_edited');
    });
}

};
