<?php

// database/migrations/xxxx_xx_xx_create_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cek_plagiasi_id');
            $table->string('token')->unique();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('cek_plagiasi_id')
                  ->references('id')
                  ->on('cek_plagiasi')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
