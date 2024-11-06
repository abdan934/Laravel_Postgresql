<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->tb_role();
        $this->tb_users();
        $this->tb_jurusan();
        $this->tb_prodi();
    }

    public function tb_role(){
         $roles = [
            ['name_role' => 'Bagian Akademik Mahasiswa','created_at'=>now(),'updated_at'=>now()],
            ['name_role' => 'Admin Jurusan','created_at'=>now(),'updated_at'=>now()],
            ['name_role' => 'Dosen','created_at'=>now(),'updated_at'=>now()],
            ['name_role' => 'Mahasiswa','created_at'=>now(),'updated_at'=>now()],
        ];

        DB::table('tb_role')->insert($roles);
    }
    public function tb_users(){
         $users = [
            [
                'id_users'=>(string) Str::uuid(),
                'id_role' => 1,
                'username' => 'baak',
                'password' => Hash::make('baak123'),
                'name_user' => 'Bagian Akademik',
                'jk_user' => 'L',
                'photo_profile' => 'default.jpg',
                'status_user' => 1,
                'default_pass' => 0,
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now(),],
        ];

        DB::table('tb_users')->insert($users);
    }
    public function tb_jurusan(){
         $id=(string) Str::uuid();
         $this->id_jurusan = $id;
         $jurusan = [
            [
                'id_jurusan'=>$id,
                'name_jurusan' => 'KOMPUTER DAN BISNIS',
                'created_at' => now(),
                'updated_at' => now(),],
        ];

        DB::table('tb_jurusan')->insert($jurusan);
    }
    public function tb_prodi(){
         if (!isset($this->id_jurusan)) {
            $this->tb_jurusan();
        }

        $id_jurusan = $this->id_jurusan;
         $prodi = [
            [ 'id_prodi'=>(string) Str::uuid(),
                'id_jurusan' => $id_jurusan,
                'jenjang_prodi' => 'DIII',
                'name_prodi' => 'TEKNIK INFORMATIKA',
                'created_at' => now(),
                'updated_at' => now(),],
            [ 'id_prodi'=>(string) Str::uuid(),
                'id_jurusan' => $id_jurusan,
                'jenjang_prodi' => 'DIV',
                'name_prodi' => 'REKAYASA KEAMANAN SIBER',
                'created_at' => now(),
                'updated_at' => now(),],
            [ 'id_prodi'=>(string) Str::uuid(),
                'id_jurusan' => $id_jurusan,
                'jenjang_prodi' => 'DIV',
                'name_prodi' => 'TEKNOLOGI REKAYASA MULTIMEDIA',
                'created_at' => now(),
                'updated_at' => now(),],
            [ 'id_prodi'=>(string) Str::uuid(),
                'id_jurusan' => $id_jurusan,
                'jenjang_prodi' => 'DIV',
                'name_prodi' => 'AKUNTANSI LEMBAGA KEUANGAN SYARIAH',
                'created_at' => now(),
                'updated_at' => now(),],
        ];
        DB::table('tb_prodi')->insert($prodi);
    }
}