<?php

namespace Language;

/**
 * Interface for language files getting strategy
 */
interface LanguageFilesGetterStrategy
{
    public function getLanguageFiles(): array;
}