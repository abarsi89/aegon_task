<?php

namespace Language\Generators;

use Language\Config;
use Language\Api\LanguageApi;
use Language\Cache\LanguageCache;
use Language\Exceptions\FileCacheErrorException;
use Language\Exceptions\FileGenerationErrorException;
use Language\Generators\LanguageFilesGeneratorStrategy;
use Language\Models\LanguageFile;

/**
 * Strategy of generating php language files
 */
class PhpLanguageFilesGenerator implements LanguageFilesGeneratorStrategy
{
    private $languageFile;

    public function generateLanguageFiles(): void
    {
		echo "\nGenerating language files\n";
		foreach (Config::get('system.translated_applications') as $application => $languages) {
			
            echo "[APPLICATION: " . $application . "]\n";
			
            foreach ($languages as $language) {

				echo "\t[LANGUAGE: " . $language . "]";

				if ($this->createLanguageFile($application, $language) && $this->storeLanguageFile()) {
					echo " OK\n";
				}
			}
		}
    }

	private function createLanguageFile($application, $language): bool
	{
        $languageResponse = LanguageApi::getLanguageFile($language);
		$destination = LanguageCache::getLanguageCachePath($application) . $language . '.php';

        if (isset($languageResponse) && isset($destination)) {
            $this->languageFile = new LanguageFile($destination, $languageResponse);
            
            return true;
        } else {
            throw new FileGenerationErrorException('Unable to generate language file!');

            return false;
        }
	}

    private function storeLanguageFile(): bool
    {
        if (LanguageCache::createDirectory($this->languageFile->getPath()) && 
		    LanguageCache::storeData($this->languageFile->getPath(), $this->languageFile->getContent())) {

            return true;
        } else {
            throw new FileCacheErrorException('Unable to store language file!');

            return false;
        }
    }
}