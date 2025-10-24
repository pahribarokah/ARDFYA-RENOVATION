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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->text('address');
            $table->string('property_type')->nullable();
            $table->integer('area_size')->nullable();
            $table->string('current_condition')->nullable();
            $table->text('description');
            $table->decimal('budget', 12, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->string('schedule_flexibility')->nullable();
            $table->enum('status', ['new', 'contacted', 'in_progress', 'completed', 'cancelled'])->default('new');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
