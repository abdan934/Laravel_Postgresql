<?php

namespace App\Livewire\Baak\Data;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use Livewire\WithFileUploads;
use App\Models\M_Mahasiswa;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\User;

class Mahasiswa extends Component
{
    use WithFileUploads;

    protected $listeners = ['ubahStatus'];

    public $file_import_mhs,$npm,$email,$name,$tempat_lahir,$tanggal_lahir,$tempat_lahir_edit,$tanggal_lahir_edit,$jenis_kelamin,$no_hp,$alamat_mhs,$jupro,$tahun_masuk,$npm_edit,$npm_edit_hide,$email_edit,$name_edit,$jenis_kelamin_edit,$no_hp_edit,$alamat_mhs_edit,$jupro_edit,$tahun_masuk_edit,$message;
    public function mount()
        {
            $this->npm = '';
            $this->email = '';
            $this->no_hp = '';
            $this->alamat_mhs = '';
            $this->tempat_lahir = '';
            $this->tanggal_lahir = '';
            $this->tempat_lahir_edit = '';
            $this->tanggal_lahir_edit = '';
            $this->name = '';
            $this->jenis_kelamin = '';
            $this->jupro = '';
            $this->tahun_masuk = '';
            $this->npm_edit = '';
            $this->npm_edit_hide = '';
            $this->email_edit = '';
            $this->no_hp_edit = '';
            $this->alamat_mhs_edit = '';
            $this->name_edit = '';
            $this->jenis_kelamin_edit = '';
            $this->jupro_edit = '';
            $this->tahun_masuk_edit = '';
        }

    public function rules(){
        return [
            'npm'=> ['required','numeric', 'min:9','unique:tb_mahasiswa,npm','unique:tb_users,username'],
            'email'=> ['required','email'],
            'name'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'jenis_kelamin'=> ['required'],
            'no_hp'=> ['required','numeric','min:12'],
            'alamat_mhs'=> ['required'],
            'tempat_lahir'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'tanggal_lahir'=> ['required'],
            'tahun_masuk'=> ['required','numeric'],
            'jupro'=> ['required'],

        ];
    }
    public function messages()
    {
        return [
            'npm.required' => 'Nomor Pokok Mahasiswa belum diisi.',
            'npm.min' => 'Nomor Pokok Mahasiswa tidak sesuai.',
            'npm.numeric' => 'Nomor Pokok Mahasiswa berisi angka.',
            'npm.unique' => 'Nomor Pokok Mahasiswa sudah ada.',
            'email.required' => 'Email belum diisi.',
            'email.email' => 'Email tidak cocok.',
            'name.required' => 'Nama Lengkap belum diisi.',
            'name.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin.required' => 'Jenis Kelamin belum diisi.',
            'no_hp.required' => 'Nomor Handphone belum diisi.',
            'no_hp.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp.min' => 'Nomor Handphone tidak sesuai.',
            'jupro.required' => 'Jurusan dan Prodi belum dipilih.',
            'tempat_lahir.required' => 'Tempat Lahir belum diisi.',
            'tempat_lahir.regex' => 'Tempat Lahir berisi huruf.',
            'tanggal_lahir.required' => 'Tempat Lahir belum diisi.',
            'tahun_masuk.required' => 'Tahun Masuk belum diisi.',
            'tahun_masuk.numeric' => 'Tahun Masuk berisi angka.',
        ];
    }

