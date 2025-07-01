<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
   public function index(){
      $trainings = Training::get();
      return view('pages.training.index', [
         'trainings' => $trainings
      ]);
   }


   public function store(Request $req){
      $req->validate([]);

      Training::create([
         'level' => $req->level,
         'title' => $req->title,
         'desc' => $req->desc
      ]);

      return redirect()->back()->with('success', 'Training added');
   }
}
