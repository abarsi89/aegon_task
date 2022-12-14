<?php

namespace Language\Providers;

use Language\ApiCall;
use Language\Config;
use Language\Providers\LanguageFilesProviderStrategy;
use Language\Models\LanguageFile;

/**
 * Strategy of getting php language files
 */
class PhpLanguageFilesProvider implements LanguageFilesProviderStrategy
{
    public function getLanguageFiles(): array
    {
        $files = [];
        foreach (Config::get('system.translated_applications') as $application => $languages) {
            foreach ($languages as $language) {
                //$languageFile = new LanguageFile();

                $files[] = new LanguageFile(
                    $this->getLanguageFilePath($application, $language),
                    $this->getLanguageFileContent($language)
                );
            }
        }

        return $files;
    }

    private function getLanguageFilePath($application, $language) {
        return Config::get('system.paths.root') . "/cache/{$application}/{$language}.php";
    }

    private function getLanguageFileContent($language) {
        $languageResponse = ApiCall::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ),
            array('language' => $language)
        );

        return $languageResponse['data'];
    }
}