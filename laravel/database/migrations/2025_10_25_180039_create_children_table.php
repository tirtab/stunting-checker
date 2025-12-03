<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('umur'); // dalam bulan
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->decimal('berat_badan', 5, 2); // kg
            $table->decimal('tinggi_badan', 5, 2); // cm
            $table->decimal('lingkar_lengan', 5, 2); // cm
            $table->date('tanggal_ukur');
            $table->text('catatan')->nullable();
            $table->string('sumber')->default('admin'); // admin atau publik
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};