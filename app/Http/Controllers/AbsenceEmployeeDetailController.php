<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceEmployee;
use App\Models\AbsenceEmployeeDetail;
use Illuminate\Http\Request;

class AbsenceEmployeeDetailController extends Controller
{
   public function store(Request $req){
      $absEmp = AbsenceEmployee::find($req->absence_employee);
      if ($absEmp->permit_id != null) {
         $max = $absEmp->permit->qty;
         // dd($max);
         $currentDetails = AbsenceEmployeeDetail::where('absence_employee_id', $absEmp->id)->get();
         // dd(count($currentDetails));
         if (count($currentDetails) == $max || count($currentDetails) > $max) {
            return redirect()->back()->with('danger', 'Failed, Anda telah mencapai maksimal jumlah hari untuk Izin '. $absEmp->permit->name);
         }
      }

      $absence = Absence::where('employee_id', $absEmp->employee_id)->where('date', $req->date)->where('type', '!=', 1)->first();
      
      
      
     
      

      if ($absence) {
         if($absence->type == 2) {
            $title = 'Terlambat' ;
         } elseif($absence->type == 3){
            $title = 'ATL' ;
         } elseif($absence->type == 4){
            $title = 'Izin' ;
         }  elseif($absence->type == 5){
            $title = 'Cuti' ;
         } elseif($absence->type == 6){
            $title = 'SPT' ;
         } elseif($absence->type == 7){
            $title = 'Sakit' ;
         } elseif($absence->type == 8){
            $title = 'Dinas Luar' ;
         } elseif($absence->type == 9){
            $title = 'Off Kontrak' ;
         } elseif($absence->type == 10){
            $title = 'Izin Resmi' ;
         } else {
            $title = '';
         }
         return redirect()->back()->with('danger', 'Duplikat data absensi pada tanggal tersebut - '. $title . ' ' . formatDate($absence->date)) ;
      }

      AbsenceEmployeeDetail::create([
         'absence_employee_id' => $req->absence_employee,
         'date' => $req->date
      ]);

      return redirect()->back()->with('success', 'Tanggal berhasil ditambahkan');
   }

   public function update(Request $req){
      $absenceEmployeeDetail = AbsenceEmployeeDetail::find($req->detail);

      $absenceEmployeeDetail->update([
         'date' => $req->date,
         'remark' => $req->remark
      ]);


     return redirect()->back()->with('success', 'Tanggal berhasil diubah');
   }

   public function delete($id){
      // dd('ok');
      $absenceEmployeeDetail = AbsenceEmployeeDetail::find(dekripRambo($id));
      $absenceEmployeeDetail->delete();

      return redirect()->back()->with('success', 'Tanggal berhasil dihapus');
   }
}
