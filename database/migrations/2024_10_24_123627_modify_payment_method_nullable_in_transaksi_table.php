<?php

// database/migrations/xxxx_xx_xx_xxxxxx_modify_payment_method_nullable_in_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPaymentMethodNullableInTransaksiTable extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('payment_method')->nullable(false)->change();
        });
    }
}

