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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_title', 255);
            $table->longText('post_lead')->nullable()->default(null);
            $table->longText('post_content');
            $table->string('post_image', 255)->nullable()->default(null);
            $table->text('post_seo_keywords')->nullable()->default(null);
            $table->string('post_seo_title', 255)->nullable()->default(null);
            $table->string('post_seo_description', 500)->nullable()->default(null);            
            $table->string('post_url', 255)->nullable()->default(null);
            $table->integer('post_category')->index('post_category')->nullable()->default(null);
            $table->integer('post_ai')->default(0);
            $table->integer('active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
