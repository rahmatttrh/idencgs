<?php

namespace App\Imports;

use App\Models\Cuti;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CutiImport implements ToCollection,  WithHeadingRow
{
   /**
 * @param Collection $collection
   */
   public function collection(Collection $collection)
   {
      foreach ($collection as $key => $row) {
         if($row->filter()->isNotEmpty()){
            $employee = Employee::where('nik', $row['nik'])->first();
            $cuti = Cuti::where('employee_id', $employee->id)->first();
            $totalCuti = $row['cuti_tahunan']+ $row['cuti_masa_kerja'] + $row['cuti_extend'];
            if ($cuti) {
               $cuti->update([
                  'start' => $row['berlaku'],
                  'end' => $row['expired'],
                  'tahunan' => $row['cuti_tahunan'],
                  'masa_kerja' => $row['cuti_masa_kerja'],
                  'extend' => $row['cuti_extend'],
                  'expired' => $row['cuti_extend_expired'],
                  'total' => $totalCuti,
                  'used' => $row['cuti_dipakai'],
                  'sisa' => $totalCuti - $row['cuti_dipakai']
               ]);
            } else {
               Cuti::create([
                  'employee_id' => $employee->id,
                  'start' => $row['berlaku'],
                  'end' => $row['expired'],
                  'tahunan' => $row['cuti_tahunan'],
                  'masa_kerja' => $row['cuti_masa_kerja'],
                  'extend' => $row['cuti_extend'],
                  'expired' => $row['cuti_extend_expired'],
                  'total' => $totalCuti,
                  'used' => $row['cuti_dipakai'],
                  'sisa' => $totalCuti - $row['cuti_dipakai']
               ]);
            }
         }
      }
   }
}
