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
            $table->foreignId('queue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('citoyen_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('number');
            $table->enum('status', ['EN_ATTENTE', 'APPELE', 'TERMINE', 'ANNULE'])->default('EN_ATTENTE');
            $table->timestamps();

            $table->unique(['queue_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
