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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories', 'id') // To connect Child object with Parent object
                  ->nullOnDelete();  //when you delete parents, child won't delete and parent_id will be null
                //   ->cascadeOnUpdate()  //when you delete parents, Both child and parent will be deleted
                //   ->restrictOnDelete();//**Default**  *when you try to delete parent, parent won't be deleted because has a child
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['active', 'archived']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
