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
            ])->nullable()->comment('Company that owns the equipment');
            $table->string('name')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->string('brand')->nullable();
            $table->foreignId('provider_id')->nullable()->constrained();
            $table->enum('status', [
                'available',     // Disponible
                'in_use',       // En uso
                'maintenance',   // En mantenimiento 
                'repair',       // En reparación
                'retired',      // Dado de baja
                'reserved'      // Reservado
            ])->nullable()->default('available');
            $table->string('assigned_to')->nullable();
            $table->string('area')->nullable();
            $table->string('delivery_record')->nullable()->comment('Ruta del documento del acta de entrega');
            $table->text('notes')->nullable();

            $table->string('disco')->nullable()->comment('Información del disco duro');
            $table->string('procesador')->nullable()->comment('Información del procesador');
            $table->string('otros')->nullable()->comment('Otros detalles del equipo');
            $table->string('ram')->nullable()->comment('Información de la ram');


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
