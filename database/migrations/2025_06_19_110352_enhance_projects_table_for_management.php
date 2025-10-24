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
            // Add project management fields
            $table->json('team_assigned')->nullable()->after('notes');
            $table->json('project_photos')->nullable()->after('team_assigned');
            $table->decimal('budget_used', 15, 2)->default(0)->after('budget');
            $table->text('timeline_details')->nullable()->after('notes');
            $table->timestamp('customer_last_viewed')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'team_assigned',
                'project_photos',
                'budget_used',
                'timeline_details',
                'customer_last_viewed'
            ]);
        });
    }
};
