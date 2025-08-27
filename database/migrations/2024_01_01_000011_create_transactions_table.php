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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique()->comment('Auto-generated transaction code');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('borrowed_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('returned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('borrowed_date');
            $table->date('due_date');
            $table->date('returned_date')->nullable();
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed');
            $table->text('notes')->nullable();
            $table->decimal('fine_amount', 10, 2)->default(0)->comment('Fine for overdue books');
            $table->boolean('fine_paid')->default(false);
            $table->timestamps();
            
            $table->index('transaction_code');
            $table->index(['member_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index('due_date');
            $table->index('status');
            $table->index(['borrowed_date', 'returned_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};