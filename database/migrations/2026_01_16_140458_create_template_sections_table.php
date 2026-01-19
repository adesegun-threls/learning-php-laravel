<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('template_sections')->cascadeOnDelete();
            $table->string('key')->nullable(); // e.g., 'hero', 'content', 'sidebar'
            $table->string('type')->default('layout_section'); // layout_section, column
            $table->unsignedInteger('order')->default(0);
            $table->json('settings')->nullable(); // Responsive layout settings
            $table->timestamps();

            $table->index(['template_id', 'parent_id']);
            $table->index(['template_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_sections');
    }
};
