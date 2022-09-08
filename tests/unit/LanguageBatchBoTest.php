<?php

use Language\LanguageBatchBo;
use Language\LanguageFilesGetter;
use Language\PhpLanguageFilesGetter;
use Language\XmlLanguageFilesGetter;
use PHPUnit\Framework\TestCase;

class LanguageBatchBoTest extends TestCase
{
    private $language;

    public function setUp(): void
    {
        $this->language = new LanguageBatchBo();
    }

    public function testMethodsOfLanguageBatchBoExist()
    {
        $methods = [
            'generateLanguageFiles',
            'generateAppletLanguageXmlFiles'
        ];

        foreach ($methods as $method) {
            $this->assertTrue(
                method_exists($this->language, $method),
                "'$method' method does not exist in LanguageBatchBo class"
            );
        }
    }

    public function testGenerateLanguageFiles()
    {
        $this->deleteLanguageFiles();
        $this->language->generateLanguageFiles();

        foreach ($this->getLanguageFiles() as $languageFile) {
            $this->assertFileExists($languageFile);
        }
    }

    public function testGenerateAppletLanguageXmlFiles()
    {
        $this->deleteLanguageFiles('xml');
        $this->language->generateAppletLanguageXmlFiles();

        foreach ($this->getLanguageFiles('xml') as $languageFile) {
            $this->assertFileExists($languageFile);
        }
    }

    private function deleteLanguageFiles(string $type = 'php'): void
    {
        foreach ($this->getLanguageFiles($type) as $languageFile) {
            @unlink($languageFile);
        }
    }

    private function getLanguageFiles(string $type = 'php')
    {
        switch ($type) {
            case "php":
                $languageFilesGenerator = new LanguageFilesGetter(new PhpLanguageFilesGetter());
                break;
            case "xml":
                $languageFilesGenerator = new LanguageFilesGetter(new XmlLanguageFilesGetter());
                break;
        }

        return $languageFilesGenerator->getLanguageFiles();
    }
}