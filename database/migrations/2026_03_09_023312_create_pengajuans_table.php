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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('jenis_berkas_id')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->string('file')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
            $table->enum('status', ['disetujui', 'ditolak', 'menunggu'])->default('menunggu');
            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('verified_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('jenis_berkas_id')
                ->references('id')
                ->on('jenis_berkas')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
