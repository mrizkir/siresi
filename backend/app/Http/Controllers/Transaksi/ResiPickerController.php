<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

use App\Models\User;
use App\Models\Transaksi\ResiModel;

use App\Helpers\Helper;

class ResiPickerController extends Controller
{
  /**
   * daftar resi yang sedang berada di picker
   */
  public function index(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-RESI-PICKER_BROWSE');

    $data = User::select(\DB::raw('
      resi.id,
      users.name,
      users.nomor_hp,
      users.foto,
      resi.no_resi,
      resi.created_at,
      resi.updated_at
    '))
    ->join('resi', 'resi.user_id_picker', 'users.id')
    ->where('resi.user_id_scan', $this->getUserid())
    ->where('users.default_role', 'picker')
    ->whereRaw('(resi.status = 1 OR resi.status = 10)')
    ->get();

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',      
      'resi'=>$data,      
      'message'=>'Fetch data resi picker berhasil diperoleh'
    ], 200);
  }
  public function picker(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-ADMIN-SCAN-RESI_BROWSE');

    //digunakan untuk mendapatkan picker
    $subquery=\DB::table('resi')
    ->select(\DB::raw('
      user_id_picker,
      COUNT(id) AS jumlah            
    '))
    ->whereDate('created_at', Helper::tanggal('Y-m-d'))
    ->whereNull('resi_id_src')
    ->groupBy('user_id_picker');

    $data = User::select(\DB::raw('
      users.*,
      COALESCE(resi.jumlah, 0) AS jumlah
    '))
    ->leftJoinSub($subquery, 'resi', function($join) {
      $join->on('resi.user_id_picker','=','users.id');
    }) 
    ->where('default_role', 'picker')
    ->orderBy('username','ASC')
    ->get(); 

    //digunakan untuk mendapatkan jumlah resi yang discan oleh admin    
    $jumlah_resi_hari_ini = \DB::table('resi')
    ->whereDate('created_at', '=', date('Y-m-d'))
    ->whereNull('user_id_picker')
    ->count();

    $jumlah_resi_yang_lalu = \DB::table('resi')
    ->whereDate('created_at', '<', date('Y-m-d'))
    ->whereNull('user_id_picker')
    ->count();

    return Response()->json([
      'status'=>1,
      'pid'=>'fetchdata',      
      'picker'=>$data,
      'waktu'=>Helper::tanggal('d F Y H:i:s'),
      'jumlah_resi_hari_ini' => $jumlah_resi_hari_ini,
      'jumlah_resi_yang_lalu' => $jumlah_resi_yang_lalu,
      'message'=>'Fetch data pengguna picker berhasil diperoleh'
    ], 200);  
  }
  public function store(Request $request)
	{
		$this->hasPermissionTo('TRANSAKSI-ADMIN-SCAN-RESI_STORE');

		$this->validate($request, [
			'no_resi'=>'required||unique:resi,no_resi',			
		]);

    $resi = ResiModel::create([
      'id' => Uuid::uuid4()->toString(),
      'no_resi' => $request->input('no_resi'),
      'user_id_picker' => null,      
      'user_id_scan' => $this->getUserid(),
      'status'=>'1'
    ]);

    return Response()->json([
      'status'=>1,
      'pid'=>'store',
      'resi'=>$resi,                                    
      'message'=>'Data resi picker berhasil disimpan.'
    ], 200); 
  }
  public function storeresipicker(Request $request)
  {
    $this->hasPermissionTo('TRANSAKSI-ADMIN-SCAN-RESI_STORE');

		$this->validate($request, [
			'jumlah_resi'=>'required|numeric',
      'picker_id'=>'required|numeric|exists:users,id',	
		]);

    $jumlah_resi = $request->input('jumlah_resi');
    $picker_id = $request->input('picker_id');

    $sql = "UPDATE resi dest,
      (SELECT 
        id
      FROM
        resi
      WHERE 
        user_id_picker IS NULL
      ) AS src
    SET 
      dest.user_id_picker=$picker_id
    WHERE
      dest.id=src.id
    ";
    
    \DB::statement($sql);

    return Response()->json([
      'status'=>1,
      'pid'=>'store',
      'message'=>'Data resi picker berhasil disimpan.'
    ], 200);
  }
}