<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class Dashboard extends Component
{
    public $current_password,$new_password,$confirm_password;
    public function mount()
        {
            $this->current_password = '';
            $this->new_password = '';
            $this->confirm_password = '';
        }

    public function rules(){
        return [
            'new_password'=> ['required','same:confirm_password','min:8'],
        ];
    }
    public function messages()
    {
        return [
            'new_password.required' => 'Password belum diisi.',
            'new_password.same' => 'Password tidak cocok.',
            'new_password.min' => 'Password minimal 8 karakter.',
        ];
    }

    public function default_pass(){
        $this->validate();
        $username= Session::get('username');
        $user= User::where('username',$username)->first();

        if (Hash::check($this->current_password, $user->password)){
            $password = Hash::make($this->new_password);
            User::where('username', $username)->update(['password'=>$password,'default_pass'=>1]);
            $this->dispatch('Success', 'Password berhasil disimpan');
            return redirect('/dashboard');
        } else {
            $this->mount();
            $this->addError('current_password', 'Password sekarang salah');
        }
    }
    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title = 'Dashboard';

        return view('livewire.dashboard',['user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}