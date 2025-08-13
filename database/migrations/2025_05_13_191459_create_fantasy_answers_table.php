<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('fantasy_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('fantasy_questions')->onDelete('cascade');
            $table->text('answer');
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fantasy_answers');
    }
}

