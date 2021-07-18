<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_id')->unsigned()->comment('消息来源者id');
            /*$table->string('user_avatar')->comment('消息来源者头像');*/
            $table->integer('to_id')->unsigned()->comment('消息目标者id');
            $table->text('content');
            $table->tinyInteger('push')->unsigned()->comment('是否已推送？ 1已推送 0尚未推送')->default(0);
            $table->tinyInteger('dynamic_id')->unsigned()->index()->nullable();
            $table->tinyInteger('vlog_id')->unsigned()->index()->nullable();
            $table->string('type')->index()->comment("system , dynamic , video");
            $table->tinyInteger('status')->comment("是否已读？ 0未读，1已读")->default(0);
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
        Schema::dropIfExists('messages');
    }
}
