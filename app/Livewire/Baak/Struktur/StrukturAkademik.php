<?php

namespace App\Livewire\Baak\Struktur;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\M_Prodi;
use App\Models\M_Kaprodi;
use App\Models\M_Kajur;
use App\Models\M_Jurusan;
use App\Models\M_Dosen;
use App\Models\User;

class StrukturAkademik extends Component
{
    public $nama_dosen_jurusan_edit_prodi,$nidn_jurusan_edit_prodi,$nama_dosen_jurusan_edit,$nidn_jurusan_edit,$data_dosen,$data_dosen_prodi,$search_dosen,$name_prodi,$jenjang_prodi,$jurusan,$name_jurusan,$name_prodi_edit,$jenjang_prodi_edit,$jurusan_edit,$id_prodi_hide,$name_jurusan_edit,$id_jurusan_hide,$message;

    public function mount()
    {
        $this->search_dosen = '';
        $this->name_jurusan = '';
        $this->name_jurusan_edit = '';
        $this->nidn_jurusan_edit = '';
        $this->nama_dosen_jurusan_edit = '';
        $this->nidn_jurusan_edit_prodi = '';
        $this->nama_dosen_jurusan_edit_prodi = '';
        $this->jenjang_prodi = '';
        $this->name_prodi = '';
        $this->name_prodi_edit = '';
        $this->jenjang_prodi_edit = '';
        $this->jurusan = '';
        $this->jurusan_edit = '';
        $this->data_dosen = $this->UpdatedsearchDosen();
        $this->data_dosen_prodi = $this->UpdatedsearchDosen();
    }

    public function Add_Prodi()
    {
            try {
                $this->validate([
                    'name_prodi'=> ['required','regex:/^[a-zA-Z\s.,]+$/','uppercase','unique:tb_prodi,name_prodi'],
                    'jenjang_prodi'=> ['required'],
                    'jurusan'=> ['required','exists:tb_jurusan,id_jurusan'],
                ],[
                    'name_prodi.required' => 'Nama Prodi belum diisi.',
                    'name_prodi.unique' => 'Nama Prodi sudah terdaftar.',
                    'name_prodi.regex' => 'Nama Prodi berisi huruf.',
                    'name_prodi.uppercase' => 'Nama Prodi berisi huruf Kapital.',
                    'jenjang_prodi.required' => 'Jenjang belum dipilih.',
                    'jurusan.required' => 'Jurusan belum dipilih.',
                    'jurusan.exists' => 'Jurusan tidak ditemukan.',
                ]);

                $datacreated=[
                    'id_prodi'=>(string) Str::uuid(),
                    'name_prodi'=>trim($this->name_prodi),
                    'jenjang_prodi'=>trim($this->jenjang_prodi),
                    'id_jurusan'=>$this->jurusan,
                    'created_at'=>now(),
                ];

                M_Prodi::create($datacreated);
                $this->dispatch('close-modal-form-prodi');
                $this->dispatch('Success', 'Berhasil ditambahkan!');
                $this->mount();
            } catch (ValidationException $e) {
                $errors = $e->validator->getMessageBag()->all();
                foreach ($errors as $error) {
                    session()->flash('pesanerror', $error);
                }
            }
    }
    public function Add_Jurusan()
    {
            try {
                $this->validate([
                    'name_jurusan'=> ['required','regex:/^[a-zA-Z\s.,]+$/','uppercase','unique:tb_jurusan,name_jurusan']
                ],[
                    'name_jurusan.required' => 'Nama Jurusan belum diisi.',
                    'name_jurusan.unique' => 'Nama Jurusan sudah terdaftar.',
                    'name_jurusan.regex' => 'Nama Jurusan berisi huruf.',
                    'name_jurusan.uppercase' => 'Nama Jurusan berisi huruf Kapital.',
                ]);

                $datacreated=[
                    'id_jurusan'=>(string) Str::uuid(),
                    'name_jurusan'=>trim($this->name_jurusan),
                    'created_at'=>now(),
                ];

                M_Jurusan::create($datacreated);
                $this->dispatch('close-modal-form-jurusan');
                $this->dispatch('Success', 'Berhasil ditambahkan!');
                $this->mount();
            } catch (ValidationException $e) {
                $errors = $e->validator->getMessageBag()->all();
                foreach ($errors as $error) {
                    session()->flash('pesanerror', $error);
                }
            }
    }

