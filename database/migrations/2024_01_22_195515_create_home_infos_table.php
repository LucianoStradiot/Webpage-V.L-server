<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('home_infos', function (Blueprint $table) {
            $table->id();
            $table->string('principalTitle')->nullable();
            $table->text('biography')->nullable();
            $table->string('secondaryTitle')->nullable();
            $table->text('descriptionLeft')->nullable();
            $table->text('descriptionRight')->nullable();
            $table->string('motivationalPhrase')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_infos');
    }
};
