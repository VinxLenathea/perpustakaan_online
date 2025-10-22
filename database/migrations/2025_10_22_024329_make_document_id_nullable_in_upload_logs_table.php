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
        Schema::table('upload_logs', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->unsignedBigInteger('document_id')->nullable()->change();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('upload_logs', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->unsignedBigInteger('document_id')->nullable(false)->change();
            $table->foreign('document_id')->references('id')->on('documents');
        });
    }
};
