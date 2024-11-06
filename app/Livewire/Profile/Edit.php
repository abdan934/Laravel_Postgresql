<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Livewire\WithFileUploads;
use App\Models\User;

class Edit extends Component
{
     use WithFileUploads;

    public $password_lama,$password,$password_confirmation,$profile_photo;
    public function mount()
        {
            $this->profile_photo = '';
            $this->password_lama = '';
            $this->password = '';
            $this->password_confirmation = '';
        }

    public function rules(){
        return [
            'profile_photo'=> ['image','mimes:jpeg,png,jpg','max:2048'],
            'password'=> ['confirmed','min:8'],
        ];
    }
    public function messages()
    {
        return [
            'password.confirmed' => 'Password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'profile_photo.image' => 'Foto tidak cocok.',
            'profile_photo.mimes' => 'Foto harus menggunakan format JPEG|PNG|JPG.',
            'profile_photo.max' => 'Foto Maksimal berukuran 2048kb.',
        ];
    }
    public function Update_Profile(){
        $this->validate();
        $username= Session::get('username');
        $user= User::where('username',$username)->first();

        if (!empty($this->profile_photo) || !empty($this->password) || !empty($this->password_lama)) {
            if (!empty($this->profile_photo)) {
                $imageName = $username . '.' . $this->profile_photo->extension();
                Storage::disk('photo')->putFileAs('pp', $this->profile_photo, $imageName);
                User::where('username', $username)->update(['photo_profile' => $imageName]);
                $this->dispatch('Success','Perubahan berhasil disimpan');
                $this->mount();
            }
            
            $pass_user = $user->password;
            if (!empty($this->password) && !empty($this->password_lama)) {
                if (Hash::check($this->password_lama, $pass_user)){
                    $password = Hash::make($this->password);
                    User::where('username', $username)->update(['password'=>$password]);
                    $this->dispatch('Success','Perubahan berhasil disimpan');
                    $this->mount();
                } else {
                    session()->flash('gagal','Password lama salah');
                    $this->mount();
                }
            }
        } elseif(empty($this->profile_photo) && empty($this->password) && empty($this->password_lama)){
            $this->dispatch('Failed','Perubahan gagal dilakukan');
            $this->mount();
        }else {
            $this->dispatch('Failed','Perubahan gagal dilakukan');
            $this->mount();
        }
        
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Profile';
        return view('livewire.profile.edit',['user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}