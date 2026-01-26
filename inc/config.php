<?php
	//Ambil setting database
	include 'settingdb.php';

    $Connection = mysqli_connect($dbhost_name, $username, $password, $database);
    //date_default_timezone_set('Asia/Jakarta');
    
	date_default_timezone_set('Asia/Jakarta');
	$sekarang = new DateTime();
	
	$menit = $sekarang -> getOffset() / 60;
	//echo $menit."<br>";

	$tanda = ($menit < 0 ? -1 : 1);
	$menit = abs($menit);
	$jam = floor($menit / 60);
	$menit -= $jam * 60;
	
	$offset = sprintf('%+d:%02d', $tanda * $jam, $menit);
	//echo date_default_timezone_get();
    //echo $offset;
    $sql = "SET time_zone = '$offset'";
    $query = mysqli_query($Connection, $sql);
    
?>