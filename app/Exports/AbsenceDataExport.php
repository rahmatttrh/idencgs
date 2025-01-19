<?php

namespace App\Exports;

use App\Models\Absence;
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

class AbsenceDataExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
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
         
            return Absence::query()->whereBetween('date', [$this->from, $this->to])->where('location_id', 4)->orWhere('location_id', 5);  
         
         } else {
            return Absence::query()->whereBetween('date', [$this->from, $this->to]);
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
                'Terlambat/Absen',
                'Jam',
            ]
        ];
    }

    public function map($absence): array
    {
         if ($absence->type == 1) {
            $type = 'Absen';
         } elseif($absence->type == 2) {
            $type = 'Terlambat';
         } elseif($absence->type == 3) {
            $type = 'ATL';
         } elseif($absence->type == 4) {
            $type = 'Izin';
         } elseif($absence->type == 5) {
            $type = 'Cuti';
         } elseif($absence->type == 6) {
            $type = 'SPT';
         } elseif($absence->type == 7) {
            $type = 'Sakit';
         } elseif($absence->type == 8) {
            $type = 'Dinas Luar';
         } elseif($absence->type == 9) {
            $type = 'Off Kontrak';
         } 

         
         

        
            return [
               $absence->employee->nik,
               $absence->employee->biodata->first_name . ' ' . $absence->employee->biodata->last_name,
               formatDayName($absence->date),
               formatDate($absence->date),
               $type,
               $absence->minutes,
               
           ];
         
            
         

         // dd($overtime);
        
        
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
