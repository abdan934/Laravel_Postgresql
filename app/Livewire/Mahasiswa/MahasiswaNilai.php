<?php

namespace App\Livewire\Mahasiswa;

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
use App\Models\M_Matkul;
use App\Models\M_Mengajar;
use App\Models\M_Nilai;
use App\Models\M_Detail_Nilai;
use App\Models\M_Keterangan;
use App\Models\User;
use Dompdf\Dompdf;
use Carbon\Carbon;


class MahasiswaNilai extends Component
{
    public $tahun_awal,$tahun_akhir,$filteredNilaiList,$tahun_ajar_nilai,$semester_nilai,$data_nilai,$ips,$ipk,$sks,$totalSKS,$totalSKSAll,$displayNilai;

    public function mount(){
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $mahasiswa= M_Mahasiswa::where('npm',$username)
                ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $latest = M_Nilai::where('npm',$mahasiswa->npm)
                            ->latest()
                            ->first();
        $this->data_nilai = $this->data_nilai($mahasiswa->npm,$latest->tahun_ajar_awal_nilai,$latest->tahun_ajar_akhir_nilai,$latest->semester_nilai);
        $this->ips = $this->data_nilai['ips'];
        $this->ipk = $this->data_nilai['ipk'];
        $this->totalSKS =$this->data_nilai['totalSKS'];
        $this->totalSKSAll =$this->data_nilai['totalSKSAll'];
        $this->tahun_ajar_nilai = $this->data_nilai['nilaiList'][0]->tahun_ajar_awal_nilai . '/' . $this->data_nilai['nilaiList'][0]->tahun_ajar_akhir_nilai;
        $semesterArab = $this->romawiKeArab($this->data_nilai['nilaiList'][0]->semester_nilai);
        if ($semesterArab % 2 == 0) {
            $semesterType = 0;
        } else {
            $semesterType = 1;
        }
        $this->semester_nilai = $semesterType;
        $this->displayNilai = 0;
        $this->tahun_awal = 0;
        $this->tahun_akhir = 0;
        $this->tahun_awal = $this->data_nilai['nilaiList'][0]->tahun_ajar_awal_nilai;
        $this->tahun_akhir = $this->data_nilai['nilaiList'][0]->tahun_ajar_akhir_nilai;
        $this->filteredNilaiList = [];
        $this->filteredNilaiList = $this->data_nilai['nilaiList'];
    }

