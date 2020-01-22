<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartasTable extends Migration
{
   
    public function up()
    {
        Schema::create('cartas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('IdManzana');
            $table->integer('manzana');
            $table->integer('comuna');
            $table->integer('barrio');
            $table->string('pdf');
            $table->string('cad');
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('cartas');
    }
}
