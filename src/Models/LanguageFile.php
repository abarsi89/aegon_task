<?php

namespace Language\Models;

class LanguageFile
{
    public $path;
    
    public $content;

    public function __construct(string $path, string $content)
    {
        $this->path = $path;
        $this->content = $content;
    }
}