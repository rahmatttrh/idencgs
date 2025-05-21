<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Project::create([
         'name' => 'Medco',
         
         'created_at' => NOW(),
         'updated_at' => NOW()
     ]);

      Project::create([
         'name' => 'Petrogas',
         
         'created_at' => NOW(),
         'updated_at' => NOW()
      ]);
      Project::create([
         'name' => 'Premier Oil',
         
         'created_at' => NOW(),
         'updated_at' => NOW()
      ]);
      Project::create([
         'name' => 'Star Energy',
         
         'created_at' => NOW(),
         'updated_at' => NOW()
      ]);
    }
}
