<?php

namespace Controller;

use Illuminate\Database\Query\Builder;
use Src\Request;
use Src\Response;
use Src\Session;
use Src\View;

use Model\Employee;
use Model\Patient;
use Model\Person;
use Model\Application;
use Model\Role;
use Model\Department;

class ListPage
{
    public function show(Request $request): string
    {
        $response = new Response();
        $payload = $request->all();

        if($request->method === 'GET') {

            if(!empty($payload)) {

                if(isset($payload['table'])) {
                    $table = $payload['table'];

                    if($table === 'employees') {
                        $employees_list = Employee::getFieldsInFormattedArray(Employee::all()->toArray());
                        echo $response->setData($employees_list); die();
                    }

                    if($table === 'patients') {
                        Session::set('table', 'patients');
                        $patients_list = Patient::getFieldsInFormattedArray(Patient::all()->toArray());
                        echo $response->setData($patients_list);die();
                    }

                    Session::set('table', $table);
                }

            }

            Session::set('table', 'employees');
            $employees_list = Employee::getFieldsInFormattedArray(Employee::all()->toArray());
            $roles_list = Role::all();
            $departments_list = Department::all();
            return new View('list.show', [
                'employees_list' => $employees_list,
                'roles_list' => $roles_list,
                'departments_list' => $departments_list
            ]);
        }
    }

    public function search(Request $request): void {
        $response = new Response();
        $class = (Session::get('table') === 'employees')? Employee::class: Patient::class;
        $payload = $request->all();

        if($request->method === 'GET') {
            $where = [];
            if(!empty($payload)) {
                foreach($payload as $key => $value) {
                    $where[] = [$key, "like", "$value%"];
                }
                $response_list = $class::whereHas('person', function($query) use ($where){
                    $query->where($where);
                })->get()->toArray();
                echo $response->setData($class::getFieldsInFormattedArray($response_list)); die();
            }
        }
    }

    public function patient_applications(Request $request): string {

        if($request->method === 'GET') {
            $patient_id = $request->all()['id'];
            $applications = Application::where('patient_id', $patient_id)->orderBy('date_of_application', 'desc')->get()->toArray();
            $doctors = Employee::whereIn('role_id', [2, 3, 4])->get()->toArray();
            return new View('list.applications', [
                'applications' => $applications,
                'doctors' => $doctors,
                'id' => $patient_id]);
        }

        if($request->method === 'POST') {
            $payload = $request->all();
            Application::create([
                'employee_id' => $payload['doctor'],
                'date_of_application' => $payload['date_of_application'],
                'patient_id' => $payload['id']
            ]);
            app()->route->redirect("/applications/patient?id={$payload['id']}"); die();
        }
    }
}