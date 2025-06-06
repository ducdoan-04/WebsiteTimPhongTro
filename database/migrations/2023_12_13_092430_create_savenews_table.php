<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savenews', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->increments('id');
            $table->integer( 'pf_motelrooms_id')->index()->default(0);
            $table->integer('pf_users_id')->index()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savenews');
    }
}
