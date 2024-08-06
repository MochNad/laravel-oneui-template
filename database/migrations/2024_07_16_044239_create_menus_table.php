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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('name', 100);
            $table->string('module', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('icon', 100)->nullable();
            $table->string('url', 100)->nullable();
            $table->enum('type', ['dashboard', 'landing'])->default('dashboard');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            $table->unsignedTinyInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
