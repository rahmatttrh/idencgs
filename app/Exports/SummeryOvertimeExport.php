<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Overtime;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummeryOvertimeExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public $from; 
    public $to; 
    public $unit; 

    public function __construct($from, $to, $unit)
    {
        $this->from = $from;
        $this->unit = $unit;
        $this->to = $to;

    }



    public function query()
    {
      //   $loc = Location::where('code', $this->loc)->first();

      // $overs = Overtime::whereBetween('date', [$this->from, $this->to])->where('location_id', 4)->orWhere('location_id', 5)->get(); 

      // dd($overs);
      // $employees = Employee::where('unit_id', $this->unit)->where('status', 1)->get();
      // $empArray = [];
      // foreach($employees as $emp){
      //    $empArray[] = $emp->id;
      // }

      // dd(Overtime::query()->whereBetween('date', [$this->from, $this->to])->whereIn('employee_id', $empArray));
      // return Overtime::query()->whereBetween('date', [$this->from, $this->to])->whereIn('employee_id', $empArray); 
      return Employee::query()->where('unit_id', $this->unit)->where('status', 1);

         // dd($overtime);
    }

    public function headings(): array
    {

      $unit = Unit::find($this->unit);
        return [
         [
            'SUMMARY SPKL',
            
         ],
         [
            $unit->name,
            
         ],
         [
            'Periode',
            formatDate($this->from) . ' - ' . formatDate($this->to),
            
            
         ],
            
            [
                'NIK',
                'Nama',
                'Lokasi',
                'Lembur',
                'Piket',
            ]
        ];
    }

    public function map($employee): array
    {
        

         // dd($overtime);
        
        return [
            $employee->nik,
            $employee->biodata->first_name . ' ' . $employee->biodata->last_name,
            $employee->location->name,
            count($employee->getSpkl($this->from, $this->to)->where('type', 1)),
            count($employee->getSpkl($this->from, $this->to)->where('type', 2)),
            
            
        ];
    }

    

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // 2    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'A2' => ['rowspan' => ['2' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }



}
