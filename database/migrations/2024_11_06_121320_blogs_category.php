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
        Schema::create('blogs_categories', function (Blueprint $table) {
            $table->foreignId('blog_id')->constrained()->noActionOnDelete();
            $table->foreignId('category_id')->constrained()->noActionOnDelete();
            $table->primary(['blog_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_categories');
    }
};
