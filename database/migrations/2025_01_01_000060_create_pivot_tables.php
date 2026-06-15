<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hostel <-> Facility pivot
        Schema::create('hostel_facilities', function (Blueprint $table) {
            $table->foreignId('hostel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->primary(['hostel_id', 'facility_id']);
        });

        // Hostel <-> CoachingCenter pivot with distance
        Schema::create('hostel_coaching_centers', function (Blueprint $table) {
            $table->foreignId('hostel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('coaching_center_id')->constrained()->cascadeOnDelete();
            $table->decimal('distance_km', 5, 2)->nullable();
            $table->primary(['hostel_id', 'coaching_center_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_coaching_centers');
        Schema::dropIfExists('hostel_facilities');
    }
};
