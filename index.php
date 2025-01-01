<?php

Kirby::plugin('datenliebe/sitemap', [
    // Serve the sitemap.xml route
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'method' => 'GET',
            'action' => function () {
                // Default ignored pages
                $defaultIgnorePages = [
                    'error',
                ];

                // Custom ignored pages from config.php
                $customIgnorePages = option('datenliebe.sitemap.ignore', []);
                $ignorePages = array_merge($defaultIgnorePages, $customIgnorePages);

                $includeUnlisted = option('datenliebe.sitemap.includeUnlisted', false);

                // Fetch pages based on visibility
                $pages = $includeUnlisted ? site()->pages()->published() : site()->pages()->listed();

                // Filter out ignored pages
                $pages = $pages->filter(function ($page) use ($ignorePages) {
                    return !in_array($page->id(), $ignorePages);
                });

                $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $sitemap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";

                if (kirby()->multilang()) {
                    foreach ($pages as $page) {
                        foreach (kirby()->languages() as $language) {
                            $sitemap .= "<url>";
                            $sitemap .= "<loc>" . html($page->url($language->code())) . "</loc>";
                            $sitemap .= "<lastmod>" . $page->modified('Y-m-d') . "</lastmod>";
                            $sitemap .= "<xhtml:link rel=\"alternate\" hreflang=\"" . $language->code() . "\" href=\"" . html($page->url($language->code())) . "\" />";
                            $sitemap .= "</url>";
                        }
                    }
                } else {
                    foreach ($pages as $page) {
                        $sitemap .= "<url>";
                        $sitemap .= "<loc>" . html($page->url()) . "</loc>";
                        $sitemap .= "<lastmod>" . $page->modified('Y-m-d') . "</lastmod>";
                        $sitemap .= "</url>";
                    }
                }

                $sitemap .= "</urlset>";

                return new Kirby\Http\Response($sitemap, 'application/xml');
            }
        ]
    ],

    // Default plugin options
    'options' => [
        'includeUnlisted' => false, // Whether to include unlisted pages
        'ignore' => [], // Custom pages to ignore
    ]
]);
