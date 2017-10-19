<?php

/**
 * Custom controller autoloader.
 */
spl_autoload_register(function ($fullClass) {

    $fullClassExploded = explode('\\', $fullClass);
    $class = array_pop($fullClassExploded);

    // Check if $class belongs to controllers
    if (substr_count($class, 'Controller') !== 1) {
        return;
    }

    $base_dir = APP_DIR . 'controllers/';

    // Find wanted file
    $file = $base_dir . $class . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        include_once $file;
    } else {
        throw new \App\Exceptions\ResponseException('Page Not Found', 404);
    }
});