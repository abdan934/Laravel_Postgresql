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
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\M_AdminJurusan;
use App\Models\User;

class AdminJurusan extends Component
{
     protected $listeners = ['ubahStatus','ResetPass'];

    public $nip,$email_admin_jurusan,$name_admin_jurusan,$jenis_kelamin_admin_jurusan,$no_hp_admin_jurusan,$alamat_admin_jurusan,$jurusan,$nip_edit,$nip_edit_hide,$email_edit,$name_edit,$jenis_kelamin_edit,$no_hp_edit,$alamat_admin_jurusan_edit,$jurusan_edit,$message;

     public function mount()
    {
        $this->nip = '';
        $this->email_admin_jurusan = '';
        $this->no_hp_admin_jurusan = '';
        $this->alamat_admin_jurusan = '';
        $this->name_admin_jurusan = '';
        $this->jenis_kelamin_admin_jurusan = '';
        $this->jurusan = '';
        $this->nip_edit = '';
        $this->nip_edit_hide = '';
        $this->email_edit = '';
        $this->no_hp_edit = '';
        $this->alamat_mhs_edit = '';
        $this->name_edit = '';
        $this->jenis_kelamin_edit = '';
        $this->jurusan_edit = '';
    }

    public function rules(){
        return [
            'nip'=> ['required','numeric', 'min:10','unique:tb_admin_jurusan,nip','unique:tb_users,username'],
            'email_admin_jurusan'=> ['required','email'],
            'name_admin_jurusan'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'jenis_kelamin_admin_jurusan'=> ['required'],
            'no_hp_admin_jurusan'=> ['required','numeric','min:12'],
            'alamat_admin_jurusan'=> ['required'],
            'jurusan'=> ['required'],

        ];
    }
    public function messages()
    {
        return [
            'nip.required' => 'Nomor Induk Pegawai belum diisi.',
            'nip.min' => 'Nomor Induk Pegawai tidak sesuai.',
            'nip.numeric' => 'Nomor Induk Pegawai berisi angka.',
            'nip.unique' => 'Nomor Induk Pegawai sudah ada.',
            'email_admin_jurusan.required' => 'Email belum diisi.',
            'email_admin_jurusan.email' => 'Email tidak cocok.',
            'name_admin_jurusan.required' => 'Nama Lengkap belum diisi.',
            'name_admin_jurusan.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin_admin_jurusan.required' => 'Jenis Kelamin belum diisi.',
            'no_hp_admin_jurusan.required' => 'Nomor Handphone belum diisi.',
            'no_hp_admin_jurusan.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp_admin_jurusan.min' => 'Nomor Handphone tidak sesuai.',
            'jurusan.required' => 'Jurusan belum dipilih.',

        ];
    }

    public function Add_Ajur(){

            try {
                $this->validate();

                $datacreated=[
                    'id_admin_jurusan'=>(string) Str::uuid(),
                    'nip'=>trim($this->nip),
                    'id_jurusan'=> $this->jurusan,
                    'email_admin_jurusan'=>trim($this->email_admin_jurusan),
                    'name_admin_jurusan'=>trim($this->name_admin_jurusan),
                    'no_hp_admin_jurusan'=>trim($this->no_hp_admin_jurusan),
                    'jk_admin_jurusan'=>$this->jenis_kelamin_admin_jurusan,
                    'alamat_admin_jurusan'=>trim($this->alamat_admin_jurusan),
                    'status_admin_jurusan'=>0,
                    'created_at'=>now(),
                ];
                $datacreated_user=[
                    'id_users' => (string) Str::uuid(),
                    'id_role' => 2,
                    'username' => trim($this->nip),
                    'password' => Hash::make(trim($this->nip)),
                    'name_user' => trim($this->name_admin_jurusan),
                    'jk_user' => $this->jenis_kelamin_admin_jurusan,
                    'photo_profile' => 'default.jpg',
                    'status_user' => 0,
                    'default_pass' => 0,
                    'created_at' => now(),
                ];

                M_AdminJurusan::create($datacreated);
                User::create($datacreated_user);
                $this->dispatch('close-modal-form');
                $this->dispatch('Success', 'Berhasil ditambahkan!');
                $this->mount();
            } catch (ValidationException $e) {
                $errors = $e->validator->getMessageBag()->all();
                foreach ($errors as $error) {
                    session()->flash('pesanerror', $error);
                }
                return;
            }
    }

    public function show_modalstatus($nip)
    {
        $this->dispatch('close-modal-detail',$nip);
        $this->dispatch('open-modal-validation-status',$nip);
    }

    public function ubahStatus($id){
        $admin_jurusan = M_AdminJurusan::where('nip', $id)->first();
        if($admin_jurusan){
            $id_jurusan = M_AdminJurusan::where('nip', $admin_jurusan->nip)->pluck('nip');
            M_AdminJurusan::where('id_jurusan', '=', $admin_jurusan->id_jurusan)->update(['status_admin_jurusan' => 0]);
            User::whereIn('username', $id_jurusan)->update(['status_user' => 0]);


            M_AdminJurusan::where('nip', $id)->update(['status_admin_jurusan' => 1]);
            User::where('username', $id)->update(['status_user' => 1]);
            $this->dispatch('Success', 'Berhasil diubah!');
        }
    }

