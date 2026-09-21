<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class MarketingPagesTest extends TestCase
{
    /** @return array<string, array{string, string, string}> */
    public static function marketingPages(): array
    {
        return [
            'simple time tracker' => [
                'marketing.simple-time-tracker',
                'Simple Time Tracker for Clear, Effortless Time Tracking | SimpleTimer',
                'A simple time tracker that stays simple',
            ],
            'freelancers' => [
                'marketing.time-tracker-for-freelancers',
                'Time Tracker for Freelancers, Consultants and Client Work | SimpleTimer',
                'From focused work to a clear client report',
            ],
            'small business' => [
                'marketing.time-tracker-for-small-business',
                'Simple Time Tracker for Small Business Project Work | SimpleTimer',
                'Keep project time clear without enterprise complexity',
            ],
            'privacy friendly' => [
                'marketing.privacy-friendly-time-tracking',
                'Privacy-Friendly Time Tracking Without Surveillance | SimpleTimer',
                'Time tracking without surveillance',
            ],
            'project time tracking' => [
                'marketing.project-time-tracking',
                'Project Time Tracking with Clients, Rates and Reports | SimpleTimer',
                'See the time and value behind each project',
            ],
        ];
    }

    #[Test]
    #[DataProvider('marketingPages')]
    public function marketing_pages_have_expected_seo_metadata_and_one_h1(
        string $routeName,
        string $title,
        string $heading,
    ): void {
        $response = $this->get(route($routeName));

        $response->assertOk()
            ->assertSee("<title>{$title}</title>", false)
            ->assertSee('name="description"', false)
            ->assertSee('rel="canonical" href="'.route($routeName).'"', false)
            ->assertSee($heading);

        self::assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    #[Test]
    public function homepage_clearly_identifies_the_product_as_a_time_tracking_app(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('<title>Simple Time Tracking App for Freelancers | SimpleTimer</title>', false)
            ->assertSee('rel="canonical" href="'.route('home').'"', false)
            ->assertSee('Simple time tracking for freelancers')
            ->assertSee('An app that tracks time, not you.');

        self::assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    #[Test]
    public function sitemap_contains_every_public_marketing_page(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml');

        foreach (array_keys(self::marketingPages()) as $key) {
            $routeName = self::marketingPages()[$key][0];
            $response->assertSee('<loc>'.route($routeName).'</loc>', false);
        }
    }

    #[Test]
    public function robots_allows_crawling_and_advertises_the_sitemap(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        self::assertIsString($robots);
        self::assertStringContainsString("User-agent: *\nDisallow:", $robots);
        self::assertStringContainsString('Sitemap: https://simpletimerapp.com/sitemap.xml', $robots);
        self::assertStringNotContainsString('Disallow: /', $robots);
    }
}
