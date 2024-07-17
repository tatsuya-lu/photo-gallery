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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });

        \DB::table('accounts')->insert([
            [
                'name' => 'ゲストユーザー01',
                'nickname' => 'ゲスト01さん',
                'email' => 'owner@example.com',
                'password' => \Hash::make('password'),
                'created_at' => '2024-01-01 00:00:00',
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
