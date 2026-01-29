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
        // Patients Table
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('patient_number')->unique();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('blood_group')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->json('medical_history')->nullable();
            $table->timestamps();
        });

        // Doctors Table
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('doctor_number')->unique();
            $table->string('specialization');
            $table->string('qualification')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('department')->nullable();
            $table->string('license_number')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0.00);
            $table->enum('availability_status', ['available', 'unavailable', 'busy'])->default('available');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // Medicines Table
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_code')->unique();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('category')->nullable();
            $table->string('unit')->nullable(); // Tablet, Syrup, etc.
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Lab Tests Table
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_code')->unique();
            $table->string('test_name');
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('normal_range')->nullable();
            $table->string('sample_type')->nullable();
            $table->integer('turnaround_time')->nullable(); // in hours
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Schedules Table
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_duration')->default(30); // in minutes
            $table->integer('max_patients_per_slot')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Appointments Table
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('time_slot');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('symptoms')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Prescriptions Table
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription_number')->unique();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->json('medicines'); // Array of {medicine_id, dosage, duration, instructions}
            $table->text('diagnosis')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });

        // Invoices Table
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
        });

        // Invoice Items Table
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        // Lab Results Table
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->string('result_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('test_date')->useCurrent();
            $table->dateTime('result_date')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('result_value')->nullable();
            $table->string('unit')->nullable();
            $table->string('reference_range')->nullable();
            $table->text('remarks')->nullable();
            $table->string('technician_name')->nullable();
            $table->boolean('is_abnormal')->default(false);
            $table->string('report_file_path')->nullable();
            $table->timestamps();
        });

        // Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // appointment, lab_result, invoice, etc.
            $table->string('title');
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Medical Records Table
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->date('visit_date');
            $table->string('diagnosis');
            $table->text('treatment')->nullable();
            $table->text('symptoms')->nullable();
            $table->json('vital_signs')->nullable(); // BP, Weight, Temp, etc.
            $table->text('notes')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('lab_results');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('medicines');
        Schema::dropIfExists('doctors');
        Schema::dropIfExists('patients');
    }
};
