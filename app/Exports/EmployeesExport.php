<?php

namespace App\Exports;

use App\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings,WithTitle,ShouldAutoSize,WithEvents,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
protected $data;

    /**
     * Catch the data for EmployeeController.
     * Thu Rein Lynn
     * 28.8.2020
     * @param $data=array[id,employee_name]
     * @return 
     */
    function __construct($data) {
         $this->data = $data;
    }

    /**
     * Take the data from employee table.
     * @author Thu Rein Lynn
     *  28.8.2020
     *  
     * @return array['employee_name','email','gender','dob']
     */
    public function collection()
    {
    // $employees=Employee::withTrashed()->with('department','position')
    //                 ->select('employee_name','email','gender','dob')
    //                 ->where($this->data)
    //                 ->get();
    $employees = DB::table('employees')
            ->join('emp_dep_positions', 'employees.id', '=', 'emp_dep_positions.employee_id')
            ->join('departments','departments.id','=','emp_dep_positions.department_id')
            ->join('positions','positions.id','=','emp_dep_positions.position_id')
            ->where($this->data)
            ->select('employees.*','departments.department_name','positions.position_name')
            ->get();
    return $employees;
	}

    /**
     * Display a listing of the headings.
     * Thu Rein Lynn
     * 28.8.2020
     * 
     * @return array["Employee_name", "Email", "Date_of_Birth","Gender"]
     */
	public function headings(): array
    {
        return ["Employee_name", "Email", "Date_of_Birth","Gender","Dep_Name","Pos_Name"];
    }

    /**
     * Display sheet Title.
     * @author Thu Rein Lynn
     * 28.8.2020
     *
     * @return string 'EmployeesList'
     */
     public function title(): string
    {
        return 'EmployeesList';
    }

    /**
     * Display sheet style.
     * @author Thu Rein Lynn
     * 31.8.2020
     *
     * @return
     */
     public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFont()
                ->setSize(14);
                $cell_range='A1:F1';
                $event->sheet->getStyle($cell_range)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('ff07F0');

            },
            
        ];  
    }
    public function map($employees): array
	{
	    return [
	        $employees->employee_name,
	        $employees->email,
	        $employees->dob,
	        $employees->gender,
	        $employees->department_name,
	        $employees->position_name
	        
	    ];
	}
}