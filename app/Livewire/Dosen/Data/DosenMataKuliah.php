<?php

namespace App\Livewire\Dosen\Data;

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
use App\Models\M_Nilai;
use App\Models\M_Detail_Nilai;
use App\Models\M_Keterangan;
use App\Models\User;

class DosenMataKuliah extends Component
{
    public $data_nilai_mhs,
    $id_nilai,
    $hitung,
    $form,
    $search,
    $searchEdit,
    $kmEdit,
    $npmEdit,
    $nilai,
    $prosentase_lain_nilai,
    $lain_nilai,
    $prosentase_uts_nilai,
    $uts_nilai,
    $prosentase_uas_nilai,
    $uas_nilai,
    $predikat_nilai,
    $nilai_utuh,
    $alpha_nilai,
    $sakit_nilai,
    $izin_nilai,
    $sks_nilai,
    $catatan_nilai,
    $semester_nilai,
    $ta_awal_nilai,
    $ta_akhir_nilai,
    $npm_nilai,
    $kelas_nilai,
    $kelas_nilai_edit,
    $nama_mhs_nilai,
    $km_nilai,
    $nama_matkul_nilai,
    $prosentase_lain_nilai_edit,
    $lain_nilai_edit,
    $prosentase_uts_nilai_edit,
    $uts_nilai_edit,
    $prosentase_uas_nilai_edit,
    $uas_nilai_edit,
    $predikat_nilai_edit,
    $nilai_utuh_edit,
    $nilai_edit,
    $alpha_nilai_edit,
    $sakit_nilai_edit,
    $izin_nilai_edit,
    $sks_nilai_edit,
    $catatan_nilai_edit,
    $semester_nilai_edit,
    $ta_awal_nilai_edit,
    $ta_akhir_nilai_edit,
    $npm_nilai_edit,
    $nama_mhs_nilai_edit,
    $km_nilai_edit,
    $nama_matkul_nilai_edit;

