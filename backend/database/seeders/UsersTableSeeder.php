<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{       
		\DB::statement('DELETE FROM users');

		$user = User::create([
			'username'=>'admin',
			'password'=>Hash::make('12345678'),                
			'name'=>'admin',                
			'email'=>'admin@beverra.com',                
			'nomor_hp'=>'+612345678',			
			'theme'=>'default',
			'email_verified_at'=>Carbon::now(),
			'isdeleted'=>false,
			'default_role'=>'superadmin',			
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]); 	
		$user->assignRole('superadmin');
		
		$user = User::create([
			'username'=>'admin_scan',
			'password'=>Hash::make('12345678'),                
			'name'=>'admin_scan',                
			'email'=>'admin_scan@beverra.com',                
			'nomor_hp'=>'+612345679',			
			'theme'=>'default',
			'email_verified_at'=>Carbon::now(),
			'isdeleted'=>false,
			'default_role'=>'admin',			
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);  		
		$user->assignRole('admin');
		
		$user = User::create([
			'username'=>'picker',
			'password'=>Hash::make('12345678'),                
			'name'=>'picker',                
			'email'=>'picker@beverra.com',                
			'nomor_hp'=>'+612345674',			
			'theme'=>'default',
			'email_verified_at'=>Carbon::now(),
			'isdeleted'=>false,
			'default_role'=>'picker',			
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);  		
		$user->assignRole('admin');
		
		$user = User::create([
			'username'=>'checker_scan',
			'password'=>Hash::make('12345678'),                
			'name'=>'checker_scan',                
			'email'=>'checker_scan@beverra.com',                
			'nomor_hp'=>'+612345676',			
			'theme'=>'default',
			'email_verified_at'=>Carbon::now(),
			'isdeleted'=>false,
			'default_role'=>'checker',			
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);  		
		$user->assignRole('checker');

		$user = User::create([
			'username'=>'handoffer_scan',
			'password'=>Hash::make('12345678'),                
			'name'=>'handoffer_scan',                
			'email'=>'handoffer_scan@beverra.com',                
			'nomor_hp'=>'+612345675',			
			'theme'=>'default',
			'email_verified_at'=>Carbon::now(),
			'isdeleted'=>false,
			'default_role'=>'handoffer',			
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now()
		]);  
		$user->assignRole('handoffer');
	}
}