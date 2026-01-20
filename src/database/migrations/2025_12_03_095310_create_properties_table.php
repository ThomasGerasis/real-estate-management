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
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->string('address');
            $table->string('postal_code')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('status', ['available', 'sold', 'rented', 'pending'])->default('available');
            $table->enum('type', ['house', 'apartment', 'commercial', 'land'])->default('apartment');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('square_meters', 10, 2)->nullable();
            $table->integer('year_built')->nullable();
            $table->enum('energy_class', ['A+', 'A', 'B', 'C', 'D', 'E', 'F', 'G'])->nullable();
            $table->integer('garage')->default(0);
            $table->json('images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
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
