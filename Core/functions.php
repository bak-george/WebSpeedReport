<?php

function base_path($path)
{
    return BASE_PATH . $path;
}

function sort_by_created_at($a, $b)
{
    return filectime($a) < filectime($b);
}