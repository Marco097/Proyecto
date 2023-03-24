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
            $table->unsignedBigInteger('tipo_archivo_id');
            $table->foreign('tipo_archivo_id')->references('id')->on('tipo_archivos');
            $table->unsignedBigInteger('tamaño_id');
            $table->foreign('tamaño_id')->references('id')->on('tamaños');
            $table->unsignedBigInteger('fecha_ingreso_id');
            $table->foreign('fecha_ingreso_id')->references('id')->on('fecha_ingresos');
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
