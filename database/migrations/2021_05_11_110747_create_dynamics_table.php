<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('thumb_count')->unsigned()->default(0);
            $table->integer('collect_count')->unsigned()->default(0);
            $table->integer('comment_count')->unsigned()->default(0);
            $table->Text('content');
            $table->integer('status')->comment("0审核不通过，1审核中，2审核通过")->default(0);
            $table->String('location');
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
        Schema::dropIfExists('dynamics');
    }
}
