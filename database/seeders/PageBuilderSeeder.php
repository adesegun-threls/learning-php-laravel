<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Threls\FilamentPageBuilder\Models\Blueprint;
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
                    ['name' => 'cta_text', 'type' => 'text', 'required' => false],
                    ['name' => 'cta_url', 'type' => 'url', 'required' => false],
                ],
            ],
        ]);

        $contentBlueprint = Blueprint::create([
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

        $featureBlueprint = Blueprint::create([
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

        $this->command->info('✓ Created 3 blueprints');

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

        // Create Compositions
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
                    ['blueprint' => 'rich-content', 'order' => 2],
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
