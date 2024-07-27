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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('phone_number');  
            $table->integer('id_number');  
            $table->text('address');
            $table->enum('status',['متزوج','أعزب']);
            $table->integer('age');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
