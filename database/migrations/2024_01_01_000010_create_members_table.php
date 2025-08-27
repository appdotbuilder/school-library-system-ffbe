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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique()->comment('Auto-generated member code');
            $table->string('barcode')->unique()->comment('Auto-generated barcode for member card');
            $table->string('nisn_nip')->nullable()->comment('NISN for students or NIP for staff');
            $table->string('name');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('member_type', ['student', 'teacher', 'staff'])->default('student');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->onDelete('set null');
            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');
            $table->date('joined_date')->default(now());
            $table->timestamps();
            
            $table->index('member_code');
            $table->index('barcode');
            $table->index('nisn_nip');
            $table->index('name');
            $table->index('status');
            $table->index('member_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};