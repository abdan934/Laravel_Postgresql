<?php

namespace App\Livewire\Baak\Data;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\M_Dosen;
use App\Models\M_Mahasiswa;
use App\Models\M_AdminJurusan;
use App\Models\M_JadwalKuliah;
use App\Models\User;

class JadwalKuliahJurusan extends Component
{
    public function getFile($id,$ext)
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $file_jadwal_kuliah = M_JadwalKuliah::where('tb_file_jadwal.id_file_jadwal',$id)
                                ->join('tb_jurusan', 'tb_file_jadwal.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
         if($ext == 1){
            $pathExcel = asset('jadwal_kuliah/'.$file_jadwal_kuliah->name_jurusan.'/'.$file_jadwal_kuliah->tahun_file_jadwal.'/'.$file_jadwal_kuliah->name_file_jadwal_excel);
        }elseif ($ext == 0) {
            $pathExcel = asset('jadwal_kuliah/'.$file_jadwal_kuliah->name_jurusan.'/'.$file_jadwal_kuliah->tahun_file_jadwal.'/'.$file_jadwal_kuliah->name_file_jadwal_pdf);
        }
        $this->dispatch('NewTab',$pathExcel);
    }
    
    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Jadwal Kuliah';
        $file_jadwal_kuliah = M_JadwalKuliah::join('tb_jurusan', 'tb_file_jadwal.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->get();
        return view('livewire.baak.data.jadwal-kuliah-jurusan',['user'=>$user,'file_jadwal_kuliah'=>$file_jadwal_kuliah])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}