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
        Schema::create('property_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->enum('classification', ['for family', 'for individuals'])->nullable();
            $table->integer('rooms_num')->nullable();
            $table->integer('toilets_num')->nullable();
            $table->integer('bedrooms_num')->nullable();
            $table->integer('living_rooms_num')->nullable();
            $table->boolean('has_board')->nullable();
            $table->boolean('has_floor_seating')->nullable();
            $table->boolean('has_roof')->nullable();
            $table->boolean('has_mashab')->nullable();
            $table->boolean('has_private_entrance')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_features');
    }
};
