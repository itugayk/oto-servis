@php
    $jsonld = [
        '@context' => 'https://schema.org',
        '@type' => 'AutoRepair',
        'name' => setting('site_name', 'OtoPro Servis & Kaporta'),
        'description' => setting('tagline'),
        'image' => media_url(setting('hero_image')),
        'url' => url('/'),
        'telephone' => setting('phone'),
        'email' => setting('email'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => setting('address'),
            'addressCountry' => 'TR',
        ],
        'priceRange' => '₺₺',
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '09:00',
                'closes' => '18:00',
            ],
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'Saturday',
                'opens' => '09:00',
                'closes' => '14:00',
            ],
        ],
        'makesOffer' => \App\Models\Service::active()->orderBy('sort_order')->get()->map(fn ($s) => [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $s->name, 'description' => $s->summary],
        ])->all(),
        'sameAs' => array_values(array_filter([
            setting('instagram'), setting('facebook'), setting('youtube'),
        ])),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
