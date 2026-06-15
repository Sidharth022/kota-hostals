<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('area_id')->constrained('areas')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('monthly_rent', 10, 2)->default(0);
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->json('room_types')->nullable(); // ["single","double","triple"]
            $table->enum('gender_type', ['boys', 'girls', 'coed'])->default('boys');
            $table->string('google_map_url')->nullable();
            $table->unsignedSmallInteger('total_rooms')->nullable();
            $table->unsignedSmallInteger('available_rooms')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();

            // Indexes for filtering & geo
            $table->index('owner_id');
            $table->index('area_id');
            $table->index(['status', 'featured', 'verified']);
            $table->index(['latitude', 'longitude']);
            $table->index('gender_type');
            $table->index('monthly_rent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostels');
    }
};