    public function mount()
    {
        $this->id_nilai = '';
        $this->form = 0;
        $this->hitung = 0;
        $this->nama_matkul_nilai = '';
        $this->nama_mhs_nilai = '';
        $this->km_nilai = '';
        $this->npm_nilai = '';
        $this->kelas_nilai = '';
        $this->kelas_nilai_edit = '';
        $this->ta_awal_nilai = '';
        $this->ta_akhir_nilai = '';
        $this->semester_nilai = '';
        $this->sks_nilai = 0;
        $this->catatan_nilai = '';
        $this->izin_nilai = 0;
        $this->sakit_nilai = 0;
        $this->alpha_nilai = 0;
        $this->prosentase_lain_nilai = 0;
        $this->lain_nilai = 0;
        $this->prosentase_uts_nilai = 0;
        $this->uts_nilai = 0;
        $this->prosentase_uas_nilai = 0;
        $this->uas_nilai = 0;
        $this->predikat_nilai = 0;
        $this->nilai_utuh = 0;
        $this->nilai = 0;
        $this->nama_matkul_nilai_edit = '';
        $this->nama_mhs_nilai_edit = '';
        $this->km_nilai_edit = '';
        $this->npm_nilai_edit = '';
        $this->ta_awal_nilai_edit = '';
        $this->ta_akhir_nilai_edit = '';
        $this->semester_nilai_edit = 0;
        $this->sks_nilai_edit = 0;
        $this->catatan_nilai_edit = '';
        $this->izin_nilai_edit = 0;
        $this->sakit_nilai_edit = 0;
        $this->alpha_nilai_edit = 0;
        $this->nilai_edit = 0;
        $this->data_nilai_mhs = [];
        $this->search = '';
        $this->searchEdit = '';
        $this->kmEdit = '';
        $this->npmEdit = '';
        $this->prosentase_lain_nilai_edit = 0;
        $this->lain_nilai_edit = 0;
        $this->prosentase_uts_nilai_edit = 0;
        $this->uts_nilai_edit = 0;
        $this->prosentase_uas_nilai_edit = 0;
        $this->uas_nilai_edit = 0;
        $this->predikat_nilai_edit = 0;
        $this->nilai_utuh_edit = 0;
        $this->nilai_edit = 0;
        $this->dispatch('close-Load');
    }
    public function allreset(){
        $this->mount();
        $this->dispatch('reload-page');
    }
    public function KMtoInput($km){
        $this->dispatch('Load');
        $data_mengajar = M_Mengajar::where('tb_mengajar.kode_mengajar',$km)
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        if ($data_mengajar->status_mengajar ==1) {
            $this->km_nilai = $data_mengajar->kode_mengajar;
            $this->nama_matkul_nilai = $data_mengajar->nama_matkul_ind;
            $this->dispatch('close-Load');
            $this->dispatch('open-modal-pilih-mhs');
            $this->form=1;
        }else{
            $this->dispatch('close-Load');
            $this->mount();
            $this->dispatch('Failed','Anda sudah tidak aktif');
        }
    }
    public function NpmtoInput($npm){
        $data_mhs = M_Mahasiswa::where('tb_mahasiswa.npm',$npm)
                                ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        if ($data_mhs->status_mhs ==1) {
            $this->form=1;
            $this->dispatch('close-Load');
            $this->dispatch('close-modal-pilih-mhs');
            $this->npm_nilai = $data_mhs->npm;
            $this->nama_mhs_nilai = $data_mhs->name_mhs;
        }else{
            $this->mount();
            $this->dispatch('close-Load');
            $this->dispatch('close-modal-pilih-mhs');
            $this->dispatch('Failed','Mahasiswa sudah tidak aktif');
        }
    }
    public function HitungNilai(){
        $this->validate([
            'prosentase_lain_nilai' => 'required|numeric|between:20,40',
            'lain_nilai' => 'required|numeric',
            'prosentase_uts_nilai' => 'required|numeric|between:20,40',
            'uts_nilai' => 'required|numeric',
            'prosentase_uas_nilai' => 'required|numeric|between:20,40',
            'uas_nilai' => 'required|numeric',
        ],[
            'prosentase_lain_nilai.required' => 'Presentase Lain-lain belum diisi.',
            'prosentase_lain_nilai.numeric' => 'Presentase Lain-lain berisi angka.',
            'prosentase_lain_nilai.between' => 'Presentase Lain-lain Range 20 - 40.',
            'lain_nilai.required' => 'Nilai Lain-lain belum diisi.',
            'lain_nilai.numeric' => 'Nilai Lain-lain berisi angka.',
            'prosentase_uts_nilai.required' => 'Presentase UTS belum diisi.',
            'prosentase_uts_nilai.numeric' => 'Presentase UTS berisi angka.',
            'prosentase_uts_nilai.between' => 'Presentase UTS Range 20 - 40.',
            'uts_nilai.required' => 'Nilai UTS belum diisi.',
            'uts_nilai.numeric' => 'Nilai UTS berisi angka.',
            'prosentase_uas_nilai.required' => 'Presentase UAS belum diisi.',
            'prosentase_uas_nilai.numeric' => 'Presentase UAS berisi angka.',
            'prosentase_uas_nilai.between' => 'Presentase UAS Range 20 - 40.',
            'uas_nilai.required' => 'Nilai UAS belum diisi.',
            'uas_nilai.numeric' => 'Nilai UAS berisi angka.',
        ]);
        $checkpersen =($this->prosentase_lain_nilai+$this->prosentase_uts_nilai+$this->prosentase_uas_nilai);
        if($checkpersen == 100){
            $nilai_lain = $this->lain_nilai*($this->prosentase_lain_nilai/100);
            $nilai_uts = $this->uts_nilai*($this->prosentase_uts_nilai/100);
            $nilai_uas = $this->uas_nilai*($this->prosentase_uas_nilai/100);
            $nilai_utuh = ($nilai_lain+$nilai_uts+$nilai_uas);
            $predikat = '';
            if ($nilai_utuh >= 85) {
                $predikat = 'A';
            } elseif ($nilai_utuh >= 80) {
                $predikat = 'AB';
            } elseif ($nilai_utuh >= 75) {
                $predikat = 'B';
            } elseif ($nilai_utuh >= 70) {
                $predikat = 'BC';
            } elseif ($nilai_utuh >= 65) {
                $predikat = 'C';
            } elseif ($nilai_utuh >= 60) {
                $predikat = 'D';
            } else {
                $predikat = 'E';
            }
            $this->hitung = 1;
            $nilai_utuh = number_format($nilai_utuh, 1);
            $this->nilai = $nilai_utuh;
            $this->predikat_nilai = $predikat;
        }else{
            $this->addError('prosentase_lain_nilai','Persentase tidak tepat');
            $this->addError('prosentase_uas_nilai','Persentase tidak tepat');
            $this->addError('prosentase_uts_nilai','Persentase tidak tepat');
        }
    }
    public function Add_Nilai(){
        $this->validate([
            'km_nilai' => 'required|exists:tb_mengajar,kode_mengajar',
            'npm_nilai' => 'required|exists:tb_mahasiswa,npm',
            'kelas_nilai' => 'required|uppercase|regex:/^[A-Z0-9\-]+$/',
            'ta_awal_nilai' => 'required',
            'ta_akhir_nilai' => 'required',
            'semester_nilai' => 'required',
            'sks_nilai' => 'required|numeric',
            'alpha_nilai' => 'required|numeric',
            'sakit_nilai' => 'required|numeric',
            'izin_nilai' => 'required|numeric',
            'nilai' => 'required|numeric',
            'prosentase_lain_nilai' => 'required|numeric|between:20,40',
            'lain_nilai' => 'required|numeric',
            'prosentase_uts_nilai' => 'required|numeric|between:20,40',
            'uts_nilai' => 'required|numeric',
            'prosentase_uas_nilai' => 'required|numeric|between:20,40',
            'uas_nilai' => 'required|numeric',
        ],[
            'km_nilai.required' => 'Kode Mengajar belum diisi.',
            'km_nilai.exists' => 'Kode Mengajar tidak ditemukan.',
            'npm_nilai.required' => 'Nomor Pokok Mahasiswa belum diisi.',
            'npm_nilai.exists' => 'Nomor Pokok tidak ditemukan.',
            'kelas_nilai.required' => 'Kelas belum diisi.',
            'kelas_nilai.uppercase' => 'Kelas menggunakan huruf kapital.',
            'kelas_nilai.regex' => 'Kelas tidak sesuai format contoh[TI-3D].',
            'ta_awal_nilai.required' => 'Tahun Ajaran belum dipilih.',
            'ta_akhir_nilai.required' => 'Tahun Ajaran belum dipilih.',
            'semester_nilai.required' => 'Semester belum dipilih.',
            'sks_nilai.required' => 'SKS belum diisi.',
            'sks_nilai.numeric' => 'SKS berisi angka.',
            'alpha_nilai.required' => 'Alpha belum diisi.',
            'alpha_nilai.numeric' => 'Alpha berisi angka.',
            'sakit_nilai.required' => 'Sakit belum diisi.',
            'sakit_nilai.numeric' => 'Sakit berisi angka.',
            'izin_nilai.required' => 'Izin belum diisi.',
            'izin_nilai.numeric' => 'Izin berisi angka.',
            'nilai.required' => 'Nilai belum diisi.',
            'nilai.numeric' => 'Nilai berisi angka.',
            'prosentase_lain_nilai.required' => 'Presentase Lain-lain belum diisi.',
            'prosentase_lain_nilai.numeric' => 'Presentase Lain-lain berisi angka.',
            'prosentase_lain_nilai.between' => 'Presentase Lain-lain Range 20 - 40.',
            'lain_nilai.required' => 'Nilai Lain-lain belum diisi.',
            'lain_nilai.numeric' => 'Nilai Lain-lain berisi angka.',
            'prosentase_uts_nilai.required' => 'Presentase UTS belum diisi.',
            'prosentase_uts_nilai.numeric' => 'Presentase UTS berisi angka.',
            'prosentase_uts_nilai.between' => 'Presentase UTS Range 20 - 40.',
            'uts_nilai.required' => 'Nilai UTS belum diisi.',
            'uts_nilai.numeric' => 'Nilai UTS berisi angka.',
            'prosentase_uas_nilai.required' => 'Presentase UAS belum diisi.',
            'prosentase_uas_nilai.numeric' => 'Presentase UAS berisi angka.',
            'prosentase_uas_nilai.between' => 'Presentase UAS Range 20 - 40.',
            'uas_nilai.required' => 'Nilai UAS belum diisi.',
            'uas_nilai.numeric' => 'Nilai UAS berisi angka.',
        ]);

        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $dosen= M_Dosen::where('nidn',$username)
                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $check = M_Nilai::where('kode_mengajar',$this->km_nilai)
                          ->where('npm',$this->npm_nilai)
                          ->first();
        if($this->ta_akhir_nilai == ($this->ta_awal_nilai+1)){
            if($dosen){
                if(!$check){
                    $datacreated_ket=[
                        'id_keterangan'=>(string) Str::uuid(),
                        'alpha'=>$this->alpha_nilai,
                        'izin'=>$this->izin_nilai,
                        'sakit'=>$this->sakit_nilai,
                        'catatan'=>$this->catatan_nilai,
                        'created_at'=>now(),
                    ];
                    $add_ket = M_Keterangan::create($datacreated_ket);
                if($add_ket){
                        $lastid = M_Keterangan::latest()->first();
                        $id_ket = $lastid->id_keterangan == null? 1:$lastid->id_keterangan;
                        $datacreated_nilai=[
                            'id_nilai'=>(string) Str::uuid(),
                            'kode_mengajar'=>$this->km_nilai,
                            'id_keterangan'=>$id_ket,
                            'npm'=>$this->npm_nilai,
                            'kelas_nilai'=>$this->kelas_nilai,
                            'tahun_ajar_awal_nilai'=>$this->ta_awal_nilai,
                            'tahun_ajar_akhir_nilai'=>$this->ta_akhir_nilai,
                            'semester_nilai'=>$this->semester_nilai,
                            'sks'=>$this->sks_nilai,
                            'angka_nilai'=>$this->nilai,
                            'created_at'=>now(),
                        ];
                        $add_nilai = M_Nilai::create($datacreated_nilai);
                        if($add_nilai){
                            $lastid_nilai = M_Nilai::latest()->first();
                            $id_nilai = $lastid_nilai->id_nilai == null? 1:$lastid_nilai->id_nilai;
                            $datacreated_detail_nilai=[
                            'id_detail_nilai'=>(string) Str::uuid(),
                            'id_nilai'=>$id_nilai,
                            'lain_detail'=>$this->lain_nilai,
                            'lain_prosentase_detail'=>$this->prosentase_lain_nilai,
                            'uts_detail'=>$this->uts_nilai,
                            'uts_prosentase_detail'=>$this->prosentase_uts_nilai,
                            'uas_detail'=>$this->uas_nilai,
                            'uas_prosentase_detail'=>$this->prosentase_uas_nilai,
                            'created_at'=>now(),
                            ];
                            M_Detail_Nilai::create($datacreated_detail_nilai);
                            $this->mount();
                            $this->dispatch('close-modal-form-pengajar');
                            $this->dispatch('Success','Berhasil ditambahkan');
                        }else{
                            $this->mount();
                            $this->dispatch('Failed','Gagal menambahkan Nilai');
                        }
                }else{
                    $this->mount();
                    $this->dispatch('Failed','Gagal menambahkan Nilai');
                }
                }else{
                    $this->mount();
                    $this->dispatch('Failed','Nilai sudah tersedia');
                }
            }else{
                $this->mount();
                $this->dispatch('Failed','Gagal menambahkan Nilai');
            }
        }else{
            $this->addError('ta_akhir_nilai','Tahun Ajaran tidak benar');
            $this->addError('ta_awal_nilai','Tahun Ajaran tidak benar');
            $this->ta_akhir_nilai = '';
            $this->ta_awal_nilai = '';
        }
    }

