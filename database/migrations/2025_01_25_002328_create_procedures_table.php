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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('expedient_number')->nullable();
            $table->string('reason');
            $table->text('description');
            $table->string('ticket')->nullable();
            $table->boolean('is_juridical')->default(0);
            $table->foreignId('procedure_priority_id')->constrained();
            $table->foreignId('procedure_category_id')->constrained();
            $table->foreignId('procedure_state_id')->constrained();
            $table->foreignId('document_type_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
