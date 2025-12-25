<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renter_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('apartment_id')
                ->constrained('apartments')->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('site')->nullable();
            $table->enum('transaction', ['cache','paypal'])->default('cache');
            $table->enum('is_approved', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->enum('status', ['current', 'cancelled', 'ended'])
                ->nullable();
            $table->timestamps();
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