    public function KMtoInputEdit($km){
        $this->dispatch('Load');
        $data_mengajar = M_Mengajar::where('tb_mengajar.kode_mengajar',$km)
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        $this->kmEdit = $km;
        $this->data_nilai_mhs = $this->UpdatedsearchEdit();
        if ($data_mengajar->status_mengajar ==1) {
            $this->km_nilai_edit = $data_mengajar->kode_mengajar;
            $this->nama_matkul_nilai_edit = $data_mengajar->nama_matkul_ind;
            $this->dispatch('close-Load');
            $this->dispatch('open-modal-pilih-mhs-edit');
            $this->form=2;
        }else{
            $this->dispatch('close-Load');
            $this->mount();
            $this->dispatch('Failed','Anda sudah tidak aktif');
        }
    }
    public function NpmtoInputEdit($npm){
        $data_nilai_mhs_edit = M_Nilai::where('tb_nilai.kode_mengajar',$this->kmEdit)
                                ->where('tb_nilai.npm',$npm)
                                ->join('tb_keterangan', 'tb_nilai.id_keterangan','=','tb_keterangan.id_keterangan')
                                ->join('tb_mengajar', 'tb_nilai.kode_mengajar','=','tb_mengajar.kode_mengajar')
                                ->join('tb_mahasiswa', 'tb_nilai.npm','=','tb_mahasiswa.npm')
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_detail_nilai', 'tb_detail_nilai.id_nilai','=','tb_nilai.id_nilai')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        $this->npmEdit = $npm;
        $this->data_nilai_mhs = $this->UpdatedsearchEdit();
        if ($data_nilai_mhs_edit->status_mhs ==1) {
            $this->form=2;
            $this->dispatch('close-Load');
            $this->dispatch('close-modal-pilih-mhs-edit');
            $this->ta_awal_nilai_edit = $data_nilai_mhs_edit->tahun_ajar_awal_nilai;
            $this->ta_akhir_nilai_edit = $data_nilai_mhs_edit->tahun_ajar_akhir_nilai;
            $this->semester_nilai_edit = $data_nilai_mhs_edit->semester_nilai;
            $this->sks_nilai_edit = $data_nilai_mhs_edit->sks;
            $this->alpha_nilai_edit = $data_nilai_mhs_edit->alpha;
            $this->sakit_nilai_edit = $data_nilai_mhs_edit->sakit;
            $this->izin_nilai_edit = $data_nilai_mhs_edit->izin;
            $this->catatan_nilai_edit = $data_nilai_mhs_edit->catatan;
            $this->npm_nilai_edit = $data_nilai_mhs_edit->npm;
            $this->nama_mhs_nilai_edit = $data_nilai_mhs_edit->name_mhs;
            $this->lain_nilai_edit = $data_nilai_mhs_edit->lain_detail;
            $this->prosentase_lain_nilai_edit = $data_nilai_mhs_edit->lain_prosentase_detail;
            $this->uts_nilai_edit = $data_nilai_mhs_edit->uts_detail;
            $this->prosentase_uts_nilai_edit = $data_nilai_mhs_edit->uts_prosentase_detail;
            $this->uas_nilai_edit = $data_nilai_mhs_edit->uas_detail;
            $this->prosentase_uas_nilai_edit = $data_nilai_mhs_edit->uas_prosentase_detail;
            $this->nilai_edit = $data_nilai_mhs_edit->angka_nilai;
            $this->kelas_nilai_edit = $data_nilai_mhs_edit->kelas_nilai;
            $predikat = '';
            if ($data_nilai_mhs_edit->angka_nilai >= 85) {
                $predikat = 'A';
            } elseif ($data_nilai_mhs_edit->angka_nilai >= 80) {
                $predikat = 'AB';
            } elseif ($data_nilai_mhs_edit->angka_nilai >= 75) {
                $predikat = 'B';
            } elseif ($data_nilai_mhs_edit->angka_nilai >= 70) {
                $predikat = 'BC';
            } elseif ($data_nilai_mhs_edit->angka_nilai >= 65) {
                $predikat = 'C';
            } elseif ($data_nilai_mhs_edit->angka_nilai >= 60) {
                $predikat = 'D';
            } else {
                $predikat = 'E';
            }
            $this->predikat_nilai_edit = $predikat;
            $this->id_nilai = $data_nilai_mhs_edit->id_nilai;
        }else{
            $this->mount();
            $this->dispatch('close-Load');
            $this->dispatch('close-modal-pilih-mhs');
            $this->dispatch('Failed','Mahasiswa sudah tidak aktif');
        }
    }

