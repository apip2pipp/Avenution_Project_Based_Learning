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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // breakfast, lunch, dinner, snack
            $table->integer('calories');
            $table->decimal('protein', 5, 2);
            $table->decimal('carbs', 5, 2);
            $table->decimal('fat', 5, 2);
            $table->decimal('fiber', 5, 2);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->json('dietary_tags')->nullable(); // vegetarian, vegan, gluten-free, etc.
            $table->json('health_benefits')->nullable(); // array of benefits
            $table->string('emoji')->default('🍽️');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
