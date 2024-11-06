<?php

namespace App\Imports;

use App\Models\M_Mahasiswa;
use App\Models\M_Prodi;
use App\Models\M_Jurusan;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Concerns\ValidatesAttributes;


class MahasiswaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
     use Importable, ValidatesAttributes;

    public function collection(Collection $rows)
    {
        $validatedData = [];

        foreach ($rows as $key => $row) {
            if ($key == 0) continue; 


            $validatedData[] = $row->toArray();
        }

        if (!empty($validatedData)) {
            M_Mahasiswa::insert($validatedData);
        }
    }
}