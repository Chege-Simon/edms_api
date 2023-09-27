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
        Schema::create('possible_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workstep_id');
            $table->string('name');
            $table->unsignedBigInteger('next_workstep_id');
            $table->timestamps();

            $table->foreign('workstep_id')->references('id')->on('work_steps')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('possible_actions');
    }
};
