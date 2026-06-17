<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hostels', function (Blueprint $table) {
            // Hidden Costs
            $table->decimal('electricity_charges', 10, 2)->default(0.00)->after('security_deposit');
            $table->decimal('laundry_charges', 10, 2)->default(0.00)->after('electricity_charges');
            $table->decimal('mess_charges', 10, 2)->default(0.00)->after('laundry_charges');
            $table->decimal('maintenance_charges', 10, 2)->default(0.00)->after('mess_charges');
            $table->decimal('other_charges', 10, 2)->default(0.00)->after('maintenance_charges');

            // Convenience Distances
            $table->decimal('distance_coaching', 5, 2)->nullable()->after('google_map_url');
            $table->decimal('distance_medical', 5, 2)->nullable()->after('distance_coaching');
            $table->decimal('distance_hospital', 5, 2)->nullable()->after('distance_medical');
            $table->decimal('distance_library', 5, 2)->nullable()->after('distance_hospital');
            $table->decimal('distance_stationery', 5, 2)->nullable()->after('distance_library');
            $table->decimal('distance_food', 5, 2)->nullable()->after('distance_stationery');

            // Score Cached Column
            $table->unsignedInteger('hostel_score')->default(70)->after('featured');
        });
    }

    public function down(): void
    {
        Schema::table('hostels', function (Blueprint $table) {
            $table->dropColumn([
                'electricity_charges',
                'laundry_charges',
                'mess_charges',
                'maintenance_charges',
                'other_charges',
                'distance_coaching',
                'distance_medical',
                'distance_hospital',
                'distance_library',
                'distance_stationery',
                'distance_food',
                'hostel_score'
            ]);
        });
    }
};
