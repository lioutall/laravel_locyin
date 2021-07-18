<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vcomments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            //$table->bigInteger('video_id')->unsigned()->index()->nullable();
            $table->Integer('thumb_count')->unsigned()->default(0);
            //$table->string('type')->index()->comment("dynamic , video");
            $table->Text('content');
            $table->integer('status')->comment("0审核不通过，1审核中，2审核通过")->default(0);
            //$table->foreignId('dynamic_id')->constrained('dynamics')->onDelete('cascade');
            $table->foreignId('vlog_id')->constrained('vlogs')->onDelete('cascade');
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
        Schema::dropIfExists('vcomments');
    }
}
