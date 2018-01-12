<?php

namespace User;
class User
{
  public function __construct()
  {
    // declare variables---------

    // ip function
    $this->ip = array();
  }

  public function fake_ip()
  {
    for ($i=1; $i <= 4; $i++) {
      $n = rand(0, 255);
      array_push($this->ip, $n);
    }
    $this->ip = implode(".", $this->ip);

    return $this->ip;
  }

  public function user_ip()
  {
    return $_SERVER['REMOTE_ADDR'];
  }

  public function thai_date($datetime_string)
  {
    date_default_timezone_set('Asia/Bangkok');
    $ts = strtotime($datetime_string);

    if(!$ts){
      return array();
    }

    $time = date('H:i น.', $ts);

    $days = array("อาทิตย์", "จันทร์", "อังคาร", "พุทธ", "พฤหัส", "ศุกร์", "เสาร์");
    $d = date('w', $ts);
    $day = $days[$d];

    $date = date('j', $ts);

    $months = array(1=>"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "กรกฎาคม", "สิงหาคม", "มิถุนายน", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $months_short = array(1=>"ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "ก.ค.", "ส.ค.", "มิ.ย.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

    $m = date('n', $ts);
    $month = $months[$m];
    $month_short = $months_short[$m];

    $year = date('Y', $ts) + 543;

    return array(
      'time' => $time,
      'day' => $day,
      'date' => $date,
      'month' => $month,
      'year' => $year,
      'month_short' => $month_short
    );
  }

  public function time_in_table($time)
  {
    $ts = strtotime($time);
    $ts = strtotime('+5 hours', $ts);
    $time = date('H:i', $ts);
    return $time;
  }

  public function short_text($string, $n=80)
  {
    $pat = "/(<.*?>)|(&.*?;)/";
    $replace = "";
    $str = preg_replace($pat, $replace, $string);
    $des = mb_substr($str, 0, $n, 'utf-8');
    return $des;
  }

  function checkFlags($url){
    $str = strtolower($url);
    $flags = array(
      "czech republic",
      "hong kong",
      "champions league",
      "international",
      "northern ireland",
      "saudi arabia",
      "south africa",
      "bosnia & herz.",
      "costa rica",
      "fyr macedonia",
      "republic of korea",
      "south america",
      "u.a.e.",
      "europa league",
      "world cup women"
    );
    if( in_array( $str, $flags ) ){
      return true;
    }else{
      return false;
    }
  }

  function videoSize(){
    define( 'KB_IN_BYTES', 1024 );
  	define( 'MB_IN_BYTES', 1024 * KB_IN_BYTES );
  	define( 'GB_IN_BYTES', 1024 * MB_IN_BYTES );
  	define( 'TB_IN_BYTES', 1024 * GB_IN_BYTES );

    $minus = KB_IN_BYTES * 150;
    $value = @ini_get( 'upload_max_filesize' );

    $value = strtolower( trim( $value ) );
  	$bytes = (int) $value;

  	if ( false !== strpos( $value, 'g' ) ) {
  		$bytes *= GB_IN_BYTES;
  	} elseif ( false !== strpos( $value, 'm' ) ) {
  		$bytes *= MB_IN_BYTES;
  	} elseif ( false !== strpos( $value, 'k' ) ) {
  		return $bytes;
  	}

    $bytes = ($bytes / KB_IN_BYTES) - $minus;

  	// Deal with large (float) values which run into the maximum integer size.
  	return min( $bytes, PHP_INT_MAX );

  }

  public function shared_links($url){
    // ตัด www.dropbox.com ทิ้งออกไป
    $find_pattern = "/www.dropbox/i";
    $replace_pattern = "dl.dropboxusercontent";
    $link = preg_replace($find_pattern, $replace_pattern, $url);

    // ตัด dl? ออกไป
    $find_pattern = "/\?dl=.*/i";
    $replace_pattern = "";
    $links = preg_replace($find_pattern, $replace_pattern, $link);
    return $links;
  }
}
