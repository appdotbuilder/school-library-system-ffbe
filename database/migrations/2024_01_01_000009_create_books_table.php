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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('isbn')->unique()->nullable();
            $table->string('barcode')->unique()->comment('Auto-generated barcode');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->year('publication_year');
            $table->integer('quantity')->default(1);
            $table->integer('available_quantity')->default(1);
            $table->foreignId('book_shelf_id')->constrained('book_shelves')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            $table->timestamps();
            
            $table->index('title');
            $table->index('barcode');
            $table->index('isbn');
            $table->index(['category_id', 'author_id']);
            $table->index('publication_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};