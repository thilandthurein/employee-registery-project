<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            ''=>$row[0];
            ''=>$row[1];
            ''=>$row[2];
            ''=>$row[3];
            ''=>$row[4];
        ]);
    }
}
