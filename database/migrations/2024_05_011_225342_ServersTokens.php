<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServersTokens extends Migration{

    public function up(){
        Schema::create('servers_tokens', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->string("server_name",200);
            $table->string("server_ip",25);
            $table->string("server_token",300);
            $table->timestamp("expire_date")->nullable();
            $table->boolean("active")->default(true);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('servers_tokens');
    }
}
