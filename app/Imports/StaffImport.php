<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Staff([
            'staff_id'      => $row['staff_id'],
            'name'          => $row['name'],
            'email'         => $row['email'],
            'phone'         => $row['phone'] ?? null,
            'position'      => $row['position'],
            'department_id' => $row['department_id'],
        ]);
    }
}