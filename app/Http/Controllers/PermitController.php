<?php

namespace App\Http\Controllers;

use App\Models\Perdin;
use App\Models\Permit;
use Illuminate\Http\Request;

class PermitController extends Controller
{
   public function index(){
      $permits = Permit::get();
      return view('pages.permit.index', [
         'permits' => $permits
      ]);
   }

   public function store(Request $req){
      $req->validate([

      ]);

      Permit::create([
         'name' => $req->name,
         'desc' => $req->desc,
         'qty' => $req->qty
      ]);


      return redirect()->back()->with('success', 'Data Izin Resmi berhasil disimpan');
   }

   public function update(Request $req){
      $req->validate([

      ]);

      $permit = Permit::find($req->permit);
      $permit->update([
         'name' => $req->name,
         'desc' => $req->desc,
         'qty' => $req->qty
      ]);

      return redirect()->back()->with('success', 'Data Izin Resmi berhasil diubah');
   }
}
