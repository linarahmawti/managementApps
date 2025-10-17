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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('karyawan_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('lokasi_pengantaran');
            $table->integer('jumlah_diantar');
            $table->decimal('harga_total', 10, 2);
            $table->enum('status_pengantaran', ['on_delivery', 'delivered', 'failed'])->default('on_delivery');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_laporan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};
