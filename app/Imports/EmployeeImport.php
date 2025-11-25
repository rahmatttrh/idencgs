<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\Biodata;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Educational;
use App\Models\Emergency;
use App\Models\Employee;
use App\Models\Position;
use App\Models\SubDept;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Str;


class EmployeeImport implements ToCollection, WithHeadingRow
{
   public function collection(Collection $rows)
   {
      // dd('ok');
      foreach ($rows as $key => $row) {
         // dd($rows);
         if($row->filter()->isNotEmpty()){
            $employeeExist = Employee::where('nik', $row['nik'])->first();

            if ($employeeExist) {
               $employeeExist->biodata->update([
               
                  'first_name' => $row['first_name'] ,
                  'last_name' => $row['last_name'],
                  'email' => $row['email'],
                  'phone' => $row['phone'],
                  'gender' => $row['gender'],
                  'religion' => $row['agama'], //agama
                  'birth_place' => $row['tempat_lahir'], //
                  'birth_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])), //tanggal lahir
                  'no_ktp' => $row['no_ktp'],
                  'no_npwp' => $row['no_npwp'], //
                  'no_kk' => $row['no_kk'], //
                  'no_bpjs_kesehatan' => $row['no_bpjs_kesehatan'], // bpjs
                  'no_jamsostek' => $row['no_jamsostek'], //
                  'marital' => $row['status_nikah'], // status nikah 
                  'last_education' => $row['pendidikan_terakhir'], //pendidikan terakhir
                  'institution_name' => $row['nama_institusi'], // nama institusi
                  'vocational' => $row['jurusan'], //jurusan
                  'status_pajak' => $row['status_pajak'], //
                  'blood' => $row['gol_darah'], //golongan darah
                  'address' => $row['alamat_domisili'], //alamat domisili
                  'alamat_ktp' => $row['alamat_ktp'], //alamat ktp
                  'nationality' => $row['nationality'],
                  'citizenship' => $row['citizenship'],
                  'city' => $row['city'],
                  'state' => $row['state'],
                  'created_at' => NOW(),
                  'updated_at' => NOW() //
               ]);

               $existEdus = Educational::where('employee_id', $employeeExist->id)->get();
               $existEmers = Emergency::where('employee_id', $employeeExist->id)->get();
               $existBanks = BankAccount::where('employee_id', $employeeExist->id)->get();
               // dd($existEdu);
               if ($existEdus) {
                  foreach ($existEdus as $edu) {
                     $edu->delete();
                  }
               } 
               if ($existEmers) {
                  foreach($existEmers as $emer){
                     $emer->delete();
                  }
               } 
               if ($existBanks) {
                  foreach($existBanks as $acbank){
                     $acbank->delete();
                  }
               } 

               Educational::create([
                  'employee_id' => $employeeExist->id,
                  'degree' => $row['pendidikan_terakhir'],
                  'major' => $row['jurusan'],
                  'name' =>  $row['nama_institusi'],
               ]);
               Emergency::create([
                  'employee_id' => $employeeExist->id,
                  'name' => $row['nama_kontak_darurat'],
                  'phone' => $row['kontak_darurat'],
                  'hubungan' => $row['hubungan'],
                  'created_at' => NOW(),
                  'updated_at' => NOW()
               ]);
               $bank = Bank::where('name', $row['bank'])->first();
               if ($bank == null) {
                  if ($row['bank'] != null) {
                     $bankCurrent = Bank::create([
                        'name' => $row['bank'],
                        'color' => 'primary'
                     ]);
                  }
                  
               } else {
                  $bankCurrent = $bank;
               }

               if ($row['bank'] != null){
                  BankAccount::create([
                     'employee_id' => $employeeExist->id,
                     'bank_id' => $bankCurrent->id,
                     'account_no' => $row['no_rekening']
                  ]);
               }
               

               // dd($employeeExist->biodata->birth_place);
   
               $employeeExist->contract->update([
                  'id_no' => $row['nik'],
                  'type' => $row['type'],
                  'location' => $row['lokasi'],
                  'project' => $row['project'],
                  // 'unit_id' => $unit->id,
                  // 'department_id' => $department->id,
                  // 'designation_id' => $designation->id,
                  // 'sub_dept_id' => $sub_dept->id,
                  // 'position_id' => $position->id,
                  'start' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_awal_kontrak'])),
                  'end' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_akhir_kontrak'])),
                  'determination' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_penetapan'])),
                  // 'salary' => $row['salary'],
                  // 'payslip' => $row['payslip_type'],
                  'created_at' => NOW(),
                  'updated_at' => NOW()
               ]);
   
               // Insert Contract udah Oke
               

               // dd($employeeExist->emergency_id);
               
   
               $employeeExist->update([
                  // 'status' => 0, 
                  'nik' => $row['nik'],
                  'join' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk'])),
                  'determination_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_penetapan'])),
                  'seragam' =>$row['ukuran_seragam'],
                  'created_at' => NOW(),
                  'updated_at' => NOW()
   
               ]);

               // dd('ok');


            } else {

               
            
               // Cari bis nis unid 
               $unit = Unit::where('name', $row['business_unit'])->first();
               // dd($row['nik'] . ' ' . $row['first_name']);
               // Jika tidak ada insert baru
               if ($unit == null) {
                  $unit = Unit::create([
                     'name' => $row['business_unit'],
                     'created_at' => NOW(),
                     'updated_at' => NOW()
                  ]);
               }

               // Cari departement
               $department = Department::where('name', $row['department'])
                  ->where('unit_id', $unit->id)
                  ->first();
               // Jika tidak ada insert baru
               if ($department == null) {

                  $department = Department::create([
                     'unit_id' => $unit->id,
                     'name' => $row['department'],
                     'created_at' => NOW(),
                     'updated_at' => NOW()
                  ]);
               }

               // Cari sub departement
               // $sub_dept = SubDept::where('name', $row['sub_dept'])
               //    ->where('department_id', $department->id)
               //    ->first();
               // Jika tidak ada insert baru
               // if ($sub_dept == null) {

                  $sub_dept = SubDept::create([
                     'department_id' => $department->id,
                     'name' => $department->name,
                     'created_at' => NOW(),
                     'updated_at' => NOW()
                  ]);
               // }

               // Designation atau level
               $designation = Designation::where('slug', $row['designation'])->first();
               if ($designation == null) {
                  $designation = Designation::create([
                     'name' => Str::title(str_replace('-', ' ', $row['designation'])),
                     'slug' => $row['designation']
                  ]);
               }

               // Mencari position 
               $position = Position::where('name', $row['position'])->where('sub_dept_id', $sub_dept->id)->where('designation_id', $designation->id)->first();
               // jika tidak ada insert baru 
               if ($position == null) {

                  $position = Position::create([
                     'sub_dept_id' => $sub_dept->id,
                     'designation_id' => $designation->id,
                     'name' => $row['position'],
                     'created_at' => NOW(),
                     'updated_at' => NOW()
                  ]);
               }

               if ($row['email'] == null) {
                  $row['email'] = $key . '-' . time() . '@empty.com';
               }

               // Mencari Role 
               // if ($row['golongan'] == '1' || $row['golongan'] == '2') {
               //    $role = 3;
               // } else if ($row['golongan'] == '3' || $row['golongan'] == '4') {
               //    $role = 4;
               // } else if ($row['golongan'] == '5' || $row['golongan'] == '6'  || $row['golongan'] == '7') {
               //    $role = 5;
               // }
               $biodata = Biodata::create([
                  'status' => 0,
                  'first_name' => $row['first_name'] ,
                  'last_name' => $row['last_name'],
                  'email' => $row['email'],
                  'phone' => $row['phone'],
                  'gender' => $row['gender'],
                  'religion' => $row['agama'], //agama
                  'birth_place' => $row['tempat_lahir'], //
                  'birth_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])), //tanggal lahir
                  'no_ktp' => $row['no_ktp'],
                  'no_npwp' => $row['no_npwp'], //
                  'no_kk' => $row['no_kk'], //
                  'no_bpjs_kesehatan' => $row['no_bpjs_kesehatan'], // bpjs
                  'no_jamsostek' => $row['no_jamsostek'], //
                  'marital' => $row['status_nikah'], // status nikah 
                  'last_education' => $row['pendidikan_terakhir'], //pendidikan terakhir
                  'institution_name' => $row['nama_institusi'], // nama institusi
                  'vocational' => $row['jurusan'], //jurusan
                  'status_pajak' => $row['status_pajak'], //
                  'blood' => $row['gol_darah'], //golongan darah
                  'address' => $row['alamat_domisili'], //alamat domisili
                  'alamat_ktp' => $row['alamat_ktp'], //alamat ktp
                  'nationality' => $row['nationality'],
                  'citizenship' => $row['citizenship'],
                  'city' => $row['city'],
                  'state' => $row['state'],
                  'created_at' => NOW(),
                  'updated_at' => NOW() //
   
               ]);

              


   
               $contract = Contract::create([
                  'type' => $row['type'],
                  'id_no' => $row['nik'],
                  'unit_id' => $unit->id,
                  'department_id' => $department->id,
                  'sub_dept_id' => $sub_dept->id,
                  'designation_id' => $designation->id,
                  'sub_dept_id' => $sub_dept->id,
                  'position_id' => $position->id,
                  // 'designation_id' => $designation->id,
                  // 'location' => $row['lokasi'],
                  // 'project' => $row['project'],
                  'start' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_awal_kontrak'])),
                  'end' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_akhir_kontrak'])),
                  'determination' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_penetapan'])),
                  // 'salary' => $row['salary'],
                  // 'payslip' => $row['payslip_type'],
                  'created_at' => NOW(),
                  'updated_at' => NOW()
               ]);
   
               // Insert Contract udah Oke
               $emergency = Emergency::create([
                  'name' => $row['nama_kontak_darurat'],
                  'phone' => $row['kontak_darurat'],
                  'hubungan' => $row['hubungan'],
                  'created_at' => NOW(),
                  'updated_at' => NOW()
               ]);
   
               
               $employee = Employee::create([
                  'status' => 0,
                  // 'role' => $role,
                  'unit_id' => $unit->id,
                  'department_id' => $department->id,
                  'sub_dept_id' => $sub_dept->id,
                  'designation_id' => $designation->id,
                  'position_id' => $position->id,
                  'biodata_id' => $biodata->id,
                  'contract_id' => $contract->id,
                  // 'emergency_id' => $emergency->id,
                  'nik' => $row['nik'],
                  'join' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_masuk'])),
                  'determination_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_penetapan'])),
                  'seragam' =>$row['ukuran_seragam'],
                  
