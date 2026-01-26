<?php
    //ob_start();
	ini_set('session.save_path', 'session');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
    session_start();
	include 'inc/config.php';
	//$MyUsername    = $_POST['Login$UserName'];
	//$password    = $_POST['Login$Password'];
	$MyUsername = mysqli_real_escape_string($Connection, trim($_POST['Login$UserName']));
	$Password   = mysqli_real_escape_string($Connection, trim($_POST['Login$Password']));
	if(!strpos($MyUsername, ';'))
	{
		$_SESSION['login'] = $MyUsername;
		//echo $_SESSION['login'];

		//Kalau table user_list kosong, maka dibuatkan account su (super user)
		$sql = "SELECT * FROM user_list ";
		//echo $sql.";<br>";
		$qry = mysqli_query($Connection, $sql);
		$num = mysqli_num_rows($qry);
		if($num==0)
		{
			//masuk ke table user_list (siswa)
			$Password = 1; // User bisa akses ke sistem jika IsEnabled = 1
			$Login_Retry = 0; //Jumlah login salah sebelum diblok
			$Reset_Password = 0;  //Pertama kali login ke sistem, user harus mengganti password
			$Deleted = 0;  //Pertama kali login ke sistem, user harus mengganti password
			$Password = "smartsoftware";  //Password default
			$hashed_password = password_hash($Password, PASSWORD_DEFAULT);
			$qry1 ="INSERT INTO user_list (Username, Password, Reset_Password, Last_Login, Deleted, Login_Retry, Creator, Create_Date, Last_User)
					VALUES ('SA','$hashed_password', '$Reset_Password', now(), '$Deleted', '$Login_Retry', 1, now(), 1),
							('Sistem','$hashed_password', '$Reset_Password', now(), '$Deleted', '$Login_Retry', 1, now(), 1)";
			//echo $qry1."<br>";
			$hasil1 = mysqli_query($Connection, $qry1);
			$MyUsername="SA";

		}
		
		$Login_Error = 0;
		if(strtoupper($MyUsername)=="SA")
		{
			$sql = "SELECT * FROM user_list ul
					WHERE ul.Username = '".$MyUsername."' AND ul.Deleted = 0 ";
			//echo $sql.";<br>";
			$qry = mysqli_query($Connection, $sql);
			$num = mysqli_num_rows($qry);
			if($num==0)
			{
				//Username tidak ditemukan
				$Login_Error = 1;
			}
			else
			{
				$buff = mysqli_fetch_array($qry);
				$hashed_password = $buff['Password'];
				//Bandingkan password
				if(password_verify($Password, $hashed_password))
				{
					echo "lulus";
					$Nama_Lengkap_User = "Sistem Administrator";
					$Nama_Panggilan_User = "SA";
					$Username = $buff['Username'];
					$Reset_Password = $buff['Reset_Password'];
					$Login_Retry = $buff['Login_Retry'];
					$Profile_Picture = "SA";
					$_SESSION['KaryawanNID'] = 1;
					// Ambil hak akses
					$_SESSION['Hak_Akses']=1;
					$_SESSION['Last_UserNID']= 1;
					$_SESSION['CabangNID']= 0;
					$_SESSION['Profile_Picture']= 1;
				}
				else
				{
					$Login_Error = 1;
					
					?>
					<script>
						alert('Password salah!')
						window.location.href="index.html";
					</script>
					<?php
				}
				
			}
			
		}
		else
		{
			$sql = "SELECT ul.UserNID, ul.Username, ul.Reset_Password, ul.Login_Retry, dk.Nama_Lengkap, dk.KaryawanNID, ul.Password, dk.CabangNID, dk.Profile_Picture FROM user_list ul
						INNER JOIN data_karyawan dk ON dk.NIM = ul.Username
						WHERE ul.Username = '".$MyUsername."' AND ul.Deleted = 0 ";
			//echo $sql.";<br>";
			$qry = mysqli_query($Connection, $sql);
			$num = mysqli_num_rows($qry);
			if($num==0)
			{
				$Login_Error = 1;
			}
			else
			{
				$buff = mysqli_fetch_array($qry);
				$hashed_password = $buff['Password'];
				//echo "Password : ".$Password."<br>";
				//echo "hashed_password : ".$hashed_password."<br>";
				//Bandingkan password
				if(password_verify($Password, $hashed_password))
				{
					$Nama_Lengkap_User = $buff['Nama_Lengkap'];
					$Nama_Panggilan_User = $buff['Nama_Lengkap'];
					$Username = $buff['Username'];
					$_SESSION['KaryawanNID']= $buff['KaryawanNID'];
					$Reset_Password = $buff['Reset_Password'];
					$Login_Retry = $buff['Login_Retry'];
					$Profile_Picture = $buff['Username'];
					$_SESSION['CabangNID']= $buff['CabangNID'];
					$_SESSION['Profile_Picture']= $buff['Profile_Picture'];

					// Ambil hak akses
					$sql = "SELECT uh.Jenis_UserNID, uh.UserNID FROM user_list ul
								INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
								WHERE ul.Username = '".$MyUsername."' 
								LIMIT 1";
					$qry = mysqli_query($Connection, $sql);
					$buff = mysqli_fetch_array($qry);
					$_SESSION['Hak_Akses']= $buff['Jenis_UserNID'];
					
					$_SESSION['Last_UserNID']= $buff['UserNID'];
				}
				else
				{
					$Login_Error = 1;
					
					?>
					<script>
						alert('Password salah!')
						window.location.href="index.html";
					</script>
					<?php
				}
				
			}
		}

		if($Login_Error==0)
		{
			$sql = "SELECT ts.* FROM table_setup ts "; 
			$qry = mysqli_query($Connection, $sql);

			$buff = mysqli_fetch_array($qry);
			$Kepala_Aktif = $buff['Kepala_Sekolah'];
			$Client_Code = $buff['Client_Code'];
			
			$_SESSION['Client_Code']=$Client_Code;
			$_SESSION['Nama_Panggilan']=$Nama_Panggilan_User;
			$_SESSION['Username']=$Username;
			$_SESSION['Nama_Lengkap']=$Nama_Lengkap_User;


			
			
			/* Simpan login terakhir */
			//mysqli_close($Connection);
			$sql = "UPDATE user_list ul SET
						ul.Last_Login = now()
						WHERE ul.Username = '".$Username."' ";
			//echo $sql."<br>";
			$qry = mysqli_query($Connection, $sql);
			?>
			<script>
				window.location.href="pages/index.php";
			</script>
			<?php
		}
		else
		{
			//Cari username
			$sql = "SELECT * FROM user_list WHERE Username = '".$MyUsername."' AND Deleted=0";
			//echo $sql;
			$qry = mysqli_query($Connection, $sql);
			$num = mysqli_num_rows($qry);
			if($num==0)
			{
				//Username tidak terdaftar
				?>
					<script>
						alert('Username <?php echo $MyUsername ?> tidak terdaftar!')
						window.location.href="index.html";
					</script>
				<?php
			}
			else
			{
				//Password Salah
				?>
					<script>
						alert('Password salah!')
						window.location.href="index.html";
					</script>
				<?php
			}
		}

	}
	else
	{
		?>
			<script>
				window.location.href="index.html";
			</script>
		<?php
	}
    
    
?>