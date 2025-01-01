
# Kirby sitemap.xml Plugin

The **datenliebe/kirby-sitemap** plugin for Kirby CMS simplifies the generation of a dynamic `sitemap.xml` file. It allows you to define default ignored pages, extend the list with custom pages via `config.php`, and dynamically serve the combined sitemap.

## Features

- **Plug & Play**: Installing the plugin in your `site/plugins` directory generates a basic sitemap.xml automatically —  no configuration needed.
- **Default Ignore Pages**: Automatically excludes commonly ignored pages like:
  - `error`
- **Custom Ignore Pages via Config**: Extend the ignore list in `config.php`.
- **Dynamic Sitemap**: Generates and serves a combined sitemap dynamically at `/sitemap.xml`.
- **Multilingual Support**: Handles multilingual sites by including alternate language URLs.

---

## Installation

1. Clone or download this repository into your `site/plugins` directory:

   ```bash
   git clone https://github.com/datenliebe/kirby-sitemap.git site/plugins/sitemap
   ```

2. The plugin is now installed and ready to use.

---

## Usage

### Default Behavior

By default, the plugin generates a `sitemap.xml` file that includes all listed pages except those specified in the default ignore list:

- `error`

---

### Customizing Ignore Pages

To exclude additional pages from the sitemap, define them in your `config.php` using the `datenliebe.sitemap.ignore` option.

#### Example Config

```php
return [
    'datenliebe.sitemap.ignore' => [
        'secret-page',
        'another-hidden-page',
    ],
    'datenliebe.sitemap.includeUnlisted' => false, // Exclude unlisted pages
];
```

#### Example Output

With the above configuration, your sitemap will exclude the following pages:

- `error`
- `secret-page`
- `another-hidden-page`

If `includeUnlisted` is set to `true`, unlisted (published) pages will also be included in the sitemap.

---

### Multilingual Sitemap

For multilingual sites, the plugin automatically includes alternate language URLs in the sitemap. Each page entry will have an `<xhtml:link>` tag pointing to its translations.

#### Example Output for Multilingual Sites

```xml
<url>
  <loc>https://example.com/en/page</loc>
  <lastmod>2024-12-31</lastmod>
  <xhtml:link rel="alternate" hreflang="en" href="https://example.com/en/page" />
  <xhtml:link rel="alternate" hreflang="de" href="https://example.com/de/page" />
</url>
```

---

### Sitemap Priority

Pages are included in the sitemap based on the following priority:
1. All listed pages (published and visible).
2. Additional unlisted pages (if `includeUnlisted` is set to `true`).
3. Pages explicitly ignored via the default or custom ignore lists.

---

## Example sitemap.xml

With custom ignore pages and multilingual support, the generated `sitemap.xml` might look like this:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://example.com/page</loc>
    <lastmod>2024-12-31</lastmod>
  </url>
  <url>
    <loc>https://example.com/en/page</loc>
    <lastmod>2024-12-31</lastmod>
    <xhtml:link rel="alternate" hreflang="en" href="https://example.com/en/page" />
    <xhtml:link rel="alternate" hreflang="de" href="https://example.com/de/page" />
  </url>
</urlset>
```

---

## Options

The following options can be set in your `config.php`:

| Option                            | Description                                   | Default     |
|-----------------------------------|-----------------------------------------------|-------------|
| `datenliebe.sitemap.ignore`       | Array of page IDs to ignore in the sitemap    | `[]`        |
| `datenliebe.sitemap.includeUnlisted` | Include unlisted (draft) pages in the sitemap | `false`      |

---

## License

This plugin is licensed under the [MIT License](LICENSE).

---

## Contributing

Feel free to submit issues or pull requests to improve this plugin. Contributions are always welcome!

---

## Questions?

If you have any questions or need assistance, feel free to reach out or create an issue in the repository.
