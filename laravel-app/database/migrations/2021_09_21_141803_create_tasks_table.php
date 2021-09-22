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
            $table->id();
            $table->string('title');
            $table->boolean('completed')->default(false);
            $table->timestamp('scheduled_for');
            $table->timestamps();
//            $table->unsignedBigInteger('parent_id')->nullable();
//
//            $table->foreign('parent_id')
//                  ->references('id')
//                  ->on('tasks')
//                  ->onDelete('cascade');
//
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('tasks')
                  ->onDelete('set null');// parents
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
