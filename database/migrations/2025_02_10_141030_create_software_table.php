<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('version');
            $table->enum('tipo', ['ERP', 'CRM', 'OFFICE', 'OTROS']);
            $table->enum('criticidad', ['1', '2', '3', '4']);
            $table->boolean('requiere_capacitacion')->default(false);
            $table->date('fecha_renovacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
