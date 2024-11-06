<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Profile\Edit;
use App\Livewire\Dashboard;
use App\Livewire\Baak\Data\Dosen;
use App\Livewire\Baak\Data\Mahasiswa;
use App\Livewire\Baak\Data\AdminJurusan;
use App\Livewire\Baak\Data\JadwalKuliahJurusan;
use App\Livewire\Baak\Struktur\StrukturAkademik;
use App\Livewire\Ajur\Data\Jurusan;
use App\Livewire\Ajur\Data\MataKuliah;
use App\Livewire\Ajur\JadwalKuliah\JadwalKuliah;
use App\Livewire\Dosen\Data\DosenMataKuliah;
use App\Livewire\Dosen\JadwalKuliah\DosenJadwalKuliah;
use App\Livewire\Mahasiswa\Nilai;
use App\Livewire\Mahasiswa\MahasiswaJadwalKuliah;
use App\Livewire\Mahasiswa\MahasiswaNilai;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
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
use Carbon\Carbon;
use Dompdf\Dompdf;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Login::class)->middleware('isLogout');
Route::get('/login', Login::class)->middleware('isLogout');
Route::get('/logout', [Login::class,'logout']);

Route::get('/dashboard', Dashboard::class)->middleware('isLogin');
Route::get('/profile', Edit::class)->middleware(['isLogin','isDefaultPass']);


Route::get('/data/mahasiswa', Mahasiswa::class)->middleware(['isLogin','isBAAK','isDefaultPass']);
Route::get('/data/dosen', Dosen::class)->middleware(['isLogin','isBAAK','isDefaultPass']);
Route::get('/data/admin-jurusan', AdminJurusan::class)->middleware(['isLogin','isBAAK','isDefaultPass']);
Route::get('/struktur-akademik', StrukturAkademik::class)->middleware(['isLogin','isBAAK','isDefaultPass']);
Route::get('/data/baak/jadwal-kuliah', JadwalKuliahJurusan::class)->middleware(['isLogin','isBAAK','isDefaultPass']);


Route::get('/data/jurusan', Jurusan::class)->middleware(['isLogin','isAdminJurusan','isDefaultPass']);
Route::get('/data/mata-kuliah', MataKuliah::class)->middleware(['isLogin','isAdminJurusan','isDefaultPass']);
Route::get('/data/jadwal-kuliah', JadwalKuliah::class)->middleware(['isLogin','isAdminJurusan','isDefaultPass']);
Route::get('/file-jadwal', function () {
                                            $path = asset(session()->get('path'));

                                            if (!empty($path) && file_exists($path)) {
                                                $fileContents = file_get_contents($path);

                                                // Mendapatkan ekstensi file dari path
                                                $extension = pathinfo($path, PATHINFO_EXTENSION);

                                                // Membuat respons dengan isi file dan header yang sesuai
                                                return response($fileContents, 200)
                                                    ->header('Content-Type', mime_content_type($path)); // Menggunakan fungsi mime_content_type() untuk menentukan Content-Type
                                            } else {
                                                // Memberikan respons jika file tidak ditemukan
                                                return response('File not found', 404);
                                            }
                                        })->middleware(['isLogin','isDefaultPass']);

Route::get('/dosen/mata-kuliah', DosenMataKuliah::class)->middleware(['isLogin','isDosen','isDefaultPass']);
Route::get('/dosen/jadwal-kuliah', DosenJadwalKuliah::class)->middleware(['isLogin','isDosen','isDefaultPass']);


