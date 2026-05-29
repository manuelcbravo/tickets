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
        Schema::create('cat_uso_cfdis', function (Blueprint $table) {
            $table->string('id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('regimen_fiscal')->nullable();
            $table->softDeletes();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_uso_cfdis');
    }
};
