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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DosenImport;
use Livewire\WithFileUploads;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use App\Models\M_Dosen;
use App\Models\User;

class Dosen extends Component
{

    use WithFileUploads;

    protected $listeners = ['ubahStatus'];

    public $file_import_dosen,$nidn,$nip,$email_dosen,$name_dosen,$jenis_kelamin_dosen,$no_hp_dosen,$alamat_dosen,$jupro,$nidn_edit,$nip_edit,$nidn_edit_hide,$email_edit,$name_edit,$jenis_kelamin_edit,$no_hp_edit,$alamat_dosen_edit,$jupro_edit,$message;


    public function mount()
        {
            $this->nidn = '';
            $this->nip = '';
            $this->email_dosen = '';
            $this->no_hp_dosen = '';
            $this->alamat_dosen = '';
            $this->name_dosen = '';
            $this->jenis_kelamin_dosen = '';
            $this->jupro = '';
            $this->nidn_edit = '';
            $this->nip_edit = '';
            $this->nidn_edit_hide = '';
            $this->email_edit = '';
            $this->no_hp_edit = '';
            $this->alamat_mhs_edit = '';
            $this->name_edit = '';
            $this->jenis_kelamin_edit = '';
            $this->jupro_edit = '';
        }

    public function rules(){
        return [
            'nidn'=> ['required','numeric', 'min:10','unique:tb_dosen,nidn','unique:tb_users,username'],
            'nip'=> ['required','numeric', 'min:10','unique:tb_dosen,nip'],
            'email_dosen'=> ['required','email'],
            'name_dosen'=> ['required','regex:/^[a-zA-Z\s.,\']+$/'],
            'jenis_kelamin_dosen'=> ['required'],
            'no_hp_dosen'=> ['required','numeric','min:12'],
            'alamat_dosen'=> ['required'],
            'jupro'=> ['required'],

        ];
    }
    public function messages()
    {
        return [
            'nidn.required' => 'Nomor Induk Dosen Nasional belum diisi.',
            'nidn.min' => 'Nomor Induk Dosen Nasional tidak sesuai.',
            'nidn.numeric' => 'Nomor Induk Dosen Nasional berisi angka.',
            'nidn.unique' => 'Nomor Induk Dosen Nasional sudah ada.',
            'nip.required' => 'Nomor Induk Pegawai belum diisi.',
            'nip.min' => 'Nomor Induk Pegawai tidak sesuai.',
            'nip.numeric' => 'Nomor Induk Pegawai berisi angka.',
            'nip.unique' => 'Nomor Induk Pegawai sudah ada.',
            'email_dosen.required' => 'Email belum diisi.',
            'email_dosen.email' => 'Email tidak cocok.',
            'name_dosen.required' => 'Nama Lengkap belum diisi.',
            'name_dosen.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin_dosen.required' => 'Jenis Kelamin belum diisi.',
            'no_hp_dosen.required' => 'Nomor Handphone belum diisi.',
            'no_hp_dosen.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp_dosen.min' => 'Nomor Handphone tidak sesuai.',
            'jupro.required' => 'Jurusan dan Prodi belum dipilih.',

        ];
    }
    public function Add_Dosen(){

            try {
                $this->validate();

                $parts = explode('---', $this->jupro);
                $id_jurusan = $parts[0];
                $id_prodi = $parts[1];

                $datacreated=[
                    'id_dosen'=>(string) Str::uuid(),
                    'nidn'=>trim($this->nidn),
                    'nip'=>trim($this->nip),
                    'id_jurusan'=> $id_jurusan,
                    'id_prodi'=> $id_prodi,
                    'email_dosen'=>trim($this->email_dosen),
                    'name_dosen'=>trim($this->name_dosen),
                    'no_hp_dosen'=>trim($this->no_hp_dosen),
                    'jk_dosen'=>$this->jenis_kelamin_dosen,
                    'alamat_dosen'=>trim($this->alamat_dosen),
                    'status_dosen'=>1,
                    'created_at'=>now(),
                ];
                $datacreated_user=[
                    'id_users' => (string) Str::uuid(),
                    'id_role' => 3,
                    'username' => trim($this->nidn),
                    'password' => Hash::make(trim($this->nidn)),
                    'name_user' => trim($this->name_dosen),
                    'jk_user' => $this->jenis_kelamin_dosen,
                    'photo_profile' => 'default.jpg',
                    'status_user' => 1,
                    'default_pass' => 0,
                    'created_at' => now(),
                ];

                M_Dosen::create($datacreated);
                User::create($datacreated_user);
                $this->dispatch('close-modal-form');
                $this->dispatch('Success', 'Berhasil ditambahkan!');
                $this->mount();
            } catch (ValidationException $e) {
                $errors = $e->validator->getMessageBag()->all();
                foreach ($errors as $error) {
                    session()->flash('pesanerror', $error);
                }
            }
    }

