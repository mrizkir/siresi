<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use App\Models\User;

use DataTables;

class UserPickerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
    $this->hasPermissionTo('SETTING-PENGGUNA-PICKER_BROWSE');
		
		$data = User::where('default_role','picker')
			->orderBy('username','ASC');

		if ($request->wantsJson())
		{
			return DataTables::of($data)->toJson();
		}
		else
		{
			$breadcrumbs = [
				['link' => route('dashboard.index'), 'name' => "HOME"], 			
				['name' => "PENGGUNA"], 
				['name' => "PICKER"], 			
			];

			$role = Role::findByName('picker');

			return view('/pages/setting/userpicker/userpicker-index', [
				'page_active'=>'users-picker',
				'breadcrumbs'=>$breadcrumbs,
				'role'=>$role,
			]);
		}
	}
	public function show(Request $request, $id)
  {    
		$this->hasPermissionTo('SETTING-PENGGUNA-PICKER_SHOW');

		$user = User::find($id);
		
		if (is_null($user))
		{
			return back()->with('error', "ID user picker ($id) tidak terdaftar.");
		}
		else
		{
			$breadcrumbs = [
				['link' => route('admin-dashboard.index'), 'name' => "HOME"], 
				['name' => "PENGGUNA"], 				
				['link' => route('userpicker.index'), 'name' => "PICKER"],
				['name' => "DETAIL"], 			
			];
			$role = Role::findByName($user->default_role);			
			$user_permission = $user->permissions;
			return view('/admin/users/picker/picker-show', [			
				'page_active'=>'users-picker',    
				'breadcrumbs'=>$breadcrumbs,
				'data'=>$user,
				'jumlah_permission'=>$user_permission->count(),
				'role'=>$role,
				'user_permissions'=>$user_permission->pluck('name','id')->toJson(),
			]);
		}
  }	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{		
		$this->hasPermissionTo('SETTING-PENGGUNA-PICKER_STORE');

    $breadcrumbs = [
      ['link' => route('admin-dashboard.index'), 'name' => "HOME"], 			
			['name' => "PENGGUNA"],
      ['link' => route('userpicker.index'), 'name' => "PICKER"], 
      ['name' => "TAMBAH"], 			
    ];
    return view('/admin/users/picker/picker-create', [
      'page_active'=>'users-picker',    
      'breadcrumbs'=>$breadcrumbs,      
    ]);
  }	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->hasPermissionTo('SETTING-PENGGUNA-PICKER_STORE');

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
				'name'=>$request->input('name'),
				'email'=>$request->input('email'),
				'nomor_hp'=>$request->input('nomor_hp'),
				'username'=> $request->input('username'),
				'password'=>\Hash::make($request->input('password')),
				'email_verified_at'=>\Carbon\Carbon::now(),
				'theme'=>'default',
				'default_role'=>'picker',
				'foto'=> 'storage/images/users/no_photo.png',
				'created_at'=>$now, 
				'updated_at'=>$now
			]);       
			$role='picker';   
			$user->assignRole($role);          

			$permission=Role::findByName($role)->permissions;
    	$user->givePermissionTo($permission->pluck('name'));
			
			return $user;
		});			
		return redirect(route('userpicker.index'))->with('success','User picker  berhasil ditambah.');
	}	
	public function edit($id)
  {
		$this->hasPermissionTo('SETTING-PENGGUNA-PICKER_UPDATE');

    $picker = User::where('default_role', 'picker')->find($id);
    if (is_null($picker))
    {
      return back()->with('error', "User picker dengan ID ($id) tidak terdaftar.");			
    }
    else
    {
      $breadcrumbs = [
        ['link' => route('admin-dashboard.index'), 'name' => "HOME"], 			
				['name' => "PENGGUNA"],
      	['link' => route('userpicker.index'), 'name' => "PICKER"], 
      	['name' => "UBAH"], 			
      ];
      return view('/admin/users/picker/picker-edit', [
        'page_active'=>'users-picker',              
        'breadcrumbs'=>$breadcrumbs,
        'data'=>$picker,        
      ]);
    }
  }
	public function update(Request $request, $id)
	{
		$this->hasPermissionTo('SETTING-PENGGUNA-PICKER_UPDATE');

		$picker = User::where('default_role', 'picker')->find($id);
    if (is_null($picker))
    {
      return back()->with('error', "User picker dengan ID ($id) tidak terdaftar.");			
    }
    else
    {
			$this->validate($request, [
				'username'=>[
					'required',
					'unique:users,username,'.$picker->id
				],           
				'name'=>'required',
				'email'=>'required|string|email|unique:users,email,'.$picker->id,
				'nomor_hp'=>'required|string|unique:users,nomor_hp,'.$picker->id,       
			]);

			$picker = \DB::transaction(function () use ($request, $picker) {				
				$picker->name = $request->input('name');
				$picker->email = $request->input('email');
				$picker->username = $request->input('username');                   
				$picker->nomor_hp = $request->input('nomor_hp');                   
				if (!empty(trim($request->input('password')))) {
						$picker->password = \Hash::make($request->input('password'));
				}    
				$picker->updated_at = \Carbon\Carbon::now()->toDateTimeString();
				$picker->save();           

				return $picker;
			});			
			return redirect(route('userpicker.index'))->with('success','User picker  berhasil diubah.');
		}
	}	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		$picker = User::where('default_role', 'picker')->find($id);
    if (is_null($picker))
    {
      return back()->with('error', "User picker dengan ID ($id) tidak terdaftar.");			
    }
		else if (!$picker->isdeleted) {
			return back()->with('error', "User picker dengan ID ($id) tidak bisa dihapu.");			
		}
		else
		{
			$picker->delete();
			return redirect(route('userpicker.index'))->with('success',"Data user berhasil dihapus.");
		}
	}
}