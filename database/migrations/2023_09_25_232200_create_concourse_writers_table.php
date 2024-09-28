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
        Schema::create('concourse_writers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('matricule')->nullable()->unique();
            $table->string('address');
            $table->string('anciennete');
            $table->string('type');
            $table->string('contact_number');
            $table->string('libelle');
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade');
            $table->foreignId('classe_id')->constrained()->onUpdate('cascade');
            $table->string('payment_mode');
            $table->string('status')->default('pending');
            $table->string('student_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concourse_writers');
    }
};
