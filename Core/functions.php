<?php

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require base_path('views/' . $path);
}

function trimCharacters($string, $length = 11)
{
    if (strlen($string) > 11) {
        return substr($string, 0, $length);
    }
    return $string;
}