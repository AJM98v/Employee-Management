<?php

namespace App\Http\Livewire\User;


use App\Models\User;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;


class UserIndex extends Component
{
    use WithPagination ;

    public $search = '';
    public $firstname, $lastname, $username, $email, $password;
    public $editMode = false;
    public $user;


    public function store()
    {
        $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
        ]);

        User::create([
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'password' => Hash::make($this->password),
            'email' => $this->email,
        ]);

        $this->dispatchBrowserEvent('close');

        $this->reset([
            'firstname',
            'lastname',
            'password',
            'email',
            'username'
        ]);

        Session::flash('message','User Created Successfully');
    }


    public function edit(User $user)
    {
        $this->user = $user;

        $this->reset([
            'firstname',
            'lastname',
            'password',
            'email',
            'username'
        ]);

        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->username = $user->username;
        $this->email = $user->email;

        $this->editMode = true;

        $this->dispatchBrowserEvent('edit');


    }

    public function update()
    {
        $valid = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'email' => 'required|email',
        ]);


        $this->user->update($valid);

        $this->reset([
            'firstname',
            'lastname',
            'password',
            'email',
            'username'
        ]);

        $this->editMode = false;
        $this->dispatchBrowserEvent('close');

        Session::flash('message','User Update Successfully');


    }

    public function defualt()
    {
        $this->editMode = false;
        $this->reset([
            'firstname',
            'lastname',
            'password',
            'email',
            'username'
        ]);

    }

    public function delete(User $user)
    {
        $user->delete();
        Session::flash('message','User Delete Successfully');




    }

    public function render()
    {
        $users = User::paginate(4);
        if (strlen($this->search) > 1) {
            $users = User::where('username', 'like', "%" . $this->search . "%")->paginate(4);
        }

        return view('livewire.user.user-index', ['users'=>$users])
            ->layout('layouts.app');
    }
}
