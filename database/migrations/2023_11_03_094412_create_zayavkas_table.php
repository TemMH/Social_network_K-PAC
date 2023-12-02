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
        Schema::create('zayavkas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('zagolovok')->unique();
            $table->string('description');
            $table->string('category')->nullable();

            $table->string('user_id');

            $table->string('status');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zayavkas');
    }
    
};
