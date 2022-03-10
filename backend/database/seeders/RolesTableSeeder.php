<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \DB::statement('DELETE FROM roles');
    \DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1;');
    \DB::table('roles')->insert([			
      [
        'name'=>'superadmin',
        'guard_name'=>'api',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ],
      [
        'name'=>'admin',
        'guard_name'=>'api',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ],
      [
        'name'=>'picker',
        'guard_name'=>'api',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ],
      [
        'name'=>'checker',
        'guard_name'=>'api',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ],
      [
        'name'=>'handoffer',
        'guard_name'=>'api',
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now()
      ],			
    ]);
  }
}
