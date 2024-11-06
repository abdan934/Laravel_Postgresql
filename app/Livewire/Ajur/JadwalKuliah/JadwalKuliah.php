<?php

namespace App\Livewire\Ajur\JadwalKuliah;

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
use App\Models\User;

class JadwalKuliah extends Component
{
    use WithFileUploads;

    public $file_excel_jadwal,$file_pdf_jadwal,$file_excel_jadwal_edit,$file_pdf_jadwal_edit,$tahun_ajaran,$semester_jadwal,$tahun_ajaran_edit,$semester_jadwal_edit,$id_edit_hide,$message;

    public function mount()
    {
        $this->id_jadwal_hide = '';
        $this->file_excel_jadwal = '';
        $this->file_pdf_jadwal = '';
        $this->file_jadwal_excel_edit = '';
        $this->file_jadwal_pdf_edit = '';
        $this->tahun_ajaran = '';
        $this->semester_jadwal = '';
        $this->tahun_ajaran_edit = '';
        $this->semester_jadwal_edit = '';
    }

    public function Add_Jadwal_Kuliah(){
         $this->validate([
            'file_excel_jadwal' => 'required|file|mimes:xlsx,xls|max:10240',
            'file_pdf_jadwal' => 'required|file|mimes:pdf|max:10240',
            'tahun_ajaran' => 'required|numeric',
            'semester_jadwal' => 'required|numeric',
        ],[
            'file_excel_jadwal.required'=>'File tidak boleh kosong.',
            'file_excel_jadwal.mimes'=>'File berformat .xlsx|.xls',
            'file_excel_jadwal.max'=>'File makasimal berukuran 10MB',
            'file_pdf_jadwal.required'=>'File tidak boleh kosong.',
            'file_pdf_jadwal.mimes'=>'File berformat .pdf',
            'file_pdf_jadwal.max'=>'File makasimal berukuran 10MB',
            'tahun_ajaran.required'=>'Tahun Ajaran belum dipilih.',
            'tahun_ajaran.numeric'=>'Tahun Ajaran berisi angka.',
            'semester_jadwal.required'=>'Semester belum dipilih.',
            'semester_jadwal.numeric'=>'Semester tidak sesuai.',
        ]);

        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();

        if($ajur){
            $semester = ($this->semester_jadwal==1)? "Ganjil":"Genap";
            $fileNameExcel = $ajur->name_jurusan.'_'.$this->tahun_ajaran.'_'.$semester . '.' . $this->file_excel_jadwal->extension();
            $fileNamePDF = $ajur->name_jurusan.'_'.$this->tahun_ajaran.'_'.$semester . '.' . $this->file_pdf_jadwal->extension();
                
            $checkfile1 = M_JadwalKuliah::where('name_file_jadwal_excel',$fileNameExcel)->first();
            $checkfile2 = M_JadwalKuliah::where('name_file_jadwal_pdf',$fileNamePDF)->first();
            if(!$checkfile1 && !$checkfile2){
                $datacreated=[
                    'id_jurusan'=>$ajur->id_jurusan,
                    'name_file_jadwal_excel'=>$fileNameExcel,
                    'name_file_jadwal_pdf'=>$fileNamePDF,
                    'semester_file_jadwal'=>$this->semester_jadwal,
                    'tahun_file_jadwal'=>$this->tahun_ajaran,
                    'created_at'=>now(),
                ];
                Storage::disk('file_jadwal_kuliah')->putFileAs($ajur->name_jurusan.'/'.$this->tahun_ajaran, $this->file_excel_jadwal, $fileNameExcel);
                Storage::disk('file_jadwal_kuliah')->putFileAs($ajur->name_jurusan.'/'.$this->tahun_ajaran, $this->file_pdf_jadwal, $fileNamePDF);
                M_JadwalKuliah::create($datacreated);
                $this->mount();
                $this->dispatch('close-modal-form');
                $this->dispatch('Success','Berhasil menambahankan jadwal file');
            }else{
                $this->dispatch('open-modal-add-form');
                $this->addError('file_jadwal', 'File jadwal sudah ada.');
                return;
            }
        }else{
            $this->mount();
            $this->dispatch('Failed','Gagal menambahankan jadwal file');
        }
    }

    public function show_editjadwalkuliah($id)
    {
        $file_jadwal_kuliah = M_JadwalKuliah::where('tb_file_jadwal.id_file_jadwal',$id)
                                ->join('tb_jurusan', 'tb_file_jadwal.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        if ($file_jadwal_kuliah) {
            $this->id_edit_hide = $file_jadwal_kuliah->id_file_jadwal;
            $this->tahun_ajaran_edit = $file_jadwal_kuliah->tahun_file_jadwal;
            $this->semester_jadwal_edit = $file_jadwal_kuliah->semester_file_jadwal;
        }
        $this->dispatch('open-modal-edit-form',$id);
    }

