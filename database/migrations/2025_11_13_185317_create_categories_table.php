<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 7)->nullable();
            $table->timestamps();
        });

        // Seed initial categories
        Category::insert([
            [
                'name' => 'Automation',
                'color' => '#2CBFB3',
            ],
            [
                'name' => 'Marketing',
                'color' => '#C3329E',
            ],
            [
                'name' => 'Software Development',
                'color' => '#7D49CC',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
