<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
   public function index(){
      return view('pages.project.index', [
         'projects' => Project::get()
      ]);
   }

   public function store(Request $req){
      $req->validate([

      ]);

      Project::create([
         'name' => $req->name,
         'code' => $req->code
      ]);

      return redirect()->back()->with('success', 'Project baru berhasil disimpan');
   }
}
