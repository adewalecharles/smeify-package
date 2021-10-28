<?php

use AdewaleCharles\Smeify\Models\Smeify;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmeifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smeifies', function (Blueprint $table) {
            $table->id();
            $table->text('token');
            $table->dateTime('expires');
            $table->timestamps();
        });

        Smeify::create([
            'token' => 'sgifufguwtfwetr89q3t89tr23wefi384tgfbuiwtg89rgetiuer',
            'expires' => '2021-10-21 11:32:37'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smeifies');
    }
}
