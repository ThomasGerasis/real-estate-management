<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['address', 'postal_code']);

            $table->boolean('elevator')->nullable()->after('garage');
            $table->enum('heating_type', ['central', 'autonomous', 'none'])->nullable()->after('elevator');
            $table->enum('heating_fuel', ['gas', 'oil', 'electric', 'heat_pump', 'other'])->nullable()->after('heating_type');
            $table->boolean('fireplace')->nullable()->after('heating_fuel');
            $table->boolean('furnished')->nullable()->after('fireplace');
            $table->enum('property_position', ['front', 'interior', 'corner', 'through'])->nullable()->after('furnished');
            $table->enum('property_condition', ['new', 'renovated', 'excellent', 'needs_renovation'])->nullable()->after('property_position');
            $table->string('floor_type')->nullable()->after('property_condition');
            $table->enum('garage_type', ['open', 'pilotis', 'underground', 'closed', 'spots'])->nullable()->after('floor_type');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'elevator', 'heating_type', 'heating_fuel', 'fireplace',
                'furnished', 'property_position', 'property_condition',
                'floor_type', 'garage_type',
            ]);

            $table->string('address')->after('district_id');
            $table->string('postal_code')->nullable()->after('address');
        });
    }
};
