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
        Schema::create('ticket_classifications', function (Blueprint $table) {
            $table->id();
            $table->ulid('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->string('category', 50);
            $table->text('explanation');
            $table->decimal('confidence', 5, 4);
            $table->boolean('is_override')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->enum('job_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_classifications');
    }
};
