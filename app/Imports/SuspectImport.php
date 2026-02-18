<?php

namespace App\Imports;

use App\Models\Suspect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SuspectImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Suspect([
            'nik' => $row['nik'] ?? null,
            'name' => $row['name'] ?? null,
            'alias' => $row['alias'] ?? null,
            'gender' => $row['gender'] ?? null,
            'place_of_birth' => $row['place_of_birth'] ?? null,
            'date_of_birth' => $row['date_of_birth'] ?? null,
            'age' => $row['age'] ?? null,
            'religion' => $row['religion'] ?? null,
            'education' => $row['education'] ?? null,
            'occupation' => $row['occupation'] ?? null,
            'address' => $row['address'] ?? null,
            'finger_code' => $row['finger_code'] ?? null,
            'photo' => $row['photo'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'required|unique:suspects,nik',
            'name' => 'required|string',
            'gender' => 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem',
            'name.required' => 'Nama tidak boleh kosong',
            'gender.required' => 'Gender tidak boleh kosong',
        ];
    }
}

