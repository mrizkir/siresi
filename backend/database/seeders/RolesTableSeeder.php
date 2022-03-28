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

    $role = Role::findByName('admin');
      $records=[
        'DASHBOARD_SHOW',
        'TRANSAKSI-GROUP',

        'TRANSAKSI-RESI_BROWSE',
        'TRANSAKSI-RESI_SHOW',
        'TRANSAKSI-RESI_STORE',
        'TRANSAKSI-RESI_UPDATE', 
        
        'TRANSAKSI-ADMIN-SCAN-RESI_BROWSE',
        'TRANSAKSI-ADMIN-SCAN-RESI_SHOW',
        'TRANSAKSI-ADMIN-SCAN-RESI_STORE',
        'TRANSAKSI-ADMIN-SCAN-RESI_UPDATE',        
        
        'SETTING-VARIABLES_BROWSE',
        'SETTING-VARIABLES_SHOW',
        'SETTING-VARIABLES_STORE',
        'SETTING-VARIABLES_UPDATE',

        'SETTING-PENGGUNA-PICKER_BROWSE',
        'SETTING-PENGGUNA-PICKER_SHOW',
        'SETTING-PENGGUNA-PICKER_STORE',
        'SETTING-PENGGUNA-PICKER_UPDATE',

        'REPORT-GROUP',
    ];
    $role->syncPermissions($records);
    
    $role = Role::findByName('checker');
      $records=[
        'DASHBOARD_SHOW',
        'TRANSAKSI-GROUP',
        
        'TRANSAKSI-RESI_BROWSE',
        'TRANSAKSI-RESI_SHOW',
        'TRANSAKSI-RESI_STORE',
        'TRANSAKSI-RESI_UPDATE', 

        'TRANSAKSI-CHECKER-SCAN-RESI_BROWSE',
        'TRANSAKSI-CHECKER-SCAN-RESI_SHOW',
        'TRANSAKSI-CHECKER-SCAN-RESI_STORE',
        'TRANSAKSI-CHECKER-SCAN-RESI_UPDATE',        

        'REPORT-GROUP',
    ];
    $role->syncPermissions($records);

    $role = Role::findByName('handoffer');
      $records=[
        'DASHBOARD_SHOW',
        'TRANSAKSI-GROUP',

        'TRANSAKSI-RESI_BROWSE',
        'TRANSAKSI-RESI_SHOW',
        'TRANSAKSI-RESI_STORE',
        'TRANSAKSI-RESI_UPDATE', 

        'TRANSAKSI-HANDOFFER-SCAN-RESI_BROWSE',
        'TRANSAKSI-HANDOFFER-SCAN-RESI_SHOW',
        'TRANSAKSI-HANDOFFER-SCAN-RESI_STORE',
        'TRANSAKSI-HANDOFFER-SCAN-RESI_UPDATE', 
        
        'REPORT-GROUP',
    ];
    $role->syncPermissions($records);
  }
}