    public function HitungNilaiEdit(){
        $this->validate([
            'prosentase_lain_nilai_edit' => 'required|numeric|between:20,40',
            'lain_nilai_edit' => 'required|numeric',
            'prosentase_uts_nilai_edit' => 'required|numeric|between:20,40',
            'uts_nilai_edit' => 'required|numeric',
            'prosentase_uas_nilai_edit' => 'required|numeric|between:20,40',
            'uas_nilai_edit' => 'required|numeric',
        ],[
            'prosentase_lain_nilai_edit.required' => 'Presentase Lain-lain belum diisi.',
            'prosentase_lain_nilai_edit.numeric' => 'Presentase Lain-lain berisi angka.',
            'prosentase_lain_nilai_edit.between' => 'Presentase Lain-lain Range 20 - 40.',
            'lain_nilai_edit.required' => 'Nilai Lain-lain belum diisi.',
            'lain_nilai_edit.numeric' => 'Nilai Lain-lain berisi angka.',
            'prosentase_uts_nilai_edit.required' => 'Presentase UTS belum diisi.',
            'prosentase_uts_nilai_edit.numeric' => 'Presentase UTS berisi angka.',
            'prosentase_uts_nilai_edit.between' => 'Presentase UTS Range 20 - 40.',
            'uts_nilai_edit.required' => 'Nilai UTS belum diisi.',
            'uts_nilai_edit.numeric' => 'Nilai UTS berisi angka.',
            'prosentase_uas_nilai_edit.required' => 'Presentase UAS belum diisi.',
            'prosentase_uas_nilai_edit.numeric' => 'Presentase UAS berisi angka.',
            'prosentase_uas_nilai_edit.between' => 'Presentase UAS Range 20 - 40.',
            'uas_nilai_edit.required' => 'Nilai UAS belum diisi.',
            'uas_nilai_edit.numeric' => 'Nilai UAS berisi angka.',
        ]);
        $checkpersen =($this->prosentase_lain_nilai_edit+$this->prosentase_uts_nilai_edit+$this->prosentase_uas_nilai_edit);
        if($checkpersen == 100){
            $nilai_lain = $this->lain_nilai_edit*($this->prosentase_lain_nilai_edit/100);
            $nilai_uts = $this->uts_nilai_edit*($this->prosentase_uts_nilai_edit/100);
            $nilai_uas = $this->uas_nilai_edit*($this->prosentase_uas_nilai_edit/100);
            $nilai_utuh = ($nilai_lain+$nilai_uts+$nilai_uas);
            $predikat = '';
            if ($nilai_utuh >= 85) {
                $predikat = 'A';
            } elseif ($nilai_utuh >= 80) {
                $predikat = 'AB';
            } elseif ($nilai_utuh >= 75) {
                $predikat = 'B';
            } elseif ($nilai_utuh >= 70) {
                $predikat = 'BC';
            } elseif ($nilai_utuh >= 65) {
                $predikat = 'C';
            } elseif ($nilai_utuh >= 60) {
                $predikat = 'D';
            } else {
                $predikat = 'E';
            }
            $this->nilai_edit = $nilai_utuh;
            $this->predikat_nilai_edit = $predikat;
        }else{
            $this->addError('prosentase_lain_nilai','Persentase tidak tepat');
            $this->addError('prosentase_uas_nilai','Persentase tidak tepat');
            $this->addError('prosentase_uts_nilai','Persentase tidak tepat');
        }
    }
    public function Edit_Nilai($id){
        $this->validate([
            'km_nilai_edit' => 'required|exists:tb_mengajar,kode_mengajar',
            'npm_nilai_edit' => 'required|exists:tb_mahasiswa,npm',
            'kelas_nilai_edit' => 'required|uppercase|regex:/^[A-Z0-9\-]+$/',
            'ta_awal_nilai_edit' => 'required',
            'ta_akhir_nilai_edit' => 'required',
            'semester_nilai_edit' => 'required',
            'sks_nilai_edit' => 'required|numeric',
            'alpha_nilai_edit' => 'required|numeric',
            'sakit_nilai_edit' => 'required|numeric',
            'izin_nilai_edit' => 'required|numeric',
            'nilai_edit' => 'required|numeric',
            'prosentase_lain_nilai_edit' => 'required|numeric|between:20,40',
            'lain_nilai_edit' => 'required|numeric',
            'prosentase_uts_nilai_edit' => 'required|numeric|between:20,40',
            'uts_nilai_edit' => 'required|numeric',
            'prosentase_uas_nilai_edit' => 'required|numeric|between:20,40',
            'uas_nilai_edit' => 'required|numeric',
        ],[
            'km_nilai_edit.required' => 'Kode Mengajar belum diisi.',
            'km_nilai_edit.exists' => 'Kode Mengajar tidak ditemukan.',
            'npm_nilai_edit.required' => 'Nomor Pokok Mahasiswa belum diisi.',
            'npm_nilai_edit.exists' => 'Nomor Pokok tidak ditemukan.',
            'kelas_nilai_edit.required' => 'Kelas belum diisi.',
            'kelas_nilai_edit.uppercase' => 'Kelas menggunakan huruf kapital.',
            'kelas_nilai_edit.regex' => 'Kelas tidak sesuai format contoh[TI-3D].',
            'ta_awal_nilai_edit.required' => 'Tahun Ajaran belum dipilih.',
            'ta_akhir_nilai_edit.required' => 'Tahun Ajaran belum dipilih.',
            'semester_nilai_edit.required' => 'Semester belum dipilih.',
            'sks_nilai_edit.required' => 'SKS belum diisi.',
            'sks_nilai_edit.numeric' => 'SKS berisi angka.',
            'alpha_nilai_edit.required' => 'Alpha belum diisi.',
            'alpha_nilai_edit.numeric' => 'Alpha berisi angka.',
            'sakit_nilai_edit.required' => 'Sakit belum diisi.',
            'sakit_nilai_edit.numeric' => 'Sakit berisi angka.',
            'izin_nilai_edit.required' => 'Izin belum diisi.',
            'izin_nilai_edit.numeric' => 'Izin berisi angka.',
            'nilai_edit.required' => 'Nilai belum diisi.',
            'nilai_edit.numeric' => 'Nilai berisi angka.',
            'prosentase_lain_nilai_edit.required' => 'Presentase Lain-lain belum diisi.',
            'prosentase_lain_nilai_edit.numeric' => 'Presentase Lain-lain berisi angka.',
            'prosentase_lain_nilai_edit.between' => 'Presentase Lain-lain Range 20 - 40.',
            'lain_nilai_edit.required' => 'Nilai Lain-lain belum diisi.',
            'lain_nilai_edit.numeric' => 'Nilai Lain-lain berisi angka.',
            'prosentase_uts_nilai_edit.required' => 'Presentase UTS belum diisi.',
            'prosentase_uts_nilai_edit.numeric' => 'Presentase UTS berisi angka.',
            'prosentase_uts_nilai_edit.between' => 'Presentase UTS Range 20 - 40.',
            'uts_nilai_edit.required' => 'Nilai UTS belum diisi.',
            'uts_nilai_edit.numeric' => 'Nilai UTS berisi angka.',
            'prosentase_uas_nilai_edit.required' => 'Presentase UAS belum diisi.',
            'prosentase_uas_nilai_edit.numeric' => 'Presentase UAS berisi angka.',
            'prosentase_uas_nilai_edit.between' => 'Presentase UAS Range 20 - 40.',
            'uas_nilai_edit.required' => 'Nilai UAS belum diisi.',
            'uas_nilai_edit.numeric' => 'Nilai UAS berisi angka.',
        ]);
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $dosen= M_Dosen::where('nidn',$username)
                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $check = M_Nilai::where('tb_nilai.kode_mengajar',$this->kmEdit)
                                ->where('tb_nilai.npm',$this->npmEdit)
                                ->join('tb_keterangan', 'tb_nilai.id_keterangan','=','tb_keterangan.id_keterangan')
                                ->join('tb_mengajar', 'tb_nilai.kode_mengajar','=','tb_mengajar.kode_mengajar')
                                ->join('tb_mahasiswa', 'tb_nilai.npm','=','tb_mahasiswa.npm')
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_detail_nilai', 'tb_detail_nilai.id_nilai','=','tb_nilai.id_nilai')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->first();
        if($this->ta_akhir_nilai_edit == ($this->ta_awal_nilai_edit+1)){
            if($dosen){
                if($check){
                    $dataupdated_ket=[
                        'alpha'=>$this->alpha_nilai_edit,
                        'izin'=>$this->izin_nilai_edit,
                        'sakit'=>$this->sakit_nilai_edit,
                    ];
                    $keterangan = M_Keterangan::where('id_keterangan',$check->id_keterangan);
                    $updated_ket = $keterangan->update($dataupdated_ket);
                if($updated_ket){
                        $dataupdated_nilai=[
                            'kelas_nilai'=>$this->kelas_nilai_edit,
                            'tahun_ajar_awal_nilai'=>$this->ta_awal_nilai_edit,
                            'tahun_ajar_akhir_nilai'=>$this->ta_akhir_nilai_edit,
                            'semester_nilai'=>$this->semester_nilai_edit,
                            'sks'=>$this->sks_nilai_edit,
                            'angka_nilai'=>$this->nilai_edit,
                        ];
                        $updated_nilai = $check->update($dataupdated_nilai);
                        if($updated_nilai){
                            $dataupdated_detail_nilai=[
                            'lain_detail'=>$this->lain_nilai_edit,
                            'lain_prosentase_detail'=>$this->prosentase_lain_nilai_edit,
                            'uts_detail'=>$this->uts_nilai_edit,
                            'uts_prosentase_detail'=>$this->prosentase_uts_nilai_edit,
                            'uas_detail'=>$this->uas_nilai_edit,
                            'uas_prosentase_detail'=>$this->prosentase_uas_nilai_edit,
                            ];
                            $detail = M_Detail_nilai::where('id_nilai',$check->id_nilai)->first();
                            M_Detail_nilai::where('id_detail_nilai',$detail->id_detail_nilai)->update($dataupdated_detail_nilai);
                            $this->mount();
                            $this->dispatch('close-modal-form-pengajar');
                            $this->dispatch('Success','Berhasil diubah');
                        }else{
                            $this->mount();
                            $this->dispatch('Failed','Gagal Mengubah Nilai');
                        }
                }else{
                    $this->mount();
                    $this->dispatch('Failed','Gagal Mengubah Nilai');
                }
                }else{
                    $this->mount();
                    $this->dispatch('Failed','Nilai tidak ditemukan');
                }
            }else{
                $this->mount();
                $this->dispatch('Failed','Gagal Mengubah Nilai');
            }
        }else{
            $this->addError('ta_akhir_nilai','Tahun Ajaran tidak benar');
            $this->addError('ta_awal_nilai','Tahun Ajaran tidak benar');
            $this->ta_akhir_nilai = '';
            $this->ta_awal_nilai = '';
        }
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Mata Kuliah';
        $dosen= M_Dosen::where('nidn',$username)
                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $data_mhs= $this->Updatedsearch();
        $this->data_nilai_mhs= $this->UpdatedsearchEdit();
        $mata_kuliah = M_Mengajar::where('tb_mengajar.nidn',$dosen->nidn)
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->get();
        return view('livewire.dosen.data.dosen-mata-kuliah',['user'=>$user,'dosen'=>$dosen,'data_mhs'=>$data_mhs,'mata_kuliah'=>$mata_kuliah])->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }

