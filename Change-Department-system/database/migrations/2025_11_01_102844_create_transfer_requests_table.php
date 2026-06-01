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
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('from_department_id');
            $table->unsignedBigInteger('to_department_id');

            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->text('reviewer_comment')->nullable();
            $table->text('admin_comment')->nullable();

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('to_department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
