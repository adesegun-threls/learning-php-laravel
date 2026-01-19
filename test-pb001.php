<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Threls\FilamentPageBuilder\Models\Template;
use Threls\FilamentPageBuilder\Models\TemplateSection;
use Threls\FilamentPageBuilder\Models\TemplateComponent;

// Create a template with timestamp to ensure uniqueness
$timestamp = now()->timestamp;
$template = Template::create([
    'name' => "Test Template {$timestamp}",
    'handle' => "test-template-{$timestamp}",
    'description' => 'A test template from PB-001',
    'status' => 'draft'
]);

echo "✅ Created template: {$template->name} (ID: {$template->id})\n";

// Create a root section
$section = TemplateSection::create([
    'template_id' => $template->id,
    'key' => 'hero',
    'type' => 'layout_section',
    'order' => 0,
    'settings' => ['width' => 'full']
]);

echo "✅ Created section: {$section->key} (ID: {$section->id})\n";

// Create a component
$component = TemplateComponent::create([
    'template_section_id' => $section->id,
    'type' => 'project-hero',
    'slug' => 'hero-1',
    'order' => 0,
    'data' => ['title' => 'Welcome'],
    'template_keys' => ['title' => 'page_title']
]);

echo "✅ Created component: {$component->type} (ID: {$component->id})\n\n";

// Test relationships
echo "🔗 Testing relationships:\n";
echo "   - Template has " . $template->sections()->count() . " section(s)\n";
echo "   - Section has " . $section->components()->count() . " component(s)\n\n";

// Test getStructure()
echo "📊 Template structure:\n";
$structure = $template->getStructure();
echo "   - ID: {$structure['id']}\n";
echo "   - Handle: {$structure['handle']}\n";
echo "   - Sections: " . count($structure['sections']) . "\n";
echo "   - First section has " . count($structure['sections'][0]['components']) . " component(s)\n\n";

// Test DTO
echo "📦 Testing DTO:\n";
$dto = \Threls\FilamentPageBuilder\Data\TemplateData::fromModel($template);
echo "   - DTO name: {$dto->name}\n";
echo "   - DTO sections: " . count($dto->sections) . "\n\n";

// Test validation (should pass)
echo "✓ Testing validation:\n";
$validator = new \Threls\FilamentPageBuilder\Support\Validation\TemplateSchemaValidator();
$sectionsArray = [
    [
        'key' => 'test',
        'type' => 'layout_section',
        'order' => 0,
        'components' => []
    ]
];
$isValid = $validator->validate($sectionsArray, $template->id);
echo "   - Valid structure: " . ($isValid ? "✅ YES" : "❌ NO") . "\n";
if (!$isValid) {
    foreach ($validator->getErrorMessages() as $error) {
        echo "     - Error: $error\n";
    }
}

echo "\n✨ PB-001 Test Complete!\n";
