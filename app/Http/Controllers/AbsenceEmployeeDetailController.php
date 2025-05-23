<?php

namespace App\Http\Controllers;

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
      $absenceEmployeeDetail = AbsenceEmployeeDetail::find(dekripRambo($id));
      $absenceEmployeeDetail->delete();

      return redirect()->back()->with('success', 'Tanggal berhasil dihapus');
   }
}
