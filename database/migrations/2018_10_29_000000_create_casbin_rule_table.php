<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCasbinRuleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $connection = config('casbin.database.connection') ?: config('database.default');
        Schema::connection($connection)->create(config('casbin.database.casbin_rules_table'), function (Blueprint $table) {
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
     */
    public function down()
    {
        $connection = config('casbin.database.connection') ?: config('database.default');
        Schema::connection($connection)->dropIfExists(config('casbin.database.casbin_rules_table'));
    }
}
