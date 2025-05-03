<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /* CREATE TABLE $tableOrder(
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      payment_amount INTEGER,
      sub_total INTEGER,
      tax INTEGER,
      discount INTEGER,
      service_charge INTEGER,
      total INTEGER,
      payment_method TEXT,
      total_item INTEGER,
      id_kasir INTEGER,
      nama_kasir TEXT,
      transaction_time TEXT,
      is_sync INTEGER DEFAULT 0
    )
    ''');*/
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('bukti_pembayaran');
            $table->integer('total_item');
            $table->text('alamat');
            $table->string('status')->default('pending');
            // Mengubah id_customer menjadi relasi ke tabel customers
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
            
            $table->string('transaction_time');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
