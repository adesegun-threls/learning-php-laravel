<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component Registry
    |--------------------------------------------------------------------------
    |
    | Define all available template components that can be used in templates.
    | Each component must reference a valid blueprint type.
    |
    */

    'components' => [
        'layout' => [
            'label' => 'Layout Components',
            'components' => [
                'container' => [
                    'label' => 'Container',
                    'description' => 'Basic container wrapper',
                    'icon' => 'heroicon-o-rectangle-stack',
                    'blueprint_type' => null, // Pure layout, no blueprint
                ],
                'grid' => [
                    'label' => 'Grid',
                    'description' => 'Responsive grid layout',
                    'icon' => 'heroicon-o-squares-2x2',
                    'blueprint_type' => null,
                ],
                'flex' => [
                    'label' => 'Flex Container',
                    'description' => 'Flexbox layout',
                    'icon' => 'heroicon-o-arrows-right-left',
                    'blueprint_type' => null,
                ],
            ],
        ],

        'content' => [
            'label' => 'Content Components',
            'components' => [
                'project-hero' => [
                    'label' => 'Project Hero',
                    'description' => 'Hero section for project pages',
                    'icon' => 'heroicon-o-photo',
                    'blueprint_type' => 'project-hero',
                    'template_keys_schema' => [
                        'title' => ['type' => 'string', 'required' => true],
                        'subtitle' => ['type' => 'string', 'required' => false],
                        'image' => ['type' => 'media', 'required' => false],
                    ],
                ],
                'text-block' => [
                    'label' => 'Text Block',
                    'description' => 'Rich text content block',
                    'icon' => 'heroicon-o-document-text',
                    'blueprint_type' => 'text-block',
                    'template_keys_schema' => [
                        'content' => ['type' => 'richtext', 'required' => true],
                    ],
                ],
                'image-gallery' => [
                    'label' => 'Image Gallery',
                    'description' => 'Multi-image gallery component',
                    'icon' => 'heroicon-o-photo',
                    'blueprint_type' => 'image-gallery',
                    'template_keys_schema' => [
                        'images' => ['type' => 'media_collection', 'required' => true],
                        'layout' => ['type' => 'string', 'required' => false],
                    ],
                ],
            ],
        ],

        'media' => [
            'label' => 'Media Components',
            'components' => [
                'video-player' => [
                    'label' => 'Video Player',
                    'description' => 'Embedded video player',
                    'icon' => 'heroicon-o-play',
                    'blueprint_type' => 'video-player',
                    'template_keys_schema' => [
                        'video_url' => ['type' => 'string', 'required' => true],
                        'poster' => ['type' => 'media', 'required' => false],
                    ],
                ],
                'image' => [
                    'label' => 'Single Image',
                    'description' => 'Single image with caption',
                    'icon' => 'heroicon-o-photo',
                    'blueprint_type' => 'image',
                    'template_keys_schema' => [
                        'image' => ['type' => 'media', 'required' => true],
                        'caption' => ['type' => 'string', 'required' => false],
                    ],
                ],
            ],
        ],

        'forms' => [
            'label' => 'Form Components',
            'components' => [
                'contact-form' => [
                    'label' => 'Contact Form',
                    'description' => 'Basic contact form',
                    'icon' => 'heroicon-o-envelope',
                    'blueprint_type' => 'contact-form',
                    'template_keys_schema' => [
                        'form_id' => ['type' => 'string', 'required' => true],
                        'success_message' => ['type' => 'string', 'required' => false],
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Section Types
    |--------------------------------------------------------------------------
    |
    | Define available section types for organizing components.
    |
    */

    'section_types' => [
        'layout_section' => [
            'label' => 'Layout Section',
            'description' => 'Container for nested columns',
            'supports_nesting' => true,
            'max_depth' => 10,
        ],
        'content_section' => [
            'label' => 'Content Section',
            'description' => 'Section containing components',
            'supports_nesting' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */

    'validation' => [
        'max_depth' => 10,
        'max_components_per_section' => 50,
        'max_sections_per_template' => 100,
    ],
];
