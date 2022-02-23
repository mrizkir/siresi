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
	}
}