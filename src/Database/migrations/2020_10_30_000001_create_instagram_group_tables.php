<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class CreateInstagramGroupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();

        Schema::create('instagram_popular_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hashtag',250);
            $table->decimal('chances',6,3)->default(1);
            $table->timestamps();
        });
        
        Schema::create('instagram_general_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hashtag',250);
            $table->decimal('chances',6,3)->default(1);
            $table->timestamps();
        });
        
        Schema::create('instagram_template', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->nullable();
            $table->timestamps();
        });
        
        Schema::create('instagram_schedule_post', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_url',250)->nullable();
            $table->datetime('schedule_date');
            $table->text('content')->nullable();
            $table->string('alt',1000)->nullable();
            $table->string('tags',1000)->nullable();
            $table->boolean('is_posted')->default(false);
            $table->timestamps();
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagram_schedule_post');
        Schema::dropIfExists('instagram_template');
        Schema::dropIfExists('instagram_general_tag');
        Schema::dropIfExists('instagram_popular_tag');

    }
}
