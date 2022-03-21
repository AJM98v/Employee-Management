<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CountryIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $countries = array();
    public $editMode;
    public $name;
    public $code;
    public $country;

    public function mount()
    {
        $this->countries = Country::all();
        $this->editMode = false;
    }

    public function updatedSearch($search)
    {
        $this->countries = Country::where('name', 'like', "%" . $search . "%")->get();
    }


    public function store()
    {
        $data = $this->validate([
            'name' => 'required|unique:countries',
            'code' => 'required'
        ]);

        Country::create([
            'name' => $data['name'],
            'country_code' => $data['code']
        ]);

        $this->reset([
            'name',
            'code'
        ]);
        $this->dispatchBrowserEvent('close');
        session()->flash('message', 'Country Added Successfully');
        $this->updateContries();

    }

    public function edit(Country $country)
    {

        $this->country = $country;
        $this->editMode = true;

        $this->reset([
            'name',
            'code'
        ]);

        $this->name = $country->name;
        $this->code = $country->country_code;

        $this->dispatchBrowserEvent('edit');


    }

    public function update()
    {
        $data = $this->validate([
            'name' => 'required',
            'code' => 'required'
        ]);
        $this->country->update([
            'name'=>$data['name'],
            'country_code'=>$data['code']
        ]);

        $this->reset([
            'name',
            'code'
        ]);
        $this->dispatchBrowserEvent('close');

        session()->flash('message', 'Update is Done');

        $this->updateContries();


    }

    public function delete(Country $country)
    {
        $country->delete();
        session()->flash('message', 'Deleted Successfully');

        $this->updateContries();

    }

    public function updateContries()
    {
        $this->countries = Country::all();


    }

    public function defualt()
    {
        $this->dispatchBrowserEvent('close');
        $this->reset([
            'name',
            'code'
        ]);
        $this->editMode = false;
    }

    public function render()
    {

        return view('livewire.country.country-index', [
            'countries' => $this->countries
        ])->layout('layouts.app');
    }
}