    public function show_editajur($nip)
    {
        $admin_jurusan = M_AdminJurusan::join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_admin_jurusan.nip')
                    ->where('nip', $nip)->first();
        if ($admin_jurusan) {
            $this->nip_edit_hide = $admin_jurusan->nip;
            $this->nip_edit = $admin_jurusan->nip;
            $this->name_edit = $admin_jurusan->name_admin_jurusan;
            $this->jenis_kelamin_edit = $admin_jurusan->jk_admin_jurusan;
            $this->email_edit = $admin_jurusan->email_admin_jurusan;
            $this->no_hp_edit = $admin_jurusan->no_hp_admin_jurusan;
            $this->alamat_admin_jurusan_edit = $admin_jurusan->alamat_admin_jurusan;
            $this->jurusan_edit = $admin_jurusan->id_jurusan;
            $this->dispatch('close-modal-detail',$nip);
            $this->dispatch('open-modal-edit-form',$nip);
        }
    }

    public function close_modal_edit_form()
    {
        $this->mount();
    }

    public function Edit_Ajur()
    {
        $this->validate([
            'nip_edit'=> ['required','numeric', 'min:9'],
            'nip_edit_hide'=> ['required','numeric','exists:tb_admin_jurusan,nip','exists:tb_users,username'],
            'email_edit'=> ['required','email'],
            'name_edit'=> ['required','regex:/^[a-zA-Z\s.,]+$/'],
            'jenis_kelamin_edit'=> ['required'],
            'no_hp_edit'=> ['required','numeric','min:12'],
            'alamat_admin_jurusan_edit'=> ['required'],
            'jurusan_edit'=> ['required'],
        ],[
            'nip_edit.required' => 'Nomor Induk Pegawai belum diisi.',
            'nip_edit.min' => 'Nomor Induk Pegawai tidak sesuai.',
            'nip_edit.numeric' => 'Nomor Induk Pegawai berisi angka.',
            'nip_edit.unique' => 'Nomor Induk Pegawai sudah terdaftar.',
            'nip_edit_hide.exists' => 'Nomor Induk Pegawai tidak ditemukan.',
            'email_edit.required' => 'Email belum diisi.',
            'email_edit.email' => 'Email tidak cocok.',
            'name_edit.required' => 'Nama Lengkap belum diisi.',
            'name_edit.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin_edit.required' => 'Jenis Kelamin belum diisi.',
            'alamat_admin_jurusan_edit.required' => 'Alamat belum diisi.',
            'no_hp_edit.required' => 'Nomor Handphone belum diisi.',
            'no_hp_edit.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp_edit.min' => 'Nomor Handphone tidak sesuai.',
            'jurusan_edit.required' => 'Jurusan belum diisi.',
        ]);

        $admin_jurusan = M_AdminJurusan::where('nip', $this->nip_edit_hide)->first();
        if($admin_jurusan){
            $dataupdated= [
                'name_admin_jurusan'=>trim($this->name_edit) ,
                'jk_admin_jurusan'=>$this->jenis_kelamin_edit ,
                'email_admin_jurusan'=>trim($this->email_edit) ,
                'no_hp_admin_jurusan'=>trim($this->no_hp_edit) ,
                'alamat_admin_jurusan'=>trim($this->alamat_admin_jurusan_edit) ,
                'id_jurusan'=>$this->jurusan_edit ,
            ];
            $dataupdateduser= [
                'name_user'=>trim($this->name_edit) ,
                'jk_user'=>$this->jenis_kelamin_edit ,
                'update_at'=>now() ,
            ];
            M_AdminJurusan::where('id_admin_jurusan', $admin_jurusan->id_admin_jurusan)->update($dataupdated);
            User::where('username', $this->nip_edit_hide)->first()->update($dataupdateduser);
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Success', 'Berhasil diubah!');
        }else{
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
        }

    }

    public function show_resetajur($nip)
    {
        $this->dispatch('close-modal-detail',$nip);
        $this->dispatch('open-modal-validation-reset',$nip);
    }

     public function ResetPass($id){
        $admin_jurusan = M_AdminJurusan::where('nip', $id)->first();
        if($admin_jurusan){
            $id_jurusan = M_AdminJurusan::where('nip', $admin_jurusan->nip)->pluck('nip');

            $new_pass = Str::random(8);
            User::whereIn('username', $id_jurusan)->update(['password' => Hash::make(trim($new_pass)),'default_pass'=>0]);

            $this->dispatch('open-modal-information-reset', $new_pass);
        }
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Data Admin Jurusan';
        $data_ajur = M_AdminJurusan::join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_admin_jurusan.nip')
                    ->orderBy('tb_admin_jurusan.name_admin_jurusan')
                    ->get();
        $data_jurusan = M_Jurusan::all();
        return view('livewire.baak.data.admin-jurusan',['data_ajur'=>$data_ajur,'data_jurusan'=>$data_jurusan,'user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}