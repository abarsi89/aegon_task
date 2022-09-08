<?php

namespace Language;

use Language\ApiCall;
use Language\Config;
use Language\LanguageFilesGetterStrategy;

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
            $files[] = (Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml');
        }

        return $files;
    }
}