                  'created_at' => NOW(),
                  'updated_at' => NOW()
   
               ]);

               if ($row['pendidikan_terakhir'] != null) {
                  Educational::create([
                     'employee_id' => $employee->id,
                     'degree' => $row['pendidikan_terakhir'],
                     'major' => $row['jurusan'],
                     'name' =>  $row['nama_institusi'],
                  ]);
               }

               if ($row['nama_kontak_darurat'] != null) {
                  Emergency::create([
                     'employee_id' => $employee->id,
                     'name' => $row['nama_kontak_darurat'],
                     'phone' => $row['kontak_darurat'],
                     'hubungan' => $row['hubungan'],
                     'created_at' => NOW(),
                     'updated_at' => NOW()
                  ]);
               }
              
               
               $bank = Bank::where('name', $row['bank'])->first();
               if ($bank == null) {
                  if ($row['bank'] != null) {
                     $bankCurrent = Bank::create([
                        'name' => $row['bank'],
                        'color' => 'primary'
                     ]);
                  }
                  
               } else {
                  $bankCurrent = $bank;
               }

               if ($row['bank'] != null){
                  BankAccount::create([
                     'employee_id' => $employee->id,
                     'bank_id' => $bankCurrent->id,
                     'account_no' => $row['no_rekening']
                  ]);
               }

            }
            

         }
      }
   }
}