    private function data_nilai($npm,$tahunawal,$tahunakhir,$semester)
    {
        $nilaiList = M_Nilai::where('tb_nilai.npm', $npm)
                            ->where('tb_nilai.tahun_ajar_awal_nilai', $tahunawal)
                            ->where('tb_nilai.tahun_ajar_akhir_nilai', $tahunakhir)
                            ->where('tb_nilai.semester_nilai', $semester)
                            ->join('tb_mengajar', 'tb_mengajar.kode_mengajar', '=', 'tb_nilai.kode_mengajar')
                            ->join('tb_matkul', 'tb_matkul.kode_matkul', '=', 'tb_mengajar.kode_matkul')
                            ->join('tb_mahasiswa', 'tb_mahasiswa.npm', '=', 'tb_nilai.npm')
                            ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                            ->join('tb_keterangan', 'tb_keterangan.id_keterangan', '=', 'tb_nilai.id_keterangan')
                            ->get();
        $totalNilaiMutu = 0;
        $totalSKS = 0;
        foreach ($nilaiList as $nilai) {
            if ($nilai->angka_nilai >= 85) {
                $nilai->predikat = 'A';
            } elseif ($nilai->angka_nilai >= 80) {
                $nilai->predikat = 'AB';
            } elseif ($nilai->angka_nilai >= 75) {
                $nilai->predikat = 'B';
            } elseif ($nilai->angka_nilai >= 70) {
                $nilai->predikat = 'BC';
            } elseif ($nilai->angka_nilai >= 65) {
                $nilai->predikat = 'C';
            } elseif ($nilai->angka_nilai >= 60) {
                $nilai->predikat = 'D';
            } else {
                $nilai->predikat = 'E';
            }

            $nilaiBerbobot = ($nilai->angka_nilai / 100) * 4;
            $totalNilaiMutu += $nilaiBerbobot * $nilai->sks;
            $totalSKS += $nilai->sks;
        }

        $ips = $totalSKS ? $totalNilaiMutu / $totalSKS : 0;
        $ips = number_format($ips, 2);

        $nilaiListAll = M_Nilai::where('tb_nilai.npm', $npm)
            ->join('tb_mengajar', 'tb_mengajar.kode_mengajar', '=', 'tb_nilai.kode_mengajar')
            ->join('tb_matkul', 'tb_matkul.kode_matkul', '=', 'tb_mengajar.kode_matkul')
            ->join('tb_mahasiswa', 'tb_mahasiswa.npm', '=', 'tb_nilai.npm')
            ->join('tb_keterangan', 'tb_keterangan.id_keterangan', '=', 'tb_nilai.id_keterangan')
            ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan', '=', 'tb_jurusan.id_jurusan')
            ->orderBy('tb_nilai.semester_nilai')
            ->get();

        $totalNilaiMutuAll = 0;
        $totalSKSAll = 0;

        foreach ($nilaiListAll as $nilaiAll) {
            if ($nilaiAll->angka_nilai >= 85) {
                $nilaiAll->predikatAll = 'A';
            } elseif ($nilaiAll->angka_nilai >= 80) {
                $nilaiAll->predikatAll = 'AB';
            } elseif ($nilaiAll->angka_nilai >= 75) {
                $nilaiAll->predikatAll = 'B';
            } elseif ($nilaiAll->angka_nilai >= 70) {
                $nilaiAll->predikatAll = 'BC';
            } elseif ($nilaiAll->angka_nilai >= 65) {
                $nilaiAll->predikatAll = 'C';
            } elseif ($nilaiAll->angka_nilai >= 60) {
                $nilaiAll->predikatAll = 'D';
            } else {
                $nilaiAll->predikatAll = 'E';
            }
            $nilaiBerbobotAll = ($nilaiAll->angka_nilai / 100) * 4;
            $totalNilaiMutuAll += $nilaiBerbobotAll * $nilaiAll->sks;
            $totalSKSAll += $nilaiAll->sks;
        }

        $ipk = $totalSKSAll ? $totalNilaiMutuAll / $totalSKSAll : 0;
        $ipk = number_format($ipk, 2);

        $kajur =  M_Jurusan::where('tb_jurusan.id_jurusan', $nilaiListAll[0]->id_jurusan)
            ->where( 'tb_kajur.status_kajur', 1)
            ->join('tb_kajur', 'tb_kajur.id_jurusan', '=', 'tb_jurusan.id_jurusan')
            ->join('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kajur.nidn')
            ->first();

        return [
            'nilaiList' => $nilaiList,
            'nilaiListAll' => $nilaiListAll,
            'totalSKS' => $totalSKS,
            'totalSKSAll' => $totalSKSAll,
            'ips' => $ips,
            'ipk' => $ipk,
            'kajur' => $kajur,
        ];
    }