    public function Edit_Jadwal_Kuliah()
    {
        $this->validate([
            'file_excel_jadwal_edit' => 'required|file|mimes:xlsx,xls|max:10240',
            'file_pdf_jadwal_edit' => 'required|file|mimes:pdf|max:10240',
            'tahun_ajaran_edit' => 'required|numeric',
            'semester_jadwal_edit' => 'required|numeric',
        ],[
            'file_excel_jadwal_edit.required'=>'File tidak boleh kosong.',
            'file_excel_jadwal_edit.mimes'=>'File berformat .xlsx|.xls',
            'file_excel_jadwal_edit.max'=>'File makasimal berukuran 10MB',
            'file_pdf_jadwal_edit.required'=>'File tidak boleh kosong.',
            'file_pdf_jadwal_edit.mimes'=>'File berformat .pdf',
            'file_pdf_jadwal_edit.max'=>'File makasimal berukuran 10MB',
            'tahun_ajaran_edit.required'=>'Tahun Ajaran belum dipilih.',
            'tahun_ajaran_edit.numeric'=>'Tahun Ajaran berisi angka.',
            'semester_jadwal_edit.required'=>'Semester belum dipilih.',
            'semester_jadwal_edit.numeric'=>'Semester tidak sesuai.',
        ]);
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        if($ajur){
            $semester = ($this->semester_jadwal_edit==1)? "Ganjil":"Genap";

            $fileNameExcel = $ajur->name_jurusan.'_'.$this->tahun_ajaran_edit.'_'.$semester . '.' . $this->file_excel_jadwal_edit->extension();
            $fileNamePDF = $ajur->name_jurusan.'_'.$this->tahun_ajaran_edit.'_'.$semester . '.' . $this->file_pdf_jadwal_edit->extension();
                
            $checkfile = M_JadwalKuliah::where('id_file_jadwal',$this->id_edit_hide)->first();
            
            if($checkfile){
                $dataupdated=[
                    'id_jurusan'=>$ajur->id_jurusan,
                    'name_file_jadwal_excel'=>$fileNameExcel,
                    'name_file_jadwal_pdf'=>$fileNamePDF,
                    'semester_file_jadwal'=>$this->semester_jadwal_edit,
                    'tahun_file_jadwal'=>$this->tahun_ajaran_edit,
                    'updated_at'=>now(),
                ];
                Storage::disk('file_jadwal_kuliah')->putFileAs($ajur->name_jurusan.'/'.$this->tahun_ajaran_edit, $this->file_excel_jadwal_edit, $fileNameExcel);
                Storage::disk('file_jadwal_kuliah')->putFileAs($ajur->name_jurusan.'/'.$this->tahun_ajaran_edit, $this->file_pdf_jadwal_edit, $fileNamePDF);
                $checkfile->update($dataupdated);
                $this->mount();
                $this->dispatch('close-modal-edit-form');
                $this->dispatch('Success', 'Telah berhasil diubah!');
            }else{
                $this->mount();
                $this->dispatch('close-modal-edit-form');
                $this->dispatch('Failed', 'Gagal melakukan perubahan!');
                return;
            }
        }else{
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
        }
    }

    public function getFile($id,$ext)
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $file_jadwal_kuliah = M_JadwalKuliah::where('tb_file_jadwal.id_file_jadwal',$id)
                                ->join('tb_jurusan', 'tb_file_jadwal.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
         if($ext == 1){
            $pathExcel = asset('jadwal_kuliah/'.$ajur->name_jurusan.'/'.$file_jadwal_kuliah->tahun_file_jadwal.'/'.$file_jadwal_kuliah->name_file_jadwal_excel);
        }elseif ($ext == 0) {
            $pathExcel = asset('jadwal_kuliah/'.$ajur->name_jurusan.'/'.$file_jadwal_kuliah->tahun_file_jadwal.'/'.$file_jadwal_kuliah->name_file_jadwal_pdf);
        }
        $this->dispatch('NewTab',$pathExcel);
        $this->mount();
    }
    
    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Jadwal Kuliah';
        $ajur= M_AdminJurusan::where('nip',$username)
                ->join('tb_jurusan', 'tb_admin_jurusan.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $file_jadwal_kuliah = M_JadwalKuliah::where('tb_file_jadwal.id_jurusan',$ajur->id_jurusan)
                                ->join('tb_jurusan', 'tb_file_jadwal.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->get();
        $data_jurusan = M_Jurusan::all();
            
        return view('livewire.ajur.jadwal-kuliah.jadwal-kuliah',['user'=>$user,'data_jurusan'=>$data_jurusan,'ajur'=>$ajur,'file_jadwal_kuliah'=>$file_jadwal_kuliah])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}