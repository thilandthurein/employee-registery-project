<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class EmployeesExport implements FromCollection, WithHeadings,WithTitle,ShouldAutoSize,WithEvents
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
    $employees=Employee::withTrashed()->with('department','position')
                    ->select('employee_name','email','gender','dob')
                    ->where($this->data)
                    ->get();
    return $employees;
	}

    /**
     * Display a listing of the headings.
     * Thu Rein Lynn
     * 28.8.2020
     * 
     * @return array["Employee_name", "Email", "Gender","Date_of_Birth"]
     */
	public function headings(): array
    {
        return ["Employee_name", "Email", "Gender","Date of birth"];
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
                $cellRange = 'A1:D1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)
                ->getFont()
                ->setSize(14);
                $cell_range='A1:D1';
                $event->sheet->getStyle($cell_range)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('ff07F0');

            },
            
        ];  
    }
}