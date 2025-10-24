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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('image_path')->nullable();
            $table->string('client_name')->nullable();
            $table->string('location')->nullable();
            $table->date('completion_date')->nullable();
            $table->decimal('project_value', 15, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('ordering')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'is_featured']);
            $table->index(['category', 'is_active']);
            $table->index('ordering');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
