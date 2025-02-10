<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('software_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('software_id')->constrained()->onDelete('cascade');
            $table->boolean('has_access')->default(false);
            $table->date('fecha_asignacion')->nullable();
            $table->enum('estado_capacitacion', ['pendiente', 'completado'])->default('pendiente');
            $table->timestamps();

            $table->unique(['user_id', 'software_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('software_user');
    }
};
