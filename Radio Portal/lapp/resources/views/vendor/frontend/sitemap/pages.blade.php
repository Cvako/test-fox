@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($rows as $row)
    <url>
        <loc>{{ asset($settings['page_base'].'/'.$row->slug) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($row->updated_at)) }}</lastmod>
    </url>
    @endforeach
</urlset>
