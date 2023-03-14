<?php

if (!function_exists('base_url')) {
    function base_url($path = null)
    {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/' . $path;
    }
}
