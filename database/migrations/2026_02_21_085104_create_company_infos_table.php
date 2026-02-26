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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('siren', 20)->nullable();
            $table->string('siret', 20)->nullable();
            $table->string('numero_tva', 50)->nullable();
            $table->date('date_creation')->nullable();
            $table->string('activite_naf_ape', 50)->nullable();
            $table->string('forme_juridique', 100)->nullable();
            $table->string('adresse_siege')->nullable();
            $table->json('dirigeants')->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email_contact')->nullable();
            $table->string('rcs_ville')->nullable();
            $table->decimal('capital_social', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
