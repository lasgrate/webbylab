<?php

/**
 * PSR-4 autoloader
 */
spl_autoload_register(function ($class) {

    // Project namespace prefix
    $prefix = 'App\\';

    // Base directory for the namespace prefix

    $base_dir = APP_DIR;

    // Determine if the class use namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // Move to next autoloader
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        include_once $file;
    }
});