<?php

namespace Language\Cache;

use Language\Config;
use Language\Models\LanguageFile;

class LanguageCache
{
    public static function set(LanguageFile $file)
    {
        file_put_contents($file->path, $file->content);
    }

    /**
	 * Gets the directory of the cached language files.
	 *
	 * @param string $application   The application.
	 *
	 * @return string   The directory of the cached language files.
	 */
	public static function getLanguageCachePath($application): string
	{
		return Config::get('system.paths.root') . '/cache/' . $application. '/';
	}

    public static function createDirectory($destination): bool
    {
        if (!is_dir(dirname($destination))) {
			return mkdir(dirname($destination), 0755, true);
		} else {
            return true;
        }
    }

    public static function storeData($destination, $content): bool
    {
        return (bool)file_put_contents($destination, $content);
    }
}