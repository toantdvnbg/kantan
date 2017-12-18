<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid',100);
            $table->string('email',200)->nullable();
            $table->string('full_name',100)->nullable()->comment('Full name');
            $table->string('avatar',255)->nullable()->comment('Avatar');
            $table->string('address',255)->nullable()->comment('Address');
            $table->string('birthday',20)->nullable();
            $table->string('gender')->nullable();
            $table->integer('status')->nullable();
            $table->text('access_token');
            $table->timestamp('created_at')->useCurrent()->comment('作成日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->comment('更新日');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
