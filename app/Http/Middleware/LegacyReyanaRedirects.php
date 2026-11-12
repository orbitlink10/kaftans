<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LegacyReyanaRedirects
{
    public function handle(Request $request, Closure $next)
    {
        $legacy = config('kaftan.legacy');

        if (! ($legacy['redirects_enabled'] ?? false)) {
            return $next($request);
        }

        $host = strtolower($request->getHost());
        if (! in_array($host, $legacy['hosts'] ?? [], true)) {
            return $next($request);
        }

        $path = '/'.ltrim($request->path(), '/');
        $path = $path === '/' ? '/' : rtrim($path, '/');

        foreach ($legacy['excluded_prefixes'] ?? [] as $prefix) {
            if ($path === '/'.$prefix || str_starts_with($path, '/'.$prefix.'/')) {
                return $next($request);
            }
        }

        if (isset($legacy['paths'][$path])) {
            $target = rtrim(config('kaftan.canonical_base'), '/').$legacy['paths'][$path];
            if ($request->getQueryString()) {
                $target .= '?'.$request->getQueryString();
            }

            return redirect()->away($target, 301);
        }

        if (in_array($path, $legacy['gone'] ?? [], true)) {
            abort(410);
        }

        return $next($request);
    }
}
