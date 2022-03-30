<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\User;
use App\Models\Transaksi\ResiModel;

use App\Helpers\Helper;

class ResiController extends Controller
{
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
      ->get();

		return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',
      'daftar_resi'=>$daftar_resi,  
      'jumlah'=>$daftar_resi->count(),
      'message'=>'Daftar resi berhasil diperoleh.'
    ], 200);
                
  }  
}