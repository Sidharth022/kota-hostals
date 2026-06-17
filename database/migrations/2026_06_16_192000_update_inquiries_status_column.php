<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Remap status values
        \DB::table('hostel_inquiries')->where('status', 'new')->update(['status' => 'pending']);
        \DB::table('hostel_inquiries')->where('status', 'contacted')->update(['status' => 'responded']);

        // Since it's enum originally, we modify it to string or allow new values
        Schema::table('hostel_inquiries', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('hostel_inquiries', function (Blueprint $table) {
            // Revert to enum
            $table->enum('status', ['new', 'contacted', 'closed'])->default('new')->change();
        });

        \DB::table('hostel_inquiries')->where('status', 'pending')->update(['status' => 'new']);
        \DB::table('hostel_inquiries')->where('status', 'responded')->update(['status' => 'contacted']);
    }
};
