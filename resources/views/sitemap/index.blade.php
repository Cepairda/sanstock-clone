<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    @foreach ($sitemaps as $sitemap)

        <sitemap>

            <loc>{{ url($sitemap) }}</loc>

        </sitemap>

    @endforeach

</sitemapindex>
