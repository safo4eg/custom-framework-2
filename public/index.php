<?php
    declare(strict_types=1);
    use Src\Application;

    try {
        $bootstrap_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'bootstrap.php';
        $app = require_once($bootstrap_path);
        $app->run();

    } catch(\Throwable $exception) {
        echo '<pre>';
        print_r($exception);
        echo '</pre>';
    }

