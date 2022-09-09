<?php

namespace Language\Models;

class LanguageFile
{
    private $path;
    
    private $content;

    public function __construct(string $path, string $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }
}