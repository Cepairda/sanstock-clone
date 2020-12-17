<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    @foreach ($categories as $category)

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('uk', $category->slug) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $category->slug) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $category->slug) }}"/>

            <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.8</priority>

        </url>

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('ru', $category->slug) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $category->slug) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $category->slug) }}"/>

            <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.8</priority>

        </url>

    @endforeach

</urlset>
