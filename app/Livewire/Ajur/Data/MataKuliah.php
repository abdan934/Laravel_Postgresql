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
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\M_Dosen;
use App\Models\M_Mahasiswa;
use App\Models\M_AdminJurusan;
use App\Models\M_JadwalKuliah;
use App\Models\M_Matkul;
use App\Models\M_Mengajar;
use App\Models\User;

class MataKuliah extends Component
{
    public $mengajar,$search,$nama_pengajar,$nidn_pengajar,$kode_matkul_pengajar,$nama_matkul_pengajar,$id_matkul,$label_kode_matkul,$label_nama_matkul_ind,$label_nama_matkul_eng,$label_jurusan,$kode_matkul,$nama_matkul_ind,$nama_matkul_eng,$nama_matkul_ind_edit,$nama_matkul_eng_edit,$id_edit_hide,$kode_matkul_edit,$message;

     protected $listeners = ['ubahStatus'];


    public function mount()
    {
        $this->id_edit_hide = '';
        $this->id_matkul = '';
        $this->kode_matkul_edit = '';
        $this->kode_matkul_pengajar = '';
        $this->nama_matkul_pengajar = '';
        $this->nama_matkul_eng_edit = '';
        $this->nama_matkul_ind_edit = '';
        $this->kode_matkul = '';
        $this->nama_matkul_ind = '';
        $this->nama_matkul_eng = '';
        $this->label_kode_matkul = '';
        $this->label_nama_matkul_ind = '';
        $this->label_nama_matkul_eng = '';
        $this->label_jurusan = '';
        $this->nama_pengajar = '';
        $this->nidn_pengajar = '';
    }

    public function Add_Mata_Kuliah(){
         $this->validate([
            'kode_matkul' => 'required',
            'nama_matkul_ind' => 'required|regex:/^[a-zA-Z\s.,\']+$/',
            'nama_matkul_eng' => 'required|regex:/^[a-zA-Z\s.,\']+$/',
        ],[
            'kode_matkul.required' => 'Kode Mata Kuliah belum diisi.',
            'nama_matkul_ind.required' => 'Nama Lengkap belum diisi.',
            'nama_matkul_ind.regex' => 'Nama Lengkap berisi huruf.',
            'nama_matkul_eng.required' => 'Nama Lengkap belum diisi.',
            'nama_matkul_eng.regex' => 'Nama Lengkap berisi huruf.',
        ]);

        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();

        if($ajur){
            $check1 = M_Matkul::where('nama_matkul_ind',$this->nama_matkul_ind)->first();
            $check2 = M_Matkul::where('nama_matkul_eng',$this->nama_matkul_eng)->first();
            if(!$check1 && !$check2){
                $datacreated=[
                    'id_matkul'=>(string) Str::uuid(),
                    'kode_matkul'=>$this->kode_matkul,
                    'id_jurusan'=>$ajur->id_jurusan,
                    'nama_matkul_ind'=>$this->nama_matkul_ind,
                    'nama_matkul_eng'=>$this->nama_matkul_eng,
                    'created_at'=>now(),
                ];
                M_Matkul::create($datacreated);
                $this->mount();
                $this->dispatch('close-modal-form');
                $this->dispatch('Success','Berhasil ditambahkan');
            }else{
                $this->dispatch('open-modal-add-form');
                $this->addError('nama_matkul_ind', 'Nama Matkul sudah ada.');
                $this->addError('nama_matkul_eng', 'Nama Matkul sudah ada.');
                return;
            }
        }else{
            $this->mount();
            $this->dispatch('Failed','Gagal menambahkan Mata Kuliah');
        }
    }

    public function Add_Mengajar(){
         $this->validate([
            'kode_matkul_pengajar' => 'required|exists:tb_matkul,kode_matkul',
            'nidn_pengajar' => 'required|exists:tb_dosen,nidn',
        ],[
            'kode_matkul_pengajar.required' => 'Kode Mata Kuliah belum diisi.',
            'kode_matkul_pengajar.exists' => 'Kode Mata Kuliah tidak ditemukan.',
            'nidn_pengajar.required' => 'NIDN belum dipilih.',
            'nidn_pengajar.exists' => 'NIDN tidak ditemukan.',
        ]);
        $check = M_Mengajar::where('kode_matkul',$this->kode_matkul_pengajar)
                            ->where('nidn',$this->nidn_pengajar)
                            ->first();
        if(!$check){
            $datacreated=[
                    'id_mengajar'=>(string) Str::uuid(),
                    'kode_mengajar'=>$this->generateKodeMengajar(),
                    'kode_matkul'=>$this->kode_matkul_pengajar,
                    'nidn'=>$this->nidn_pengajar,
                    'status_mengajar'=>1,
                ];
                M_Mengajar::create($datacreated);
                $this->mount();
                $this->dispatch('close-modal-form-pengajar');
                $this->dispatch('Success','Berhasil ditambahkan');
        }else{
            $this->dispatch('open-modal-add-pengajar');
            $this->addError('nidn_pengajar', 'NIDN sudah ada.');
            $this->addError('nama_pengajar', 'Nama Dosen sudah ada.');
            return;
        }
    }

