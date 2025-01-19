<?php

namespace App\Exports;

use App\Models\Crew;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Overtime;
use App\Models\Vessel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OvertimeExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public $from; 
    public $to; 
    public $loc; 

    public function __construct($from, $to, $loc)
    {
        $this->from = $from;
        $this->loc = $loc;
        $this->to = $to;

    }

    
    
    public function query()
    {
      //   $loc = Location::where('code', $this->loc)->first();

      // $overs = Overtime::whereBetween('date', [$this->from, $this->to])->where('location_id', 4)->orWhere('location_id', 5)->get(); 

      // dd($overs);
        if ($this->loc == 'KJ45') {
         // dd('ok');
            return Overtime::query()->whereBetween('date', [$this->from, $this->to])->where('location_id', 4)->orWhere('location_id', 5);  
         
         } else {
            return Overtime::query()->whereBetween('date', [$this->from, $this->to]);
         }

         // dd($overtime);
    }

    public function headings(): array
    {
        return [
            
            [
                'NIK',
                'Nama',
                'Hari',
                'Tanggal',
                'Lembur/Piket',
                'Jam',
            ]
        ];
    }

    public function map($overtime): array
    {
         if ($overtime->type == 1) {
            $type = 'Lembur';
         } else {
            $type = 'Piket';
         }

         // dd($overtime);
        
        return [
            $overtime->employee->nik,
            $overtime->employee->biodata->first_name . ' ' . $overtime->employee->biodata->last_name,
            formatDayName($overtime->date),
            formatDate($overtime->date),
            $type,
            $overtime->hours,
            
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
