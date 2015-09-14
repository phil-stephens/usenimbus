<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('droplet_id')->unsigned()->index();
            $table->foreign('droplet_id')->references('id')->on('droplets')->onDelete('cascade');
            $table->integer('storage_id')->default(0);
            $table->string('file_name');
            $table->string('type');
            $table->double('size');
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
		Schema::drop('files');
	}

}
