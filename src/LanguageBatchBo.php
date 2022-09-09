<?php

namespace Language;


use Language\Generators\LanguageFilesGenerator;
use Language\Generators\PhpLanguageFilesGenerator;
use Language\Generators\XmlLanguageFilesGenerator;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
    /**
     * @param string $languageType
     */
    private $languageType;

    private function setLanguageType(string $type): void
    {
        $this->languageType = $type;
    }

	public function generateLanguageFiles($type = 'php')
	{
        $this->setLanguageType($type);

        switch ($this->languageType) {
            case "php":
                $languageFilesGenerator = new LanguageFilesGenerator(new PhpLanguageFilesGenerator());
                break;
            case "xml":
                $languageFilesGenerator = new LanguageFilesGenerator(new XmlLanguageFilesGenerator());
                break;
        }

        return $languageFilesGenerator->generateLanguageFiles();
	}
}
