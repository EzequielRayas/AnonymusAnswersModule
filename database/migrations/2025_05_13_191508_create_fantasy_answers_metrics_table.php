<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFantasyAnswersMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('fantasy_answers_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answers_id')->constrained('fantasy_answers')->onDelete('cascade');
            $table->date('date_metric');
            $table->bigInteger('likes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fantasy_answers_metrics');
    }  
}  





