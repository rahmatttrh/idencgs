<?php

namespace App\Imports;

use App\Models\Additional;
use App\Models\Employee;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionReduction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayslipImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    protected $unitTransaction;

    public function __construct($unitTransaction)
    {
        $this->unitTransaction = $unitTransaction;
    }

    public function collection(Collection $rows)
    {


      foreach ($rows as $key => $row) {


         if ($row->filter()->isNotEmpty()) {
            $emp = Employee::where('nik', $row['nik'])->first();

            // dd($row);
            if ($emp) {
               $transaction = Transaction::create([
                  'status' => 0,
                  'unit_transaction_id' => $this->unitTransaction->id,
                  'unit_id' => $emp->unit_id,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'name' => $emp->biodata->first_name,
                  'payroll_id' => $emp->payroll->id,
                  'cut_from' => $this->unitTransaction->cut_from,
                  'cut_to' => $this->unitTransaction->cut_to,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'total' => 0,
                  'payslip_status' => $emp->payroll->payslip_status,

                  'reduction_absence' => $row['pot_hadir'],
                  'reduction_late' => $row['pot_disiplin'],
                  'overtime_qty' => $row['total_lembur'],
                  'overtime' => $row['upah_lembur'],
                  // 'overtime_rapel' => $row['RAPEL_LEMBUR'],

                  'total' => $row['total_thp']
                  
               ]);

               // Additional Tambahan
               Additional::create([
                  'type' => 1,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['subsidi'],
                  'desc' => 'Subsidi',
                  'transaction_id' => $transaction->id,
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 1,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['tunjangan'],
                  'desc' => 'Tunjangan'
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 1,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['rapel_lembur'],
                  'desc' => 'Rapel Lembur'
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 1,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['reimburse'],
                  'desc' => 'Reimburse'
               ]);


               $add_penambahan = $row['subsidi'] + $row['tunjangan'] + $row['rapel_lembur'] + $row['reimburse'];




               // Additional Potongan
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 2,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['pinjaman'],
                  'desc' => 'Pinjaman'
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 2,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['koperasi'],
                  'desc' => 'Koperasi'
               ]);

               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 2,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['bpjs_tk'],
                  'desc' => 'BPJS Ketenagakerjaan'
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 2,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['bpjs_kes'],
                  'desc' => 'BPJS Kesehatan'
               ]);
               Additional::create([
                  'transaction_id' => $transaction->id,
                  'type' => 2,
                  'location_id' => $emp->location_id,
                  'employee_id' => $emp->id,
                  'month' => $this->unitTransaction->month,
                  'year' => $this->unitTransaction->year,
                  'date' => $this->unitTransaction->cut_from,
                  'value' => $row['bpjs_jp'],
                  'desc' => 'BPJS JP'
               ]);

               $reduction = $row['bpjs_tk'] + $row['bpjs_kes'] + $row['bpjs_jp'];
               $add_pengurangan = $row['koperasi'] + $row['pinjaman'];

               $transaction->update([
                  'reduction' => $reduction,
                  'additional_pengurangan' => $add_pengurangan,
                  'additional_penambahan' => $add_penambahan,

               ]);
         
         
         
               // 
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Gaji Pokok',
                  'value' => $row['gp']
               ]);
         
               // 04 Create transaction detail Tunj Jabatan
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Tunj. Jabatan',
                  'value' => $row['tunjab']
               ]);
         
               // 05 Create transaction detail Tunj OPS
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Tunj. OPS',
                  'value' => $row['tunops']
               ]);
         
               // 06 Create transaction detail Tunj Kinerja
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Tunj. Kinerja',
                  'value' => $row['kinerja']
               ]);
         
               // 07 Create transaction detail Tunj Fungsional
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Tunj. Fungsional',
                  'value' => $row['fungsional']
               ]);
         
               // 08 Create transaction detail insentif
               TransactionDetail::create([
                  'transaction_id' => $transaction->id,
                  'type' => 'basic',
                  'desc' => 'Insentif',
                  'value' => 0
               ]);

               // TransactionReduction::create([
               //    'transaction_id' => $transaction->id,
               //    'reduction_id' => $red->reduction_id,
               //    'reduction_employee_id' => $red->id,
               //    'class' => $red->type,
               //    'type' => 'employee',
               //    'location_id' => $location,
               //    'name' => $red->reduction->name . $red->description,
               //    'value' => $red->employee_value,
               //    'value_real' => $red->employee_value_real,
               // ]);






            }
         }
      }
    }
}
