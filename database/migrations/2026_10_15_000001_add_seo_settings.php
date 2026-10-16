<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['services', 'posts', 'pages'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('meta_robots', 32)->default('index');
                $table->text('og_image')->nullable();
            });
        }

        Schema::table('packages', function (Blueprint $table) {
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_robots', 32)->default('index');
            $table->text('og_image')->nullable();
        });

        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 32)->unique();
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_robots', 32)->default('index');
            $table->text('og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description', 'meta_robots', 'og_image']);
        });

        foreach (['pages', 'posts', 'services'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['meta_robots', 'og_image']);
            });
        }
    }
};