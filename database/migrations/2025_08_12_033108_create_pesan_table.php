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
        Schema::create('pesan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengirim_id')->nullable()->constrained('user_profile')->onUpdate('cascade')->nullOnDelete();
            $table->foreignId('penerima_id')->nullable()->constrained('user_profile')->onUpdate('cascade')->nullOnDelete();
            $table->text('isi')->nullable();
            $table->integer('parent_id')->nullable();
            $table->dateTime('tgl_pesan')->nullable();
            $table->foreignId('jenis_id')->nullable()->constrained('jenis_pesan')->onUpdate('cascade')->nullOnDelete();
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
        Schema::dropIfExists('pesan');
    }
};