<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingHistoryController extends Controller
{
   public function index(){
      // dd('ok')
      $trainingHistories = TrainingHistory::orderBy('updated_at', 'desc')->get();
      return view('pages.training.history.index', [
         'trainingHistories' => $trainingHistories
      ]);
   }

   public function create(){
      $employees = Employee::where('status', 1)->get();
      $trainings = Training::get();
      return view('pages.training.history.create', [
         'employees' => $employees,
         'trainings' => $trainings
      ]);
   }

   public function store(Request $req){
      $req->validate([

      ]);

      if (request('doc')) {
         
         $doc = request()->file('doc')->store('doc/employee/training');
      }  else {
         $doc = null;
      }

      TrainingHistory::create([
         'status' => 1,
         'type' => $req->type,
         'type_sertificate' => $req->type_sertificate,
         'employee_id' => $req->employee,
         'training_id' => $req->training,
         'periode' => $req->periode,
         'doc' => $req->sertifikat,
         'vendor' => $req->vendor,
         'expired' => $req->expired,
         'doc' => $doc ,
      ]);

      return redirect()->route('training.history')->with('success', 'Training History added');
   }


   public function edit($id){
      $trainingHistory = TrainingHistory::find(dekripRambo($id));
      $employees = Employee::where('status', 1)->get();
      $trainings = Training::get();
      return view('pages.training.history.edit', [
         'trainingHistory' => $trainingHistory,
         'employees' => $employees,
         'trainings' => $trainings
      ]);


   }


   public function update(Request $req){
      $req->validate([
         
      ]);
      $trainingHistory = TrainingHistory::find($req->history);

      if (request('doc')) {
         Storage::delete($trainingHistory->doc);
         $doc = request()->file('doc')->store('images/employee/training');
      } elseif ($trainingHistory->doc) {
         $doc = $trainingHistory->doc;
      } else {
         $doc = null;
      }

      
      $trainingHistory->update([
         'type' => $req->type,
         'type_sertificate' => $req->type_sertificate,
         'employee_id' => $req->employee,
         'training_id' => $req->training,
         'periode' => $req->periode,
         'doc' => $req->sertifikat,
         'vendor' => $req->vendor,
         'expired' => $req->expired,
         'doc' => $doc ,
      ]);

      return redirect()->route('training.history')->with('success', 'Training History updated');

   }


   public function delete($id){
      $trainingHistory = TrainingHistory::find(dekripRambo($id));

      Storage::delete($trainingHistory->doc);
      $trainingHistory->delete();

      return redirect()->route('training.history')->with('success', 'Training History deleted');

   }
}
