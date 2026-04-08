<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->enum('tipo', ['url', 'pdf', 'excel']);
            $table->string('path_o_url');
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();

            $table->index(['store_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

