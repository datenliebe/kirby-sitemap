<?php

Kirby::plugin('datenliebe/sitemap', [
    'snippets' => [
        'sitemap' => __DIR__ . '/snippets/sitemap.php',
    ],
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'method' => 'GET',
            'action' => function () {
                $defaultIgnorePages = ['error'];
                $customIgnorePages = option('datenliebe.sitemap.ignore', []);
                $ignorePages = array_merge($defaultIgnorePages, $customIgnorePages);

                $includeUnlisted = option('datenliebe.sitemap.includeUnlisted', false);

                // Fetch pages based on visibility
                $pages = $includeUnlisted ? site()->index()->published() : site()->index()->listed();

                // Filter out ignored pages
                $pages = $pages->filter(function ($page) use ($ignorePages) {
                    return !in_array($page->id(), $ignorePages);
                });

                return new Kirby\Http\Response(
                    snippet('sitemap', compact('pages'), true),
                    'application/xml'
                );
            }
        ]
    ],
    'options' => [
        'includeUnlisted' => false,
        'ignore' => [],
    ]
]);
