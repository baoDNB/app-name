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
        Schema::create('shared_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('website_domain')->index();
            $table->string('login')->index();
            $table->text('password');
            $table->text('two_factor_secret');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_accounts');
    }
};
