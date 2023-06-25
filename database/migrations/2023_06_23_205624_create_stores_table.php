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
        Schema::create('stores', function (Blueprint $table) {
            // id BIGINT UNSIGNED AUTO INCREMENT PRIMARY
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // $table->bigIncrements('id')->primary();
            $table->id();
            $table->string('name'); //VARCHAR(max 64000, Default 255 char)
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // foreign key to users table, store belongsTo user

            // 2 columns: created_at and updated_at (timestamp)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
