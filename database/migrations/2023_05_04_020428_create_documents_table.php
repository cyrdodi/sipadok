<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('documents', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('description');
      $table->unsignedBigInteger('type_id');
      $table->json('tags');
      $table->year('year');
      $table->string('link');
      $table->unsignedBigInteger('user_id');
      $table->timestamps();

      $table->foreign('type_id')->references('id')->on('types');
      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('documents');
  }
};
