<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('thumb_count')->unsigned()->default(0);
            $table->integer('collect_count')->unsigned()->default(0);
            $table->integer('comment_count')->unsigned()->default(0);
            $table->Text('illustration');
            $table->integer('status')->comment("0审核不通过，1审核中，2审核通过")->default(0);
            $table->String('location');
            $table->String('title');
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
        Schema::dropIfExists('vlogs');
    }
}
