<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDropletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('droplets', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('storage_id')->default(0);
            $table->string('upload_hash');
            $table->string('slug')->unique()->index();
            $table->string('title')->nullable()->default(null);
            $table->text('introduction')->nullable()->default(null);
            $table->boolean('watermark_images')->default(true);
            $table->string('password')->nullable()->default(null);
            $table->integer('limit')->unsigned()->nullable()->default(null);
            $table->timestamp('start_at')->nullable()->default(null);
            $table->timestamp('finish_at')->nullable()->default(null);
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
		Schema::drop('droplets');
	}

}
