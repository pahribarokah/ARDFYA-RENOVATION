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
        Schema::table('projects', function (Blueprint $table) {
            // Add end_date column if it doesn't exist
            if (!Schema::hasColumn('projects', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            
            // Add address column if it doesn't exist
            if (!Schema::hasColumn('projects', 'address')) {
                $table->text('address')->nullable()->after('status');
            }
            
            // Add total_cost column if it doesn't exist
            if (!Schema::hasColumn('projects', 'total_cost')) {
                $table->decimal('total_cost', 12, 2)->nullable()->after('address');
            }
            
            // Add category column if it doesn't exist
            if (!Schema::hasColumn('projects', 'category')) {
                $table->string('category')->nullable()->after('total_cost');
            }
            
            // Add is_featured column if it doesn't exist
            if (!Schema::hasColumn('projects', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('category');
            }
            
            // Add progress_percentage column if it doesn't exist
            if (!Schema::hasColumn('projects', 'progress_percentage')) {
                $table->integer('progress_percentage')->default(0)->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Remove columns if they exist
            if (Schema::hasColumn('projects', 'end_date')) {
                $table->dropColumn('end_date');
            }
            
            if (Schema::hasColumn('projects', 'address')) {
                $table->dropColumn('address');
            }
            
            if (Schema::hasColumn('projects', 'total_cost')) {
                $table->dropColumn('total_cost');
            }
            
            if (Schema::hasColumn('projects', 'category')) {
                $table->dropColumn('category');
            }
            
            if (Schema::hasColumn('projects', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            
            if (Schema::hasColumn('projects', 'progress_percentage')) {
                $table->dropColumn('progress_percentage');
            }
        });
    }
}; 