    private function data_nilai_seleksi($npm,$tahunawal,$tahunakhir,$semester)
    {
       $nilaiList = M_Nilai::where('tb_nilai.npm', $npm)
                            ->where('tb_nilai.tahun_ajar_awal_nilai', $tahunawal)
                            ->where('tb_nilai.tahun_ajar_akhir_nilai', $tahunakhir)
                            ->join('tb_mengajar', 'tb_mengajar.kode_mengajar', '=', 'tb_nilai.kode_mengajar')
                            ->join('tb_matkul', 'tb_matkul.kode_matkul', '=', 'tb_mengajar.kode_matkul')
                            ->join('tb_mahasiswa', 'tb_mahasiswa.npm', '=', 'tb_nilai.npm')
                            ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                            ->join('tb_keterangan', 'tb_keterangan.id_keterangan', '=', 'tb_nilai.id_keterangan')
                            ->get();
        $sekarang = '';
        $statusLulus ='';
        $kajur = [];
        $kaprodi = [];
        $totalNilaiMutu = 0;
        $totalMutu = 0;
        $totalSakit = 0;
        $totalAlpha = 0;
        $totalIzin = 0;
        $rataMutu = 0;
        $jumlahNilai = 0;
        $totalSKS = 0;
        $filteredNilaiList = [];
        foreach ($nilaiList as $nilai) {
            $angkaBiasa = $this->romawikeArab($nilai->semester_nilai);
            if ($nilai->angka_nilai >= 85) {
                $nilai->predikat     = 'A';
            } elseif ($nilai->angka_nilai >= 80) {
                $nilai->predikat = 'AB';
            } elseif ($nilai->angka_nilai >= 75) {
                $nilai->predikat = 'B';
            } elseif ($nilai->angka_nilai >= 70) {
                $nilai->predikat = 'BC';
            } elseif ($nilai->angka_nilai >= 65) {
                $nilai->predikat = 'C';
            } elseif ($nilai->angka_nilai >= 60) {
                $nilai->predikat = 'D';
            } else {
                $nilai->predikat = 'E';
            }
            if ($semester == 1) {
                if ($angkaBiasa % 2 != 0) {
                    $filteredNilaiList[] = $nilai;
                    $nilaiBerbobot = ($nilai->angka_nilai / 100) * 4;
                    $nilaiMutu = $nilai->angka_nilai;
                    $jumlahNilai++;
                    $totalMutu += $nilaiMutu;
                    $totalNilaiMutu += $nilaiBerbobot * $nilai->sks;
                    $totalSKS += $nilai->sks;
                    $totalSakit += $nilai->sakit;
                    $totalAlpha += $nilai->alpha;
                    $totalIzin += $nilai->izin;
                }
            } elseif ($semester == 0) {
                if ($angkaBiasa % 2 == 0) {
                    $filteredNilaiList[] = $nilai;
                    $nilaiBerbobot = ($nilai->angka_nilai / 100) * 4;
                    $nilaiMutu = $nilai->angka_nilai;
                    $jumlahNilai++;
                    $totalMutu += $nilai->angka_nilai;
                    $totalNilaiMutu += $nilaiBerbobot * $nilai->sks;
                    $totalSKS += $nilai->sks;
                    $totalSakit += $nilai->sakit;
                    $totalAlpha += $nilai->alpha;
                    $totalIzin += $nilai->izin;
                }
            }

        }
        $ips = $totalSKS ? $totalNilaiMutu / $totalSKS : 0;
        $ips = number_format($ips, 2);
        $rataMutu = $jumlahNilai != 0 ? $totalMutu / $jumlahNilai : 0;

        $nilaiListAll = M_Nilai::where('tb_nilai.npm', $npm)
            ->join('tb_mengajar', 'tb_mengajar.kode_mengajar', '=', 'tb_nilai.kode_mengajar')
            ->join('tb_matkul', 'tb_matkul.kode_matkul', '=', 'tb_mengajar.kode_matkul')
            ->join('tb_mahasiswa', 'tb_mahasiswa.npm', '=', 'tb_nilai.npm')
            ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan', '=', 'tb_jurusan.id_jurusan')
            ->join('tb_prodi', 'tb_mahasiswa.id_prodi', '=', 'tb_prodi.id_prodi')
            ->join('tb_keterangan', 'tb_keterangan.id_keterangan', '=', 'tb_nilai.id_keterangan')
            ->get();

        $totalNilaiMutuAll = 0;
        $totalSKSAll = 0;

        foreach ($nilaiListAll as $nilaiAll) {
            if ($nilaiAll->angka_nilai >= 85) {
                $nilaiAll->predikatAll = 'A';
            } elseif ($nilaiAll->angka_nilai >= 80) {
                $nilaiAll->predikatAll = 'AB';
            } elseif ($nilaiAll->angka_nilai >= 75) {
                $nilaiAll->predikatAll = 'B';
            } elseif ($nilaiAll->angka_nilai >= 70) {
                $nilaiAll->predikatAll = 'BC';
            } elseif ($nilaiAll->angka_nilai >= 65) {
                $nilaiAll->predikatAll = 'C';
            } elseif ($nilaiAll->angka_nilai >= 60) {
                $nilaiAll->predikatAll = 'D';
            } else {
                $nilaiAll->predikatAll = 'E';
            }
            $nilaiBerbobotAll = ($nilaiAll->angka_nilai / 100) * 4;
            $totalNilaiMutuAll += $nilaiBerbobotAll * $nilaiAll->sks;
            $totalSKSAll += $nilaiAll->sks;
        }

        $ipk = $totalSKSAll ? $totalNilaiMutuAll / $totalSKSAll : 0;
        $ipk = number_format($ipk, 2);
        ($ipk>=2.50)?$statusLulus = 'LULUS':$statusLulus = 'TIDAK LULUS';
        setlocale(LC_TIME, 'id_ID.utf8');
        Carbon::setLocale('id');
        $sekarang = Carbon::now()->translatedFormat('d F');
        $kajur =  M_Jurusan::where('tb_jurusan.id_jurusan', $nilaiListAll[0]->id_jurusan)
                ->where( 'tb_kajur.status_kajur', 1)
                ->join('tb_kajur', 'tb_kajur.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                ->join('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kajur.nidn')
                ->first();
        $kaprodi =  M_Prodi::where('tb_prodi.id_prodi', $nilaiListAll[0]->id_prodi)
                ->where( 'tb_kaprodi.status_kaprodi', 1)
                ->join('tb_kaprodi', 'tb_kaprodi.id_prodi', '=', 'tb_prodi.id_prodi')
                ->join('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kaprodi.nidn')
                ->first();

        return [
            'nilaiList'=> $filteredNilaiList,
            'semester'=> $angkaBiasa,
            'totalSKS'=> $totalSKS,
            'NilaiMutu'=> round($rataMutu),
            'ips'=> $ips,
            'ipk'=> $ipk,
            'statusLulus'=> $statusLulus,
            'totalSakit'=> $totalSakit,
            'totalAlpha'=> $totalAlpha,
            'totalIzin'=> $totalIzin,
            'sekarang'=> $sekarang,
            'kajur'=> $kajur,
            'kaprodi'=> $kaprodi,
        ];
    }

    public function render()
    {
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $title='Nilai Mata Kuliah';
        $mahasiswa= M_Mahasiswa::where('npm',$username)
                ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $latest = M_Nilai::where('npm',$mahasiswa->npm)
                            ->latest()
                            ->first();
        $gettahunajaran= M_Nilai::select('tahun_ajar_awal_nilai', 'tahun_ajar_akhir_nilai')
                        ->distinct()
                        ->where('npm', $mahasiswa->npm)
                        ->orderBy('tahun_ajar_awal_nilai','asc')
                        ->get();
        return view('livewire.mahasiswa.mahasiswa-nilai',['user'=>$user,'mahasiswa'=>$mahasiswa],compact('gettahunajaran'))->extends('layouts.base',['title'=>$title,'user'=>$user]);
    }

    public function change_data_nilai(){
        $this->dispatch('Load');
        $username= Session::get('username');
        $user= User::where('username',$username)->first();
        $mahasiswa= M_Mahasiswa::where('npm',$username)
                ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                ->first();
        $latest = M_Nilai::where('npm',$mahasiswa->npm)
                            ->latest()
                            ->first();
        $tahunArray = explode("/", $this->tahun_ajar_nilai);
        $tahun_awal = $tahunArray[0];
        $tahun_akhir = $tahunArray[1];
        $this->data_nilai = $this->data_nilai_seleksi($mahasiswa->npm,$tahun_awal,$tahun_akhir,$this->semester_nilai);
        $this->filteredNilaiList = $this->data_nilai['nilaiList'];
        $this->ips = $this->data_nilai['ips'];
        $this->ipk = $this->data_nilai['ipk'];
        $this->totalSKS =$this->data_nilai['totalSKS'];
        $this->tahun_awal = (!empty($this->data_nilai['nilaiList'][0]->tahun_ajar_awal_nilai)?$this->data_nilai['nilaiList'][0]->tahun_ajar_awal_nilai:[]);
        $this->tahun_akhir = (!empty($this->data_nilai['nilaiList'][0]->tahun_ajar_akhir_nilai)?$this->data_nilai['nilaiList'][0]->tahun_ajar_akhir_nilai:[]);
    }

    public function outputNilai($output){
        $this->dispatch('Load');
        $this->mount();
        $this->displayNilai = $output;
    }

    private function romawiKeArab($romawi)
    {
        $romawiToArab = [
            'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4,
            'V' => 5, 'VI' => 6, 'VII' => 7, 'VIII' => 8,
            'IX' => 9, 'X' => 10,'XI' => 11,'XII' => 12,'XIII' => 13,'XIV' => 14
        ];

        return $romawiToArab[$romawi] ?? null;
    }

    public function cetakKHS(){
        $this->dispatch('Load');
        if($this->tahun_akhir==[]||$this->tahun_awal==[]||$this->semester_nilai==[]){
            $this->dispatch('Failed','Cetak Kartu Hasil Studi');
        }else{
            $username= Session::get('username');
            $user= User::where('username',$username)->first();
            $mahasiswa= M_Mahasiswa::where('npm',$username)
                    ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->first();
            $latest = M_Nilai::where('npm',$mahasiswa->npm)
                                ->latest()
                                ->first();
            $tahunArray = explode("/", $this->tahun_ajar_nilai);
            $tahun_awal = $tahunArray[0];
            $tahun_akhir = $tahunArray[1];
            $this->data_nilai = $this->data_nilai_seleksi($mahasiswa->npm,$tahun_awal,$tahun_akhir,$this->semester_nilai);
            $data = [
                'npm'=>$mahasiswa->npm,
                'tahun_awal'=>$tahun_awal,
                'tahun_akhir'=>$tahun_akhir,
                'semester_nilai'=>$this->semester_nilai,
            ];
            return redirect()->route('nilai.khs', $data);
        }
    }
    public function cetakTranskrip(){
        $this->dispatch('Load');
        if($this->tahun_akhir==[]||$this->tahun_awal==[]||$this->semester_nilai==[]){
            $this->dispatch('Failed','Cetak Transkrip Nilai');
        }else{
            $username= Session::get('username');
            $user= User::where('username',$username)->first();
            $mahasiswa= M_Mahasiswa::where('npm',$username)
                    ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan','=','tb_jurusan.id_jurusan')
                    ->first();
            $data = [
                'npm'=>$mahasiswa->npm
            ];
            return redirect()->route('nilai.transkrip', $data);
        }
    }

}
