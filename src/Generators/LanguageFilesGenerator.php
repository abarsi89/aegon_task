<?php

namespace Language\Generators;

use Language\Generators\LanguageFilesGeneratorStrategy;

/**
 * Context class for language files generating strategy 
 */
class LanguageFilesGenerator
{
    private $generator;

    public function __construct(LanguageFilesGeneratorStrategy $generator)
    {
        $this->generator = $generator;
    }

    public function generateLanguageFiles()
    {
        return $this->generator->generateLanguageFiles();
    }
}