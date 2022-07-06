<?php

namespace Uchup07\Themes\Support;

use Uchup07\Themes\Facades\Theme;
use Uchup07\Themes\Concerns\GetsManifest;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Support\Facades\Log;

class ServiceProvider extends IlluminateServiceProvider
{
    use GetsManifest;

    public function boot()
    {
        $slug = $this->getManifest()['slug'];

        if (Theme::getCurrent() === $slug) {
            $this->loadTranslationsFrom(Theme::path('resources/lang'), 'theme');
            $this->loadViewsFrom(Theme::path('resources/views'), 'theme');
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  string  $path
     * @return array
     */
    private function getConfigurationFiles($path) {
        $files      = [];
        $configPath = realpath($path);

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        krsort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Register any additional config.
     *
     * @param string $path
     *
     * @return void
     */
    protected function loadConfigsFrom($path)
    {
        if (! $this->app->configurationIsCached()) {
            $files = $this->getConfigurationFiles($path);
            // Log::info(print_r($files, true));
            foreach ($files as $key => $path) {
                // Log::info($key);
                config()->set($key, require $path);
            }
        }
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }
        
        return $nested;
    }
}
