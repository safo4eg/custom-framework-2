<?php

namespace Middlewares;

use Src\Request;

class NonAccessMiddleware
{
    public function handle(Request $request, $param)
    {
        preg_match('#^type=(?<type>[a-z]+)(?:\[(?<param>[\d,]+)\])?$#', $param, $match);
        $type = $match['type'];

        if($type === 'role') {
            $param = $match['param'];
            $arr = explode(',', $param);
            if(!in_array($_SESSION['role'], $arr)) {
                app()->route->redirect('/non-access');
            }
        } else if($type === 'id') {
            $request_id = $request->all()['id'];
            $current_id = $_SESSION['id'];
            if($request_id != $current_id) {
                app()->route->redirect('/non-access');
            }
        }
    }

}