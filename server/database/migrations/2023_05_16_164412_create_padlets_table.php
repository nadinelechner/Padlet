<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padlets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('private');
            $table->integer('user_id');
            $table->dateTime('erstellungsdatum');
            $table->timestamps();
        });
    }
    /*cool, weil auf der Variable table können wir einfach die Methode string aufrufen und zb
    auch noch die Methoden unique,nullable..*/
    /*timestamp: automatisch da. laravel zeichnet mit wann erstellt bzw wann das letzte mal etwas
    geändert wurde (created_at, updated_at in der DB) */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('padlets');
    }
};
