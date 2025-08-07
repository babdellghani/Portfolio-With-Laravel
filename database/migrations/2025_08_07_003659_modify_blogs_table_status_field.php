<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Add new columns for the blog system
            $table->text('content')->nullable()->after('description');
            $table->text('excerpt')->nullable()->after('content');
            $table->string('thumbnail')->nullable()->after('image');
            $table->integer('views')->default(0)->after('status');

            // Change status from boolean to enum for draft/published
            $table->enum('status_new', ['draft', 'published'])->default('draft')->after('status');
        });

        // Copy data from old status to new status
        DB::statement("UPDATE blogs SET status_new = CASE WHEN status = 1 THEN 'published' ELSE 'draft' END");

        Schema::table('blogs', function (Blueprint $table) {
            // Drop old status column and rename new one
            $table->dropColumn('status');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('status_new', 'status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Revert back to boolean status
            $table->boolean('status_old')->default(0)->after('status');
        });

        // Copy data back
        DB::statement("UPDATE blogs SET status_old = CASE WHEN status = 'published' THEN 1 ELSE 0 END");

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['content', 'excerpt', 'thumbnail', 'views', 'status']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('status_old', 'status');
        });
    }
};
