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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('order_id');
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('freelancer_id');
            // $table->unsignedBigInteger('service_id');
            $table->string('images')->nullable();
            $table->tinyInteger('stars');
            $table->string('title')->nullable();
            $table->text('review')->nullable();
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
