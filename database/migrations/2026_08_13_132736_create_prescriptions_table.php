<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('doctor_name')->nullable();
            $table->string('patient_name')->nullable();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->enum('urgency', ['normal', 'urgent', 'emergency'])->default('normal');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('review_status', ['pending', 'reviewed', 'approved', 'rejected', 'ordered'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};