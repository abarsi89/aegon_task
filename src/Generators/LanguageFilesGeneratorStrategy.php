<?php

namespace Language\Generators;

/**
 * Interface for language files generating strategy
 */
interface LanguageFilesGeneratorStrategy
{
    public function generateLanguageFiles(): void;
}