<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('documents', function (Blueprint $table) {
        if (!Schema::hasColumn('documents', 'cover_image')) {
            $table->string('cover_image')->nullable()->after('abstract');
        }
    });
}


    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['abstract', 'cover_image']);
        });
    }
};
