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
        Schema::create('job_apply_positions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('society_id')->constrained('societies')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('job_vacancy_id')->constrained('job_vacancies')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('position_id')->constrained('available_positions')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('job_apply_society_id')->constrained('job_apply_societies')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['pending', 'accepted', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_apply_positions');
    }
};
