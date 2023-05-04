<?php

namespace Controller;

use Src\Request;
use Src\View;

class NonAccess
{
    public function show(Request $request): string
    {
        return new View('nonaccess.show');
    }
}