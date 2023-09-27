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
        Schema::create('work_steps', function (Blueprint $table) {
            $table->id();
            $table->string('workstep_type');
            $table->unsignedBigInteger('previous');
            $table->unsignedBigInteger('folder_id');
            $table->string('activity');
            $table->timestamps();

            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_steps');
    }
};

