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
        Schema::create('proyek_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->nullable()->constrained('proyek')->onUpdate('cascade')->nullOnDelete();
            $table->foreignId('user_profile_id')->constrained('user_profile')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('proyek_user');
    }
};
