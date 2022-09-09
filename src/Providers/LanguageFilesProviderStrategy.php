<?php

namespace Language\Providers;

/**
 * Interface for language files getting strategy
 */
interface LanguageFilesProviderStrategy
{
    public function getLanguageFiles(): array;
}