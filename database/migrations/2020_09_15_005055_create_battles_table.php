<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->enum('battle_type', ['3v3', '5v5', 'ships', 'training']);
            $table->unsignedBigInteger('video_id')->nullable();

            $table->unsignedBigInteger('offense_leader');
            $table->unsignedBigInteger('offense_slot_2')->nullable();
            $table->unsignedBigInteger('offense_slot_3')->nullable();
            $table->unsignedBigInteger('offense_slot_4')->nullable();
            $table->unsignedBigInteger('offense_slot_5')->nullable();
            $table->unsignedBigInteger('offense_slot_6')->nullable();
            $table->unsignedBigInteger('offense_slot_7')->nullable();
            $table->unsignedBigInteger('offense_slot_8')->nullable();

            $table->unsignedBigInteger('defense_leader');
            $table->unsignedBigInteger('defense_slot_2')->nullable();
            $table->unsignedBigInteger('defense_slot_3')->nullable();
            $table->unsignedBigInteger('defense_slot_4')->nullable();
            $table->unsignedBigInteger('defense_slot_5')->nullable();
            $table->unsignedBigInteger('defense_slot_6')->nullable();
            $table->unsignedBigInteger('defense_slot_7')->nullable();
            $table->unsignedBigInteger('defense_slot_8')->nullable();

            $table->unsignedBigInteger('score')->nullable();
            $table->string('video_timestamp')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('battles');
    }
}
