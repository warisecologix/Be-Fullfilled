<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDailyCheckQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_daily_check_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_check_question_id')->constrained("daily_check_questions");
            $table->boolean('status'); // 1 yes 0 no
            $table->foreignId('user_id')->constrained("users");
            $table->date('date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_daily_check_questions');
    }
}
