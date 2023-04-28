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

    public function getWebrootsPath(): array
    {
        $webroot = $this->path['webroot'];
        $root = $this->getRootPath();
        $general_dirs = $webroot['general_dirs'];
        $webroot_paths = [];

        foreach($webroot as $key => $value) {
            if($key !== 'general_dirs') {
                $webroot_path =
                    $root . DIRECTORY_SEPARATOR .
                    $general_dirs . DIRECTORY_SEPARATOR .
                    $key . DIRECTORY_SEPARATOR;
                if($key === 'js') {
                    foreach($value as $js_path) {
                        $webroot_paths[$key][] = $webroot_path.$js_path;
                    }
                    $webroot_paths[$key] = array_reverse($webroot_paths[$key]);
                } else {
                    $webroot_paths[$key] = $webroot_path.$value;
                }
            }
        }

        return $webroot_paths;
    }

    public function getDbSetting(): array
    {
        return $this->db?? [];
    }
}