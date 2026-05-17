<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    // Leave empty — CodeIgniter will auto-detect the URL from the request
    public string $baseURL = 'https://cs-attendance-system-production.up.railway.app/';

    public array $allowedHostnames = [];

    // Remove index.php from URLs (Railway uses PHP built-in server)
    public string $indexPage = '';

    public string $uriProtocol = 'REQUEST_URI';

    public string $defaultLocale = 'en';
    public string $negotiateLocale = '';
    public string $supportedLocales = 'en';
    public float $cookieLifetime = 0;
    public string $cookiePath = '/';
    public string $cookieDomain = '';
    public bool $cookieSecure = false;
    public bool $cookieHTTPOnly = false;
    public string $cookieSameSite = 'Lax';
    public string $defaultDateformat = 'int';
    public string $charset = 'UTF-8';
    public bool $forceGlobalSecureRequests = false;
    public string $proxyIPs = '';
    public string $CSRFTokenName = 'csrf_token_name';
    public string $CSRFHeaderName = 'X-CSRF-TOKEN';
    public string $CSRFCookieName = 'csrf_cookie_name';
    public int $CSRFExpire = 7200;
    public bool $CSRFRegenerate = true;
    public bool $CSRFRedirect = false;
    public bool $CSRFSameSiteProtection = true;
    public string $CSPEnabled = 'false';
}
