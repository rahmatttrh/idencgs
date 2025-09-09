<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Employee;
use App\Models\Log;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
       $employees = Employee::where('status', 1)->get();
       $announcements = Announcement::get();
       return view('pages.announcement.index', [
          'employees' => $employees,
          'announcements' => $announcements
       ])->with('i');
    }
 
    public function create()
    {
       $employees = Employee::where('status', 1)->get();
       $units = Unit::get();
       return view('pages.announcement.create', [
          'employees' => $employees,
          'units' => $units
       ])->with('i');
    }
 
    public function store(Request $req)
    {
        $req->validate([]);
        // dd($req->body);

        if ($req->type == 2) {
            $req->validate([
                'employee' => 'required'
            ]);
        }

         if ($req->type == 3) {
            $req->validate([
               'unit' => 'required'
            ]);
         }

         if (request('doc')) {
            $doc = request()->file('doc')->store('doc/announcement');
         }  else {
            $doc = null;
         }

         
 
       Announcement::create([
          'type' => $req->type,
          'employee_id' => $req->employee,
          'unit_id' => $req->unit,
          'status' => 1,
          'title' => $req->title,
          'body' => $req->body,
          'doc' => $doc
       ]);
 
       if (auth()->user()->hasRole('Administrator')) {
          $departmentId = null;
       } else {
          $user = Employee::find(auth()->user()->getEmployeeId());
          $departmentId = $user->department_id;
       }
       Log::create([
          'department_id' => $departmentId,
          'user_id' => auth()->user()->id,
          'action' => 'Create',
          'desc' => 'Announcement ' . $req->title
       ]);
 
       return redirect()->route('announcement')->with('success', 'Announcement successfully created');
    }

    public function delete($id){
        $announce = Announcement::find(dekripRambo($id));
  
        Storage::delete($announce->doc);
        $announce->delete();
  
        return redirect()->route('announcement')->with('success', 'Data Announcement berhasil dihapus');
      }
 
    public function detail($id)
    {
       $announcement = Announcement::find(dekripRambo($id));
       return view('pages.announcement.detail', [
          'announcement' => $announcement
       ])->with('i');
    }

    // public function delete($id){
    //   $announce = Announcement::find(dekripRambo($id));

    //   Storage::delete($announce->doc);
    //   $announce->delete();

    //   return redirect()->route('announcement')->with('success', 'Data Announcement berhasil dihapus');
    // }
 
 
 
    public function activate($id)
    {
       $announcement = Announcement::find(dekripRambo($id));
 
       $announcement->update([
          'status' => 1
       ]);
 
       return redirect()->back()->with('success', 'Announcement successfully activated, akan muncul pada Dashboard Employee');
    }
 
    public function deactivate($id)
    {
       $announcement = Announcement::find(dekripRambo($id));
 
       $announcement->update([
          'status' => 0
       ]);
 
       return redirect()->back()->with('success', 'Announcement successfully deactivated');
    }
 }
