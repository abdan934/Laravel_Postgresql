<?php

namespace App\Imports;

use App\Models\M_Dosen;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class DosenImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
         $validatedData = [];

        foreach ($rows as $key => $row) {
            if ($key == 0) continue; 


            $validatedData[] = $row->toArray();
        }

        if (!empty($validatedData)) {
            M_Dosen::insert($validatedData);
        }
    }
}