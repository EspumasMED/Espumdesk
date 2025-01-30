<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->enum('company', [
                'espumas_medellin',
                'espumados_litoral'
            ])->comment('Company that owns the equipment');
            $table->string('name');
            $table->string('model');
            $table->string('serial_number')->unique();
            $table->string('brand');
            $table->foreignId('provider_id')->constrained()->nullable();
            $table->enum('status', [
                'available',     // Disponible
                'in_use',       // En uso
                'maintenance',   // En mantenimiento
                'repair',       // En reparación
                'retired',      // Dado de baja
                'reserved'      // Reservado
            ])->default('available');
            $table->string('assigned_to')->nullable(); // Persona que tiene el equipo
            $table->string('area')->nullable();        // Área/Departamento
            $table->string('delivery_record')->nullable()->comment('Ruta del documento del acta de entrega');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
