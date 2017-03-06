<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLTITables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lti2_consumer', function (Blueprint $table) {
            $table->increments('consumer_pk');
            $table->string('name');
            $table->string('consumer_key256')->unique();
            $table->text('consumer_key')->nullable();
            $table->text('secret');
            $table->string('lti_version')->nullable();
            $table->string('consumer_name')->nullable();
            $table->string('consumer_version')->nullable();
            $table->text('consumer_guid')->nullable();
            $table->text('profile')->nullable();
            $table->text('tool_proxy')->nullable();
            $table->text('settings')->nullable();
            $table->tinyInteger('protected')->nullable();
            $table->tinyInteger('enabled')->nullable();
            $table->dateTime('enable_from')->nullable();
            $table->dateTime('enable_until')->nullable();
            $table->date('last_access')->nullable();
            $table->dateTime('created')->nullable();
            $table->dateTime('updated')->nullable();

            $table->timestamps();
        });

        Schema::create('lti2_tool_proxy', function (Blueprint $table) {
            $table->increments('tool_proxy_pk');
            $table->string('tool_proxy_id')->index();
            $table->integer('consumer_pk')->unsigned()->index();
            $table->text('tool_proxy');
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->timestamps();
        });

        Schema::create('lti2_nonce', function (Blueprint $table) {
            $table->integer('consumer_pk');
            $table->string('value');
            $table->dateTime('expires');

            $table->primary(['consumer_pk', 'value']);

            $table->timestamps();
        });

        Schema::create('lti2_context', function (Blueprint $table) {
            $table->increments('context_pk');
            $table->integer('consumer_pk')->index();
            $table->string('lti_context_id');
            $table->text('settings')->nullable();
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->timestamps();
        });

        Schema::create('lti2_resource_link', function (Blueprint $table) {
            $table->increments('resource_link_pk');
            $table->integer('context_pk')->nullable()->index();
            $table->integer('consumer_pk')->nullable()->index();
            $table->string('lti_resource_link_id');
            $table->text('settings')->nullable();
            $table->integer('primary_resource_link_pk');
            $table->tinyInteger('share_approved');
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->timestamps();
        });

        Schema::create('lti2_user_result', function (Blueprint $table) {
            $table->increments('user_pk');
            $table->integer('resource_link_pk')->index();
            $table->string('lti_user_id');
            $table->text('lti_result_sourcedid');
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->timestamps();
        });

        Schema::create('lti2_share_key', function (Blueprint $table) {
            $table->string('share_key_id');
            $table->integer('resource_link_pk')->index();
            $table->tinyInteger('auto_approve');
            $table->dateTime('expires');

            $table->primary('share_key_id');

            $table->timestamps();
        });

//        Schema::table('lti2_tool_proxy', function(Blueprint $table) {
//            $table->foreign('consumer_pk')->references('consumer_pk')->on('lti2_consumer')->onDelete('cascade');
//        });
//
//        Schema::table('lti2_context', function(Blueprint $table) {
//            $table->foreign('consumer_pk')->references('consumer_pk')->on('lti2_consumer')->onDelete('cascade');
//        });
//
//        Schema::table('lti2_resource_link', function(Blueprint $table) {
//            $table->foreign('context_pk')->references('context_pk')->on('lti2_context')->onDelete('cascade');
//        });
//
//        Schema::table('lti2_user_result', function(Blueprint $table) {
//            $table->foreign('resource_link_pk')->references('resource_link_pk')->on('lti2_resource_link')->onDelete('cascade');
//        });
//
//        Schema::table('lti2_share_key', function(Blueprint $table) {
//            $table->foreign('resource_link_pk')->references('resource_link_pk')->on('lti2_resource_link')->onDelete('cascade');
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lti2_consumer');
        Schema::drop('lti2_tool_proxy');
        Schema::drop('lti2_nonce');
        Schema::drop('lti2_context');
        Schema::drop('lti2_resource_link');
        Schema::drop('lti2_user_result');
        Schema::drop('lti2_share_key');
    }

}