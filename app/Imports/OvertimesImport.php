<?php

namespace App\Imports;

use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\TransactionController;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Overtime;
use App\Models\Payroll;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OvertimesImport implements ToCollection,  WithHeadingRow
{
   /**
 * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
   public function collection(Collection $rows)
   {
      foreach ($rows as $key => $row) {
         

         $overtimeController = new OvertimeController;

         if($row->filter()->isNotEmpty()){

            $employee = Employee::where('nik', $row['nik'])->first();
            // dd($employee);
            $spkl_type = $employee->unit->spkl_type;
            $hour_type = $employee->unit->hour_type;
            $payroll = Payroll::find($employee->payroll_id);

            $locations = Location::get();
            $locId = null;
            foreach ($locations as $loc) {
                if ($employee->contract->loc == $loc->code) {
                $locId = $loc->id;
                }
            }

            if ($row['tipe_libur'] == 'Masuk') {
                $holidayType = 1;
            } elseif($row['tipe_libur'] == 'Libur') {
                $holidayType = 2;
            } elseif($row['tipe_libur'] == 'Libur Nasional') {
                $holidayType = 3;
            } elseif($row['tipe_libur'] == 'Idhul Fitri') {
                $holidayType = 4;
            }

            if ($row['type'] == 'Lembur') {
                $type = 1;
            } elseif($row['type'] == 'Piket'){
                $type = 2;
            }

            // $hoursFinal = 0;
            // if ($holidayType == 1) {
            //    $finalHour = $row['hours'];
            //    if ($hour_type == 2) {
            //       // dd('test');
            //       $multiHours = $row['hours'] - 1;
            //       $finalHour = $multiHours * 2 + 1.5;
            //       // dd($finalHour);
            //    }
            // } elseif ($holidayType == 2) {
            //    $finalHour = $row['hours'] * 2;
            // } elseif ($holidayType == 3) {
            //    $finalHour = $row['hours'] * 2;
            // } elseif ($holidayType == 4) {
            //    $finalHour = $row['hours'] * 3;
            // }

            // if ($type == 1) {
            //    $finalHour = $finalHour;
            // } else {

            // }

            if ($holidayType == 1) {
               $finalHour = $row['hours'];
               if ($hour_type == 2) {
                  // dd('test');
                  $multiHours = $row['hours'] - 1;
                  $finalHour = $multiHours * 2 + 1.5;
                  // dd($finalHour);
               }
            } elseif ($holidayType == 2) {
               $finalHour = $row['hours'] * 2;
            } elseif ($holidayType == 3) {
               $finalHour = $row['hours'] * 2;
               // $employee = Employee::where('payroll_id', $payroll->id)->first();
                  if ($employee->unit_id ==  7 || $employee->unit_id ==  8 || $employee->unit_id ==  9) {
                     // dd('ok');
                     if ($row['hours'] <= 7) {
                        $finalHour = $row['hours'] * 2;
                     } else{
                        // dd('ok');
                        $hours7 = 14;
                        $sisa1 = $row['hours'] - 7;
                        $hours8 = 3;
                        if ($sisa1 > 1) {
                           $sisa2 = $sisa1 - 1;
                           $hours9 = $sisa2 * 4;
                        } else {
                           $hours9 = 0;
                        }
         
                        $finalHour = $hours7 + $hours8 + $hours9;
                        // dd($finalHour);
      
                     }
                  } else {
                     if ($row['hours'] <= 8) {
                        $finalHour = $row['hours'] * 2;
                     } else{
                        $hours8 = 16;
                        $sisa1 = $row['hours'] - 8;
                        $hours9 = 3;
                        if ($sisa1 > 1) {
                           $sisa2 = $sisa1 - 1;
                           $hours10 = $sisa2 * 4;
                        } else {
                           $hours10 = 0;
                        }
         
                        $finalHour = $hours8 + $hours9 + $hours10;
                     }
                  }
            } elseif ($holidayType == 4) {
               $finalHour = $row['hours'] * 3;
            }
      
            if ($type == 1) {
               $finalHour = $finalHour;
            } else {
      
            }

            // dd('ok');
            if ($payroll) {
               // dd('ok');
                // $this->calculateRate($payroll, $req->type, $spkl_type, $hour_type, $req->hours, $req->holiday_type);
                $rate = $overtimeController->calculateRate($payroll, $type, $spkl_type, $hour_type, $row['hours'], $holidayType);
                //  dd($rate);
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
                //  dd($date->format('Y'));
                $date = Carbon::create($date);
                // dd($date->format('Y'));
                $currentOvertime = Overtime::where('employee_id', $employee->id)->where('date', $date)->where('type', $type)->where('description', $row['note'] )->first();

                if (!$currentOvertime) {
                    $overtime = Overtime::create([
                        'status' => 0,
                        'location_id' => $locId,
                        'employee_id' => $employee->id,
                        'month' => $date->format('F'),
                        'year' => $date->format('Y'),
                        'date' => $date->format('Y-m-d'),
                        'type' => $type,
                        'hour_type' => $hour_type,
                        'holiday_type' => $holidayType,
                        'hours' => $row['hours'],
                        'hours_final' => $finalHour,
                        'rate' => round($rate),
                        'description' => $row['note'],
                        // 'doc' => $doc
                    ]);

                  //   dd('oke');
                  //   $transactionCon = new TransactionController;
                  //   $transactions = Transaction::where('status', '!=', 3)->where('employee_id', $employee->id)->get();

                  //   foreach($transactions as $tran){
                  //       $transactionCon->calculateTotalTransaction($tran, $tran->cut_from, $tran->cut_to);
                  //   }

                }
            
            }
            
         }
      }
      
      
   }
}
