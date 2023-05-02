<?php

namespace Controller;
use Src\Request;
use Src\Response;
use Src\View;

use Model\Employee;
use Model\Patient;
use Model\Person;

class Actions
{
    public function add_employee(Request $request) {

        if($request->method === 'POST') {
            $response = new Response();
            $payload = $request->all();

            $person_fields = ['name', 'surname', 'patronymic', 'date_of_birth'];
            $person_payload = [];

            $employee_fields = ['login', 'password', 'role_id', 'specialization', 'department_id', 'cabinet'];
            $employee_payload = [];

            foreach($payload as $key => $value) {
                if(in_array($key, $person_fields)) {
                    $person_payload[$key] = $value;
                }

                if(in_array($key, $employee_fields)) {
                    if($key === 'password') $value = md5($value);
                    $employee_payload[$key] = $value;
                }
            }

            if(!empty($payload) && $person = Person::create($person_payload)) {
                $employee_payload['person_id'] = $person->id;
                $employee_id = Employee::create($employee_payload)->person_id;
                $employee[] = Employee::find($employee_id)->toArray();
                $covert_employee = Employee::getFieldsInFormattedArray($employee);
                echo $response->setData($covert_employee); die();
            }
        }

    }

    public function add_patient(Request $request) {
        if($request->method === 'POST') {
            $response = new Response();
            $payload = $request->all();

            if(!empty($payload) && $person = Person::create($payload)) {
                Patient::create(['person_id' => $person->id, 'status_id' => 1]);
                $patient[] = Patient::find($person->id)->toArray();
                $covert_patient = Patient::getFieldsInFormattedArray($patient);
                echo $response->setData($covert_patient); die();
            }
        }
    }

}