    public function Updatedsearch()
    {
        $username= Session::get('username');
        $dosen= M_Dosen::where('nidn',$username)
                ->join('tb_jurusan', 'tb_dosen.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $data_mhs = M_Mahasiswa::where('tb_mahasiswa.id_jurusan',$dosen->id_jurusan)
                                ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->where(function ($query) {
                                    $query->where('name_mhs', 'like', '%' . $this->search . '%')
                                          ->orWhere('npm', 'like', '%' . $this->search . '%');
                                })
                                ->get();
        return $data_mhs;
    }

    public function UpdatedsearchEdit()
    {
        $data_nilai_mhs = M_Nilai::where('tb_nilai.kode_mengajar',$this->kmEdit)
                                ->join('tb_mengajar', 'tb_nilai.kode_mengajar','=','tb_mengajar.kode_mengajar')
                                ->join('tb_mahasiswa', 'tb_nilai.npm','=','tb_mahasiswa.npm')
                                ->join('tb_matkul', 'tb_matkul.kode_matkul','=','tb_mengajar.kode_matkul')
                                ->join('tb_jurusan', 'tb_matkul.id_jurusan','=','tb_jurusan.id_jurusan')
                                ->where(function ($query) {
                                    $query->where('tb_mahasiswa.name_mhs', 'like', '%' . $this->searchEdit . '%')
                                          ->orWhere('tb_mahasiswa.npm', 'like', '%' . $this->searchEdit . '%');
                                })
                                ->get();
        return $data_nilai_mhs;
    }

}
