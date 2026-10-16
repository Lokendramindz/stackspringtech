<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('status', 20)->default('published');
            $table->string('nav_label', 80)->nullable();
            $table->boolean('show_in_nav')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['status', 'nav_label', 'show_in_nav']);
        });
    }
};
