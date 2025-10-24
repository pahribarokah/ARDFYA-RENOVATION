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
        Schema::table('contracts', function (Blueprint $table) {
            // Remove payment-related columns
            $table->dropColumn([
                'paid_amount',
                'payment_status',
                'payment_method',
                'last_payment_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Restore payment-related columns
            $table->decimal('paid_amount', 15, 2)->default(0)->after('amount');
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'overdue'])->default('pending')->after('paid_amount');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->timestamp('last_payment_date')->nullable()->after('payment_method');
        });
    }
};
