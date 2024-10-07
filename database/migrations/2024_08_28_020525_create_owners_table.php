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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address', length: 255);
            $table->string('city', length: 100);
            $table->string('state', length: 100);
            $table->string('phone', length: 15);
            $table->string('alternate_phone', length: 15)->nullable();
            $table->string('web_page', length: 150)->nullable();
            $table->string('email', length: 64);
            $table->string('image_path', length: 100)->nullable();
            $table->string('email_notifications', length: 64);
            $table->string('stripe_key', length: 64)->nullable();
            $table->string('stripe_secret', length: 64)->nullable();
            $table->boolean('active')->default(true);
            $table->json('storage')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
