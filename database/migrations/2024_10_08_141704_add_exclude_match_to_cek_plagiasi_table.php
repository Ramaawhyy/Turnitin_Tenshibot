<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->string('exclude_match_type')->nullable();
            $table->integer('exclude_match_value')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('cek_plagiasi', function (Blueprint $table) {
            $table->dropColumn('exclude_match_type');
            $table->dropColumn('exclude_match_value');
        });
    }
    
};
