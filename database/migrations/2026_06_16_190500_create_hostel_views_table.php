<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostel_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained('hostels')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('ip_address');
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            $table->index(['hostel_id', 'ip_address', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_views');
    }
};
