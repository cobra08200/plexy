<?php

/**
 * Get the path to a versioned Elixir file.
 *
 * @param  string  $file
 * @return string
 *
 * @throws \InvalidArgumentException
 */
function elixir($file) {
    static $manifest = null;

    if (is_null($manifest)) {
        $manifest = json_decode(file_get_contents('../public/rev-manifest.json'), true);
    }

    if (isset($manifest[$file])) {
        return '/'.$manifest[$file];
    }

    throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
}
