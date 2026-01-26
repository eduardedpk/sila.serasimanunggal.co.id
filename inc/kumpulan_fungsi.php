<?php

	/*
		Variable
	*/
	$Array_Bulan=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
	
	

	/*
		Function
	*/

	/* 	Fungsi GetSemesterNID($Semester)
		Parameter $Semester
		Digunakan untuk mengambil SemesterNID dari table semester
	*/
	function GetSemesterNID($Semester) 
	{
		include '../../util/config.php';
		$sql = "SELECT SemesterNID FROM semester tu
					WHERE tu.SemesterID = '".$Semester."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['SemesterNID'];
	}

	/* 	Fungsi GetPeriodeNID($PeriodeID)
		Parameter $PeriodeID
		Digunakan untuk mengambil PeriodeNID dari table periode
	*/
	function GetPeriodeNID($PeriodeID) 
	{
		include 'config.php';
		$sql = "SELECT PeriodeNID FROM periode tu
					WHERE tu.PeriodeID = '".$PeriodeID."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['PeriodeNID'];
	}

	/* 	Fungsi GetPeriodeNID($PeriodeID)
		Parameter $PeriodeID
		Digunakan untuk mengambil PeriodeNID dari table periode
	*/
	function GetPeriodeID($PeriodeNID) 
	{
		include '../../util/config.php';
		$sql = "SELECT PeriodeID FROM periode tu
					WHERE tu.PeriodeNID = '".$PeriodeNID."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['PeriodeID'];
	}

	/* 	Fungsi GetKodeMapel($PelajaranID)
		Parameter $PelajaranID
		Digunakan untuk mengambil Kode mapel 
	*/
	function GetKodeMapel($PelajaranID)
	{
		include '../../util/config.php';
		$sql = "SELECT Kode FROM nama_bidang_studi tu
					WHERE tu.PelajaranID = '".$PelajaranID."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['Kode'];
	}

	/* 	Fungsi GetKelasID($Bidang_Studi_ID)
		Parameter $Bidang_Studi_ID
		Digunakan untuk mengambil KelasID 
	*/
	function GetKelasID($Bidang_Studi_ID)
	{
		include '../../util/config.php';
		$sql = "SELECT bs.KelasID FROM bidang_studi bs
					INNER JOIN kelas kl ON kl.KelasID = bs.KelasID
					WHERE bs.Bidang_Studi_ID = '".$Bidang_Studi_ID."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['KelasID'];
	}

	/* 	Fungsi GetUserID($Username)
		Parameter $Username
		Digunakan untuk mengambil UserID dari table table_user
	*/
	
	function GetUserID2($Username) 
	{
		include '../../util/config.php';
		$sql = "SELECT UserID FROM table_user tu
					WHERE tu.Username = '".$Username."' ";
		//echo $sql."<br>";
		$qry = mysqli_query($Connection, $sql);
		$buff = mysqli_fetch_array($qry);

		return $buff['UserID'];
	}

	function GetUserID($Username) 
	{
		include '../../util/dbconnection.php';
		$sql = "SELECT UserID FROM table_user tu
					WHERE tu.Username = '".$Username."' ";
		//echo $sql."<br>";
		$query = $dbo->prepare($sql);
        $query->execute();
        $buff = $query->fetch();

		return $buff['UserID'];
	}

	function GetKelas($Username) 
	{
		include '../../util/dbconnection.php';
		include '../../util/config.php';
		include '../../util/inisiasi.php';
		$sql = "SELECT rk.KelasID FROM rombongankelas rk
					INNER join kelas kl ON kl.KelasID = rk.KelasID
					WHERE rk.PeriodeID = '".$_Periode."' AND rk.NIS = '".$Username."' ";
		//echo $sql."<br>";
		$query = $dbo->prepare($sql);
        $query->execute();
		$buff = $query->fetch();
		$KelasNID = $buff['KelasID'];

		if($KelasNID==1 || $KelasNID==2 || $KelasNID==3)
		{
			return 1;
		}
		elseif($KelasNID==4 || $KelasNID==5 || $KelasNID==6)
		{
			return 2;
		}
		elseif($KelasNID==7 || $KelasNID==8 || $KelasNID==9)
		{
			return 3;
		}
		elseif($KelasNID==10 || $KelasNID==11 || $KelasNID==12)
		{
			return 4;
		}
		elseif($KelasNID==13 || $KelasNID==14 || $KelasNID==15)
		{
			return 5;
		}
		elseif($KelasNID==16 || $KelasNID==17 || $KelasNID==18)
		{
			return 6;
		}
	}

	function GetUserFullName($UserID) 
	{
		include '../../util/dbconnection.php';
		$sql = "SELECT Nama_Lengkap FROM table_user tu
					WHERE tu.UserID = '".$UserID."' ";
		//echo $sql."<br>";
		$query = $dbo->prepare($sql);
        $query->execute();
        $buff = $query->fetch();

		return $buff['Nama_Lengkap'];
	}

	function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
		$bulan = array (1 =>   'Januari',
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
				);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}

	// Mendapatkan IP pengunjung menggunakan getenv()
	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'IP tidak dikenali';
		return $ipaddress;
	}

	// Mendapatkan jenis web browser pengunjung
	function get_client_browser() {
		$browser = '';
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
			$browser = 'Netscape';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			$browser = 'Firefox';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			$browser = 'Chrome';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			$browser = 'Opera';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
			$browser = 'Internet Explorer';
		else
			$browser = 'Other';
		return $browser;
	}

	// Mendapatkan sistem operasi
	function get_client_os() {
		$os = $_SERVER['HTTP_USER_AGENT'];
		return $os;
	}

	function getReligion($agama)
	{
		$Array_Agama=array("Budha","Hindu","Islam","Katolik","Kong Hu Cu","Kristen","Lain-lain");
		$result = $Array_Agama[$agama];
		return $result;                          
	}

    function getSemesterText($semester)
	{
		$result = "";
		switch ($semester) 
		{
			case 1:
				$result = "Ganjil";
				break;
			case 2:
				$result = "Genap";
				break;
		}
		return $result;                          
	}

	function getLongDate($Paramater_Tanggal)
	{
		$Bulan_Str = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', );
		$Tanggal = substr($Paramater_Tanggal, -2);
		//echo "Tanggal : ".$Tanggal."<br>";
		$Bulan = $Bulan_Str[(int)substr($Paramater_Tanggal, 5, 2)];
		//echo "Bulan : ".$Bulan."<br>";
		$Tahun = substr($Paramater_Tanggal, 0, 4);
		//echo "Tahun : ".$Tahun."<br>";
		//$Array_Hari=array(1=>"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
		$result = $Tanggal." ".$Bulan." ".$Tahun;
		return $result;                          
	}

	function getDayText($urutanhari)
	{
		$Array_Hari=array(1=>"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");	
		$result = $Array_Hari[$urutanhari];
		return $result;                          
	}

	function mail_attachment($to, $subject, $message, $from, $file) {
		// $file should include path and filename
		$filename = basename($file);    
		$file_size = filesize($file);
		$content = chunk_split(base64_encode(file_get_contents($file)));
		$uid = md5(uniqid(time()));
		$from = str_replace(array(" ", " "), '', $from); // to prevent email injection
		$header = "From: ".$from." "
		."MIME-Version: 1.0 "
		."Content-Type: multipart/mixed; boundary='".$uid."' "
		."This is a multi-part message in MIME format. "
		."--".$uid." "
		."Content-type:text/plain; charset=iso-8859-1 "
		."Content-Transfer-Encoding: 7bit "
		.$message." "
		."--".$uid." "
		."Content-Type: application/octet-stream; name='".$filename."' "
		."Content-Transfer-Encoding: base64 "
		."Content-Disposition: attachment; filename='".$filename."' "
		.$content." "
		."--".$uid."--";
		return mail($to, $subject, "", $header);
	}
	/*
		Contoh bentuk email :  
		$to = "takehikoboyz@gmail.com"; // email tujuan
		$subject = "Contoh Email Attachment"; // subjek email
		$message = "Yes ini adalah email attachment"; // body email
		$from = "no-reply@agussaputra.com"; // email pengirim
		$file = "attachment.zip"; // letak file

		mail_attachment($to,$subject,$message,$from,$file); // proses kirim email
	*/
?>
