<?php

namespace Src;
use Error;

class Application
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function __get($key) {
        if($key === 'settings') {
            return $this->settings;
        }
        throw new Error("Обращение к несуществующему свойству");
    }

    public function run(): void
    {
        echo 'Working';
    }
}