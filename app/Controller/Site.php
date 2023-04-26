<?php
namespace Controller;
use Illuminate\Database\Capsule\Manager as DB;
use Src\View;

class Site
{
    public function index(): string
    {
        $people = DB::table('people')->get();
        return new View('site.people', ['people' => $people]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }
}