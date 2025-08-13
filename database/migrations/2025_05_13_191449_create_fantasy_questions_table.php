<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('fantasy_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('question', 100);
            $table->boolean('status')->default(1);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('placeholder')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fantasy_questions');
    }
}

