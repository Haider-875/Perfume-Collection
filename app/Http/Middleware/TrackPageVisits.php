<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;

class TrackPageVisits
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only track GET HTML requests and exclude asset requests / admin / api / bot requests
        if ($request->isMethod('GET') && !$request->ajax() && !$request->is('admin*') && !$request->is('assets/*') && !$request->is('uploads/*') && !$request->is('_ignition*')) {
            $userAgent = $request->header('User-Agent', '');
            
            // Simple bot exclusion
            $botPatterns = ['bot', 'crawler', 'spider', 'slurp', 'baiduspider', 'yandex', 'headless'];
            $isBot = false;
            foreach ($botPatterns as $bot) {
                if (stripos($userAgent, $bot) !== false) {
                    $isBot = true;
                    break;
                }
            }

            if (!$isBot) {
                $isMobile = preg_match('/(android|iphone|ipad|mobile|touch)/i', $userAgent);

                try {
                    PageVisit::create([
                        'session_id' => $request->session()->getId(),
                        'ip_address' => $request->ip(),
                        'page_url' => substr($request->fullUrl(), 0, 250),
                        'referer' => substr($request->header('referer', ''), 0, 250) ?: null,
                        'user_agent' => substr($userAgent, 0, 250),
                        'device_type' => $isMobile ? 'mobile' : 'desktop',
                        'utm_source' => $request->input('utm_source'),
                        'visited_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    // Fail silently to never interrupt visitor response on shared hosting
                }
            }
        }

        return $response;
    }
}
