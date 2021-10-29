<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->timestamps();
            $table->id();
            $table->softDeletes();
            $table->string('name')->comment("人員名稱");
            $table->string('account')->comment("帳號");
            $table->string('email')->nullable()->comment("信箱");
            $table->text('remark')->nullable()->comment("備註");
            $table->string('password')->comment("密碼");
            $table->string('menuroles');
            $table->rememberToken();
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
