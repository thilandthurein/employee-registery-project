<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepHasPositionsTable extends Migration
{
    /**
     * Run the migrations.
     * @author Thu Rein Lynn
     * 26.8.2020
     * @return void
     */
    public function up()
    {
        Schema::create('dep_has_positions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id');
            $table->bigInteger('position_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dep_has_positions');
    }
}
