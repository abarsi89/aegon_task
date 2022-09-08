<?php

namespace Language;

use Language\LanguageFilesGetterStrategy;

/**
 * Context class for language files getting strategy 
 */
class LanguageFilesGetter
{
    private $getter;

    public function __construct(LanguageFilesGetterStrategy $getter)
    {
        $this->getter = $getter;
    }

    public function getLanguageFiles()
    {
        return $this->getter->getLanguageFiles();
    }
}