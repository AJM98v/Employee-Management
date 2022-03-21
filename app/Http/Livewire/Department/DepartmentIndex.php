<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentIndex extends Component
{
    public $search = '';
    public $departments;
    public $editMode;
    public $name;
    public $department;

    public function mount()
    {
        $this->departments = Department::all();
        $this->editMode = false;
    }

    public function updatedSearch($search)
    {
        $this->departments = Department::where('name', 'like', "%" . $search . "%")->get();
    }

    public function store()
    {
        $data = $this->validate([
            'name'=>'required|unique:departments'
        ]);

        Department::create([
            'name'=>$data['name']
        ]);

        $this->dispatchBrowserEvent('close');
        session()->flash('message','Department added Successfully');
        $this->reset(['name']);

        $this->updateDepartment();


    }

    public function edit(Department $department){
        $this->editMode =true;
        $this->department = $department;
        $this->reset(['name']);
        $this->name = $department->name;

        $this->dispatchBrowserEvent('edit');



    }
    public function update(){
        $data = $this->validate([
            'name'=>'required'
        ]);
        $this->department->update([
            'name'=>$data['name']
        ]);

        $this->dispatchBrowserEvent('close');
        session()->flash('message','Department Update Successfully');
        $this->reset(['name']);

        $this->updateDepartment();
    }

    public function defualt(){
        $this->reset(['name']);
    }

    public function delete(Department $department){
        $department->delete();
        session()->flash('message','Department Deleted');
        $this->updateDepartment();

    }


    public function updateDepartment(){
        $this->departments = Department::all();
    }
    public function render()
    {
        return view('livewire.department.department-index',[
            'department'=>$this->departments
        ]);
    }
}
