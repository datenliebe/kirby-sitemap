<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?= kirby()->multilang() ? html($page->url(kirby()->defaultLanguage()->code())) : html($page->url()) ?></loc>
        <lastmod><?= $page->modified('Y-m-d') ?></lastmod>
        <?php if (kirby()->multilang()): ?>
            <?php foreach (kirby()->languages() as $altLanguage): ?>
                <xhtml:link rel="alternate" hreflang="<?= $altLanguage->code() ?>" href="<?= html($page->url($altLanguage->code())) ?>" />
            <?php endforeach ?>
        <?php endif ?>
    </url>
<?php endforeach ?>
</urlset>
