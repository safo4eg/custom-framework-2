<?php
    const DIR_CONFIG = DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."config";

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../routes/web.php';

    function getConfigs(string $path = DIR_CONFIG): array
    {
        $settings = [];
        foreach(scandir(__DIR__.$path) as $file) {
            $name = explode('.', $file)[0];
            if(!empty($name)) {
                $settings[$name] = include __DIR__.$path.DIRECTORY_SEPARATOR.$file;
            }
        }
        return $settings;
    }

    require_once(
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."routes".
        DIRECTORY_SEPARATOR."web.php"
    );

    $app = new Src\Application(new Src\Settings(getConfigs()));
    function app() {
        global $app;
        return $app;
    }
    return $app;
