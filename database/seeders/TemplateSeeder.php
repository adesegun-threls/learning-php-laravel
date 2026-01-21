<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Threls\FilamentPageBuilder\Models\Blueprint;
use Threls\FilamentPageBuilder\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Get blueprint IDs by handle for easy reference
        $blueprints = Blueprint::all()->keyBy('handle');
        
        $templates = [
            [
                'name' => 'Marketing Landing Page',
                'handle' => 'marketing-landing-page',
                'description' => 'Full-featured landing page with hero, features, testimonials, and CTA',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        // Hero Section
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('hero-section')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Transform Your Business with Our Platform',
                                                            'subtitle' => 'The all-in-one solution for modern teams',
                                                            'cta_text' => 'Get Started Free',
                                                            'cta_url' => '/signup',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Features Grid
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('feature-grid')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Why Choose Us',
                                                            'features' => [
                                                                ['name' => 'Fast Setup', 'description' => 'Get started in minutes'],
                                                                ['name' => 'Secure', 'description' => 'Enterprise-grade security'],
                                                                ['name' => '24/7 Support', 'description' => 'Always here to help'],
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Testimonials
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('testimonial')?->versions()->first()?->id,
                                                        'data' => [
                                                            'quote' => 'This platform changed how we work. Highly recommended!',
                                                            'author' => 'John Doe',
                                                            'role' => 'CEO, TechCorp',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Blog Post Template',
                'handle' => 'blog-post-template',
                'description' => 'Standard blog post with sidebar and related content',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 2,
                                'columnData' => [
                                    // Main Content
                                    [
                                        'columnId' => 3,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Blog Post Title',
                                                            'level' => 'h1',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('image')?->versions()->first()?->id,
                                                        'data' => [
                                                            'caption' => 'Featured image',
                                                            'alt_text' => 'Blog post cover image',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('rich-content')?->versions()->first()?->id,
                                                        'data' => [
                                                            'content' => '<p>Your blog post content goes here. Write engaging stories that captivate your audience.</p>',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    // Sidebar
                                    [
                                        'columnId' => 4,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('card')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'About the Author',
                                                            'description' => 'Expert writer with 10+ years experience',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('button')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Subscribe',
                                                            'url' => '/subscribe',
                                                            'variant' => 'primary',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Product Showcase',
                'handle' => 'product-showcase',
                'description' => 'Showcase products with gallery, features, and pricing',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        // Product Hero
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('project-hero')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Revolutionary Product',
                                                            'subtitle' => 'Innovation Meets Design',
                                                            'description' => 'Experience the future of technology',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Image Gallery
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('image-gallery')?->versions()->first()?->id,
                                                        'data' => [
                                                            'layout' => 'grid',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Video Demo
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('video-player')?->versions()->first()?->id,
                                                        'data' => [
                                                            'video_url' => 'https://example.com/demo.mp4',
                                                            'autoplay' => false,
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'FAQ Page',
                'handle' => 'faq-page',
                'description' => 'Frequently asked questions with accordion',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Frequently Asked Questions',
                                                            'level' => 'h1',
                                                            'style' => 'display',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('accordion')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Common Questions',
                                                            'items' => [
                                                                ['question' => 'How do I get started?', 'answer' => 'Simply sign up and follow our onboarding guide.'],
                                                                ['question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit cards and PayPal.'],
                                                                ['question' => 'Can I cancel anytime?', 'answer' => 'Yes, you can cancel your subscription at any time.'],
                                                            ],
                                                            'allow_multiple' => false,
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('faq-item')?->versions()->first()?->id,
                                                        'data' => [
                                                            'question' => 'Still have questions?',
                                                            'answer' => '<p>Contact our support team at support@example.com</p>',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Contact Us',
                'handle' => 'contact-us',
                'description' => 'Contact page with form and information cards',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 2,
                                'columnData' => [
                                    // Left - Contact Form
                                    [
                                        'columnId' => 3,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Get in Touch',
                                                            'level' => 'h2',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('contact-form')?->versions()->first()?->id,
                                                        'data' => [
                                                            'form_id' => 'contact',
                                                            'success_message' => 'Thank you! We will get back to you soon.',
                                                            'fields' => [
                                                                ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'required' => true],
                                                                ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
                                                                ['type' => 'textarea', 'name' => 'message', 'label' => 'Message', 'required' => true],
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    // Right - Contact Info
                                    [
                                        'columnId' => 4,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Contact Information',
                                                            'level' => 'h3',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('card')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Email',
                                                            'description' => 'hello@example.com',
                                                            'link' => 'mailto:hello@example.com',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('card')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Phone',
                                                            'description' => '+1 (555) 123-4567',
                                                            'link' => 'tel:+15551234567',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('card')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Address',
                                                            'description' => '123 Main St, City, State 12345',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Team Page',
                'handle' => 'team-page',
                'description' => 'Team member showcase with cards and testimonials',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Meet Our Team',
                                                            'level' => 'h1',
                                                            'style' => 'display',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('paragraph')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => '<p>Meet the talented individuals who make our company great.</p>',
                                                            'size' => 'lg',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Team Grid
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('grid')?->versions()->first()?->id,
                                                        'data' => [
                                                            'columns' => 3,
                                                            'gap' => 'medium',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Services Listing',
                'handle' => 'services-listing',
                'description' => 'Service offerings with tabbed content and cards',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('hero-section')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Our Services',
                                                            'subtitle' => 'Comprehensive solutions for your needs',
                                                            'cta_text' => 'View All Services',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('tabs')?->versions()->first()?->id,
                                                        'data' => [
                                                            'tabs' => [
                                                                ['label' => 'Design', 'content' => 'Professional design services'],
                                                                ['label' => 'Development', 'content' => 'Custom software development'],
                                                                ['label' => 'Marketing', 'content' => 'Digital marketing solutions'],
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Service Cards Grid
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('container')?->versions()->first()?->id,
                                                        'data' => [
                                                            'width' => 'full',
                                                            'padding' => 'large',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Portfolio Gallery',
                'handle' => 'portfolio-gallery',
                'description' => 'Portfolio showcase with project hero and galleries',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('project-hero')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'Our Portfolio',
                                                            'subtitle' => 'Work We\'re Proud Of',
                                                            'description' => 'Explore our latest projects and creative work',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Main Gallery
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('image-gallery')?->versions()->first()?->id,
                                                        'data' => [
                                                            'layout' => 'masonry',
                                                            'columns' => 3,
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Featured Project
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 2,
                                'columnData' => [
                                    [
                                        'columnId' => 3,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('image')?->versions()->first()?->id,
                                                        'data' => [
                                                            'caption' => 'Featured Project',
                                                            'alt_text' => 'Our best work',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'columnId' => 4,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Featured Project',
                                                            'level' => 'h2',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('rich-content')?->versions()->first()?->id,
                                                        'data' => [
                                                            'content' => '<p>Description of our most impressive project to date.</p>',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('button')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'View Case Study',
                                                            'url' => '/case-study',
                                                            'variant' => 'secondary',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'About Us Page',
                'handle' => 'about-us-page',
                'description' => 'Company about page with story, team, and testimonials',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        // Hero
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('hero-section')?->versions()->first()?->id,
                                                        'data' => [
                                                            'title' => 'About Our Company',
                                                            'subtitle' => 'Building the future together',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Story Section
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 2,
                                'columnData' => [
                                    [
                                        'columnId' => 3,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Our Story',
                                                            'level' => 'h2',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('rich-content')?->versions()->first()?->id,
                                                        'data' => [
                                                            'content' => '<p>Founded in 2020, we have been committed to excellence and innovation in everything we do.</p>',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'columnId' => 4,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('image')?->versions()->first()?->id,
                                                        'data' => [
                                                            'caption' => 'Our team at work',
                                                            'alt_text' => 'Team collaboration',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // Testimonials
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('heading')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'What Our Clients Say',
                                                            'level' => 'h2',
                                                            'style' => 'display',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('testimonial')?->versions()->first()?->id,
                                                        'data' => [
                                                            'quote' => 'Working with this team has been transformative for our business.',
                                                            'author' => 'Jane Smith',
                                                            'role' => 'CTO, InnovateCorp',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('testimonial')?->versions()->first()?->id,
                                                        'data' => [
                                                            'quote' => 'Exceptional quality and outstanding support.',
                                                            'author' => 'Mike Johnson',
                                                            'role' => 'Director, Digital Solutions',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        // CTA
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 1,
                                'columnData' => [
                                    [
                                        'columnId' => 1,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('text-block')?->versions()->first()?->id,
                                                        'data' => [
                                                            'content' => '<h3>Ready to work with us?</h3><p>Let\'s create something amazing together.</p>',
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => $blueprints->get('button')?->versions()->first()?->id,
                                                        'data' => [
                                                            'text' => 'Contact Us Today',
                                                            'url' => '/contact',
                                                            'variant' => 'primary',
                                                            'size' => 'large',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Empty Canvas',
                'handle' => 'empty-canvas',
                'description' => 'Blank template to start from scratch',
                'status' => 'draft',
                'content' => [
                    'type' => 'doc',
                    'content' => [],
                ],
            ],
        ];

        foreach ($templates as $templateData) {
            $content = $templateData['content'];
            unset($templateData['content']);

            $template = Template::create($templateData);

            // Create translations for both locales
            foreach (['en', 'mt'] as $locale) {
                $template->translateOrNew($locale)->content_tiptap = $content;
            }

            $template->save();
        }

        $this->command->info('✅ Created ' . count($templates) . ' sample templates');
    }
}
