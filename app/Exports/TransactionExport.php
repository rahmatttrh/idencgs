<?php

namespace App\Exports;

use App\Models\Employee;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public $unitTransaction; 
    // public $loc; 
    // public $gender; 
    // public $type; 

    public function __construct($unitTransaction)
    {
        $this->unitTransaction = $unitTransaction;
        // $this->loc = $loc;
        // $this->gender = $gender;
        // $this->type = $type;

    }
    
    public function query()
    {
        return Location::query();
    }

    public function headings(): array
    {

                     
      $totalGrandHead = 0;
      $locations = Location::get();
      foreach($locations as $loc){
         if(count($loc->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)) > 0) {
            $bruto = $loc->getValueGaji($this->unitTransaction->unit_id, $this->unitTransaction) + $loc->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)->sum('overtime') + $loc->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)->sum('additional_penambahan');
            // $tk = 2/100 * $loc->getValueGaji($this->unitTransaction->unit_id, $this->unitTransaction);
            $tk = $loc->getReduction($this->unitTransaction->unit_id, $this->unitTransaction, 'JHT');
            $ks = $loc->getReduction($this->unitTransaction->unit_id, $this->unitTransaction, 'BPJS KS') + $loc->getReductionAdditional($this->unitTransaction->unit_id, $this->unitTransaction);
            $jp = $loc->getReduction($this->unitTransaction->unit_id, $this->unitTransaction, 'JP');
            $abs = $loc->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)->sum('reduction_absence');
            $late = $loc->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)->sum('reduction_late');

            $total = ($bruto) - ($tk + $ks + $jp + $abs + $late);
            
            $totalGrandHead += $total;
         } 
      }

   
   

        return [
            [
                $this->unitTransaction->unit->name,
            ],
            [
                formatRupiahB($totalGrandHead)
            ],
            [
                $this->unitTransaction->month,
                $this->unitTransaction->year,
            ],
            [
                '-'
            ],
            
            [
                'location',
                'Jumlah Pegawai',
                'Gaji Pokok',
                'Tunj. Jabatan',
                'Tunj. OPS',
                'Tunj. Kinerja',
                'Total Gaji',
                'Lembur',
                'Lain-lain',
                'Total Bruto',
               

                'BPJS Ketenagakerjaan',
                'BPJS Kesehatan',
                'JP',
                'Absen',
                'Terlambat',
                'Gaji Bersih',
                

            ],
            
        ];
    }

    public function map($location): array
    {

      if(count($location->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)) == 0) {
         return [];
      } 
        return [


            $location->name,
            count($location->getUnitTransaction($this->unitTransaction->unit_id, $this->unitTransaction)),
            formatRupiahB($location->getValue($this->unitTransaction->unit->id, $this->unitTransaction, 'Gaji Pokok')),
            formatRupiahB($location->getValue($this->unitTransaction->unit->id, $this->unitTransaction,  'Tunj. Jabatan')),
            formatRupiahB($location->getValue($this->unitTransaction->unit->id, $this->unitTransaction, 'Tunj. OPS')),
            formatRupiahB($location->getValue($this->unitTransaction->unit->id, $this->unitTransaction, 'Tunj. Kinerja')),

            formatRupiahB($location->getValueGaji($this->unitTransaction->unit->id, $this->unitTransaction)),
            formatRupiahB($location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('overtime')),
            formatRupiahB($location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('additional_penambahan')),
            formatRupiahB($location->getValueGaji($this->unitTransaction->unit->id, $this->unitTransaction) + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('overtime') + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('additional_penambahan')),

            formatRupiahB($location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'JHT')),
            
            formatRupiahB($location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'BPJS KS')),
            formatRupiahB($location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'JP')),
            formatRupiahB($location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('reduction_absence')),
            formatRupiahB($location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('reduction_late')),
            formatRupiahB(($location->getValueGaji($this->unitTransaction->unit->id, $this->unitTransaction) + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('overtime') + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('additional_penambahan')) - ($location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'JHT') + $location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'BPJS KS') + $location->getReduction($this->unitTransaction->unit->id, $this->unitTransaction, 'JP') + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('reduction_absence') + $location->getUnitTransaction($this->unitTransaction->unit->id, $this->unitTransaction)->sum('reduction_late') + $location->getReductionAdditional($this->unitTransaction->unit->id, $this->unitTransaction) ))
        ];
        
    }


}
