<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['pages', 'services', 'packages', 'posts'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        Schema::create('content_revisions', function (Blueprint $table) {
            $table->id();
            $table->string('record_type', 40);
            $table->string('record_id', 100);
            $table->string('action', 32)->default('updated');
            $table->json('snapshot');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index(['record_type', 'record_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_revisions');
        foreach (['pages', 'services', 'packages', 'posts'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
