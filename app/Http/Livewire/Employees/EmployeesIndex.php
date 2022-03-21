<?php

namespace App\Http\Livewire\Employees;

use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Department;
use Carbon\Carbon;
use Livewire\Component;

class EmployeesIndex extends Component
{
    public $employees;
    public $firstname, $lastname, $address, $country_id, $city_id, $department_id, $zip_code, $birthdate, $hired_date, $middle_name;
    public $editMode;
    public $search = '';
    public $employee;
    public $countries;
    public $departments;
    public $cities;

    public function mount()
    {
        $this->employees = Employee::all();
        $this->editMode = false;
        $this->departments = Department::all();
        $this->countries = Country::all();
        $this->cities = City::all();
    }

    public function updatedSearch($search)
    {
        $this->employees = Employee::where('lastname', 'like', "%" . $search . "%")->get();
    }

    public function store()
    {
        $data = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'department_id' => 'required',
            'zip_code' => 'required',
            'middle_name' => 'required',
            'birthdate' => 'required',
            'hired_date' => 'required'
        ]);



        Employee::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'department_id' => $data['department_id'],
            'zip_code' => $data['zip_code'],
            'middle_name' => $data['middle_name'],
            'birthdate' => Carbon::parse($data['birthdate'])->format('Y-m-d'),
            'date_hired' => Carbon::parse($data['hired_date'])->format('Y-m-d')
        ]);


        $this->dispatchBrowserEvent('close');
        $this->reset([
            'firstname',
            'lastname',
            'middle_name',
            'zip_code',
            'address',
            'country_id',
            'city_id',
            'department_id',
            'birthdate', 'hired_date'
        ]);
        session()->flash('message', 'Employee Added');

        $this->UpdateEmployees();

    }

    public function edit(Employee $employee)
    {
        $this->editMode = true;
        $this->employee = $employee;

        $this->reset([
            'firstname',
            'lastname',
            'middle_name',
            'zip_code',
            'address',
            'country_id',
            'city_id',
            'department_id',
            'birthdate', 'hired_date'
        ]);

        $this->dispatchBrowserEvent('edit');

        $this->firstname = $employee->firstname;
        $this->lastname = $employee->lastname;
        $this->address = $employee->address;
        $this->middle_name = $employee->middle_name;
        $this->country_id = $employee->country_id;
        $this->city_id = $employee->city_id;
        $this->department_id = $employee->department_id;
        $this->zip_code = $employee->zip_code;
        $this->birthdate = $employee->birthdate;
        $this->hired_date = $employee->date_hired;

    }

    public function update()
    {
        $data = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'department_id' => 'required',
            'zip_code' => 'required',
            'middle_name' => 'required',
            'birthdate' => 'required',
            'hired_date' => 'required'
        ]);

        $this->employee->update($data);

        $this->dispatchBrowserEvent('close');
        $this->reset([
            'firstname',
            'lastname',
            'middle_name',
            'zip_code',
            'address',
            'country_id',
            'city_id',
            'department_id',
            'birthdate', 'hired_date'
        ]);

        session()->flash('message', 'Updated Successfully');

        $this->UpdateEmployees();
    }

    public function delete(Employee $employee)
    {
        $employee->delete();
        session()->flash('message', 'Deleted');

        $this->UpdateEmployees();


    }

    public function UpdateEmployees()
    {
        $this->employees = Employee::all();
    }


    public function defualt()
    {
        $this->reset([
            'firstname',
            'lastname',
            'middle_name',
            'zip_code',
            'address',
            'country_id',
            'city_id',
            'department_id',
            'birthdate', 'hired_date'
        ]);
        $this->editMode = false;

    }

    public function updatedCountryId($id)
    {
        $country = Country::where('id', $id)->first();
        if ($country !== null) {
            $this->cities = $country->City()->get();
        } else {
            $this->cities = City::all();
        }


    }


    public function render()
    {
        return view('livewire.employees.employees-index', [
            'employees' => $this->employees
        ])->layout('layouts.app');
    }
}
