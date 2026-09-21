{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ([
        ['route' => 'home', 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['route' => 'marketing.simple-time-tracker', 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['route' => 'marketing.time-tracker-for-freelancers', 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['route' => 'marketing.time-tracker-for-small-business', 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['route' => 'marketing.privacy-friendly-time-tracking', 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['route' => 'marketing.project-time-tracking', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ] as $page)
    <url>
        <loc>{{ route($page['route']) }}</loc>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
</urlset>
