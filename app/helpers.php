<?php

if (! function_exists('kaftan_url')) {
    function kaftan_url(string $path = ''): string
    {
        $base = rtrim(config('kaftan.canonical_base'), '/');

        return $base.'/'.ltrim($path, '/');
    }
}

if (! function_exists('kaftan_brand')) {
    function kaftan_brand(): string
    {
        return config('kaftan.name', 'Kaftan Dress Kenya');
    }
}

if (! function_exists('kaftan_indexable')) {
    function kaftan_indexable(): bool
    {
        return ! config('kaftan.preview') && config('kaftan.indexable') && app()->environment('production');
    }
}