Route::get('/mahasiswa/jadwal-kuliah', MahasiswaJadwalKuliah::class)->middleware(['isLogin','isMahasiswa','isDefaultPass']);
Route::get('/mahasiswa/nilai-mata-kuliah', MahasiswaNilai::class)->middleware(['isLogin','isMahasiswa','isDefaultPass']);
Route::get('/mahasiswa/nilai-khs', function (Request $request) {
    $data=$request->query();
    $nilaiList = M_Nilai::where('tb_nilai.npm', $data['npm'])
                        ->where('tb_nilai.tahun_ajar_awal_nilai', $data['tahun_awal'])
                        ->where('tb_nilai.tahun_ajar_akhir_nilai', $data['tahun_akhir'])
                        ->join('tb_mengajar', 'tb_mengajar.kode_mengajar', '=', 'tb_nilai.kode_mengajar')
                        ->join('tb_matkul', 'tb_matkul.kode_matkul', '=', 'tb_mengajar.kode_matkul')
                        ->join('tb_mahasiswa', 'tb_mahasiswa.npm', '=', 'tb_nilai.npm')
                        ->join('tb_prodi', 'tb_mahasiswa.id_prodi', '=', 'tb_prodi.id_prodi')
                        ->join('tb_jurusan', 'tb_mahasiswa.id_jurusan', '=', 'tb_jurusan.id_jurusan')
                        ->join('tb_keterangan', 'tb_keterangan.id_keterangan', '=', 'tb_nilai.id_keterangan')
                        ->get();
    $sekarang = '';
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
    $romawiToArab = [
    'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4,
    'V' => 5, 'VI' => 6, 'VII' => 7, 'VIII' => 8,
    'IX' => 9, 'X' => 10,'XI' => 11,'XII' => 12,'XIII' => 13,'XIV' => 14
    ];

    foreach ($nilaiList as $nilai) {
        $angkaBiasa = $romawiToArab[$nilai->semester_nilai] ?? null;
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
        if ($data['semester_nilai'] == 1) {
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
        } elseif ($data['semester_nilai'] == 0) {
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

    $nilaiListAll = M_Nilai::where('tb_nilai.npm', $data['npm'])
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
        $statusLulus ='';
        ($ipk>=2.50)?$statusLulus = 'LULUS':$statusLulus = 'TIDAK LULUS';
    setlocale(LC_TIME, 'id_ID.utf8');
    Carbon::setLocale('id');
    $sekarang = Carbon::now()->translatedFormat('d F Y');
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
    $data_nilai = [
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
    // return view('cetak-khs',compact('data_nilai'))
    //         ->render();
    $dompdf = new Dompdf();
    $html = view('cetak-khs', compact('data_nilai'))
            ->extends('layouts.appKHS')
            ->render();

    $dompdf->loadHtml($html);
    $dompdf->render();

    return $dompdf->stream('document.pdf', ['Attachment' => 0]);
})->name('nilai.khs')->middleware(['isLogin', 'isMahasiswa', 'isDefaultPass']);
Route::get('/mahasiswa/nilai-transkrip', function (Request $request) {
    $data=$request->query();
    $sekarang = '';
    $kajur = [];
    $totalNilaiMutu = 0;
    $totalMutu = 0;
    $totalSakit = 0;
    $totalAlpha = 0;
    $totalIzin = 0;
    $rataMutu = 0;
    $jumlahNilai = 0;
    $totalSKSAll = 0;

    $nilaiListAll = M_Nilai::where('tb_nilai.npm', $data['npm'])
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

            $totalMutu += $nilaiAll->angka_nilai;
            $jumlahNilai++;
            $nilaiBerbobotAll = ($nilaiAll->angka_nilai / 100) * 4;
            $totalNilaiMutuAll += $nilaiBerbobotAll * $nilaiAll->sks;
            $totalSKSAll += $nilaiAll->sks;
        }

        $ipk = $totalSKSAll ? $totalNilaiMutuAll / $totalSKSAll : 0;
        $ipk = number_format($ipk, 2);
        $rataMutu = $jumlahNilai != 0 ? $totalMutu / $jumlahNilai : 0;
        $statusLulus ='';
        ($ipk>=2.50)?$statusLulus = 'LULUS':$statusLulus = 'TIDAK LULUS';
    setlocale(LC_TIME, 'id_ID.utf8');
    Carbon::setLocale('id');
    $sekarang = Carbon::now()->translatedFormat('d F Y');
    $parts = explode(', ', $nilaiListAll[0]->tempat_tgl_lahir_mhs);
                            $date = $parts[1];
    $formattedDate = Carbon::parse($date)->translatedFormat('d F Y');
    $ttgl_lahir = $parts[0] . ', ' . $formattedDate;
    $kajur =  M_Jurusan::where('tb_jurusan.id_jurusan', $nilaiListAll[0]->id_jurusan)
            ->where( 'tb_kajur.status_kajur', 1)
            ->join('tb_kajur', 'tb_kajur.id_jurusan', '=', 'tb_jurusan.id_jurusan')
            ->join('tb_dosen', 'tb_dosen.nidn', '=', 'tb_kajur.nidn')
            ->first();
    $data_nilai = [
        'nilaiList'=> $nilaiListAll,
        'totalSKS'=> $totalSKSAll,
        'TotalMutu'=> $totalMutu,
        'ipk'=> $ipk,
        'ttgl_lahir'=> $ttgl_lahir,
        'sekarang'=> $sekarang,
        'kajur'=> $kajur,
    ];
    // return view('cetak-khs',compact('data_nilai'))
    //         ->render();
    $dompdf = new Dompdf();
    $html = view('cetak-transkrip', compact('data_nilai'))
            ->extends('layouts.appKHS')
            ->render();

    $dompdf->loadHtml($html);
    $dompdf->render();

    return $dompdf->stream('document.pdf', ['Attachment' => 0]);
})->name('nilai.transkrip')->middleware(['isLogin', 'isMahasiswa', 'isDefaultPass']);
