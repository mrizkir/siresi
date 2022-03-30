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
  public function index(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-CHECKER-SCAN-RESI_BROWSE');

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',          
      'waktu'=>Helper::tanggal('d F Y H:i:s'),
      'message'=>'Fetch data resi berhasil diperoleh'
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
        id,        
        no_resi                
      '))      
      ->whereRaw("no_resi LIKE '%$search%'")   
      ->where('status', 1)     
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
  
      $data_resi->status = 10;
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