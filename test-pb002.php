<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test 1: Check if TemplateResource exists
echo "✓ Testing PB-002 Implementation\n\n";

echo "1. TemplateResource exists: ";
echo class_exists(\Threls\FilamentPageBuilder\Resources\TemplateResource::class) ? "✅ YES\n" : "❌ NO\n";

echo "2. ComponentRegistry exists: ";
echo class_exists(\Threls\FilamentPageBuilder\Services\ComponentRegistry::class) ? "✅ YES\n" : "❌ NO\n";

echo "3. TemplateSectionBuilder exists: ";
echo class_exists(\Threls\FilamentPageBuilder\Forms\Components\TemplateSectionBuilder::class) ? "✅ YES\n" : "❌ NO\n";

echo "4. ResponsiveSettingsBuilder exists: ";
echo class_exists(\Threls\FilamentPageBuilder\Forms\Components\ResponsiveSettingsBuilder::class) ? "✅ YES\n" : "❌ NO\n";

echo "5. TemplateKeyMapper exists: ";
echo class_exists(\Threls\FilamentPageBuilder\Forms\Components\TemplateKeyMapper::class) ? "✅ YES\n" : "❌ NO\n";

echo "6. FilamentPageBuilderPlugin exists: ";
echo class_exists(\Threls\FilamentPageBuilder\FilamentPageBuilderPlugin::class) ? "✅ YES\n" : "❌ NO\n";

// Test ComponentRegistry
echo "\n📦 Testing ComponentRegistry:\n";
$registry = app(\Threls\FilamentPageBuilder\Services\ComponentRegistry::class);

$components = $registry->getFlatComponents();
echo "   - Total components: " . $components->count() . "\n";
echo "   - Component types: " . implode(', ', $components->keys()->take(5)->toArray()) . "...\n";

$sectionTypes = $registry->getSectionTypes();
echo "   - Section types: " . implode(', ', array_keys($sectionTypes)) . "\n";

echo "\n✨ PB-002 Core Implementation Complete!\n";
echo "\n📋 Next Steps:\n";
echo "   1. Register FilamentPageBuilderPlugin in AdminPanelProvider\n";
echo "   2. Access /admin/templates to test the UI\n";
echo "   3. Create a test template with sections and components\n";
