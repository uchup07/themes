<?php

namespace Uchup07\Themes\Support;

use Uchup07\Themes\Concerns\GetsManifest;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;

class RouteServiceProvider extends LaravelRouteServiceProvider
{
    use GetsManifest;
}
