<?php

namespace App\Http\Controllers;

use App\Models\AbsenceEmployeeDetail;
use Illuminate\Http\Request;

class AbsenceEmployeeDetailController extends Controller
{
   public function store(Request $req){
      AbsenceEmployeeDetail::create([
         'absence_employee_id' => $req->absence_employee,
         'date' => $req->date
      ]);

      return redirect()->back()->with('success', 'Tanggal berhasil ditambahkan');
   }

   public function delete($id){
      $absenceEmployeeDetail = AbsenceEmployeeDetail::find(dekripRambo($id));
      $absenceEmployeeDetail->delete();

      return redirect()->back()->with('success', 'Tanggal berhasil dihapus');
   }
}
