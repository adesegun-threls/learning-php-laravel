<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_section_id')->constrained('template_sections')->cascadeOnDelete();
            $table->foreignId('blueprint_version_id')->nullable()->constrained('blueprint_versions')->nullOnDelete();
            $table->string('type'); // Component type identifier (e.g., 'project-hero', 'paragraph')
            $table->string('slug')->nullable(); // Unique instance identifier within template
            $table->unsignedInteger('order')->default(0);
            $table->json('data')->nullable(); // Static component data
            $table->json('template_keys')->nullable(); // Mapping between component props and page data fields
            $table->timestamps();

            $table->index(['template_section_id', 'order']);
            $table->index('blueprint_version_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_components');
    }
};
