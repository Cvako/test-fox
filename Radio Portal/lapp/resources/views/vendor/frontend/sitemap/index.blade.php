@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        @php $numberofpages = ceil($total_stations / $settings['sitemap_records_per_page']); @endphp
        @for ($i = 0; $i < $numberofpages; $i++)
    <sitemap>
        <loc>{{ asset('/sitemap/stations.xml') }}?page={{$i+1}}</loc>
    </sitemap>
        @endfor
    <sitemap>
        @php $numberofpages = ceil($total_genres / $settings['sitemap_records_per_page']); @endphp
        @for ($i = 0; $i < $numberofpages; $i++)
        <loc>{{ asset('/sitemap/genres.xml') }}?page={{$i+1}}</loc>
        @endfor    </sitemap>
    <sitemap>
        @php $numberofpages = ceil($total_countries / $settings['sitemap_records_per_page']); @endphp
        @for ($i = 0; $i < $numberofpages; $i++)
        <loc>{{ asset('/sitemap/countries.xml') }}?page={{$i+1}}</loc>
        @endfor
    </sitemap>
    <sitemap>
        @php $numberofpages = ceil($total_languages / $settings['sitemap_records_per_page']); @endphp
        @for ($i = 0; $i < $numberofpages; $i++)
        <loc>{{ asset('/sitemap/languages.xml') }}?page={{$i+1}}</loc>
        @endfor
    </sitemap>
    <sitemap>
        @php $numberofpages = ceil($total_pages / $settings['sitemap_records_per_page']); @endphp
        @for ($i = 0; $i < $numberofpages; $i++)
        <loc>{{ asset('/sitemap/pages.xml') }}?page={{$i+1}}</loc>
        @endfor
    </sitemap>
</sitemapindex>
