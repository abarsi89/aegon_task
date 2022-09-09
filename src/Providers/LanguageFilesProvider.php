<?php

namespace Language\Providers;

use Language\Providers\LanguageFilesProviderStrategy;

/**
 * Context class for language files getting strategy 
 */
class LanguageFilesProvider
{
    private $provider;

    public function __construct(LanguageFilesProviderStrategy $provider)
    {
        $this->provider = $provider;
    }

    public function getLanguageFiles()
    {
        return $this->provider->getLanguageFiles();
    }
}