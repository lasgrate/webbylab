<?php

namespace App\Vendor;

class Link
{
    /**
     * Form url according app architecture
     *
     * @param string $controller
     * @param string $action
     * @param array $arguments
     * @return string
     */
    public static function getLink(
        $controller = DEFAULT_CONTROLLER,
        $action = DEFAULT_ACTION,
        $arguments = []
    ) {
        $link = "index.php?controller={$controller}&action={$action}";

        foreach ($arguments as $key => $value) {
            $link .= "&{$key}={$value}";
        }

        return $link;
    }
}