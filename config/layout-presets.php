<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Responsive Layout Presets
    |--------------------------------------------------------------------------
    |
    | Pre-configured responsive settings for common layout patterns.
    | Users can apply these presets when configuring section settings.
    |
    */

    'presets' => [
        'full_width' => [
            'label' => 'Full Width',
            'description' => 'Full width layout with no container',
            'settings' => [
                'xs' => ['width' => 'full', 'padding' => 'none'],
                'sm' => ['width' => 'full', 'padding' => 'none'],
                'md' => ['width' => 'full', 'padding' => 'none'],
                'lg' => ['width' => 'full', 'padding' => 'none'],
                'xl' => ['width' => 'full', 'padding' => 'none'],
            ],
        ],

        'container' => [
            'label' => 'Container',
            'description' => 'Standard container with responsive max-width',
            'settings' => [
                'xs' => ['width' => 'container', 'padding' => 'medium', 'maxWidth' => '100%'],
                'sm' => ['width' => 'container', 'padding' => 'medium', 'maxWidth' => '640px'],
                'md' => ['width' => 'container', 'padding' => 'medium', 'maxWidth' => '768px'],
                'lg' => ['width' => 'container', 'padding' => 'large', 'maxWidth' => '1024px'],
                'xl' => ['width' => 'container', 'padding' => 'large', 'maxWidth' => '1280px'],
            ],
        ],

        'sidebar_layout' => [
            'label' => 'Sidebar Layout',
            'description' => '2-column layout with sidebar',
            'settings' => [
                'xs' => ['columns' => 1, 'gap' => 'medium'],
                'sm' => ['columns' => 1, 'gap' => 'medium'],
                'md' => ['columns' => '3fr 1fr', 'gap' => 'large'],
                'lg' => ['columns' => '3fr 1fr', 'gap' => 'large'],
                'xl' => ['columns' => '4fr 1fr', 'gap' => 'xlarge'],
            ],
        ],

        'three_column_grid' => [
            'label' => '3-Column Grid',
            'description' => 'Responsive 3-column grid layout',
            'settings' => [
                'xs' => ['columns' => 1, 'gap' => 'medium'],
                'sm' => ['columns' => 2, 'gap' => 'medium'],
                'md' => ['columns' => 3, 'gap' => 'large'],
                'lg' => ['columns' => 3, 'gap' => 'large'],
                'xl' => ['columns' => 3, 'gap' => 'xlarge'],
            ],
        ],

        'hero_section' => [
            'label' => 'Hero Section',
            'description' => 'Full-width hero with centered content',
            'settings' => [
                'xs' => ['width' => 'full', 'padding' => 'large', 'alignment' => 'center'],
                'sm' => ['width' => 'full', 'padding' => 'large', 'alignment' => 'center'],
                'md' => ['width' => 'full', 'padding' => 'xlarge', 'alignment' => 'center'],
                'lg' => ['width' => 'full', 'padding' => 'xxlarge', 'alignment' => 'center'],
                'xl' => ['width' => 'full', 'padding' => 'xxlarge', 'alignment' => 'center'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Breakpoint Definitions
    |--------------------------------------------------------------------------
    |
    | Define the breakpoints used in responsive settings.
    |
    */

    'breakpoints' => [
        'xs' => [
            'label' => 'Extra Small',
            'width' => '0px',
            'icon' => 'heroicon-o-device-phone-mobile',
        ],
        'sm' => [
            'label' => 'Small',
            'width' => '640px',
            'icon' => 'heroicon-o-device-tablet',
        ],
        'md' => [
            'label' => 'Medium',
            'width' => '768px',
            'icon' => 'heroicon-o-computer-desktop',
        ],
        'lg' => [
            'label' => 'Large',
            'width' => '1024px',
            'icon' => 'heroicon-o-tv',
        ],
        'xl' => [
            'label' => 'Extra Large',
            'width' => '1280px',
            'icon' => 'heroicon-o-tv',
        ],
    ],
];
