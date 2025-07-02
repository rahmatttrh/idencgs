<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollHistoryController extends Controller
{
   public function store(Request $req){
      $req->validate([]);
      
      $payroll = Payroll::find($req->payroll);


   }
}
