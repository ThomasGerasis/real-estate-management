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
        Schema::table('contacts', function (Blueprint $table) {
            // Add surname field
            $table->string('surname')->nullable()->after('name');
            
            // Add inquiry preferences (for general inquiry and mandate forms)
            $table->foreignId('city_id')->nullable()->after('property_id')->constrained()->nullOnDelete();
            $table->string('listing_type')->nullable()->after('city_id'); // 'sale' or 'rent'
            $table->string('property_type')->nullable()->after('listing_type'); // 'house', 'apartment', etc
            $table->integer('bedrooms')->nullable()->after('property_type');
            $table->decimal('min_price', 12, 2)->nullable()->after('bedrooms');
            $table->decimal('max_price', 12, 2)->nullable()->after('min_price');
            $table->decimal('price', 12, 2)->nullable()->after('max_price'); // For mandate form
            $table->decimal('square_meters', 10, 2)->nullable()->after('price');
        });
        
        // Update type enum to include new types
        DB::statement("ALTER TABLE contacts MODIFY COLUMN type VARCHAR(50) DEFAULT 'contact'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn([
                'surname',
                'city_id',
                'listing_type',
                'property_type',
                'bedrooms',
                'min_price',
                'max_price',
                'price',
                'square_meters',
            ]);
        });
    }
};