    public function importDosen(){
            $this->validate([
                'file_import_dosen' => 'required|file|mimes:xlsx,xls|max:10240',
            ],[
                'file_import_dosen.required'=>'File tidak boleh kosong.',
                'file_import_dosen.mimes'=>'File berformat .xlsx|.xls',
                'file_import_dosen.max'=>'File makasimal berukuran 10MB',
            ]);
                $this->dispatch('close-modal-import');
            if ($this->file_import_dosen) {
                $path = $this->file_import_dosen->getRealPath();
                $headerFromExcel = Excel::toArray(new DosenImport, $path)[0][0];
                if (!empty($headerFromExcel['nidn']) && !empty($headerFromExcel['nip']) && !empty($headerFromExcel['nama_lengkap']) && !empty($headerFromExcel['email']) && !empty($headerFromExcel['prodi']) && !empty($headerFromExcel['jurusan']) && !empty($headerFromExcel['jenis_kelamin']) && !empty($headerFromExcel['no_hp']) && !empty($headerFromExcel['alamat'])){
                    $rows = collect(Excel::toArray(new DosenImport, $path)[0]);
                    $datacreated = [];
                    $validatedData = [];

                    foreach ($rows as $key => $row) {
                        if ($key == 0) continue;

                        $validator = validator($row, [
                            'nidn' => 'required|numeric|min:9|unique:tb_dosen,nidn|unique:tb_users,username',
                            'nip' => 'required|numeric|min:9|unique:tb_dosen,nip',
                            'nama_lengkap' => 'required|regex:/^[a-zA-Z\s.,\'’]+$/',
                            'email' => 'required|email',
                            'prodi' => 'required',
                            'jurusan' => 'required',
                            'jenis_kelamin' => ['required', Rule::in(['L', 'P','l','p'])],
                            'no_hp' => 'required|numeric|min:12',
                            'alamat' => 'required',
                        ], [
                            'nidn.required' => 'Nomor Induk Dosen Nasional belum diisi.',
                            'nidn.min' => 'Nomor Induk Dosen Nasional tidak sesuai.',
                            'nidn.numeric' => 'Nomor Induk Dosen Nasional berisi angka.',
                            'nidn.unique' => 'Nomor Induk Dosen Nasional sudah ada.',
                            'nip.required' => 'Nomor Induk Pegawai belum diisi.',
                            'nip.min' => 'Nomor Induk Pegawai tidak sesuai.',
                            'nip.numeric' => 'Nomor Induk Pegawai berisi angka.',
                            'nip.unique' => 'Nomor Induk Pegawai sudah ada.',
                            'email_dosen.required' => 'Email belum diisi.',
                            'email_dosen.email' => 'Email tidak cocok.',
                            'name_prodi.required' => 'Prodi belum diisi.',
                            'name_jurusan.required' => 'Jurusan belum diisi.',
                            'nama_lengkap.required' => 'Nama Lengkap belum diisi.',
                            'nama_lengkap.regex' => 'Nama Lengkap berisi huruf.',
                            'jk_dosen.required' => 'Jenis Kelamin belum diisi.',
                            'jk_dosen.rule' => 'Jenis Kelamin tidak sesuai format.',
                            'no_hp.required' => 'Nomor Handphone belum diisi.',
                            'no_hp.numeric' => 'Nomor Handphone berisi angka.',
                            'no_hp.min' => 'Nomor Handphone tidak sesuai.',
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
                                    'id_dosen'=>(string) Str::uuid(),
                                    'nidn'=>trim($row['nidn']),
                                    'nip'=>trim($row['nip']),
                                    'id_prodi'=>$prodi->id_prodi,
                                    'id_jurusan'=>$jurusan->id_jurusan,
                                    'name_dosen'=>trim($row['nama_lengkap']),
                                    'email_dosen'=>trim($row['email']),
                                    'no_hp_dosen'=>trim($row['no_hp']),
                                    'jk_dosen'=>trim($row['jenis_kelamin']),
                                    'alamat_dosen'=>trim($row['alamat']),
                                    'status_dosen'=>1,
                                    'created_at'=>now(),
                                ];

                                $datacreated_user[]=[
                                    'id_users' => (string) Str::uuid(),
                                    'id_role' => 3,
                                    'username' => trim($row['nidn']),
                                    'password' => Hash::make(trim($row['nidn'])),
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
                            M_Dosen::insert($datacreated);
                            User::insert($datacreated_user);
                            $this->dispatch('close-Load');
                            $this->dispatch('close-modal-import');
                            $this->dispatch('Success', 'Berhasil diimport!');
                        }
                    }
                } else {
                    $this->dispatch('close-Load');
                    $this->dispatch('open-modal-import');
                    $this->addError('file_import_dosen', 'Format Header tidak sesuai.');
                }
            }
    }

    public function show_modalstatus($nidn)
    {
        $this->dispatch('close-modal-detail',$nidn);
        $this->dispatch('open-modal-validation-status',$nidn);
    }
    public function ubahStatus($id){
        $dosen = M_Dosen::where('nidn', $id)->first();
        $ubahstatus = ($dosen->status_dosen==1)?0:1;
        M_Dosen::where('nidn', $id)->update(['status_dosen' => $ubahstatus]);
        User::where('username', $id)->update(['status_user' => $ubahstatus]);
        $this->dispatch('Success', 'Telah berhasil diubah!');
    }

    public function show_editdosen($nidn)
    {
        $dosen = M_Dosen::join('tb_prodi', 'tb_dosen.id_prodi', '=', 'tb_prodi.id_prodi')
                    ->join('tb_jurusan', 'tb_prodi.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_dosen.nidn')
                    ->where('nidn', $nidn)->first();
        if ($dosen) {
            $this->nidn_edit_hide = $dosen->nidn;
            $this->nidn_edit = $dosen->nidn;
            $this->nip_edit = $dosen->nip;
            $this->name_edit = $dosen->name_dosen;
            $this->jenis_kelamin_edit = $dosen->jk_dosen;
            $this->email_edit = $dosen->email_dosen;
            $this->no_hp_edit = $dosen->no_hp_dosen;
            $this->alamat_dosen_edit = $dosen->alamat_dosen;
            $this->jupro_edit = $dosen->id_jurusan .'---'.$dosen->id_prodi;
            $this->tahun_masuk_edit = $dosen->tahun_masuk;
        }
        $this->dispatch('close-modal-detail',$nidn);
        $this->dispatch('open-modal-edit-form',$nidn);
    }
    public function Edit_Dosen()
    {
        $this->validate([
            'nidn_edit_hide'=> ['required','numeric','exists:tb_dosen,nidn','exists:tb_users,username'],
            'nip_edit'=> ['required','numeric','exists:tb_dosen,nip'],
            'email_edit'=> ['required','email'],
            'name_edit'=> ['required','regex:/^[a-zA-Z\s.,]+$/'],
            'jenis_kelamin_edit'=> ['required'],
            'no_hp_edit'=> ['required','numeric','min:12'],
            'alamat_dosen_edit'=> ['required'],
            'jupro_edit'=> ['required'],
        ],[
            'nidn_edit_hide.exists' => 'Nomor Induk Dosen Nasional tidak ditemukan.',
            'nip_edit.exists' => 'Nomor Induk Pegawai tidak ditemukan.',
            'email_edit.required' => 'Email belum diisi.',
            'email_edit.email' => 'Email tidak cocok.',
            'name_edit.required' => 'Nama Lengkap belum diisi.',
            'name_edit.regex' => 'Nama Lengkap berisi huruf.',
            'jenis_kelamin_edit.required' => 'Jenis Kelamin belum diisi.',
            'alamat_edit.required' => 'Alamat belum diisi.',
            'no_hp_edit.required' => 'Nomor Handphone belum diisi.',
            'no_hp_edit.numeric' => 'Nomor Handphone berisi angka.',
            'no_hp_edit.min' => 'Nomor Handphone tidak sesuai.',
            'jupro_edit.required' => 'Jurusan dan Prodi belum diisi.',
        ]);
        $dosen = M_Dosen::where('nidn', $this->nidn_edit_hide)->first();
        if($dosen){
            $parts = explode('---', $this->jupro_edit);
                    $id_jurusan = $parts[0];
                    $id_prodi = $parts[1];
            $dataupdated= [
                'name_dosen'=>trim($this->name_edit) ,
                'jk_dosen'=>$this->jenis_kelamin_edit ,
                'email_dosen'=>trim($this->email_edit) ,
                'no_hp_dosen'=>trim($this->no_hp_edit) ,
                'alamat_dosen'=>trim($this->alamat_dosen_edit) ,
                'id_jurusan'=>$id_jurusan ,
                'id_prodi'=>$id_prodi ,
            ];
            $dataupdateduser= [
                'name_user'=>trim($this->name_edit) ,
                'jk_user'=>$this->jenis_kelamin_edit ,
            ];
            M_Dosen::where('id_dosen', $dosen->id_dosen)->update($dataupdated);
            User::where('username', $this->nidn_edit_hide)->update($dataupdateduser);
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Success', 'Telah berhasil diubah!');
        }else{
            $this->mount();
            $this->dispatch('close-modal-edit-form');
            $this->dispatch('Failed', 'Perubahan tidak berhasil.');
        }
    }

    public function close_modal_edit_form()
    {
        $this->mount();
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Data Dosen';
        $data_dosen = M_Dosen::join('tb_prodi', 'tb_dosen.id_prodi', '=', 'tb_prodi.id_prodi')
                    ->join('tb_jurusan', 'tb_prodi.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->join('tb_users', 'tb_users.username','=','tb_dosen.nidn')
                    ->orderBy('tb_dosen.name_dosen')
                    ->get();
                    // dd($data_dosen);
        $data_jupro = M_Prodi::join('tb_jurusan', 'tb_prodi.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                    ->select('tb_prodi.*', 'tb_jurusan.name_jurusan as jurusan_name')
                    ->get();
        return view('livewire.baak.data.dosen',['data_dosen'=>$data_dosen,'data_jupro'=>$data_jupro,'user'=>$user])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }
}
