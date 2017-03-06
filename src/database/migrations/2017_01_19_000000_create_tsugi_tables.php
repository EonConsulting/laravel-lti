<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsugiTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blob_file', function (Blueprint $table) {
            $table->increments('file_id');
            $table->char('file_sha256')->index();
            $table->integer('context_id')->unsigned()->nullable()->index();
            $table->text('file_name')->nullable();
            $table->tinyInteger('deleted')->nullable();
            $table->text('contenttype')->nullable();
            $table->text('path')->nullable();
            $table->longText('content')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        Schema::create('key_request', function (Blueprint $table) {
            $table->increments('request_id');
            $table->integer('user_id')->unsigned()->index();
            $table->text('title');
            $table->text('notes')->nullable();
            $table->text('admin')->nullable();
            $table->smallInteger('state')->nullable();
            $table->tinyInteger('lti')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        Schema::create('lms_plugins', function (Blueprint $table) {
            $table->increments('plugin_id');
            $table->bigInteger('version');
            $table->text('plugin_path');
            $table->text('title')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        // -- lti tables --

        Schema::create('lti_context', function (Blueprint $table) {
            $table->increments('context_id');
            $table->char('context_sha256')->unique();
            $table->text('context_key');
            $table->integer('key_id')->unsigned()->unique();
            $table->text('title')->nullable();
            $table->text('json')->nullable();
            $table->text('settings')->nullable();
            $table->text('settings_url')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_domain', function (Blueprint $table) {
            $table->integer('key_id')->unsigned()->unique();
            $table->integer('context_id')->unsigned()->nullable()->unique()->index();
            $table->string('domain')->nullable()->unique();
            $table->integer('port')->nullable();
            $table->text('consumer_key')->nullable();
            $table->text('secret')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        Schema::create('lti_key', function (Blueprint $table) {
            $table->increments('key_id');
            $table->char('key_sha256')->unique();
            $table->text('key_key');
            $table->text('secret')->nullable();
            $table->text('new_secret')->nullable();
            $table->text('ack')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('consumer_profile')->nullable();
            $table->text('new_consumer_profile')->nullable();
            $table->text('tool_profile')->nullable();
            $table->text('new_tool_profile')->nullable();
            $table->text('json')->nullable();
            $table->text('settings')->nullable();
            $table->text('settings_url')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_link', function (Blueprint $table) {
            $table->increments('link_id');
            $table->char('link_sha256')->index();
            $table->text('link_key');
            $table->integer('context_id')->unsigned()->index();
            $table->text('path')->nullable();
            $table->text('title')->nullable();
            $table->text('json')->nullable();
            $table->text('settings')->nullable();
            $table->text('settings_url')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_membership', function (Blueprint $table) {
            $table->increments('membership_id');
            $table->integer('context_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->smallInteger('role')->nullable();
            $table->smallInteger('role_override')->nullable();
            $table->text('json')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_nonce', function (Blueprint $table) {
            $table->char('nonce')->index();
            $table->integer('key_id')->unique()->index();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_result', function (Blueprint $table) {
            $table->increments('result_id');
            $table->integer('link_id')->unsigned()->index()->unique();
            $table->integer('user_id')->unsigned()->index()->unique();
            $table->text('result_url')->nullable();
            $table->text('sourcedid')->nullable();
            $table->integer('service_id')->unsigned()->nullable()->index();
            $table->string('ipaddr')->nullable();
            $table->float('grade')->nullable();
            $table->text('note')->nullable();
            $table->float('server_grade')->nullable();
            $table->text('json')->nullable();
            $table->integer('entity_version');
            $table->dateTime('retrieved_at')->nullable();

            $table->timestamps();
        });

        Schema::create('lti_service', function (Blueprint $table) {
            $table->increments('service_id');
            $table->char('service_sha256')->unique();
            $table->text('service_key');
            $table->integer('key_id')->unsigned()->unique();
            $table->text('format')->nullable();
            $table->text('json')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::create('lti_user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->char('user_sha256')->unique();
            $table->text('user_key');
            $table->integer('key_id')->unsigned()->unique();
            $table->integer('profile_id')->nullable();
            $table->text('displayname')->nullable();
            $table->text('email')->nullable();
            $table->char('locale')->nullable();
            $table->smallInteger('subscribe')->nullable();
            $table->text('json')->nullable();
            $table->dateTime('login_at')->nullable();
            $table->string('ipaddr')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        // -- end lti tables --

        Schema::create('mail_bulk', function (Blueprint $table) {
            $table->increments('bulk_id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('context_id')->unsigned()->index();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        Schema::create('mail_sent', function (Blueprint $table) {
            $table->increments('sent_id');
            $table->integer('context_id')->unsigned()->index();
            $table->integer('link_id')->unsigned()->nullable()->index();
            $table->integer('user_to')->unsigned()->nullable()->index();
            $table->integer('user_from')->unsigned()->nullable()->index();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->text('json')->nullable();

            $table->timestamps();
        });

        Schema::create('profile', function (Blueprint $table) {
            $table->increments('profile_id');
            $table->char('profile_sha256')->unique();
            $table->text('profile_key');
            $table->integer('key_id');
            $table->text('displayname')->nullable();
            $table->text('email')->nullable();
            $table->char('locale')->nullable();
            $table->smallInteger('subscribe')->nullable();
            $table->text('json')->nullable();
            $table->dateTime('login_at')->nullable();
            $table->integer('entity_version');

            $table->timestamps();
        });

        Schema::table('blob_file', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::table('key_request', function(Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('lti_user')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('mail_bulk', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('lti_user')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('mail_sent', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('link_id')->references('link_id')->on('lti_link')->onDelete('no action')->onUpdate('no action');
            $table->foreign('user_to')->references('user_id')->on('lti_user')->onDelete('no action')->onUpdate('no action');
            $table->foreign('user_from')->references('user_id')->on('lti_user')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('lti_context', function(Blueprint $table) {
            $table->foreign('key_id')->references('key_id')->on('lti_key')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_domain', function(Blueprint $table) {
            $table->foreign('key_id')->references('key_id')->on('lti_key')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_link', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_membership', function(Blueprint $table) {
            $table->foreign('context_id')->references('context_id')->on('lti_context')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('lti_user')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_result', function(Blueprint $table) {
            $table->foreign('link_id')->references('link_id')->on('lti_link')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('lti_user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_id')->references('service_id')->on('lti_service')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_service', function(Blueprint $table) {
            $table->foreign('key_id')->references('key_id')->on('lti_key')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('lti_user', function(Blueprint $table) {
            $table->foreign('key_id')->references('key_id')->on('lti_key')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blob_file');
        Schema::drop('key_request');
        Schema::drop('lms_plugins');
        Schema::drop('lti_context');
        Schema::drop('lti_domain');
        Schema::drop('lti_key');
        Schema::drop('lti_link');
        Schema::drop('lti_membership');
        Schema::drop('lti_nonce');
        Schema::drop('lti_result');
        Schema::drop('lti_service');
        Schema::drop('lti_user');
        Schema::drop('mail_bulk');
        Schema::drop('mail_sent');
        Schema::drop('profile');
    }

}