    public function show_editprodi($id)
    {
        $prodi = M_Prodi::where('id_prodi',$id)->first();
        $kaprodi = M_Kaprodi::where('id_prodi',$id)
                                ->where('status_kaprodi',1)
                                ->first();
        if ($prodi) {
            $this->id_jurusan_hide = $prodi->id_jurusan;
            $this->id_prodi_hide = $prodi->id_prodi;
            $this->name_prodi_edit = $prodi->name_prodi;
            $this->jenjang_prodi_edit = $prodi->jenjang_prodi;
            $this->jurusan_edit = $prodi->id_jurusan;
            if($kaprodi){
                $dosen=M_Dosen::where('nidn',$kaprodi->nidn)->first();
                $this->nidn_jurusan_edit_prodi = $dosen->nidn;
                $this->nama_dosen_jurusan_edit_prodi = $dosen->name_dosen;
            }
            $this->data_dosen_prodi = $this->UpdatedsearchDosen();
        }
        $this->dispatch('close-modal-detail-prodi',$id);
        $this->dispatch('open-modal-edit-prodi',$id);
    }

    public function dosentoInputProdi($id_dosen)
    {
        $jurusan = M_Jurusan::where('id_jurusan',$this->id_jurusan_hide)->first();
        $dosen = M_Dosen::where('nidn',$id_dosen)->first();
        if ($dosen) {
            $this->nidn_jurusan_edit_prodi = $dosen->nidn;
            $this->nama_dosen_jurusan_edit_prodi = $dosen->name_dosen;
        }
    }

    public function close_modal_edit_form()
    {
        $this->mount();
    }

    public function Edit_Prodi()
    {
        $this->validate([
                    'name_prodi_edit'=> ['required','regex:/^[a-zA-Z\s.,]+$/','uppercase'],
                    'jenjang_prodi_edit'=> ['required'],
                    'jurusan_edit'=> ['required','exists:tb_jurusan,id_jurusan'],
                    'nidn_jurusan_edit_prodi'=> ['required','exists:tb_dosen,nidn'],
                ],[
                    'name_prodi_edit.required' => 'Nama Prodi belum diisi.',
                    'name_prodi_edit.unique' => 'Nama Prodi sudah terdaftar.',
                    'name_prodi_edit.regex' => 'Nama Prodi berisi huruf.',
                    'name_prodi_edit.uppercase' => 'Nama Prodi berisi huruf Kapital.',
                    'jenjang_prodi_edit.required' => 'Jenjang belum dipilih.',
                    'jurusan_edit.required' => 'Jurusan belum dipilih.',
                    'nidn_jurusan_edit_prodi.required' => 'Dosen belum dipilih.',
                    'nidn_jurusan_edit_prodi.exists' => 'Dosen tidak ditemukan.',
                ]);

        $prodi = M_Prodi::where('id_prodi', $this->id_prodi_hide)->first();
        if($prodi){
            $cekkaprodi = M_Kaprodi::where('status_kaprodi',1)
                                ->first();
            if( empty($cekkaprodi) ){
                $cek1 = M_Kaprodi::where('nidn', $this->nidn_jurusan_edit_prodi)
                                        ->where('id_prodi',$this->id_prodi_hide)
                                        ->first();
                    M_Kaprodi::where('id_prodi', $this->id_prodi_hide)->update(['status_kaprodi' => 0]);
                    if($cek1){
                        M_Kaprodi::where('id_kaprodi',$cek1->id_kaprodi)
                            ->update([
                                'status_kaprodi' => 1,
                            ]);
                    }else{
                        M_Kaprodi::create([
                            'id_kaprodi' => (string) Str::uuid(),
                            'nidn' => $this->nidn_jurusan_edit_prodi,
                            'id_prodi' => $prodi->id_prodi,
                            'status_kaprodi' => 1,
                        ]);
                    }
            }elseif($cekkaprodi->nidn != $this->nidn_jurusan_edit_prodi){

                $cekkajur = M_Kajur::where('nidn', $this->nidn_jurusan_edit_prodi)
                                ->where('status_kajur',1)
                                ->first();
                if(!$cekkajur){
                    $cek1 = M_Kaprodi::where('nidn', $this->nidn_jurusan_edit_prodi)
                                        ->where('id_prodi',$this->id_prodi_hide)
                                        ->first();
                    M_Kaprodi::where('id_prodi', $this->id_prodi_hide)->update(['status_kaprodi' => 0]);
                    if($cek1){
                        M_Kaprodi::where('id_kaprodi',$cek1->id_kaprodi)
                            ->update([
                                'status_kaprodi' => 1,
                            ]);
                    }else{
                        M_Kaprodi::create([
                            'id_kaprodi' => (string) Str::uuid(),
                            'nidn' => $this->nidn_jurusan_edit_prodi,
                            'id_prodi' => $prodi->id_prodi,
                            'status_kaprodi' => 1,
                        ]);
                    }
                }else{
                    $this->addError('nidn_jurusan_edit_prodi', 'Periksa ulang data dosen');
                    return;
                }
            }
            $dataupdated=[
                'name_prodi'=>trim($this->name_prodi_edit),
                'jenjang_prodi'=>trim($this->jenjang_prodi_edit),
                'id_jurusan'=>$this->jurusan_edit,
                'updated_at'=>now(),
            ];
            M_Prodi::where('id_prodi', $this->id_prodi_hide)->update($dataupdated);
            $this->dispatch('close-modal-edit-prodi');
            $this->dispatch('Success', 'Berhasil diubah!');
            $this->mount();
        }else{
            $this->dispatch('close-modal-edit-prodi');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
            $this->mount();
        }

    }

