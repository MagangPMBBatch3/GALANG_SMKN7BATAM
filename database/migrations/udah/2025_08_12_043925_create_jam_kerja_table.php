<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_profile_id')->constrained('user_profile')->onUpdate('cascade')->onDelete('cascade');
            $table->string('no_wbs', 50)->nullable();
            $table->string('kode_proyek', 50)->nullable();
            $table->foreignId('proyek_id')->nullable()->constrained('proyek')->onUpdate('cascade')->nullOnDelete();
            $table->foreignId('Aktivitas_id')->nullable()->constrained('aktivitas')->onUpdate('cascade')->nullOnDelete();
            $table->date('tanggal')->nullable();
            $table->decimal('jumla_jam', 5, 2)->default(0.00);
            $table->text('keterangan')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('status_jam_kerja')->onUpdate('cascade')->nullOnDelete();
            $table->foreignId('mode_id')->nullable()->constrained('mode_jam_kerja')->onUpdate('cascade')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jam_kerja');
    }
};
