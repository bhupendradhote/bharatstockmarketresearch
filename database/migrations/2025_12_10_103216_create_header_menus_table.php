<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderMenusTable extends Migration
{
    public function up()
    {
        Schema::create('header_menus', function (Blueprint $table) {
            $table->id();
            $table->text('icon_svg')->nullable(); 
            $table->string('title');              
            $table->string('slug')->unique();    
            $table->string('link');               
            $table->integer('order_no')->unique(); 
            $table->boolean('show_in_header')->default(1); 
            $table->boolean('status')->default(1); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('header_menus');
    }
}
