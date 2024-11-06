<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends Component
{
    public $username,$password;
    public function mount()
    {
        $this->username = '';
        $this->password = '';
        $this->dispatch('Focus');
    }

    public function rules(){
        return [
            'username'=> ['required'],
            'password'=> ['required']
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.'
        ];
    }

    public function AuthUser(){
        $this->validate();
        $user= User::where('username',$this->username)->first();
            if($user && Hash::check($this->password, $user->password)&&$user->status_user==1){
                Session::put('username', $user->username);
                return redirect('/dashboard');
            }else{
                session()->flash('pesandanger','username atau password salah');
                $this->mount();
            }
    }

    public function render()
    {
        $this->mount();
        return view('livewire.auth.login')->extends('layouts.base_login');
    }

    public function logout(){
        Auth::logout();
        $username = Session::get('username');
        User::where('username', $username)->update(['last_login'=>now()]);
        Session::forget('username');
        $this->mount();
        return redirect('/login');
    }
}