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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->unique(); // for guest tracking
            $table->integer('age');
            $table->decimal('weight', 5, 2); // kg
            $table->decimal('height', 5, 2); // cm
            $table->string('gender');
            $table->integer('blood_pressure_systolic');
            $table->integer('blood_pressure_diastolic');
            $table->integer('blood_sugar'); // mg/dL
            $table->integer('cholesterol'); // mg/dL
            $table->string('activity_level');
            $table->string('dietary_restriction');
            $table->string('health_goal');
            $table->decimal('bmi', 5, 2);
            $table->string('bmi_category');
            $table->timestamps();
            
            $table->index('session_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
