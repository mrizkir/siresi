<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ResiPickerController extends Controller
{
  public function picker(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-RESI_BROWSE');

    $data = User::where('default_role','picker')
					->orderBy('username','ASC')
					->get(); 

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',      
      'picker'=>$data,
      'message'=>'Fetch data pengguna picker berhasil diperoleh'
    ], 200);  
  }
}