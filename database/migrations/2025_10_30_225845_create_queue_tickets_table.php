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
        Schema::create('queue_tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_queue')->index();
            $table->integer('queue_ticket_number')->nullable();
            $table->dateTime('queue_ticket_created_at')->useCurrent();
            $table->dateTime('queue_ticket_called_at')->nullable();
            $table->enum('status', ['waiting', 'called', 'non_attended', 'dismissed'])->default('waiting');
            $table->string('queue_ticket_called_by', 50)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_tickets');
    }
};
