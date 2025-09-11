<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Config;

final readonly class SubdomainUrlBuilder
{
    public function build(string $subdomain, string $path = ''): string
    {
        if (Config::get('app.single_user_mode')) {
            return $this->buildMainDomain($path);
        }

        $appUrl = config('app.url');
        $parsedUrl = parse_url((string) $appUrl);
        $scheme = $parsedUrl['scheme'] ?? 'http';
        $host = $parsedUrl['host'] ?? 'localhost';
        $port = isset($parsedUrl['port']) ? ":{$parsedUrl['port']}" : '';

        $path = ltrim($path, '/');
        $pathSegment = $path !== '' && $path !== '0' ? "/{$path}" : '';

        return "{$scheme}://{$subdomain}.{$host}{$port}{$pathSegment}";
    }

    public function buildMainDomain(string $path = ''): string
    {
        $appUrl = config('app.url');
        $parsedUrl = parse_url((string) $appUrl);
        $scheme = $parsedUrl['scheme'] ?? 'http';
        $host = $parsedUrl['host'] ?? 'localhost';
        $port = isset($parsedUrl['port']) ? ":{$parsedUrl['port']}" : '';

        $path = ltrim($path, '/');
        $pathSegment = $path !== '' && $path !== '0' ? "/{$path}" : '';

        return "{$scheme}://{$host}{$port}{$pathSegment}";
    }
}
