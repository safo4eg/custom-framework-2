<?php

namespace Controller;

use Src\Request;
use Src\Response;
use Src\Session;
use Src\View;

use Model\Employee;
use Model\Patient;
use Model\Person;

class ListPage
{
    public function show(Request $request): string
    {
        $response = new Response();
        $payload = $request->all();

        if($request->method === 'GET') {

            if(!empty($payload)) {
                $table = $payload['table'];

                if($table === 'employees') {
                    $employees_list = Employee::getFieldsInFormattedArray();
                    echo $response->setData($employees_list); die();
                }

                if($table === 'patients') {
                    $patients_list = Patient::getFieldsInFormattedArray();
                    echo $response->setData($patients_list); die();
                }
            }

            $employees_list = Employee::getFieldsInFormattedArray();
            return new View('list.show', ['employees_list' => $employees_list]);
        }
    }
}