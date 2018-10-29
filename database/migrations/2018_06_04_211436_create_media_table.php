<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner')->nullable();
            $table->string('type')->nullable();
            $table->unsignedInteger('model_id')->nullable();
            $table->boolean('main_image')->nullable();
            $table->string('client_file_name')->nullable();
            $table->string('original_file_name')->nullable();
            $table->string('video_id')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->string('mime', 127)->nullable();
            $table->text('params')->nullable();
            $table->timestamps();
            $table->index('owner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
