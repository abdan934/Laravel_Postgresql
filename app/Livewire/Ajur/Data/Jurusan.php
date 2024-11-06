<?php

namespace App\Livewire\Ajur\Data;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\M_Dosen;
use App\Models\M_Mahasiswa;
use App\Models\M_AdminJurusan;
use App\Models\User;

class Jurusan extends Component
{
     protected $listeners = ['ResetPassMahasiswa','ResetPassDosen'];

    public function show_resetdosen($nidn)
    {
        $this->dispatch('close-modal-detail-dosen',$nidn);
        $this->dispatch('open-modal-validation-reset-dosen',$nidn);
    }
    
    public function show_resetmahasiswa($npm)
    {
        $this->dispatch('close-modal-detail-mahasiswa',$npm);
        $this->dispatch('open-modal-validation-reset-mahasiswa',$npm);
    }

    public function ResetPassDosen($id){
        $dosen = M_Dosen::where('nidn', $id)->first();
        if($dosen){
            $new_pass = Str::random(8);
            $new_pass = trim($new_pass);
            User::where('username', $dosen->nidn)->update(['password' => Hash::make($new_pass),'default_pass'=>0]);
            $this->dispatch('open-modal-information-reset', $new_pass);
        }
    }
    
    public function ResetPassMahasiswa($id){
        $mahasiswa = M_Mahasiswa::where('npm', $id)->first();
        if($mahasiswa){
            $new_pass = Str::random(8);
            $new_pass = trim($new_pass);
            User::where('username', $mahasiswa->npm)->update(['password' => Hash::make($new_pass),'default_pass'=>0]);
            $this->dispatch('open-modal-information-reset', $new_pass);
        }
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $title='Data Jurusan';
        $data_dosen = M_Dosen::join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_prodi', 'tb_prodi.id_prodi','=','tb_dosen.id_prodi')
                    ->join('tb_users', 'tb_users.username','=','tb_dosen.nidn')
                    ->where('tb_dosen.id_jurusan',$ajur->id_jurusan)
                    ->orderBy('tb_dosen.name_dosen')
                    ->get();
        $data_mahasiswa = M_Mahasiswa::join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_prodi', 'tb_prodi.id_prodi','=','tb_mahasiswa.id_prodi')
                    ->join('tb_users', 'tb_users.username','=','tb_mahasiswa.npm')
                    ->where('tb_mahasiswa.id_jurusan',$ajur->id_jurusan)
                    ->orderBy('tb_mahasiswa.name_mhs')
                    ->get();
        return view('livewire.ajur.data.jurusan',['data_dosen'=>$data_dosen,'ajur'=>$ajur,'data_mahasiswa'=>$data_mahasiswa,'user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}