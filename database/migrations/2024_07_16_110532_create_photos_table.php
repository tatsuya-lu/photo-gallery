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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('path');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('downloads_count')->default(0);
            $table->unsignedInteger('favorites_count')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
