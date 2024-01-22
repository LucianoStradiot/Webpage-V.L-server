<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('home_infos', function (Blueprint $table) {
            $table->id();
            $table->string('parincipalTitle');
            $table->text('biography');
            $table->string('secondaryTitle');
            $table->text('descriptionLeft');
            $table->text('descriptionRight');
            $table->string('motivationalPhrase');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_infos');
    }
};