    public function Add_Mhs(){

            try {
                $this->validate();

                $parts = explode('---', $this->jupro);
                $id_jurusan = $parts[0];
                $id_prodi = $parts[1];
                $datacreated=[
                    'id_mhs'=> (string) Str::uuid(),
                    'npm'=>$this->npm,
                    'id_jurusan'=> $id_jurusan,
                    'id_prodi'=> $id_prodi,
                    'email_mhs'=>$this->email,
                    'name_mhs'=>$this->name,
                    'no_hp'=>$this->no_hp,
                    'jk_mhs'=>$this->jenis_kelamin,
                    'tempat_tgl_lahir_mhs'=>($this->tempat_lahir.', '.$this->tanggal_lahir),
                    'alamat_mhs'=>$this->alamat_mhs,
                    'status_mhs'=>1,
                    'tahun_masuk'=>$this->tahun_masuk,
                    'created_at'=>now(),
                ];
                $datacreated_user=[
                    'id_users' => (string) Str::uuid(),
                    'id_role' => 4,
                    'username' => $this->npm,
                    'password' => Hash::make($this->npm),
                    'name_user' => $this->name,
                    'jk_user' => $this->jenis_kelamin,
                    'photo_profile' => 'default.jpg',
                    'status_user' => 1,
                    'default_pass' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                M_Mahasiswa::create($datacreated);
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

    public function show_modalstatus($npm)
    {
        $this->dispatch('close-modal-detail',$npm);
        $this->dispatch('open-modal-validation-status',$npm);
    }
    public function close_modal_edit_form()
    {
        $this->mount();
    }
    public function show_editmhs($npm)
    {
        $mahasiswa = M_Mahasiswa::join('tb_prodi', 'tb_mahasiswa.id_prodi', '=', 'tb_prodi.id_prodi')
                    ->join('tb_jurusan', 'tb_prodi.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_mahasiswa.npm')
                    ->where('npm', $npm)->first();
        if ($mahasiswa) {
            $this->npm_edit_hide = $mahasiswa->npm;
            $this->npm_edit = $mahasiswa->npm;
            $this->name_edit = $mahasiswa->name_mhs;
            $this->jenis_kelamin_edit = $mahasiswa->jk_mhs;
            $this->email_edit = $mahasiswa->email_mhs;
            $this->no_hp_edit = $mahasiswa->no_hp;
            $this->alamat_mhs_edit = $mahasiswa->alamat_mhs;
            $this->jupro_edit = $mahasiswa->id_jurusan .' --- '.$mahasiswa->id_prodi;
            $this->tahun_masuk_edit = $mahasiswa->tahun_masuk;
            $parts = explode(', ', $mahasiswa->tempat_tgl_lahir_mhs);

            $this->tempat_lahir_edit = $parts[0];
            $this->tanggal_lahir_edit = date('Y-m-d', strtotime($parts[1]));

        }
        $this->dispatch('close-modal-detail',$npm);
        $this->dispatch('open-modal-edit-form',$npm);
    }
    public function Edit_mhs()
    {
        $this->validate([
            'npm_edit_hide'=> ['required','numeric','exists:tb_mahasiswa,npm','exists:tb_users,username'],
            'email_edit'=> ['required','email'],
            'name_edit'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'jenis_kelamin_edit'=> ['required'],
            'no_hp_edit'=> ['required','numeric','min:12'],
            'alamat_mhs_edit'=> ['required'],
            'tempat_lahir_edit'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'tanggal_lahir_edit'=> ['required'],
            'tahun_masuk_edit'=> ['required','numeric'],
            'jupro_edit'=> ['required'],
        ],[
            'npm_edit_hide.exists' => 'Nomor Pokok Mahasiswa tidak ditemukan.',
            'email_edit.required' => 'Email belum diisi.',
            'email_edit.email' => 'Email tidak cocok.',
            'name_edit.required' => 'Nama Lengkap belum diisi.',
            'name_edit.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin_edit.required' => 'Jenis Kelamin belum diisi.',
            'no_hp_edit.required' => 'Nomor Handphone belum diisi.',
            'no_hp_edit.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp_edit.min' => 'Nomor Handphone tidak sesuai.',
            'alamat_mhs_edit.required' => 'Alamat belum diisi.',
            'tempat_lahir_edit.required' => 'Tempat Lahir belum diisi.',
            'tempat_lahir_edit.regex' => 'Tempat Lahir berisi huruf.',
            'tanggal_lahir_edit.required' => 'Tanggal Lahir belum diisi.',
            'jupro_edit.required' => 'Nomor Handphone belum diisi.',
            'tahun_masuk_edit.required' => 'Tahun Masuk belum diisi.',
            'tahun_masuk_edit.numeric' => 'Tahun Masuk berisi angka.',
        ]);
        $mahasiswa = M_Mahasiswa::where('npm', $this->npm_edit_hide)->first();
        if($mahasiswa){
            $parts = explode(' --- ', $this->jupro_edit);
                    $id_jurusan = $parts[0];
                    $id_prodi = $parts[1];
            $dataupdated= [
                'name_mhs'=>$this->name_edit ,
                'jk_mhs'=>$this->jenis_kelamin_edit ,
                'email_mhs'=>$this->email_edit ,
                'no_hp'=>$this->no_hp_edit ,
                'alamat_mhs'=>$this->alamat_mhs_edit ,
                'tempat_tgl_lahir_mhs'=>($this->tempat_lahir_edit.', '.$this->tanggal_lahir_edit) ,
                'id_jurusan'=>$id_jurusan ,
                'id_prodi'=>$id_prodi ,
                'tahun_masuk'=>$this->tahun_masuk_edit ,
                'update_at'=>now() ,
            ];
            $dataudpateduser= [
                'name_user'=>$this->name_edit ,
                'jk_user'=>$this->jenis_kelamin_edit ,
                'update_at'=>now() ,
            ];
            $mahasiswa->update($dataupdated);
            User::where('username', $this->npm_edit_hide)->first()->update($dataudpateduser);
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Success', 'Telah berhasil diubah!');
        }else{
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
        }
    }

    public function ubahStatus($id){
        $mhs = M_Mahasiswa::where('npm', $id)->first();
        $ubahstatus = ($mhs->status_mhs==1)?0:1;
        M_Mahasiswa::where('npm', $id)->update(['status_mhs' => $ubahstatus]);
        User::where('username', $id)->update(['status_user' => $ubahstatus]);
        $this->dispatch('Success', 'Telah berhasil diubah!');
    }

    public function importMhs(){
        $this->validate([
            'file_import_mhs' => 'required|file|mimes:xlsx,xls|max:10240',
        ],[
            'file_import_mhs.required'=>'File tidak boleh kosong.',
            'file_import_mhs.mimes'=>'File berformat .xlsx|.xls',
            'file_import_mhs.max'=>'File makasimal berukuran 10MB',
        ]);

        if ($this->file_import_mhs) {
            $path = $this->file_import_mhs->getRealPath();
            $headerFromExcel = Excel::toArray(new MahasiswaImport, $path)[0][0];
            if (!empty($headerFromExcel['npm']) && !empty($headerFromExcel['nama_lengkap']) && !empty($headerFromExcel['email']) && !empty($headerFromExcel['prodi']) && !empty($headerFromExcel['jurusan']) && !empty($headerFromExcel['jenis_kelamin']) && !empty($headerFromExcel['no_hp']) && !empty($headerFromExcel['alamat'])&& !empty($headerFromExcel['tempat_tgl_lahir']) && !empty($headerFromExcel['tahun_masuk'])){
                $rows = collect(Excel::toArray(new MahasiswaImport, $path)[0]);
                $datacreated = [];
                $validatedData = [];

                foreach ($rows as $key => $row) {
                    if ($key == 0) continue;

                    $validator = validator($row, [
                        'npm' => 'required|numeric|min:9|unique:tb_mahasiswa,npm',
                        'nama_lengkap' => 'required|regex:/^[a-zA-Z\s.,\'’]+$/',
                        'email' => 'required|email',
                        'prodi' => 'required',
                        'jurusan' => 'required',
                        'jenis_kelamin' => ['required', Rule::in(['L', 'P','l','p'])],
                        'tempat_tgl_lahir' => 'required',
                        'no_hp' => 'required|numeric|min:12',
                        'alamat' => 'required',
                        'tahun_masuk' => 'required|date_format:Y',
                    ], [
                        'npm.required' => 'Nomor Pokok Mahasiswa belum diisi.',
                        'npm.min' => 'Nomor Pokok Mahasiswa tidak sesuai.',
                        'npm.numeric' => 'Nomor Pokok Mahasiswa berisi angka.',
                        'npm.unique' => 'Nomor Pokok Mahasiswa sudah ada.',
                        'email_mhs.required' => 'Email belum diisi.',
                        'email_mhs.email' => 'Email tidak cocok.',
                        'name_prodi.required' => 'Prodi belum diisi.',
                        'name_jurusan.required' => 'Jurusan belum diisi.',
                        'nama_lengkap.required' => 'Nama Lengkap belum diisi.',
                        'nama_lengkap.regex' => 'Nama Lengkap berisi huruf.',
                        'jk_mhs.required' => 'Jenis Kelamin belum diisi.',
                        'jk_mhs.rule' => 'Jenis Kelamin tidak sesuai format.',
                        'tempat_tgl_lahir.required' => 'Tempat Tanggal Lahir belum diisi.',
                        'no_hp.required' => 'Nomor Handphone belum diisi.',
                        'no_hp.numeric' => 'Nomor Handphone berisi angka.',
                        'no_hp.min' => 'Nomor Handphone tidak sesuai.',
                        'tahun_masuk.required' => 'Tahun Masuk belum diisi.',
                        'tahun_masuk.date_format' => 'Tahun Masuk tidak sesuai format.',
                    ]);
                    if ($validator->fails()) {
                        $this->dispatch('close-Load');
                        $errors = $validator->errors()->all();
                        $this->dispatch('Failed', $errors);
                    } else {
                        $validatedData[] = $row;
                        $jurusan = M_Jurusan::where('name_jurusan', 'like', '%' . $row['jurusan'] . '%')->first();
                        $prodi = M_Prodi::where('name_prodi', 'like', '%' . $row['prodi'] . '%')->first();
                        if(!is_null($prodi)&& !is_null($jurusan)){
                            $cekjupro = M_Prodi::where('id_prodi', $prodi->id_prodi)
                                        ->where('id_jurusan', $jurusan->id_jurusan)
                                        ->first();

                            $datacreated[]=[
                                'id_mhs'=>(string) Str::uuid(),
                                'npm'=>trim($row['npm']),
                                'id_prodi'=>$prodi->id_prodi,
                                'id_jurusan'=>$jurusan->id_jurusan,
                                'name_mhs'=>trim($row['nama_lengkap']),
                                'email_mhs'=>trim($row['email']),
                                'no_hp'=>trim($row['no_hp']),
                                'jk_mhs'=>trim($row['jenis_kelamin']),
                                'tempat_tgl_lahir_mhs'=>trim($row['tempat_tgl_lahir']),
                                'alamat_mhs'=>trim($row['alamat']),
                                'status_mhs'=>1,
                                'tahun_masuk'=>trim($row['tahun_masuk']),
                                'created_at'=>now(),
                            ];

                            $datacreated_user[]=[
                                'id_users' => (string) Str::uuid(),
                                'id_role' => 4,
                                'username' => trim($row['npm']),
                                'password' => Hash::make(trim($row['npm'])),
                                'name_user' => trim($row['nama_lengkap']),
                                'jk_user' => trim($row['jenis_kelamin']),
                                'photo_profile' => 'default.jpg',
                                'status_user' => 1,
                                'default_pass' => 0,
                                'created_at' => now(),
                            ];
                        }else{
                            $this->dispatch('close-Load');
                            $this->dispatch('close-modal-import');
                            $this->dispatch('Failed', 'Baris ke-'.($row['nama_lengkap']).' Jurusan atau Prodi tidak ditemukan.');
                            return;
                        }

                    }
                }

                if (!$validator->fails()) {
                    if($datacreated&&$datacreated_user){
                        M_Mahasiswa::insert($datacreated);
                        User::insert($datacreated_user);
                        $this->dispatch('close-Load');
                        $this->dispatch('close-modal-import');
                        $this->dispatch('Success', 'Berhasil diimport!');
                        $this->dispatch('refresh-table');
                    }
                }
            } else {
                $this->dispatch('close-Load');
                $this->dispatch('open-modal-import');
                $this->addError('file_import_mhs', 'Format Header tidak sesuai.');
            }
        }
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Data Mahasiswa';
        $data_mhs = M_Mahasiswa::join('tb_prodi', 'tb_mahasiswa.id_prodi', '=', 'tb_prodi.id_prodi')
                    ->join('tb_jurusan', 'tb_prodi.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_mahasiswa.npm')
                    ->orderBy('tb_mahasiswa.name_mhs')
                    ->get();
        $data_jupro = M_Prodi::join('tb_jurusan', 'tb_prodi.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                    ->select('tb_prodi.*', 'tb_jurusan.name_jurusan as jurusan_name')
                    ->get();
        return view('livewire.baak.data.mahasiswa',['data_mhs'=>$data_mhs,'data_jupro'=>$data_jupro,'user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }

}