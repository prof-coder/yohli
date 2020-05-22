<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('profile_id')->unsigned()->nullable();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->bigInteger('job_id')->unsigned()->nullable();
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->decimal('rate', 13, 2)->nullable();
            $table->integer('delivery_time')->nullable();
            $table->string('delivery_type')->nulable();
            $table->string('status')->nulable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('bids');
    }
}
