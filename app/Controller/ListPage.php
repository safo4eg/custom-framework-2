<?php

namespace Controller;

use Model\Patient;
use Src\Request;
use Src\Session;
use Src\View;

use Model\Employee;
use Model\Person;

class ListPage
{
    public function show(Request $request): string
    {
        $payload = $request->all();

        if($request->method === 'GET') {

            if(!empty($payload)) {
                $table = $payload['table'];

                if($table === 'employees') {
                    $employees_list = Employee::getFieldsInFormattedArray();
                    echo json_encode($employees_list); die();
                }

                if($table === 'patients') {
                    $patients = Patient::all();
                }
            }

            $employees_list = Employee::getFieldsInFormattedArray();
            return new View('list.show', ['employees_list' => $employees_list]);
        }
    }
}