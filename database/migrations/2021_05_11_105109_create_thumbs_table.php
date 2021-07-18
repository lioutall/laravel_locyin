<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThumbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thumbs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->comment("点赞者ID");
            $table->bigInteger('dynamic_id')->unsigned()->index()->nullable()->comment("动态ID");
            $table->bigInteger('comment_id')->unsigned()->index()->nullable()->comment("动态ID");
            $table->bigInteger('vlog_id')->unsigned()->index()->nullable()->comment("短视频ID");
            $table->string('type')->index()->comment("dynamic , vlog , comment")->comment("类型");
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
        Schema::dropIfExists('thumbs');
    }
}
