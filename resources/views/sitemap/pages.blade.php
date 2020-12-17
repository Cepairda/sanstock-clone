<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    @foreach ($pages as $page)

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('uk', $page['url']) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $page['url']) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $page['url']) }}"/>

            <lastmod>{{ $page['lm'] }}</lastmod>

            <changefreq>monthly</changefreq>

            <priority>{{ $page['p'] }}</priority>

        </url>

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('ru', $page['url']) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $page['url']) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $page['url']) }}"/>

            <lastmod>{{ $page['lm'] }}</lastmod>

            <changefreq>monthly</changefreq>

            <priority>{{ $page['p'] }}</priority>

        </url>

    @endforeach

</urlset>
