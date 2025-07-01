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
      $trainingHistories = TrainingHistory::get();
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

      TrainingHistory::create([
         'status' => 1,
         'employee_id' => $req->employee,
         'training_id' => $req->training,
         'periode' => $req->periode,
         'doc' => $req->sertifikat,
         'vendor' => $req->vendor,
         'expired' => $req->expired
      ]);

      return redirect()->route('training.history')->with('success', 'Training History added');
   }

   public function delete($id){
      $trainingHistory = TrainingHistory::find(dekripRambo($id));

      Storage::delete($trainingHistory->doc);
      $trainingHistory->delete();

      return redirect()->route('training.history')->with('success', 'Training History deleted');

   }
}
