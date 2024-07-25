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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('marketer_name');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->string('distinctive_address');
            $table->enum('type', ['for rent', 'for sale']);
            $table->string('unit_type');
            $table->enum('purpose', ['residential', 'commercial']);
            $table->text('description');
            $table->decimal('deposit', 10, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('area', 10, 2);
            $table->integer('floor')->nullable();
            $table->boolean('previously_occupied')->nullable();
            $table->integer('property_age')->nullable();
            $table->string('property_facing')->nullable();
            $table->string('city');
            $table->string('district');
            $table->text('location_link');
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('guard_name')->nullable();
            $table->string('guard_phone')->nullable();
            $table->string('other_attachment')->nullable();
            $table->date('available_date')->nullable();
            $table->string('status')->default('Pending');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
