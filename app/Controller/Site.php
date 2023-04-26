<?php
namespace Controller;

use Model\People;
use Src\Request;
use Src\View;

class Site
{
    public function index(Request $request): string
    {
        $people = People::where('id', $request->id)->get();
        return new View('site.people', ['people' => $people]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}