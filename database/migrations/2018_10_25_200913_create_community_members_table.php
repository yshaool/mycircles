<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommunityMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('community_id');
            $table->integer('user_id');//assigned when users accept invitation
            $table->integer('invites');//number of invitations sent
            $table->string('invite_code')->unique();//code with which user can link himself to community
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('custom1')->nullable();
            $table->string('custom2')->nullable();
            $table->string('custom3')->nullable();
            $table->string('custom4')->nullable();
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
        Schema::dropIfExists('community_members');
    }
}
