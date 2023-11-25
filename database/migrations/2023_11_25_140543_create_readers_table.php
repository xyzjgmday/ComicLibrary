<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readers', function (Blueprint $table) {
            $table->id('reader_id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('last_login')->nullable();
            $table->json('favorite_comics')->nullable(); 
            
            $table->foreign('favorite_comics')->references('comic_id')->on('comics'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readers');
    }
}

?>
