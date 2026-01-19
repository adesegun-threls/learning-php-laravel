<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->json('content_v2_tiptap')->nullable()->after('content');
            $table->json('content_v2_compiled')->nullable()->after('content_v2_tiptap');
        });
    }

    public function down(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropColumn(['content_v2_tiptap', 'content_v2_compiled']);
        });
    }
};
