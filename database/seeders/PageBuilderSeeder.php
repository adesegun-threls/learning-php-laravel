<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Threls\FilamentPageBuilder\Models\Blueprint;
use Threls\FilamentPageBuilder\Models\BlueprintVersion;
use Threls\FilamentPageBuilder\Models\Composition;
use Threls\FilamentPageBuilder\Models\Menu;
use Threls\FilamentPageBuilder\Models\MenuItem;
use Threls\FilamentPageBuilder\Models\Page;
use Threls\FilamentPageBuilder\Models\PageLayout;
use Threls\FilamentPageBuilder\Models\PageLayoutColumn;
use Threls\FilamentPageBuilder\Models\RelationshipType;
use Threls\FilamentPageBuilder\Enums\PageStatusEnum;

class PageBuilderSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Page Builder seeding...');

        // Create Page Layouts
        $singleColumnLayout = PageLayout::create([
            'name' => 'Single Column',
            'key' => 'single-column',
            'settings' => ['description' => 'A simple single column layout'],
            'is_active' => true,
        ]);

        PageLayoutColumn::create([
            'page_layout_id' => $singleColumnLayout->id,
            'index' => 1,
            'key' => 'main',
            'settings' => ['width_class' => 'w-full'],
        ]);

        $twoColumnLayout = PageLayout::create([
            'name' => 'Two Column',
            'key' => 'two-column',
            'settings' => ['description' => 'A two column layout with sidebar'],
            'is_active' => true,
        ]);

        PageLayoutColumn::create([
            'page_layout_id' => $twoColumnLayout->id,
            'index' => 1,
            'key' => 'main',
            'settings' => ['width_class' => 'w-2/3'],
        ]);

        PageLayoutColumn::create([
            'page_layout_id' => $twoColumnLayout->id,
            'index' => 2,
            'key' => 'sidebar',
            'settings' => ['width_class' => 'w-1/3'],
        ]);

        $this->command->info('✓ Created 2 page layouts with 3 columns');

        // Create Blueprints
        $heroBlueprint = Blueprint::create([
            'name' => 'Hero Section',
            'handle' => 'hero-section',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => true],
                    ['name' => 'subtitle', 'type' => 'text', 'required' => false],
                    ['name' => 'image', 'type' => 'media', 'required' => false],
                    ['name' => 'cta_text', 'type' => 'text', 'required' => false],
                    ['name' => 'cta_url', 'type' => 'url', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Rich Content',
            'handle' => 'rich-content',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => false],
                    ['name' => 'content', 'type' => 'richtext', 'required' => true],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Feature Grid',
            'handle' => 'feature-grid',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => true],
                    ['name' => 'features', 'type' => 'repeater', 'required' => true],
                ],
            ],
        ]);

        // Layout Components
        Blueprint::create([
            'name' => 'Container',
            'handle' => 'container',
            'category' => 'layout',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'width', 'type' => 'select', 'options' => ['full', 'container', 'narrow'], 'required' => false],
                    ['name' => 'padding', 'type' => 'text', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Grid',
            'handle' => 'grid',
            'category' => 'layout',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'columns', 'type' => 'number', 'required' => true],
                    ['name' => 'gap', 'type' => 'text', 'required' => false],
                ],
            ],
        ]);

        // Content Components
        Blueprint::create([
            'name' => 'Project Hero',
            'handle' => 'project-hero',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => true],
                    ['name' => 'subtitle', 'type' => 'text', 'required' => false],
                    ['name' => 'description', 'type' => 'textarea', 'required' => false],
                    ['name' => 'image', 'type' => 'media', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Text Block',
            'handle' => 'text-block',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'content', 'type' => 'richtext', 'required' => true],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Image Gallery',
            'handle' => 'image-gallery',
            'category' => 'media',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'images', 'type' => 'media_collection', 'required' => true],
                    ['name' => 'layout', 'type' => 'select', 'options' => ['grid', 'masonry', 'carousel'], 'required' => false],
                ],
            ],
        ]);

        // Media Components
        Blueprint::create([
            'name' => 'Video Player',
            'handle' => 'video-player',
            'category' => 'media',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'video_url', 'type' => 'url', 'required' => true],
                    ['name' => 'poster', 'type' => 'media', 'required' => false],
                    ['name' => 'autoplay', 'type' => 'boolean', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Single Image',
            'handle' => 'image',
            'category' => 'media',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'image', 'type' => 'media', 'required' => true],
                    ['name' => 'caption', 'type' => 'text', 'required' => false],
                    ['name' => 'alt_text', 'type' => 'text', 'required' => false],
                ],
            ],
        ]);

        // Interactive Components
        Blueprint::create([
            'name' => 'Button',
            'handle' => 'button',
            'category' => 'interactive',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'text', 'type' => 'text', 'required' => true],
                    ['name' => 'url', 'type' => 'url', 'required' => true],
                    ['name' => 'variant', 'type' => 'select', 'options' => ['primary', 'secondary', 'outline'], 'required' => false],
                    ['name' => 'size', 'type' => 'select', 'options' => ['sm', 'md', 'lg'], 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Contact Form',
            'handle' => 'contact-form',
            'category' => 'forms',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'form_id', 'type' => 'text', 'required' => true],
                    ['name' => 'success_message', 'type' => 'text', 'required' => false],
                    ['name' => 'fields', 'type' => 'repeater', 'required' => true],
                ],
            ],
        ]);

        // Content Cards
        Blueprint::create([
            'name' => 'Card',
            'handle' => 'card',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => true],
                    ['name' => 'description', 'type' => 'textarea', 'required' => false],
                    ['name' => 'image', 'type' => 'media', 'required' => false],
                    ['name' => 'link', 'type' => 'url', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Testimonial',
            'handle' => 'testimonial',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'quote', 'type' => 'textarea', 'required' => true],
                    ['name' => 'author', 'type' => 'text', 'required' => true],
                    ['name' => 'role', 'type' => 'text', 'required' => false],
                    ['name' => 'avatar', 'type' => 'media', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'FAQ Item',
            'handle' => 'faq-item',
            'category' => 'content',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'question', 'type' => 'text', 'required' => true],
                    ['name' => 'answer', 'type' => 'richtext', 'required' => true],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Accordion',
            'handle' => 'accordion',
            'category' => 'interactive',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'title', 'type' => 'text', 'required' => true],
                    ['name' => 'items', 'type' => 'repeater', 'required' => true],
                    ['name' => 'allow_multiple', 'type' => 'boolean', 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Tabs',
            'handle' => 'tabs',
            'category' => 'interactive',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'tabs', 'type' => 'repeater', 'required' => true],
                    ['name' => 'default_tab', 'type' => 'number', 'required' => false],
                ],
            ],
        ]);

        // Typography
        Blueprint::create([
            'name' => 'Heading',
            'handle' => 'heading',
            'category' => 'typography',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'text', 'type' => 'text', 'required' => true],
                    ['name' => 'level', 'type' => 'select', 'options' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], 'required' => true],
                    ['name' => 'style', 'type' => 'select', 'options' => ['default', 'display', 'subtitle'], 'required' => false],
                ],
            ],
        ]);

        Blueprint::create([
            'name' => 'Paragraph',
            'handle' => 'paragraph',
            'category' => 'typography',
            'status' => 'published',
            'working_schema' => [
                'fields' => [
                    ['name' => 'text', 'type' => 'richtext', 'required' => true],
                    ['name' => 'size', 'type' => 'select', 'options' => ['sm', 'base', 'lg', 'xl'], 'required' => false],
                ],
            ],
        ]);

        $this->command->info('✓ Created 20 blueprints across 7 categories');

        // Create BlueprintVersions for all blueprints
        $blueprints = Blueprint::all();
        foreach ($blueprints as $blueprint) {
            BlueprintVersion::create([
                'blueprint_id' => $blueprint->id,
                'version' => 1,
                'status' => 'published',
                'schema' => $blueprint->working_schema,
            ]);
        }

        $this->command->info('✓ Created initial versions for all blueprints');

        // Create Relationship Types
        RelationshipType::create([
            'name' => 'Page to Blueprint',
            'handle' => 'page-to-blueprint',
            'category' => 'content',
            'meta' => [
                'source_type' => 'Threls\\FilamentPageBuilder\\Models\\Page',
                'target_type' => 'Threls\\FilamentPageBuilder\\Models\\Blueprint',
                'arity' => 'many_to_many',
            ],
            'is_active' => true,
        ]);

        $this->command->info('✓ Created 1 relationship type');

        // Create Compositions (using Hero blueprint from above)
        Composition::create([
            'name' => 'Home Page Layout',
            'payload' => [
                'handle' => 'home-page-layout',
                'sections' => [
                    ['blueprint' => 'hero-section', 'order' => 1],
                    ['blueprint' => 'feature-grid', 'order' => 2],
                    ['blueprint' => 'rich-content', 'order' => 3],
                ],
            ],
            'is_active' => true,
        ]);

        Composition::create([
            'name' => 'About Page Layout',
            'payload' => [
                'handle' => 'about-page-layout',
                'sections' => [
                    ['blueprint' => 'hero-section', 'order' => 1],
                    ['blueprint' => 'text-block', 'order' => 2],
                    ['blueprint' => 'testimonial', 'order' => 3],
                ],
            ],
            'is_active' => true,
        ]);

        $this->command->info('✓ Created 2 compositions');

        // Create Pages with translations
        $homePage = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => ['layout' => 'single-column'],
            'status' => 'published',
        ]);

        $homePage->translateOrNew('en')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Welcome to Our Website']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'This is the home page content in English.']]],
            ],
        ];
        $homePage->save();

        $homePage->translateOrNew('mt')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Merħba fis-Sit Tagħna']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Dan huwa l-kontenut tal-paġna ewlenija bil-Malti.']]],
            ],
        ];
        $homePage->save();

        $aboutPage = Page::create([
            'title' => 'About Us',
            'slug' => 'about',
            'content' => ['layout' => 'two-column'],
            'status' => 'published',
        ]);

        $aboutPage->translateOrNew('en')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'About Our Company']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'We are a leading company in our industry.']]],
            ],
        ];
        $aboutPage->save();

        $aboutPage->translateOrNew('mt')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Dwar il-Kumpanija Tagħna']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Aħna kumpanija prinċipali fl-industrija tagħna.']]],
            ],
        ];
        $aboutPage->save();

        $servicesPage = Page::create([
            'title' => 'Our Services',
            'slug' => 'services',
            'content' => ['layout' => 'single-column'],
            'status' => 'published',
        ]);

        $servicesPage->translateOrNew('en')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Our Services']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'We offer a wide range of professional services.']]],
            ],
        ];
        $servicesPage->save();

        $contactPage = Page::create([
            'title' => 'Contact Us',
            'slug' => 'contact',
            'content' => ['layout' => 'single-column'],
            'status' => 'published',
        ]);

        $contactPage->translateOrNew('en')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Contact Us']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'We would love to hear from you.']]],
            ],
        ];
        $contactPage->save();

        $blogPage = Page::create([
            'title' => 'Blog',
            'slug' => 'blog',
            'content' => ['layout' => 'two-column'],
            'status' => 'draft',
        ]);

        $blogPage->translateOrNew('en')->content_v2_tiptap = [
            'type' => 'doc',
            'content' => [
                ['type' => 'heading', 'attrs' => ['level' => 1], 'content' => [['type' => 'text', 'text' => 'Our Blog']]],
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Stay updated with our latest posts.']]],
            ],
        ];
        $blogPage->save();

        $this->command->info('✓ Created 5 pages with translations');

        // Create Menus
        $mainMenu = Menu::create([
            'name' => 'Main Navigation',
            'description' => 'Main site navigation menu',
            'location' => 'header',
            'status' => 'active',
        ]);

        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'description' => 'Footer navigation menu',
            'location' => 'footer',
            'status' => 'active',
        ]);

        $this->command->info('✓ Created 2 menus');

        // Create Menu Items for Main Navigation
        $homeMenuItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'order' => 1,
            'type' => 'page',
            'page_id' => $homePage->id,
            'is_visible' => true,
        ]);

        $homeMenuItem->translateOrNew('en')->name = 'Home';
        $homeMenuItem->translateOrNew('en')->url = '/';
        $homeMenuItem->save();

        $homeMenuItem->translateOrNew('mt')->name = 'Dar';
        $homeMenuItem->translateOrNew('mt')->url = '/';
        $homeMenuItem->save();

        $aboutMenuItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'order' => 2,
            'type' => 'page',
            'page_id' => $aboutPage->id,
            'is_visible' => true,
        ]);

        $aboutMenuItem->translateOrNew('en')->name = 'About';
        $aboutMenuItem->translateOrNew('en')->url = '/about';
        $aboutMenuItem->save();

        $servicesMenuItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'order' => 3,
            'type' => 'page',
            'page_id' => $servicesPage->id,
            'is_visible' => true,
        ]);

        $servicesMenuItem->translateOrNew('en')->name = 'Services';
        $servicesMenuItem->translateOrNew('en')->url = '/services';
        $servicesMenuItem->save();

        $contactMenuItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'order' => 4,
            'type' => 'page',
            'page_id' => $contactPage->id,
            'is_visible' => true,
        ]);

        $contactMenuItem->translateOrNew('en')->name = 'Contact';
        $contactMenuItem->translateOrNew('en')->url = '/contact';
        $contactMenuItem->save();

        // Footer Menu Items
        $footerAboutMenuItem = MenuItem::create([
            'menu_id' => $footerMenu->id,
            'parent_id' => null,
            'order' => 1,
            'type' => 'page',
            'page_id' => $aboutPage->id,
            'is_visible' => true,
        ]);

        $footerAboutMenuItem->translateOrNew('en')->name = 'About Us';
        $footerAboutMenuItem->translateOrNew('en')->url = '/about';
        $footerAboutMenuItem->save();

        $privacyMenuItem = MenuItem::create([
            'menu_id' => $footerMenu->id,
            'parent_id' => null,
            'order' => 2,
            'type' => 'custom',
            'is_visible' => true,
        ]);

        $privacyMenuItem->translateOrNew('en')->name = 'Privacy Policy';
        $privacyMenuItem->translateOrNew('en')->url = '/privacy-policy';
        $privacyMenuItem->save();

        $this->command->info('✓ Created 6 menu items with translations');
        $this->command->info('');
        $this->command->info('🎉 Page Builder seeding completed successfully!');
    }
}
