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
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone_number')->nullable();
                $table->string('email')->nullable();
                $table->decimal('saldo', 10, 2)->default(0);
                $table->string('password');
                $table->string('api_token', 80)->nullable(); // ← Perbaikan di sini
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
