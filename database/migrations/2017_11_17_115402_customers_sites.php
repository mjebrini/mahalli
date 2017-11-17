<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomersSites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_sites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('site_domain')->unique();
            $table->string('status');
            $table->text('site_title');
            $table->text('admin_email')->nullable();
            $table->text('admin_user')->nullable();
            $table->text('admin_password')->nullable();
            $table->integer('user_id');
            $table->softDeletes();
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
        Schema::dropIfExists('ecommerce_sites');
    }
}
