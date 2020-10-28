<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRotationEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation_employees', function (Blueprint $table) {
            $table->integer('rotation_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->date('date');
            $table->tinyInteger('shift');

            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotation_employees');
    }
}
