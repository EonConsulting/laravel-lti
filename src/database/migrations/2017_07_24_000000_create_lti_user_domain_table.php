<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLTIUSERDomains extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lti_users_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('lti_user_id')->unsigned();
            $table->integer('context_id')->unsigned();
            $table->string('resource_id');
            $table->string('lti_version');
            $table->string('category');
            $table->string('privacy_level');
            $table->string('launch_target');
            $table->timestamps();
        });

        Schema::table('lti_users_domains', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_domain')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lti_users_domains');
    }

}