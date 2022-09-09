<?php

namespace Language\Generators;


use Language\Config;
use Language\Api\LanguageApi;
use Language\Cache\LanguageCache;
use Language\Exceptions\FileCacheErrorException;
use Language\Exceptions\FileGenerationErrorException;
use Language\Exceptions\NoAvailableLanguageException;
use Language\Exceptions\SavingAppletErrorException;
use Language\Generators\LanguageFilesGeneratorStrategy;
use Language\Models\LanguageFile;

/**
 * Strategy of generating xml language files
 */
class XmlLanguageFilesGenerator implements LanguageFilesGeneratorStrategy
{
    // List of the applets [directory => applet_id].
    const APPLETS = [
        'memberapplet' => 'JSM2_MemberApplet',
    ];

    private $languageFile;

	public function generateLanguageFiles(): void
	{
		echo "\nGetting applet language XMLs..\n";

		foreach (self::APPLETS as $appletDirectory => $appletLanguageId) {

			echo " Getting > $appletLanguageId ($appletDirectory) language xmls..\n";

			$languages = LanguageApi::getAppletLanguages($appletLanguageId);

			if (empty($languages)) {
				throw new NoAvailableLanguageException('There is no available languages for the ' . $appletLanguageId . ' applet.');
			}
			else {
				echo ' - Available languages: ' . implode(', ', $languages) . "\n";
			}

			foreach ($languages as $language) {
                $xmlPath = Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';

                if ($this->createLanguageFile($appletLanguageId, $language, $xmlPath) && $this->storeLanguageFile()) {
					echo " OK saving $xmlPath was successful.\n";
				} else {
					throw new SavingAppletErrorException('Unable to save applet: (' . $appletLanguageId . ') language: (' . $language
						. ') xml (' . $xmlPath . ')!');
				}
			}
			echo " < $appletLanguageId ($appletDirectory) language xml cached.\n";
		}

		echo "\nApplet language XMLs generated.\n";
	}

    private function createLanguageFile($appletLanguageId, $language, $xmlPath): bool
	{
        $xmlContent = LanguageApi::getAppletLanguageFile($appletLanguageId, $language);

        if (isset($xmlContent) && isset($xmlPath)) {
            $this->languageFile = new LanguageFile($xmlPath, $xmlContent);
            
            return true;
        } else {
            throw new FileGenerationErrorException('Unable to generate xml language file!');

            return false;
        }
	}

    private function storeLanguageFile(): bool
    {
        if (LanguageCache::createDirectory($this->languageFile->getPath()) && 
		    LanguageCache::storeData($this->languageFile->getPath(), $this->languageFile->getContent())) {

            return true;
        } else {
            throw new FileCacheErrorException('Unable to store xml language file!');

            return false;
        }
    }
}