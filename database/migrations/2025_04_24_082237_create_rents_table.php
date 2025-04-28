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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained('users');
            $table->foreignId('operator_id')->nullable()->constrained('users');
            $table->timestamp('request_date')->useCurrent();
            $table->date('loan_date')->nullable();
            $table->date('planned_return_date');
            $table->date('actual_return_date')->nullable();
            $table->text('purpose')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
