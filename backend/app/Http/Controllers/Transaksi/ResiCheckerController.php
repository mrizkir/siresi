<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\User;
use App\Models\Transaksi\ResiModel;

use App\Helpers\Helper;

class ResiCheckerController extends Controller
{
  /**
   * daftar resi yang sedang berada di picker
   */
  public function index(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-RESI-CHECKER_BROWSE');
    
    $data = User::select(\DB::raw('
      resi.id,
      users.name,
      users.nomor_hp,
      users.foto,
      resi.no_resi,
      resi.resi_id_src,
      resi.created_at,
      resi.updated_at
    '))
    ->join('resi', 'resi.user_id_scan', 'users.id')    
    ->where('users.default_role', 'checker')    
    ->whereRaw('(resi.status = 2 OR resi.status = 20)');//sudah discan oleh checker
    
    if (!$this->hasRole('superadmin'))
    {
      $data = $data->where('resi.user_id_scan', $this->getUserid());
    }    
    $data = $data->get();    
    
    $data->transform(function ($item, $key) {	
      $data_checker = \DB::table('resi')
      ->select(\DB::raw('
        users.name
      '))		
      ->join('users', 'users.id', 'resi.user_id_picker')
      ->where('resi.id', $item->resi_id_src)
      ->first();

      $item->name=$data_checker->name;
      return $item;
    });

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',      
      'resi'=>$data,      
      'message'=>'Fetch data resi picker berhasil diperoleh'
    ], 200);
  }
  public function search(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-RESI_BROWSE');
    
    $this->validate($request,[
			'search'=>'required'        
		]);

    $search = $request->input('search');
    $daftar_resi = \DB::table('resi')
      ->select(\DB::raw('
        resi.id,        
        resi.no_resi,
        users.name            
      '))      
      ->join('users', 'users.id', 'resi.user_id_picker')
      ->whereRaw("no_resi LIKE '%$search%'")   
      ->where('resi.status', 1)     
      ->get();

		return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',
      'daftar_resi'=>$daftar_resi,  
      'jumlah'=>$daftar_resi->count(),
      'message'=>'Daftar resi berhasil diperoleh.'
    ], 200);
                
  }  
  public function store(Request $request)
	{
		$this->hasPermissionTo('TRANSAKSI-CHECKER-SCAN-RESI_STORE');

		$this->validate($request, [
			'resi_id'=>'required||exists:resi,id',			
		]);
    
    $data_resi = ResiModel::find($request->input('resi_id'));

    $resi = \DB::transaction(function () use ($request, $data_resi) {
      $resi = ResiModel::create([
        'id' => Uuid::uuid4()->toString(),
        'no_resi' => $data_resi->no_resi,
        'user_id_picker' => $data_resi->user_id_picker,      
        'user_id_scan' => $this->getUserid(),
        'resi_id_src' => $data_resi->id,
        'status'=>2
      ]);
  
      $data_resi->status = 10; //resi yang udah discan oleh checker diberi kode 10
      $data_resi->save();
      
      return $resi;
    });

    

    return Response()->json([
      'status'=>1,
      'pid'=>'store',
      'resi'=>$resi,                                    
      'message'=>'Data resi picker berhasil disimpan.'
    ], 200); 
  }
}