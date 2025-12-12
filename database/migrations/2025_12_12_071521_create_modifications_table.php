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
        Schema::create('modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->constrained('books')->cascadeOnDelete();
            $table->date('new_start_date')->nullable();
            $table->date('new_end_date')->nullable();
            $table->enum('new_transaction',['cache','paypal'])->nullable();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifications');
    }
};
