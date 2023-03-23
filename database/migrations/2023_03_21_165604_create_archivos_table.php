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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',20)->unique();
            $table->unsignedBigInteger('nube_id');
            $table->foreign('nube_id')->references('id')->on('nubes');
            $table->unsignedBigInteger('detalle_archivo_id');
            $table->foreign('detalle_archivo_id')->references('id')->on('detalle_archivos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
