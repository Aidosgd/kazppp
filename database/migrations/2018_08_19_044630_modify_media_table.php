<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {

            // удаляем не нужные колонки)
            $table->dropColumn('owner');
            $table->dropColumn('type');
            $table->dropColumn('model_id');
            $table->dropColumn('video_id');
            $table->dropColumn('params');

            // добавляем нужнные колонки
            $table->unsignedInteger('imageable_id')->after('id');
            $table->string('imageable_type')->after('id');
            $table->json('conversions')->nullable()->after('original_file_name');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            //
        });
    }
}
