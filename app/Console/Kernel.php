<?php

namespace App\Console;

use App\Http\Controllers\CutiController;
use App\Models\Cuti;
use App\Models\Employee;
use App\Models\LogSystem;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         // $schedule->command('inspire')->hourly();
         $schedule->call(function(){
            // LogSystem::create([
            //    'type' => 'TEST',
            //    'modul' => 'Cuti',
               
            //    'desc' => 'Sistem otomatis memperbarui Periode Cuti ' 
            // ]);
            
            $cutis = Cuti::get();


            foreach($cutis as $cuti){
               $now = Carbon::now();

               $employee = Employee::find($cuti->employee_id);

               if ($employee) {
                  if ($cuti->end < $now) {

                     LogSystem::create([
                        'type' => 'TEST',
                        'modul' => 'Cuti',
                        'desc' => 'Sistem otomatis memperbarui Periode Cuti ' 
                     ]);
                     

                     $start = Carbon::create($cuti->start)->addYear(1);
                     $cuti->update([
                        'start' => $start
                     ]);

                     $end = $start->addYear(1);
                     $cuti->update([
                        'end' => $end,
                        'tahunan' => 12
                     ]);

                     if ($cuti->employee->contract->type == 'Tetap') {
                        $extend = Carbon::create($cuti->start)->addMonth(3);
                        $cuti->update([
                           'extend' => $cuti->sisa,
                           'expired' => $extend
                        ]);

                        $startDate = Carbon::parse($cuti->employee->contract->determination); // Or Carbon::createFromFormat('Y-m-d', '2019-05-07');
                        $endDate = Carbon::now();

                        $yearsDifference = $startDate->diffInYears($endDate);
                        $year = $yearsDifference / 5;

                        $cuti->update([
                           'masa_kerja' => $year * 2,
                           // 'expired' => $extend
                        ]);
                     }

                     $cutiController = new CutiController();
                     $cutiController->calculateCuti($cuti->id);

                     LogSystem::create([
                        'type' => 'System',
                        'modul' => 'Cuti',
                        'employee_id' => $cuti->employee_id,
                        'target_id' => $cuti->id,
                        'desc' => 'Sistem otomatis memperbarui Periode Cuti ' . $cuti->emoloyee->nik . ' ' . $cuti->employee->biodata->fullName()
                     ]);
                  }
               }
            }

         })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
