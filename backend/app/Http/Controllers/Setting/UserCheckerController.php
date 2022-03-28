<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Ramsey\Uuid\Uuid;
use Illuminate\Validation\Rule;

class UserCheckerController extends Controller 
{         
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{           
		$this->hasPermissionTo('SETTING-PENGGUNA-CHECKER_BROWSE');

		$data = User::where('default_role','checker')
					->orderBy('username','ASC')
					->get();       
					
		$role = Role::findByName('checker');
		return Response()->json([
								'status'=>1,
								'pid'=>'fetchdata',
								'role'=>$role,
								'users'=>$data,
								'message'=>'Fetch data pengguna checker berhasil diperoleh'
							], 200);  
	}    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->hasPermissionTo('SETTING-PENGGUNA-CHECKER_STORE');

		$this->validate($request, [
			'name'=>'required',
			'email'=>'required|string|email|unique:users',
			'nomor_hp'=>'required|string|unique:users',
			'username'=>'required|string|unique:users',
			'password'=>'required',
		]);
		$user = \DB::transaction(function () use ($request) {
			$now = \Carbon\Carbon::now()->toDateTimeString();        
			$user=User::create([
				'id'=>Uuid::uuid4()->toString(),
				'name'=>strtoupper($request->input('name')),
				'email'=>$request->input('email'),
				'nomor_hp'=>$request->input('nomor_hp'),
				'username'=> strtolower($request->input('username')),
				'password'=>Hash::make($request->input('password')),                        
				'theme'=>'default',
				'default_role'=>'checker',            
				'foto'=> 'storages/images/users/no_photo.png',
				'created_at'=>$now, 
				'updated_at'=>$now
			]);            
			$role='checker';   
			$user->assignRole($role);               
			
			$permission=Role::findByName('checker')->permissions;
			$permissions=$permission->pluck('name');
			$user->givePermissionTo($permissions);			

			return $user;
		});

		return Response()->json([
									'status'=>1,
									'pid'=>'store',
									'user'=>$user,                                    
									'message'=>'Data user checker berhasil disimpan.'
								], 200); 

	}
	/**
	 * digunakan untuk mendapatkan informasi detail user dengan role program studi
	 */
	public function show(Request $request, $id)
	{
		$this->hasPermissionTo('SETTING-PENGGUNA-CHECKER_SHOW');

		$user = User::find($id);
		if (is_null($user))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'update',                
									'message'=>["User ID ($id) gagal diperoleh"]
								], 422); 
		}
		else
		{
			return Response()->json([
									'status'=>1,
									'pid'=>'fetchdata',
									'user'=>$user,  
									'role_checker'=>$user->hasRole('checker'),    
									'message'=>'Data user '.$user->username.' berhasil diperoleh.'
								], 200); 
		}

	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->hasPermissionTo('SETTING-PENGGUNA-CHECKER_UPDATE');

		$user = User::find($id);
		if (is_null($user))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'update',                
									'message'=>["User ID ($id) gagal diupdate"]
								], 422); 
		}
		else
		{
			$this->validate($request, [
										'username'=>[
														'required',
														'unique:users,username,'.$user->id
													],           
										'name'=>'required',            
										'email'=>'required|string|email|unique:users,email,'.$user->id,
										'nomor_hp'=>'required|string|unique:users,nomor_hp,'.$user->id,                                                    
									]); 
			$user = \DB::transaction(function () use ($request,$user) {
				$user->name = strtoupper($request->input('name'));
				$user->email = $request->input('email');
				$user->nomor_hp = $request->input('nomor_hp');
				$user->username = strtolower($request->input('username'));        
				if (!empty(trim($request->input('password')))) {
					$user->password = Hash::make($request->input('password'));
				}    
				$user->updated_at = \Carbon\Carbon::now()->toDateTimeString();
				$user->save();
				
				return $user;
			});

			return Response()->json([
									'status'=>1,
									'pid'=>'update',
									'user'=>$user,      
									'message'=>'Data user checker '.$user->username.' berhasil diubah.'
								], 200); 
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request,$id)
	{ 
		$this->hasPermissionTo('SETTING-PENGGUNA-CHECKER_DESTROY');

		$user = User::where('isdeleted','1')
					->find($id); 
		
		if (is_null($user))
		{
			return Response()->json([
									'status'=>0,
									'pid'=>'destroy',                
									'message'=>["User ID ($id) gagal dihapus"]
								], 422); 
		}
		else
		{
			$username=$user->username;
			$user->delete();
			
		
			return Response()->json([
										'status'=>1,
										'pid'=>'destroy',                
										'message'=>"User checker ($username) berhasil dihapus"
									], 200);         
		}
				  
	}
}