    public function show_editjurusan($id)
    {
        $jurusan = M_Jurusan::where('tb_jurusan.id_jurusan',$id)->first();
        $kajur= M_Kajur::where('id_jurusan',$id)
                        ->where('status_kajur',1)
                        ->first();
        if ($jurusan) {
            $this->id_jurusan_hide = $jurusan->id_jurusan;
            $this->name_jurusan_edit = $jurusan->name_jurusan;
            if($kajur){
                $dosen=M_Dosen::where('nidn',$kajur->nidn)->first();
                $this->nidn_jurusan_edit = $dosen->nidn;
                $this->nama_dosen_jurusan_edit = $dosen->name_dosen;
            }
            $this->data_dosen = $this->UpdatedsearchDosen();
        }
        $this->dispatch('close-modal-detail-jurusan',$jurusan->id_jurusan);
        $this->dispatch('open-modal-edit-jurusan',$jurusan->id_jurusan);
    }
    public function dosentoInput($id_dosen)
    {
        $jurusan = M_Jurusan::where('id_jurusan',$this->id_jurusan_hide)->first();
        $dosen = M_Dosen::where('nidn',$id_dosen)->first();
        if ($jurusan&&$dosen) {
            $this->id_jurusan_hide = $jurusan->id_jurusan;
            $this->name_jurusan_edit = $jurusan->name_jurusan;
            $this->nidn_jurusan_edit = $dosen->nidn;
            $this->nama_dosen_jurusan_edit = $dosen->name_dosen;
        }
        $this->dispatch('close-modal-detail-jurusan',$jurusan->id_jurusan);
        $this->dispatch('open-modal-edit-jurusan',$jurusan->id_jurusan);
    }

