<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach ($products as $product)

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('uk', $product->slug) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $product->slug) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $product->slug) }}"/>

            <image:image>

      			<image:loc>{{ xml_img(['type' => 'product', 'sku' => $product->sku, 'size' => 458]) }}</image:loc>

      			<image:title>{{ $product->ua_name }}</image:title>

      			<image:caption>{{ $product->ua_name }} | {{ url('/') }}</image:caption>

    		</image:image>

            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.6</priority>

        </url>

        <url>

            <loc>{{ LaravelLocalization::getLocalizedURL('ru', $product->slug) }}</loc>

            <xhtml:link rel="alternate" hreflang="ru" href="{{ LaravelLocalization::getLocalizedURL('ru', $product->slug) }}"/>

            <xhtml:link rel="alternate" hreflang="uk" href="{{ LaravelLocalization::getLocalizedURL('uk', $product->slug) }}"/>

            <image:image>

                <image:loc>{{ xml_img(['type' => 'product', 'sku' => $product->sku, 'size' => 458]) }}</image:loc>

                <image:title>{{ $product->ru_name }}</image:title>

                <image:caption>{{ $product->ru_name }} | {{ url('/') }}</image:caption>

            </image:image>

            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.6</priority>

        </url>

    @endforeach

</urlset>
