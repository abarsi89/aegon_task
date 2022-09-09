<?php

use Language\LanguageBatchBo;
use Language\Providers\LanguageFilesProvider;
use Language\Providers\PhpLanguageFilesProvider;
use Language\Providers\XmlLanguageFilesProvider;
use PHPUnit\Framework\TestCase;

class LanguageBatchBoTest extends TestCase
{
    private $language;

    private $phpFiles;

    private $xmlFiles;

    public function setUp(): void
    {
        $this->language = new LanguageBatchBo();
        $this->phpFiles = $this->getLanguageFiles();
        $this->xmlFiles = $this->getLanguageFiles('xml');
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

        foreach ($this->phpFiles as $file) {
            $this->assertFileExists($file->path);
            $this->assertEquals($file->content, file_get_contents($file->path));
        }
    }

    public function testGenerateAppletLanguageXmlFiles()
    {
        $this->deleteLanguageFiles('xml');
        $this->language->generateAppletLanguageXmlFiles();

        foreach ($this->xmlFiles as $file) {
            $this->assertFileExists($file->path);
            $this->assertEquals($file->content, file_get_contents($file->path));
        }
    }

    private function deleteLanguageFiles(string $type = 'php'): void
    {
        switch ($type) {
            case "php":
                $files = $this->phpFiles;
                break;
            case "xml":
                $files = $this->xmlFiles;
                break;
        }

        foreach ($files as $file) {
            @unlink($file);
        }
    }

    private function getLanguageFiles(string $type = 'php'): array
    {
        switch ($type) {
            case "php":
                $languageFilesGetter = new LanguageFilesProvider(new PhpLanguageFilesProvider());
                break;
            case "xml":
                $languageFilesGetter = new LanguageFilesProvider(new XmlLanguageFilesProvider());
                break;
        }

        return $languageFilesGetter->getLanguageFiles();
    }

    public function tearDown(): void
    {
        $this->deleteLanguageFiles();
        $this->deleteLanguageFiles('xml');
    }
}