    public function Edit_Jurusan()
    {
        $this->validate([
                    'name_jurusan_edit'=> ['required','regex:/^[a-zA-Z\s.,]+$/','uppercase'],
                    'nidn_jurusan_edit'=> ['required','exists:tb_dosen,nidn'],
                ],[
                    'name_jurusan_edit.required' => 'Nama Jurusan belum diisi.',
                    'name_jurusan_edit.unique' => 'Nama Jurusan sudah terdaftar.',
                    'name_jurusan_edit.regex' => 'Nama Jurusan berisi huruf.',
                    'name_jurusan_edit.uppercase' => 'Nama Jurusan berisi huruf Kapital.',
                    'nidn_jurusan_edit.required' => 'Dosen belum dipilih.',
                    'nidn_jurusan_edit.exists' => 'Dosen tidak ditemukan.',
                ]);
        $jurusan = M_Jurusan::where('id_jurusan', $this->id_jurusan_hide)->first();
        $dosen = M_Dosen::where('nidn', $this->nidn_jurusan_edit)->first();
        if ($jurusan && $dosen) {
            $cekkajur = M_Kajur::where('status_kajur',1)
                                ->first();
            if(empty($cekkajur)){
                $cek1 = M_Kajur::where('nidn', $this->nidn_jurusan_edit)
                                    ->where('id_jurusan', $this->id_jurusan_hide)
                                    ->first();
                    M_Kajur::where('id_jurusan', $this->id_jurusan_hide)->update(['status_kajur' => 0]);
                    if ($cek1) {
                        M_Kajur::where('id_kajur',$cek1->id_kajur)
                                ->update([
                                    'status_kajur' => 1,
                                ]);
                    } else {
                        M_Kajur::create([
                            'id_kajur' => (string) Str::uuid(),
                            'nidn' => $this->nidn_jurusan_edit,
                            'id_jurusan' => $this->id_jurusan_hide,
                            'status_kajur' => 1,
                        ]);
                    }
            }elseif($cekkajur->nidn !=  $this->nidn_jurusan_edit){
                $cekkaprodi = M_Kaprodi::where('nidn', $this->nidn_jurusan_edit)
                                ->where('status_kaprodi',1)
                                ->first();
                if(!$cekkaprodi){
                    $cek1 = M_Kajur::where('nidn', $this->nidn_jurusan_edit)
                                    ->where('id_jurusan', $this->id_jurusan_hide)
                                    ->first();
                    M_Kajur::where('id_jurusan', $this->id_jurusan_hide)->update(['status_kajur' => 0]);
                    if ($cek1) {
                        M_Kajur::where('id_kajur',$cek1->id_kajur)
                                ->update([
                                    'status_kajur' => 1,
                                ]);
                    } else {
                        M_Kajur::create([
                            'id_kajur' => (string) Str::uuid(),
                            'nidn' => $this->nidn_jurusan_edit,
                            'id_jurusan' => $this->id_jurusan_hide,
                            'status_kajur' => 1,
                        ]);
                    }
                }else{
                    $this->addError('nidn_jurusan_edit', 'Periksa ulang data dosen');
                    return;
                }
            }

            $dataupdated = [
                                'name_jurusan' => trim($this->name_jurusan_edit),
                            ];
            M_Jurusan::where('id_jurusan', $this->id_jurusan_hide)->update($dataupdated);

            $this->dispatch('close-modal-edit-jurusan');
            $this->dispatch('Success', 'Berhasil diubah!');
            $this->mount();
        } else {
            $this->dispatch('close-modal-edit-jurusan');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
            $this->mount();
        }

    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Struktur Akademik';

        $hasKajurRecords = DB::table('tb_kajur')->exists();
        $hasProdiRecords = DB::table('tb_prodi')->exists();

        $data_jurusan = M_Jurusan::query();
        $data_prodi = M_Prodi::query();

        if ($hasKajurRecords) {
            $data_jurusan->leftJoin('tb_kajur', function($join) {
                                $join->on('tb_kajur.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                                    ->where('tb_kajur.status_kajur', '=', 1);
                            })
                        ->leftJoin('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kajur.nidn')
                        ->select('tb_jurusan.*', 'tb_kajur.nidn', 'tb_dosen.name_dosen');
        }
        if ($hasProdiRecords) {
            $data_prodi->leftJoin('tb_kaprodi', function($join) {
                                $join->on('tb_kaprodi.id_prodi', '=', 'tb_prodi.id_prodi')
                                    ->where('tb_kaprodi.status_kaprodi', '=', 1);
                            })
                        ->leftJoin('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kaprodi.nidn')
                        ->join('tb_jurusan', 'tb_jurusan.id_jurusan', '=', 'tb_prodi.id_jurusan')
                        ->select('tb_prodi.*', 'tb_kaprodi.nidn', 'tb_dosen.name_dosen', 'tb_jurusan.name_jurusan');
        }
        $data_jurusan = $data_jurusan->distinct()->get();
        $data_prodi = $data_prodi->distinct()->get();

        $this->data_dosen = $this->UpdatedsearchDosen();
        $this->data_dosen_prodi = $this->UpdatedsearchDosen();
        return view('livewire.baak.struktur.struktur-akademik',['data_prodi'=>$data_prodi,'data_jurusan'=>$data_jurusan,'user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }

    public function UpdatedsearchDosen()
    {
        $data_dosen = M_Dosen::where('id_jurusan',$this->id_jurusan_hide)
                                ->where(function ($query) {
                                    $query->where('name_dosen', 'like', '%' . $this->search_dosen . '%')
                                          ->orWhere('nidn', 'like', '%' . $this->search_dosen . '%');
                                })
                                ->get();
        return $data_dosen;
    }
}