    function generateKodeMengajar()
    {
        $lastmengajar = M_Mengajar::latest()->first();

        if (!$lastmengajar) {
            return $this->kode_mengajar ='KM-0001';
        }
        $lastNumber = intval(substr($lastmengajar->kode_mengajar, 3));

        if ($lastNumber >= 9999) {
            $this-dispatch('Failed','Kode Mengajar sudah mencapai batas');
            return ;
            }

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $this->kode_mengajar = 'KM-' . $newNumber;
    }
    public function generateKodeMatkul()
    {
        $lastMatkul = M_Matkul::latest()->first();

        if (!$lastMatkul) {
            return $this->kode_matkul ='KMT-0001';
        }
        $lastNumber = intval(substr($lastMatkul->kode_matkul, 4));

        if ($lastNumber >= 9999) {
            $this-dispatch('Failed','Kode Mata Kuliah sudah mencapai batas');
            return ;
            }

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $this->kode_matkul = 'KMT-' . $newNumber;
    }

     public function show_detailmatkul($id)
    {
        $matkul = M_Matkul::join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->where('id_matkul', $id)->first();
        $this->mengajar = M_Mengajar::where('tb_mengajar.kode_matkul', $matkul->kode_matkul)
                        ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                        ->join('tb_dosen', 'tb_mengajar.nidn','=','tb_dosen.nidn')
                        ->orderBy('tb_mengajar.kode_mengajar','asc')
                        ->get();
        if ($matkul) {
            $this->id_matkul = $matkul->id_matkul;
            $this->label_kode_matkul = $matkul->kode_matkul;
            $this->label_nama_matkul_ind = $matkul->nama_matkul_ind;
            $this->label_nama_matkul_eng = $matkul->nama_matkul_eng;
            $this->label_jurusan = $matkul->name_jurusan;
            $this->dispatch('open-modal-detail');
        }
    }

    public function close_modal_detail()
    {
        $this->mount();
    }

    public function modalAddMengajar($id)
    {
        $this->kode_matkul_pengajar = $id;
        $this->dispatch('close-modal-detail');
        $this->dispatch('open-modal-add-pengajar');
    }

    public function NidntoInput($nidn)
    {
        $data_dosen = M_Dosen::where('tb_dosen.nidn',$nidn)
                                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        if ($data_dosen) {
            $this->nidn_pengajar = $data_dosen->nidn;
            $this->nama_pengajar = $data_dosen->name_dosen;
        }
    }

     public function show_editmatkul($id)
    {
        $matkul = M_Matkul::join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->where('id_matkul', $id)->first();
        if ($matkul) {
            $this->id_edit_hide = $matkul->id_matkul;
            $this->kode_matkul_edit = $matkul->kode_matkul;
            $this->nama_matkul_ind_edit = $matkul->nama_matkul_ind;
            $this->nama_matkul_eng_edit = $matkul->nama_matkul_eng;
            $this->dispatch('close-modal-detail');
            $this->dispatch('open-modal-edit-form');
        }
    }

    public function close_modal_edit_form()
    {
        $this->mount();
    }

    public function Edit_Matkul()
    {
        $this->validate([
            'id_edit_hide'=> ['required','exists:tb_matkul,id_matkul'],
            'nama_matkul_ind_edit'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'nama_matkul_eng_edit'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
        ],[
            'id_edit_hide.exists' => 'Mata Kuliah tidak ditemukan.',
            'id_edit_hide.required' => 'Mata Kuliah belum diisi.',
            'nama_matkul_ind_edit_edit.required' => 'Nama Matkul belum diisi.',
            'nama_matkul_ind_edit_edit.regex' => 'Nama Matkul berisi huruf.',
            'nama_matkul_eng_edit_edit.required' => 'Nama Matkul belum diisi.',
            'nama_matkul_eng_edit_edit.regex' => 'Nama Matkul berisi huruf.',
        ]);

        $matkul = M_Matkul::where('id_matkul', $this->id_edit_hide);
        if($matkul){
            $dataupdated= [
                'nama_matkul_ind'=>trim($this->nama_matkul_ind_edit) ,
                'nama_matkul_eng'=>trim($this->nama_matkul_eng_edit) ,
            ];
            $matkul->update($dataupdated);
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Success', 'Berhasil diubah!');
        }else{
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
        }

    }

     public function show_modalstatus($id)
    {
        $this->dispatch('close-modal-detail');
        $this->dispatch('open-modal-validation-status',$id);
    }

    public function ubahStatus($id)
    {
        $ajar = M_Mengajar::where('kode_mengajar', $id)->first();
        if($ajar){
            $status = ($ajar->status_mengajar == 1)? 0:1;
            M_Mengajar::where('kode_mengajar', $id)->update(['status_mengajar' => $status]);
            $this->mount();
            $this->dispatch('Success', 'Berhasil diubah!');
        }else{
            $this->dispatch('Failed', 'Gagal diubah!');
            $this->dispatch('open-modal-detail');

        }
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Mata Kuliah';
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $mata_kuliah = M_Matkul::where('tb_matkul.id_jurusan',$ajur->id_jurusan)
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->get();
        $data_dosen = $this->Updatedsearch();

        return view('livewire.ajur.data.mata-kuliah',['user'=>$user,'ajur'=>$ajur,'mata_kuliah'=>$mata_kuliah,'data_dosen'=>$data_dosen])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }


    public function Updatedsearch()
    {
        $username= Session::get('username');
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $data_dosen = M_Dosen::where('tb_dosen.id_jurusan',$ajur->id_jurusan)
                                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->where(function ($query) {
                                    $query->where('name_dosen', 'like', '%' . $this->search . '%')
                                          ->orWhere('nidn', 'like', '%' . $this->search . '%');
                                })
                                ->get();
        return $data_dosen;
    }

}