<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCasbinRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casbin_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ptype')->nullable();
            $table->string('v0')->nullable();
            $table->string('v1')->nullable();
            $table->string('v2')->nullable();
            $table->string('v3')->nullable();
            $table->string('v4')->nullable();
            $table->string('v5')->nullable();
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
        Schema::drop('casbin_rule');
    }
}
