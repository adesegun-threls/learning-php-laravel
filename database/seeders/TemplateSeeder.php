<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Threls\FilamentPageBuilder\Models\Template;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Hero Landing Page',
                'handle' => 'hero-landing-page',
                'description' => 'A landing page template with hero section, features, and CTA',
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
                                                        'blueprintVersionId' => 1,
                                                        'data' => [
                                                            'title' => 'Welcome to Our Platform',
                                                            'description' => 'Build amazing web experiences with our page builder',
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
                'name' => 'Blog Post Layout',
                'handle' => 'blog-post-layout',
                'description' => 'Standard blog post template with sidebar',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
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
                                                        'blueprintVersionId' => 2,
                                                        'data' => [
                                                            'content' => 'Main blog content goes here...',
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
                                                        'blueprintVersionId' => 3,
                                                        'data' => [
                                                            'title' => 'Related Posts',
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
                'name' => 'Three Column Grid',
                'handle' => 'three-column-grid',
                'description' => 'Three column grid layout for features or services',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'layoutBlock',
                            'attrs' => [
                                'layoutId' => 3,
                                'columnData' => [
                                    [
                                        'columnId' => 5,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => 1,
                                                        'data' => [
                                                            'title' => 'Feature 1',
                                                            'description' => 'First feature description',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'columnId' => 6,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => 1,
                                                        'data' => [
                                                            'title' => 'Feature 2',
                                                            'description' => 'Second feature description',
                                                        ],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    [
                                        'columnId' => 7,
                                        'content' => [
                                            'type' => 'doc',
                                            'content' => [
                                                [
                                                    'type' => 'blueprintBlock',
                                                    'attrs' => [
                                                        'blueprintVersionId' => 1,
                                                        'data' => [
                                                            'title' => 'Feature 3',
                                                            'description' => 'Third feature description',
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
                'name' => 'Contact Form Section',
                'handle' => 'contact-form-section',
                'description' => 'Contact form with composition',
                'status' => 'published',
                'content' => [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'compositionBlock',
                            'attrs' => [
                                'compositionId' => 1,
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
                $template->translateOrNew($locale)->content_v2_tiptap = $content;
                $template->translateOrNew($locale)->content_v2_compiled = $this->compileContent($content);
            }

            $template->save();
        }

        $this->command->info('✅ Created ' . count($templates) . ' sample templates');
    }

    private function compileContent(array $content): array
    {
        // Simple compilation - just extract blueprint data for now
        $compiled = [];

        if (isset($content['content'])) {
            foreach ($content['content'] as $block) {
                if ($block['type'] === 'layoutBlock') {
                    $compiled[] = [
                        'type' => 'layout',
                        'layoutId' => $block['attrs']['layoutId'] ?? null,
                    ];
                } elseif ($block['type'] === 'blueprintBlock') {
                    $compiled[] = [
                        'type' => 'blueprint',
                        'blueprintVersionId' => $block['attrs']['blueprintVersionId'] ?? null,
                        'data' => $block['attrs']['data'] ?? [],
                    ];
                } elseif ($block['type'] === 'compositionBlock') {
                    $compiled[] = [
                        'type' => 'composition',
                        'compositionId' => $block['attrs']['compositionId'] ?? null,
                    ];
                }
            }
        }

        return $compiled;
    }
}
