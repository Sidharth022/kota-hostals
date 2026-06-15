<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Spatie roles table to include slug and status
        Schema::table('roles', function (Blueprint $table) {
            if (!Schema::hasColumn('roles', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('roles', 'status')) {
                $table->string('status')->default('active')->after('slug');
            }
        });

        // 2. Modify users table: add role_id, alter status, and drop role enum
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
            }
            $table->string('status')->default('pending')->change();
        });

        // Drop the role enum if it exists
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });

        // 3. Create owner_profiles table
        Schema::create('owner_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('hostel_name');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('gst_number')->nullable();
            $table->string('identity_document')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });

        // 4. Rename inquiries to hostel_inquiries and update column
        if (Schema::hasTable('inquiries')) {
            // Drop old foreign key/index on inquiries.user_id if any, then rename
            Schema::table('inquiries', function (Blueprint $table) {
                // Drop foreign key if exists. In Laravel, it's usually table_column_foreign
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {}
            });

            Schema::rename('inquiries', 'hostel_inquiries');

            Schema::table('hostel_inquiries', function (Blueprint $table) {
                $table->renameColumn('user_id', 'student_id');
            });

            Schema::table('hostel_inquiries', function (Blueprint $table) {
                $table->foreign('student_id')->references('id')->on('users')->nullOnDelete();
            });
        }

        // 5. Create hostel_applications table
        Schema::create('hostel_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostel_id')->constrained('hostels')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->date('joining_date');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled
            $table->timestamps();

            $table->index(['hostel_id', 'status']);
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostel_applications');

        if (Schema::hasTable('hostel_inquiries')) {
            Schema::table('hostel_inquiries', function (Blueprint $table) {
                try {
                    $table->dropForeign(['student_id']);
                } catch (\Exception $e) {}
            });
            Schema::table('hostel_inquiries', function (Blueprint $table) {
                $table->renameColumn('student_id', 'user_id');
            });
            Schema::rename('hostel_inquiries', 'inquiries');
            Schema::table('inquiries', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            });
        }

        Schema::dropIfExists('owner_profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'hostel_owner', 'student'])->default('student')->after('password');
            try {
                $table->dropForeign(['role_id']);
            } catch (\Exception $e) {}
            $table->dropColumn('role_id');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['slug', 'status']);
        });
    }
};
