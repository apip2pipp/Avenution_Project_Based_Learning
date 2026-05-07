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
        Schema::table('foods', function (Blueprint $table) {
            // Drop unused columns
            $table->dropColumn(['description', 'image_url', 'dietary_tags', 'health_benefits']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foods', function (Blueprint $table) {
            // Restore columns in case of rollback
            $table->text('description')->nullable()->after('category');
            $table->text('image_url')->nullable()->after('description');
            $table->json('dietary_tags')->nullable()->after('image_url');
            $table->json('health_benefits')->nullable()->after('dietary_tags');
        });
    }
};
