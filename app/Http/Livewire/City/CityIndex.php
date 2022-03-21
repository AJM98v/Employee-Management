<?php

namespace App\Http\Livewire\City;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CityIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $cities = array();
    public $editMode;
    public $name;
    public $country_id;
    public $city;

    public function mount()
    {
        $this->cities = City::all();
        $this->editMode = false;
    }

    public function updatedSearch($search)
    {
        $this->cities = City::where('name', 'like', "%" . $search . "%")->get();
    }


    public function store()
    {
        $data = $this->validate([
            'name' => 'required|unique:cities',
            'country_id' => 'required'
        ]);

        City::create([
            'name' => $data['name'],
            'country_id' => $data['country_id']
        ]);

        $this->reset([
            'name',
            'country_id'
        ]);
        $this->dispatchBrowserEvent('close');
        session()->flash('message', 'City Added Successfully');
        $this->updateCity();

    }

    public function edit(City $city)
    {

        $this->city = $city;
        $this->editMode = true;

        $this->reset([
            'name',
            'country_id'
        ]);

        $this->name = $city->name;
        $this->country_id = $city->country_id;

        $this->dispatchBrowserEvent('edit');


    }

    public function update()
    {
        $data = $this->validate([
            'name' => 'required',
            'country_id' => 'required'
        ]);
        $this->city->update([
            'name'=>$data['name'],
            'country_id'=>$data['country_id']
        ]);

        $this->reset([
            'name',
            'country_id'
        ]);
        $this->dispatchBrowserEvent('close');

        session()->flash('message', 'Update is Done');

        $this->updateCity();


    }

    public function delete(Country $country)
    {
        $country->delete();
        session()->flash('message', 'Deleted Successfully');

        $this->updateCity();

    }

    public function updateCity()
    {
        $this->cities = City::all();


    }

    public function defualt()
    {
        $this->dispatchBrowserEvent('close');
        $this->reset([
            'name',
            'country_id'
        ]);
        $this->editMode = false;
    }

    public function render()
    {

        return view('livewire.city.city-index', [
            'cities' => $this->cities,
            'countries'=>Country::all()
        ])->layout('layouts.app');
    }
}
