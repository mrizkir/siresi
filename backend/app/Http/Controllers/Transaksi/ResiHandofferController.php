<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\User;
use App\Models\Transaksi\ResiModel;

use App\Helpers\Helper;

class ResiHandofferController extends Controller
{
  public function index(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-RESI-HANDOFFER_BROWSE');    

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
    ->where('users.default_role', 'handoffer')    
    ->whereRaw('(resi.status = 3 OR resi.status = 30)'); //sudah discan oleh handoffer

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
      ->join('users', 'users.id', 'resi.user_id_scan')
      ->where('resi.id', $item->resi_id_src)
      ->first();

      $item->name=$data_checker->name;
      return $item;
    });

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',          
      'resi'=>$data,      
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
        resi.id,        
        resi.no_resi,
        users.name            
      '))      
      ->join('users', 'users.id', 'resi.user_id_scan')
      ->whereRaw("no_resi LIKE '%$search%'")   
      ->where('status', 2)     
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
		$this->hasPermissionTo('TRANSAKSI-HANDOFFER-SCAN-RESI_STORE');

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
        'status'=>3
      ]);
  
      $data_resi->status = 20; //resi yang sudah discan oleh handoffer diberi kode 20
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