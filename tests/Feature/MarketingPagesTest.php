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
            'virtual assistants' => [
                'marketing.time-tracker-for-virtual-assistants',
                'Time Tracking for Virtual Assistants | SimpleTimer',
                'Time tracking for virtual assistants with multiple direct clients',
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

        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    /** @return array<string, array{string}> */
    public static function marketingPageRoutes(): array
    {
        return array_map(fn (array $page): array => [$page[0]], self::marketingPages());
    }

    #[Test]
    #[DataProvider('marketingPageRoutes')]
    public function marketing_pages_include_product_visuals(string $routeName): void
    {
        $response = $this->get(route($routeName));

        $response->assertOk()
            ->assertSee('screenshots/running-timer.png', false)
            ->assertSee('screenshots/dashboard.png', false)
            ->assertSee('screenshots/reports.png', false);
    }

    #[Test]
    public function homepage_clearly_identifies_the_product_as_a_time_tracking_app(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('<title>Time Tracking for Freelance Developers &amp; Consultants | SimpleTimer</title>', false)
            ->assertSee('rel="canonical" href="'.route('home').'"', false)
            ->assertSee('Know exactly what to invoice.')
            ->assertSee('Simple time tracking for freelance developers and consultants who bill by the hour.')
            ->assertSee('An app that tracks time, not you.');

        $this->assertSame(1, substr_count($response->getContent(), '<h1'));
    }

    #[Test]
    public function homepage_prioritises_hosted_pricing_without_lifetime_free_promotions(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee(config('app.yearly_price'))
            ->assertSee('60-day free trial, then €59/year.')
            ->assertSee('href="'.route('register').'"', false)
            ->assertSee('href="#demo"', false)
            ->assertSeeInOrder(['Hosted for you', 'Prefer to self-host?'])
            ->assertDontSee('Early Adopter Offer')
            ->assertDontSee('lifetime free spots')
            ->assertDontSee('money-back guarantee');
    }

    #[Test]
    public function llms_file_matches_the_homepage_audience_and_offer(): void
    {
        $response = $this->get('/llms.txt');

        $response->assertOk()
            ->assertSee('freelance developers and consultants who bill by the hour')
            ->assertSee('Hosted for you: €59/year with a 60-day free trial.')
            ->assertSee('SimpleTimer produces reports, not invoices.')
            ->assertSee('Self-hosting is optional and free.')
            ->assertDontSee('Pay nothing. Forever.')
            ->assertDontSee('money-back guarantee');
    }

    #[Test]
    public function virtual_assistant_page_qualifies_visitors_and_exposes_measurement_ctas(): void
    {
        $response = $this->get(route('marketing.time-tracker-for-virtual-assistants'));

        $response->assertOk()
            ->assertSee('Best for solo VAs who choose their own tools and bill hourly or track prepaid client hours.')
            ->assertSee('Switch recent clients quickly')
            ->assertSee('Track short tasks accurately')
            ->assertSee('client-ready CSV or PDF reports')
            ->assertSee('screenshots/running-timer.png', false)
            ->assertSee('screenshots/dashboard.png', false)
            ->assertSee('screenshots/reports.png', false)
            ->assertSee('Watch the 30-second demo')
            ->assertSee('€59')
            ->assertSee('60-day trial')
            ->assertSee('data-landing-event="va-trial-start"', false)
            ->assertSee('utm_campaign=va_landing', false)
            ->assertSee('does not replace your invoicing, CRM, or retainer-management workflow');
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

        $this->assertIsString($robots);
        $this->assertStringContainsString("User-agent: *\nDisallow:", $robots);
        $this->assertStringContainsString('Sitemap: https://simpletimerapp.com/sitemap.xml', $robots);
        $this->assertStringNotContainsString('Disallow: /', $robots);
    }
}
