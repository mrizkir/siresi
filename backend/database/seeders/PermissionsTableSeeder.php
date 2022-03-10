<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::statement('DELETE FROM permissions');
		\DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1;');

		\DB::table('permissions')->insert([
			'name'=>"DASHBOARD_SHOW",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);		

		\DB::table('permissions')->insert([
			'name'=>"TRANSAKSI-GROUP",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);		

		\DB::table('permissions')->insert([
			'name'=>"REPORT-GROUP",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);		

		\DB::table('permissions')->insert([
			'name'=>"SETTING-GROUP",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);						

		$modules = [
			'TRANSAKSI-RESI',
			'SETTING-VARIABLES',
			'SETTING-PENGGUNA-PERMISSIONS',
			'SETTING-PENGGUNA-ROLES',						
			'SETTING-PENGGUNA-ADMIN',
			'SETTING-PENGGUNA-PICKER',
			'SETTING-PENGGUNA-CHECKER',
			'SETTING-PENGGUNA-HANDOFFER',			
		];
		$records=[];
		foreach($modules as $v)
		{
			$records=array(
				['name'=>"{$v}_BROWSE",'guard_name'=>'web','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
				['name'=>"{$v}_SHOW",'guard_name'=>'web','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
				['name'=>"{$v}_STORE",'guard_name'=>'web','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
				['name'=>"{$v}_UPDATE",'guard_name'=>'web','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
				['name'=>"{$v}_DESTROY",'guard_name'=>'web','created_at'=>Carbon::now(),'updated_at'=>Carbon::now()],
			);
			\DB::table('permissions')->insert($records);
		}

		\DB::table('permissions')->insert([
			'name'=>"USER_STOREPERMISSIONS",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);
		\DB::table('permissions')->insert([
			'name'=>"USER_STOREPERMISSIONS",
			'guard_name'=>'api',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);

		\DB::table('permissions')->insert([
			'name'=>"USER_REVOKEPERMISSIONS",
			'guard_name'=>'web',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);
		\DB::table('permissions')->insert([
			'name'=>"USER_REVOKEPERMISSIONS",
			'guard_name'=>'api',
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);
		app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
	}
}
