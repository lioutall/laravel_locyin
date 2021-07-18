<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            //$table->bigInteger('user_id')->index();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            //$table->bigInteger('vlog_id')->index()->nullable();
            $table->foreignId('vlog_id')->constrained('vlogs')->onDelete('cascade');
            $table->string('type')->index();
            $table->string('path');
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
        Schema::dropIfExists('videos');
    }
}
