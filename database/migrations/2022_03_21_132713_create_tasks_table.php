<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {

            // $table->id();
            $table->string("task_id",100);
            $table->primary("task_id") ;
            $table->string("project_id",20);
            // foreign key
            $table->foreign("project_id")->references("project_id")->on("projects");

            $table->string("task_type",50);
            $table->string("occurrences",50)->default("-");
            $table->string("result",50)->default("-");
            $table->dateTime("started_at")->default(now());
            $table->dateTime("ended_at")->default(now());

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
        Schema::dropIfExists('tasks');

    }
}
