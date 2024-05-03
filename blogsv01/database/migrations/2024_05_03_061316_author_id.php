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
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id'); // Define author_id as an unsigned big integer

            // Create foreign key constraint
            $table->foreign('author_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Optional: Define cascade delete behavior if user is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['author_id']);

            // Drop author_id column
            $table->dropColumn('author_id');
        });
    }
};
