<?php

namespace Src;
use Error;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders()?? [];
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function all_json()
    {
        $json = file_get_contents('php://input');
        $payload = json_decode($json, true);
        return $payload;
    }

    public function set($fields, $value): void
    {
        $this->body[$fields] = $value;
    }

    public function get($field)
    {
        return $this->body[$field];
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function __get($key)
    {
        if(array_key_exists($key, $this->body)) {
            return $this->body[$key];
        }
        throw new Error('Accessing a non-existent property');
    }
}