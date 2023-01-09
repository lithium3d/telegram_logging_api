<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domain_ping', function (Blueprint $table) {
            $table->id();
            $table->id('domain_id');
            $table->string('state');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('domain_id')->references('id')->on('domains')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domain_ping');
    }
};
