<?php

namespace Language;

use Language\Config;
use Language\LanguageFilesGetterStrategy;

/**
 * Strategy of getting php language files
 */
class PhpLanguageFilesGetter implements LanguageFilesGetterStrategy
{
    public function getLanguageFiles(): array
    {
        $files = [];
        foreach (Config::get('system.translated_applications') as $application => $languages) {
            foreach ($languages as $language) {
                $files[] = Config::get('system.paths.root') . "/cache/{$application}/{$language}.php";
            }
        }

        return $files;
    }
}