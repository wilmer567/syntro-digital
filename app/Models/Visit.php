<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_hash',
        'url',
        'referer',
        'device',
        'browser',
        'platform',
    ];

    /**
     * Record a new visit from an incoming request.
     */
    public static function record(Request $request): ?self
    {
        $userAgent = (string) $request->userAgent();

        if (self::isBot($userAgent)) {
            return null;
        }

        $ip = $request->ip() ?: '127.0.0.1';
        $ipHash = hash('sha256', $ip.(config('app.key') ?: 'sytro-salt'));

        $referer = $request->headers->get('referer');
        if ($referer && strlen($referer) > 500) {
            $referer = substr($referer, 0, 497).'...';
        }

        $url = $request->path() === '/' ? '/' : '/'.ltrim($request->path(), '/');
        if (strlen($url) > 255) {
            $url = substr($url, 0, 255);
        }

        return self::create([
            'ip_hash' => $ipHash,
            'url' => $url,
            'referer' => $referer,
            'device' => self::detectDevice($userAgent),
            'browser' => self::detectBrowser($userAgent),
            'platform' => self::detectPlatform($userAgent),
        ]);
    }

    /**
     * Check if user agent matches typical web crawlers/bots.
     */
    public static function isBot(string $userAgent): bool
    {
        if (empty($userAgent)) {
            return false;
        }

        $bots = [
            'bot', 'crawl', 'spider', 'slurp', 'mediapartners', 'googlebot',
            'bingbot', 'yandex', 'duckduckbot', 'baiduspider', 'semrushbot',
            'ahrefsbot', 'dotbot', 'petalbot', 'bytespider', 'curl', 'wget',
            'python-requests', 'headlesschrome', 'lighthouse', 'pingdom',
        ];

        $ua = strtolower($userAgent);
        foreach ($bots as $bot) {
            if (str_contains($ua, $bot)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect device type (desktop, mobile, tablet).
     */
    public static function detectDevice(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet') || (str_contains($ua, 'android') && ! str_contains($ua, 'mobi'))) {
            return 'tablet';
        }

        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android') || str_contains($ua, 'phone')) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Detect major browser.
     */
    public static function detectBrowser(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (str_contains($ua, 'edg/') || str_contains($ua, 'edge/')) {
            return 'Edge';
        }
        if (str_contains($ua, 'opr/') || str_contains($ua, 'opera')) {
            return 'Opera';
        }
        if (str_contains($ua, 'chrome') && ! str_contains($ua, 'chromium')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'safari') && ! str_contains($ua, 'chrome')) {
            return 'Safari';
        }
        if (str_contains($ua, 'firefox')) {
            return 'Firefox';
        }

        return 'Otro';
    }

    /**
     * Detect operating system/platform.
     */
    public static function detectPlatform(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (str_contains($ua, 'windows')) {
            return 'Windows';
        }
        if (str_contains($ua, 'android')) {
            return 'Android';
        }
        if (str_contains($ua, 'iphone') || str_contains($ua, 'ipad') || str_contains($ua, 'ios')) {
            return 'iOS';
        }
        if (str_contains($ua, 'macintosh') || str_contains($ua, 'mac os x')) {
            return 'macOS';
        }
        if (str_contains($ua, 'linux')) {
            return 'Linux';
        }

        return 'Otro';
    }
}
