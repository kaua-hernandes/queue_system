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
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->integer('id_company')->index();
            $table->string('name', 100)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('service_name', 50)->nullable();
            $table->string('service_desk', 20)->nullable();
            $table->string('queue_prefix', 10)->nullable();
            $table->string('queue_total_digits')->default(3);
            $table->string('queue_colors', 255)->nullable();
            $table->string('hash_code', 64)->unique();
            $table->enum('status', ['active', 'inactive', 'done'])->default('inactive');
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
        Schema::dropIfExists('queues');
    }
};
