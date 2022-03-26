<?php

namespace App\Helpers;
use Carbon\Carbon;
use URL;
class Helper {
	/**
	 * daftar bulan
	 */
	private static $daftar_bulan=[
		1=>'Januari',
		2=>'Februari',
		3=>'Maret',
		4=>'April',
		5=>'Mei',
		6=>'Juni',
		7=>'Juli',
		8=>'Agustus',
		9=>'September',
		10=>'Oktober',
		11=>'November',
		12=>'Desember',
	];
	/**
	 * daftar bulan romawai
	 */
	private static $daftar_bulan_romawi=[
		1=>'I',
		2=>'II',
		3=>'III',
		4=>'IV',
		5=>'V',
		6=>'VI',
		7=>'VII',
		8=>'VIII',
		9=>'IX',
		10=>'X',
		11=>'XI',
		12=>'XII',
	];
	 /*
		* nama hari dalam bahasa indonesia
		*/
	private static $namaHari = [
		1=>'Senin',
		2=>'Selasa',
		3=>'Rabu',
		4=>'Kamis',
		5=>'Jumat',
		6=>'Sabtu',
		7=>'Minggu',
	];
	/**
	 * digunakan untuk mendapatkan nama halaman yang sedang diakses
	 */
	public static function getNameOfPage (string $action = null)
	{
		$name = explode('.',\Route::currentRouteName());
		if ($action === null)
		{
			return $name[0];
		}
		else
		{
			return $name[0].'.'.$action;
		}
		
	}
	/**
	 * digunakan controller yang sedang diakses
	 */
	public static function getCurrentController() 
	{
		$controller_name=strtolower(class_basename(\Route::current()->controller));
		$controller=str_replace('controller','',$controller_name); 
		return $controller;    
	} 
	/**
	 * digunakan untuk mendapatkan url halaman yang sedang diakses
	 */
	public static function getCurrentPageURL() 
	{   
		return route(Helper::getNameOfPage('index'));    
	}
	/**
	 * digunakan untuk mendapatkan status aktif menu
	 */
	public static function isMenuActive ($current_page_active,$page_name,$callback='active') 
	{
		if ($current_page_active == $page_name) {
			return $callback;
		}else{
			return '';
		}
	}
	/**
	 * digunakan untuk memformat tanggal
	 * @param type $format
	 * @param type $date
	 * @return type date
	 */
	public static function tanggal($format, $date=null, $english=false) {
		Carbon::setLocale(app()->getLocale());
		if ($date == null)
		{
			$now = Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta'));
			$tanggal = Carbon::parse($now);	
			return $tanggal->format($format);		
		}
		else
		{
			$tanggal = Carbon::parse($date);						
			$tanggal = $tanggal->format($format);
		}
		if ($english)
		{
			return $tanggal;
		}
		else
		{
			$result = str_replace([
				'Sunday',
				'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday'
			],
			[
				'Minggu',
				'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu'
			],
			$tanggal);

			return str_replace([
				'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November' ,
				'December'
			],
			[
				'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			], $result);
		}		
	}
	public static function tambahJam($jam, $format, $date=null, $english=false)
	{
		if ($date == null)
		{
			$tanggal = Carbon::parse(Carbon::now(env('APP_TIMEZONE', 'Asia/Jakarta')))->addHours($jam);
		}
		else
		{
			$tanggal = Carbon::parse($date)->addHours($jam);
		}
		return Helper::tanggal($format, $tanggal->format($format), $english);
	}
	/**
	 * tanggal dan waktu sekarang lebih besar dari tanggal dan waktu parameter
	 */
	public static function tanggal_gt($param_date) {		
		$start_date = new \DateTime($param_date);
		$now = new \DateTime();
		$now->setTimeZone(new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Jakarta')));
		$sekarang = $now->format('Y-m-d H:m:s');		
		$since_start = $start_date->diff(new \DateTime($sekarang));
		return $since_start->s > 0;
	}
	/**
	 * tanggal dan waktu sekarang lebih besar dari tanggal dan waktu parameter
	*/
	public static function tanggal_lt($param_date) {
		$start_date = new \DateTime($param_date);
		$now = new \DateTime();
		$now->setTimeZone(new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Jakarta')));
		$sekarang = $now->format('Y-m-d H:m:s');		
		$since_start = $start_date->diff(new \DateTime($sekarang));
		return $since_start->s < 0;
	}
	/**
	 * untuk mengetahui tanggal/waktu saat ini telah expire atau belum
	 */
	public static function tanggal_expire($waktu_expire) {		
		$start_date = new \DateTime($waktu_expire);
		$now = new \DateTime();
		$now->setTimeZone(new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Jakarta')));
		$sekarang = $now->format('Y-m-d H:m:s');		
		$since_start = $start_date->diff(new \DateTime($sekarang));
		return !($since_start->s > 0);
	}
		/**
		 * untuk mengetahui jumlah tanggal/waktu yang telah berlalu
		 */
	public static function tanggal_yang_lalu($waktu_yang_lalu) {		
		$start_date = new \DateTime($waktu_yang_lalu);
		$now = new \DateTime();
		$now->setTimeZone(new \DateTimeZone(env('APP_TIMEZONE', 'Asia/Jakarta')));
		$sekarang = $now->format('Y-m-d H:m:s');		
		$since_start = $start_date->diff(new \DateTime($sekarang));
		
		if ($since_start->y >0 )
		{
			return "{$since_start->y} tahun";
		}
		else if ($since_start->m >0 )
		{
			return "{$since_start->m} bulan";
		}		
		else if ($since_start->d >0 )
		{
			return "{$since_start->d} hari";
		}
		else if ($since_start->h >0 )
		{
			return "{$since_start->h} jam";
		}
		else if ($since_start->i >0 )
		{
			return "{$since_start->i} menit";
		}
		else if ($since_start->h >0 )
		{
			return "{$since_start->h} detik";
		}		
	}
	/**
	 * untuk mengetahui durasi antara dua waktu
	 */
	public static function getDurationBetweenTwoTimes($start_time, $last_time, $mode = 'm')
	{
		$start = strtotime($start_time);
		$end = strtotime($last_time);
		$mins = ($end - $start) / 60;
		return $mins;
	}
	/**
	 * digunakan untuk mendapatkan bulan romawi
	 */
	public static function getBulanRomawi($no_bulan = null) 
	{
		if (is_null ($no_bulan))
		{
			$no_bulan = date('n');
		}
		return Helper::$daftar_bulan_romawi[$no_bulan];
	}
	/**
	* casting ke integer	
	*/
	public static function toInteger ($stringNumeric) {
		return (int) str_replace('.','',$stringNumeric);
	}
	/**
	* digunakan untuk mem-format uang
	*/
	public static function formatUang ($uang=0,$decimal=2) {
		$formatted = number_format((float)$uang,$decimal,',','.');
		return $formatted;
	}
	/**
	* digunakan untuk mem-format angka
	*/
	public static function formatAngka ($angka=0) {
		$bil = intval($angka);
		$formatted = ($bil < $angka) ? $angka : $bil;
		return $formatted;
	}
	/**
	* digunakan untuk mem-format persentase
	*/
	public function formatPersen ($pembilang,$penyebut=0,$dec_sep=2) {
		$result=0.00;
		if ($pembilang > 0) {
			$temp=number_format((float)($pembilang/$penyebut)*100,$dec_sep);
			$result = $temp > 100 ? 100.00 : $temp;
		}
		return $result;
	}
	/**
	* digunakan untuk mem-format pecahan
	*/
	public function formatPecahan ($pembilang,$penyebut=0,$dec_sep=2) {
		$result=0;
		if ($pembilang > 0) {
			$result=number_format((float)($pembilang/$penyebut),$dec_sep);
		}
		return $result;
	}
	public static function public_path($path = null)
	{
		return rtrim(app()->basePath('storage/app/public/' . $path), '/');
	}
	public static function exported_path($path = null)
	{
		return Helper::public_path("exported/$path");
	}
}