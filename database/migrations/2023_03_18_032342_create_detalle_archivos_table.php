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
        Schema::create('detalle_archivos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_archivo',10)->unique();
            $table->date('fecha_ingreso');
            $table->decimal('tamaño',8,2);
            $table->unsignedBigInteger('archivo_id');
            $table->foreign('archivo_id')->references('id')->on('archivos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_archivos');
    }
};
