<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $t) {
            $t->id();
            $t->string('name'); $t->string('email');
            $t->string('phone')->nullable(); $t->string('company')->nullable();
            $t->string('service')->nullable(); $t->string('package')->nullable(); $t->string('budget')->nullable();
            $t->text('message');
            $t->string('status')->default('new'); // new/contacted/proposal/won/lost
            $t->text('notes')->nullable();
            $t->timestamps();
        });
        Schema::create('services', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique();
            $t->text('summary')->nullable(); $t->longText('body')->nullable();
            $t->string('ideal_for')->nullable(); $t->integer('sort')->default(0); $t->boolean('active')->default(true);
            $t->string('meta_title')->nullable(); $t->string('meta_description', 300)->nullable();
            $t->timestamps();
        });
        Schema::create('packages', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->string('price_label'); $t->string('period')->nullable();
            $t->text('description')->nullable(); $t->text('features')->nullable();
            $t->boolean('featured')->default(false); $t->integer('sort')->default(0); $t->boolean('active')->default(true);
            $t->timestamps();
        });
        Schema::create('posts', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique();
            $t->text('excerpt')->nullable(); $t->longText('body')->nullable(); $t->timestamp('published_at')->nullable();
            $t->string('meta_title')->nullable(); $t->string('meta_description', 300)->nullable();
            $t->timestamps();
        });
        Schema::create('pages', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('slug')->unique(); $t->longText('body')->nullable();
            $t->string('meta_title')->nullable(); $t->string('meta_description', 300)->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['pages', 'posts', 'packages', 'services', 'leads'] as $t) Schema::dropIfExists($t);
    }
};
