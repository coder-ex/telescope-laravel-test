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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable()->comment('имя');
            $table->string('last_name')->nullable()->comment('фамилия');
            $table->date('birthday')->nullable()->comment('дата рождения');
            $table->string('email')->nullable()->comment('аккаунт email');
            $table->string('telegram')->nullable()->comment('аккаунт telegram');
            $table->string('phone')->nullable()->comment('телефонный номер');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
