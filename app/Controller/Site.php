<?php
namespace Controller;

use Model\People;
use Src\View;

class Site
{
    public function index(): string
    {
        $people = People::all();
        return new View('site.people', ['people' => $people]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}