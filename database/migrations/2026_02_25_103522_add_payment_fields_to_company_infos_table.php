<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('bank_address')->nullable();
            $table->boolean('show_rib_on_order')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_infos', function (Blueprint $table) {
            $table->dropColumn(['iban', 'bic', 'bank_name', 'bank_address', 'show_rib_on_order']);
        });
    }
};
