<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostel_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained('hostels')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('reason');
            $table->text('description');
            $table->string('status')->default('pending'); // pending, approved, rejected, resolved
            $table->timestamps();

            $table->index(['hostel_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_reports');
    }
};
