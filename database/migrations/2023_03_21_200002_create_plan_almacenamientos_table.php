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
        Schema::create('plan_almacenamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_plan',20)->unique();
            $table->decimal('precio',8,2);
            $table->unsignedBigInteger('nube_id');
            $table->foreign('nube_id')->references('id')->on('nubes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_almacenamientos');
    }
};
