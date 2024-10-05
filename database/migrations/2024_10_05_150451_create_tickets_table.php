<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['abierto', 'en_progreso', 'cerrado', 'pendiente'])->default('abierto');
            $table->enum('priority', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('sede', ['Medellin', 'Barranquilla', 'Ambas'])->default('Ambas');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};