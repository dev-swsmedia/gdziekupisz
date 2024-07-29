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
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('postcode', 10);
            $table->string('city', 255);
            $table->string('street', 255);
            $table->string('number', 10);
            $table->string('lat', 50)->nullable()->default(null);
            $table->string('lng', 50)->nullable()->default(null);
            $table->integer('pos_category')->index('pos_category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
