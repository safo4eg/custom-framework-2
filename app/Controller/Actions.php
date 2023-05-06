<?php

namespace Controller;
use Src\Request;
use Src\Response;
use Src\Validator\Validator;
use Src\View;
use Src\Files;

use Model\Employee;
use Model\Patient;
use Model\Person;
use Model\Application;


class Actions
{
    public function add_employee(Request $request) {

        if($request->method === 'POST') {
            $response = new Response();
            $payload = $request->all();

            $validator = new Validator($payload, [
                'name' => ['required'],
                'surname' => ['required'],
                'patronymic' => ['required'],
                'date_of_birth' => ['required'],
                'login' => ['required', 'latin', 'unique:employees,login'],
                'password' => ['required', 'latin'],
                'role_id' => ['required']
            ], [
                'required' => 'Поле :field не может быть пустым',
                'unique' => 'Такой :field уже существует',
                'latin' => 'Поле :field должно состоять из a-zA-Z, цифры или "_"'
            ]);

            if($validator->fails()) {
                echo $response->setStatus('error')->setCode(400)->setData($validator->errors()); die();
            }

            $person_fields = ['name', 'surname', 'patronymic', 'date_of_birth'];
            $person_payload = [];

            $employee_fields = ['login', 'password', 'role_id', 'specialization', 'department_id', 'cabinet'];
            $employee_payload = [];

            foreach($payload as $key => $value) {
                if(in_array($key, $person_fields)) {
                    $person_payload[$key] = $value;
                }

                if(in_array($key, $employee_fields)) {
                    if($key === 'department_id' && $value == 0) continue;
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

            $validator = new Validator($payload, [
                'name' => ['required'],
                'surname' => ['required'],
                'patronymic' => ['required'],
                'date_of_birth' => ['required'],
            ], [
                'required' => 'Поле :field не может быть пустым',
            ]);

            if($validator->fails()) {
                echo $response->setStatus('error')->setCode(400)->setData($validator->errors()); die();
            }

            if(!empty($payload) && $person = Person::create($payload)) {
                Patient::create(['person_id' => $person->id, 'status_id' => 1]);
                $patient[] = Patient::find($person->id)->toArray();
                $covert_patient = Patient::getFieldsInFormattedArray($patient);
                echo $response->setData($covert_patient); die();
            }
        }
    }

    public function edit(Request $request) {
        $response = new Response();
        $payload = $request->all_json();

        if($request->method === 'POST' && !empty($payload)) {
            Person::where('id', $payload['id'])->update([
                'name' => $payload['name'],
                'surname' => $payload['surname'],
                'patronymic' => $payload['patronymic'],
                'date_of_birth' => $payload['date_of_birth']
            ]);
            $class = null;
            $response_data = null;
            if($payload['table'] === 'работники') {
                $class = Employee::class;
                $class::find($payload['id'])->update([
                    'role_id' => $payload['role_id'],
                    'specialization' => !empty($payload['specialization'])? $payload['specialization']: null,
                    'department_id' => !empty($payload['department_id'])? $payload['department_id']: null,
                    'cabinet' => !empty($payload['cabinet'])? $payload['cabinet']: null,
                    'status_id' => ($payload['status_id'] !== '1')? 2: 1
                ]);
                $response_data[] = $class::find($payload['id'])->toArray();
            } elseif($payload['table'] === 'пациенты') {
                $class = Patient::class;
                $class::where('person_id', $payload['id'])->update([
                    'status_id' => ($payload['status_id'] !== '1')? 2: 1
                ]);
                $response_data[] = Patient::where('person_id', $payload['id'])->first()->toArray();
            }
            echo $response->setData($class::getFieldsInFormattedArray($response_data));die();
        }
    }


    public function add_diagnostic(Request $request) {
        $payload = $request->all();
        if($request->method === 'POST') {
            Application::where('id', $payload['application_id'])->update(['diagnostic' => $payload['diagnostic']]);
            app()->route->redirect("/applications/doсtor?id={$_SESSION['id']}");
        }
    }

    public function add_file(Request $request) {
        if($request->method === 'POST') {
            $files = $request->all()['files'];

            $files_handle = new Files(['image/png' => 1024*1024*2, 'text/plain' => 1024*1024*1.5]);
            $res = $files_handle->setFiles($files)->upload();
            if(!$res) {
                var_dump($files_handle->errors);
            }
        }
    }

}