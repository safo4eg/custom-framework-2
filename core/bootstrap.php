<?php
    const DIR_CONFIG = DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."config";

    spl_autoload_register(function($className)
    {
        $paths = include(__DIR__ . DIR_CONFIG . DIRECTORY_SEPARATOR . "path.php");
        $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $className);

        foreach($paths['classes'] as $path) {
            $file_name = $_SERVER['DOCUMENT_ROOT'].
                DIRECTORY_SEPARATOR.$paths['root'].
                DIRECTORY_SEPARATOR.$path.
                DIRECTORY_SEPARATOR.$class_name.".php";

            if(file_exists($file_name)) {
                require_once($file_name);
            }
        }
    });

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


    return new Src\Application(new Src\Settings(getConfigs()));
