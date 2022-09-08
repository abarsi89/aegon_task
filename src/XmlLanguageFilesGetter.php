<?php

namespace Language;

use Language\ApiCall;
use Language\Config;
use Language\LanguageFilesGetterStrategy;
use Language\Models\LanguageFile;

/**
 * Strategy of getting xml language files
 */
class XmlLanguageFilesGetter implements LanguageFilesGetterStrategy
{
    public function getLanguageFiles(): array
    {
        $files = [];
        $languages = ApiCall::call(
            'system_api',
            'language_api',
            [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages',
            ],
            ['applet' => 'JSM2_MemberApplet']
        );
        foreach ($languages['data'] as $language) {
            $files[] = new LanguageFile(
                $this->getLanguageFilePath($language),
                $this->getLanguageFileContent($language)
            );
        }

        return $files;
    }

    private function getLanguageFilePath($language) {
        return Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
    }

    private function getLanguageFileContent($language) {
        $languageResponse = ApiCall::call(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ),
            array(
                'applet' => 'JSM2_MemberApplet',
                'language' => $language
            )
        );
        return $languageResponse['data'];
    }
}