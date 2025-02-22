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
        Schema::create('transactions_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transactions_id')->nullable();
            $table->enum('type', ['creation', 'request', 'request_result', 'webhook']);
            $table->string('payload');
            $table->timestamps();

            $table->foreign('transactions_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions_history');
    }
};
