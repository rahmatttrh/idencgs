<?php

namespace App\Imports;

use App\Http\Controllers\CutiController;
use App\Models\Cuti;
use App\Models\Employee;
use App\Http\Controllers\CutiController;
use Carbon\Carbon;
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

            // dd($row['berlaku']);
            $berlaku = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['berlaku']))->format('Y-m-d');
            // dd($berlaku);
            $berlakuDate = Carbon::create($berlaku);
            $expired = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['expired']))->format('Y-m-d');
            $expiredDate = Carbon::create($expired);
            $extend = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['cuti_extend_expired']))->format('Y-m-d');
            $extendDate = Carbon::create($extend);
            if ($cuti != null) {
               
               $cuti->update([
                  'start' => $berlakuDate->format('Y-m-d'),
                  'end' => $expiredDate->format('Y-m-d'),
                  'start' => $berlakuDate->format('Y-m-d'),
                  'end' => $expiredDate->format('Y-m-d'),
                  'tahunan' => $row['cuti_tahunan'],
                  'masa_kerja' => $row['cuti_masa_kerja'],
                  'extend' => $row['cuti_extend'],
                  'expired' => $extendDate->format('Y-m-d'),
                  'expired' => $extendDate->format('Y-m-d'),
                  // 'sisa' => $totalCuti - $row['cuti_dipakai']
               ]);
               
            } else {
               $cuti = Cuti::create([
                  'employee_id' => $employee->id,
                  'start' => $berlakuDate->format('Y-m-d'),
                  'end' => $expiredDate->format('Y-m-d'),
                  'start' => $berlakuDate->format('Y-m-d'),
                  'end' => $expiredDate->format('Y-m-d'),
                  'tahunan' => $row['cuti_tahunan'],
                  'masa_kerja' => $row['cuti_masa_kerja'],
                  'extend' => $row['cuti_extend'],
                  'expired' => $extendDate->format('Y-m-d'),
                  'expired' => $extendDate->format('Y-m-d'),
               ]);

               
            }

            $cutiCon = new CutiController;
            $cutiCon->calculateCuti($cuti->id);
         }
      }
   }
}
