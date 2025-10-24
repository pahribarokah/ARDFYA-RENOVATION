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
            // Add payment tracking fields
            $table->decimal('paid_amount', 12, 2)->default(0)->after('amount');
            $table->date('last_payment_date')->nullable()->after('payment_status');
            $table->string('payment_method')->nullable()->after('last_payment_date');
            $table->integer('installments')->default(1)->after('payment_method');
            $table->string('contract_number')->nullable()->after('id');
            $table->enum('contract_status', ['draft', 'active', 'completed', 'terminated'])->default('active')->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'paid_amount',
                'last_payment_date',
                'payment_method',
                'installments',
                'contract_number',
                'contract_status'
            ]);
        });
    }
}; 