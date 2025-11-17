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
        Schema::create('ebooks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('file')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
