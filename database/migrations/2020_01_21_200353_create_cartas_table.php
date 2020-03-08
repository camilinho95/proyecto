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
            $table->string('comuna');
            $table->string('barrio');            
            $table->string('manzana');
            $table->string('idmanzana');
            $table->string('pdf');
            $table->string('dwg');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    
    public function down()
    {
        Schema::dropIfExists('cartas');
    }
}
