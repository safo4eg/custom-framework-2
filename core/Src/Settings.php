<?php

namespace Src;
use Error;

class Settings
{
    private array $_settings;
    public function __construct(array $settings = [])
    {
        $this->_settings = $settings;
    }

    public function __get($key) {
        if(array_key_exists($key, $this->_settings)) {
            return $this->_settings[$key];
        }
        throw new Error("Обращение к несуществующим настройкам");
    }

    public function getRootPath(): string
    {
        return $this->path['root']? DIRECTORY_SEPARATOR.$this->path['root']: '';
    }

    public function getViewsPath(): string
    {
        return DIRECTORY_SEPARATOR.$this->path['views']?? '';
    }
}