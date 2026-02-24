<?php
ini_set('session.save_path', '../session');
session_start();
if(!isset($_SESSION['login']))
{
    ?>
        <script>
            window.location.href="../logout.php";
        </script>
    <?php
}
else 
{
    include '../inc/config.php';

    if($_SESSION['Username']=="SA")
    {
        $Profile_Pictures = "SA".".jpg";
    }
    else
    {
        $Profile_Pictures = $_SESSION['Profile_Picture'];
        if($Profile_Pictures=="")
        {
            $Profile_Pictures = "default.jpg";
        }
        
    }
    $Nama_Panggilan = $_SESSION['Nama_Panggilan'];
    $Last_User = $_SESSION['Username'];
    $Nama_Lengkap_User = $_SESSION['Nama_Lengkap'];
    $KaryawanNID = $_SESSION['KaryawanNID'];
    $Last_UserNID = $_SESSION['Last_UserNID'];

    
    $Link_Profile = "javascript:void(0)";
    if(isset($_GET['Action']))
    {
        if($_GET['Action']=='Set_Hak_Akses')
        {
            $Hak_Akses = $_GET['Hak_Akses'];
            $Hak_Akses = str_replace('&#39;',"'",$Hak_Akses);
            $Hak_Akses = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hak_Akses));

            $_SESSION['Hak_Akses']= $Hak_Akses;
            //echo $Hak_Akses;
            ?>
            <script>
                window.location.href="index.php";
            </script>
            <?php
        }
    }
    else
    {
        $Hak_Akses = $_SESSION['Hak_Akses'];
        $_SESSION['Tanggal_Awal'] = date('Y-m-d');
        $_SESSION['Tanggal_Akhir'] = date('Y-m-d');
        $_SESSION['Filter_Agama_Siswa'] = '999';
        $_SESSION['Filter_Gender_Siswa'] = '999';
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        //Form Utama
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
                <title>SILA - SMS</title>
                <meta content="Admin Dashboard" name="description" />
                <meta content="ThemeDesign" name="author" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />

                <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicon/apple-icon-57x57.png">
                <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicon/apple-icon-60x60.png">
                <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon/apple-icon-72x72.png">
                <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicon/apple-icon-76x76.png">
                <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon/apple-icon-114x114.png">
                <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicon/apple-icon-120x120.png">
                <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon/apple-icon-144x144.png">
                <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicon/apple-icon-152x152.png">
                <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-icon-180x180.png">
                <link rel="icon" type="image/png" sizes="192x192"  href="assets/images/favicon/android-icon-192x192.png">
                <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon/favicon-96x96.png">
                <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
                <link rel="manifest" href="assets/images/favicon/manifest.json">
                <meta name="msapplication-TileColor" content="#ffffff">
                <meta name="msapplication-TileImage" content="assets/images/favicon/ms-icon-144x144.png">
                <meta name="theme-color" content="#ffffff">

                <!--Morris Chart CSS -->
                <link rel="stylesheet" href="assets/plugins/morris/morris.css">

                <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
                <link href="assets/css/style.css" rel="stylesheet" type="text/css">

            </head>


            <body class="fixed-left">

                <!-- Begin page -->
                <div id="wrapper">

                    <!-- Top Bar Start -->
                    <div class="topbar">
                        <!-- LOGO -->
                        <div class="topbar-left">
                            <a href="index.php" class="logo">SILA</a>
                            <a href="index.php" class="logo-sm"><span>S</span></a>
                            
                            <!--<a href="index.html" class="logo"><img src="assets/images/logo.png" height="20" alt="logo"></a>
                            <a href="index.html" class="logo-sm"><img src="assets/images/logo_sm.png" height="30" alt="logo"></a>-->
                        </div>
                        <!-- Button mobile view to collapse sidebar menu -->
                        <div class="navbar navbar-default" role="navigation">
                            <div class="container">
                                <div class="">
                                    <div class="pull-left">
                                        <button type="button" class="button-menu-mobile open-left waves-effect waves-light">
                                            <i class="ion-navicon"></i>
                                        </button>
                                        <span class="clearfix"></span>
                                    </div>
                                    <ul class="nav navbar-nav navbar-right pull-right">
                                        
                                        <li class="hidden-xs">
                                            <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="ion-qr-scanner"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                                <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="user-img" class="img-circle">
                                                <span class="profile-username">
                                                    <?php echo $Nama_Panggilan ?> <span class="caret"></span>
                                                </span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!--<li><a href="<?php echo $Link_Profile ?>"> Profile</a></li>-->
                                                <li><a href="../logout.php"> Logout</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <!--/.nav-collapse -->
                            </div>
                        </div>
                    </div>
                    <!-- Top Bar End -->


                    <!-- ========== Left Sidebar Start ========== -->

                    <div class="left side-menu">
                        <div class="sidebar-inner slimscrollleft">

                            <form class="sidebar-search">
                                <div class="">
                                    <input type="text" class="form-control search-bar" placeholder="Search...">
                                </div>
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </form>

                            <div class="user-details">
                                <div class="text-center">
                                    <!--<img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">-->
                                    <a href="pengaturan.php?Action=Profile_Picture"><img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle"></a>
                                </div>
                                <div class="user-info">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $Nama_Panggilan ?> <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <!--<li><a href="<?php echo $Link_Profile ?>"> Profile</a></li>-->
                                            <li><a href="../logout.php"> Logout</a></li>
                                        </ul>
                                    </div>

                                    <!--<p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>-->
                                </div>
                                <!-- Hak Akses -->
                                <div class="user-info">
                                    <select id="Hak_Akses" onchange="myFunction(this)" name="Hak_Akses">
                                        <?php
                                        if($Last_User=='SA')
                                        {
                                            ?>
                                            <option value="1">Administrator</option>
                                            <?php
                                        }
                                        else
                                        {
                                            // Ambil hak akses
                                            $sql = "SELECT uh.Jenis_UserNID, uj.Jenis_User FROM user_list ul 
                                                        INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID 
                                                        INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                        WHERE ul.Username = '".$Last_User."'  ";
                                            //echo $sql.";<br>";
                                            $qry = mysqli_query($Connection, $sql);
                                            while($buff = mysqli_fetch_array($qry))
                                            {
                                                $Jenis_UserNID = $buff['Jenis_UserNID'];
                                                $Jenis_User = $buff['Jenis_User'];
                                                if($Jenis_UserNID==$_SESSION['Hak_Akses'])
                                                {
                                                    ?>
                                                    <option value="<?php echo $Jenis_UserNID ?>" selected><?php echo $Jenis_User ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="<?php echo $Jenis_UserNID ?>"><?php echo $Jenis_User ?></option>
                                                    <?php
                                                }
                                                
                                            }
                                            
                                        }
                                        ?>
                                    </select>
                                    <!--<p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>-->
                                </div>
                            </div>
                            <!--- Divider -->


                            <div id="sidebar-menu">
                                <?php
                                //$Hak_Akses = 3;
                                //$_SESSION['Hak_Akses']= $Hak_Akses;
                                if($Hak_Akses==1) //Administrator
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="cabang.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Cabang </span></a>
                                        </li>
                                        <li>
                                            <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-user"></i><span> Karyawan </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Daftar_User" class="waves-effect"><i class="fa fa-suitcase"></i><span> User </span></a>
                                        </li>
                                        <li>
                                            <a href="hari_libur.php?Action=Daftar" class="waves-effect"><i class="fa fa-suitcase"></i><span> Hari Libur </span></a>
                                        </li>
                                        <!--<li>
                                            <a href="indikator_kpi_ho.php?Action=Daftar" class="waves-effect"><i class="fa fa-suitcase"></i><span> Indikator KPI HO </span></a>
                                        </li>-->
                                        <li>
                                            <a href="kpi.php?Action=Dashboard" class="waves-effect"><i class="fa fa-suitcase"></i><span>KPI HO </span></a>
                                        </li>
                                        <!--<li class="has_sub">
                                            <a href="javascript:void(0);" class="waves-effect"><i class="ion-connection-bars"></i><span> Upload </span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                            <ul class="list-unstyled">
                                                <li><a href="laporan_harian.php?Action=LPH">Laporan Harian</a></li>
                                                <li><a href="inspeksi_area.php?Action=IA">Inspeksi Area</a></li>
                                                <li><a href="pengguna_jasa.php?Action=PJ">Pengguna Jasa</a></li>
                                                <li><a href="peningkatan_kualitas.php?Action=PK">Peningkatan Kualitas</a></li>
                                                <li><a href="check_list_toilet.php?Action=CT">Check List Toilet</a></li>
                                                <li><a href="invoice.php?Action=Invoice">Pembayaran Invoice</a></li>
                                            </ul>
                                        </li>-->
                                        <li>
                                            <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $Last_UserNID ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Ganti Password </span></a>
                                        </li>
                                        <!--<li>
                                            <a href="pengaturan.php?Action=Profile_Picture" class="waves-effect"><i class="ti-user"></i><span> Profile Picture </span></a>
                                        </li>-->
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==2) //Supervisor
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li class="has_sub">
                                            <a href="javascript:void(0);" class="waves-effect"><i class="ion-connection-bars"></i><span> Report </span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                            <ul class="list-unstyled">
                                                <li><a href="laporan_harian_cs.php?Action=Daftar">Laporan CS</a></li>
                                                <li><a href="laporan_harian.php?Action=Daftar">Laporan Harian</a></li>
                                                <li><a href="inspeksi_area.php?Action=Daftar">Inspeksi Area</a></li>
                                                <li><a href="pengguna_jasa.php?Action=Daftar">Pengguna Jasa</a></li>
                                                <li><a href="check_list_toilet.php?Action=Daftar">Check List Toilet</a></li>
                                                <li><a href="pembayaran_invoice.php?Action=Daftar">Pembayaran Invoice</a></li>
                                                <li><a href="laporan_harian_nonCS.php?Action=Daftar">Laporan Harian Non CS</a></li>
                                                <li><a href="laporan_kpi_non_cs.php?Action=Daftar">Laporan KPI Non CS</a></li>
                                                <li><a href="cuti.php?Action=Daftar">TL Cuti</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="generate_rekap.php?Action=Daftar" class="waves-effect"><i class="ti-user"></i><span> Rekap </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $Last_UserNID ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Ganti Password </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==3) //CS
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li class="has_sub">
                                            <a href="javascript:void(0);" class="waves-effect"><i class="ion-connection-bars"></i><span> Upload </span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                            <ul class="list-unstyled">
                                                <li><a href="laporan_harian.php?Action=Daftar">Laporan Harian</a></li>
                                                <li><a href="inspeksi_area.php?Action=Daftar">Inspeksi Area</a></li>
                                                <li><a href="pengguna_jasa.php?Action=Daftar">Pengguna Jasa</a></li>
                                                <!--<li><a href="peningkatan_kualitas.php?Action=Daftar">Peningkatan Kualitas</a></li>-->
                                                <li><a href="check_list_toilet.php?Action=Daftar">Check List Toilet</a></li>
                                                <!--<li><a href="invoice.php?Action=Invoice">Pembayaran Invoice</a></li>-->
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $Last_UserNID ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Ganti Password </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==4) //Head Office
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <!--<li>
                                            <a href="laporan_harian_nonCS.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Laporan Harian </span></a>
                                        </li>--> 
                                        <li>
                                            <a href="laporan_kpi_non_cs.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Laporan KPI </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $Last_UserNID ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Ganti Password </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==5) //Operasional
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="laporan_harian_nonCS.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Laporan Harian </span></a>
                                        </li>
                                        <li>
                                            <a href="laporan_kpi_non_cs.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Laporan KPI </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $Last_UserNID ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Ganti Password </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==6) //Karyawan
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="karyawan.php?Action=View&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="ti-user"></i><span> Karyawan </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Main_Page" class="waves-effect"><i class="fa fa-cog"></i><span> Pengaturan </span></a>
                                        </li>
                                        <!--<li>
                                            <a href="kehadiran_karyawan.php" class="waves-effect"><i class="ti-calendar"></i><span> Kehadiran </span></a>
                                        </li>-->
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==7) //Sarpras
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="inventori.php?Action=Daftar" class="waves-effect"><i class="fa fa-suitcase"></i><span> Inventory </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Main_Page" class="waves-effect"><i class="fa fa-cog"></i><span> Pengaturan </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==8) //Kurikulum
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Siswa </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Main_Page" class="waves-effect"><i class="fa fa-cog"></i><span> Pengaturan </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==9) //Kesiswaan
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="mdi mdi-odnoklassniki"></i><span> Siswa </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Main_Page" class="waves-effect"><i class="fa fa-cog"></i><span> Pengaturan </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                elseif($Hak_Akses==10) //Litbang
                                {
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="dokumen_litbang.php?Action=Daftar" class="waves-effect"><i class="fa fa-suitcase"></i><span> Dokumen Litbang </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Main_Page" class="waves-effect"><i class="fa fa-cog"></i><span> Pengaturan </span></a>
                                        </li>
                                    </ul>
                                    <?php
                                }
                                ?>
                                
                            </div>
                            <div class="clearfix"></div>
                        </div> <!-- end sidebarinner -->
                    </div>
                    <!-- Left Sidebar End -->

                    <!-- Start right Content here -->

                    <div class="content-page">
                        <!-- Start content -->
                        <div class="content">

                            <div class="">
                                <div class="page-header-title">
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>

                            <div class="page-content-wrapper ">

                                <div class="container">
                                    <div>
                                        <?php 
                                        //$_SESSION['Nama_Lengkap'] = "Eduard";
                                        date_default_timezone_set("Asia/Jakarta");
                                        $Waktu = "";
                                        $b = time();
                                        $hour = date("G",$b);
                                        
                                        if ($hour>=0 && $hour<=11)
                                        {
                                            $Waktu = "Selamat pagi ";
                                        }
                                        elseif ($hour >=12 && $hour<=14)
                                        {
                                            $Waktu = "Selamat siang ";
                                        }
                                        elseif ($hour >=15 && $hour<=17)
                                        {
                                            $Waktu = "Selamat sore ";
                                        }
                                        elseif ($hour >=17 && $hour<=18)
                                        {
                                            $Waktu = "Selamat petang ";
                                        }
                                        elseif ($hour >=19 && $hour<=23)
                                        {
                                            $Waktu = "Selamat malam ";
                                        }
                                        
                                        ?>
                                        <h4>
                                        <?php echo $Waktu." ".$_SESSION['Nama_Lengkap'] ?>
                                        </h1>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <!--<div class="col-sm-6 col-lg-4">
                                            <div class="panel">
                                                <div class="panel-body p-t-10">
                                                    <div class="widget-box-one">
                                                        <i class="mdi mdi-cake-variant widget-box-icon"></i>
                                                        <h4 class="panel-title m-b-15 text-muted font-light" ><b>Ulang Tahun</b></h4>
                                                        <p class=" m-b-0 m-t-20 text-muted text-full">Bulan ini : <b>10</b></p>
                                                        <p class=" m-b-0 m-t-20 text-muted text-full">Hari ini : <b>10</b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <?php
                                        /*
                                        if($Hak_Akses==1 || $Hak_Akses==2 || $Hak_Akses==7)
                                        {
                                            ?>
                                            <div class="col-sm-6 col-lg-4">
                                                <div class="panel">
                                                    <div class="panel-body p-t-10">
                                                        <div class="widget-box-one">
                                                            <i class="mdi mdi-tag-multiple widget-box-icon"></i>
                                                            <h4 class="panel-title text-muted m-b-15 font-light"><b>Inventory</b></h4>
                                                            <!--<h2 class="m-t-0 text-primary m-b-15"><i class="mdi mdi-arrow-up-bold-circle-outline m-r-10"></i>4,52,564</h2>-->
                                                            
                                                            <p class=" m-b-0 m-t-20 text-muted text-full">Total Inventory : <b><?php echo $num ?></b></p>
                                                            <p class=" m-b-0 m-t-20 text-muted text-full">Inventory diluar : <b><?php echo $num ?></b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        */
                                        /*
                                        if($Hak_Akses==1 || $Hak_Akses==2 || $Hak_Akses==4)
                                        {
                                            ?>
                                            <div class="col-sm-6 col-lg-4">
                                                <div class="panel">
                                                    <div class="panel-body p-t-10">
                                                        <div class="widget-box-one">
                                                            <i class="mdi mdi-timetable widget-box-icon"></i>
                                                            <h4 class="panel-title text-muted m-b-15 font-light"><b>Absensi hari ini</b></h4>
                                                            <p class=" m-b-0 m-t-20 text-muted text-full">Hadir : <b>10</b></p>
                                                            <p class=" m-b-0 m-t-20 text-muted text-full">Pulang : <b>10</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }*/
                                        ?>
                                        
                                        
                                        

                                    </div>
                                    <!--
                                    <div class="row">

                                        <div class="col-lg-4">
                                            <div class="panel panel-primary">
                                                <div class="panel-body">
                                                    <h4 class="m-t-0">Monthly Earnings</h4>

                                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                                        <li>
                                                            <h4 class=""><b>3654</b></h4>
                                                            <p class="text-muted m-b-0">Marketplace</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>954</b></h4>
                                                            <p class="text-muted m-b-0">Last week</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>8462</b></h4>
                                                            <p class="text-muted m-b-0">Last Month</p>
                                                        </li>
                                                    </ul>

                                                    <div id="morris-donut-example" style="height: 300px"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-primary">
                                                <div class="panel-body">
                                                    <h4 class="m-t-0">Revenue</h4>

                                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                                        <li>
                                                            <h4 class=""><b>5248</b></h4>
                                                            <p class="text-muted m-b-0">Marketplace</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>321</b></h4>
                                                            <p class="text-muted m-b-0">Last week</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>964</b></h4>
                                                            <p class="text-muted m-b-0">Last Month</p>
                                                        </li>
                                                    </ul>

                                                    <div id="morris-bar-example" style="height: 300px"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-primary">
                                                <div class="panel-body">
                                                    <h4 class="m-t-0">Email Sent</h4>

                                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                                        <li>
                                                            <h4 class=""><b>3652</b></h4>
                                                            <p class="text-muted m-b-0">Marketplace</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>5421</b></h4>
                                                            <p class="text-muted m-b-0">Last week</p>
                                                        </li>
                                                        <li>
                                                            <h4 class=""><b>9652</b></h4>
                                                            <p class="text-muted m-b-0">Last Month</p>
                                                        </li>
                                                    </ul>

                                                    <div id="morris-area-example" style="height: 300px"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div> -->
                                    <!-- end row -->

                                    <!--
                                    <div class="row">

                                        <div class="col-md-7">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <h4 class="m-b-30 m-t-0">Recent Contacts</h4>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover m-b-0">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Position</th>
                                                                        <th>Office</th>
                                                                        <th>Age</th>
                                                                        <th>Start date</th>
                                                                        <th>Salary</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Tiger Nixon</td>
                                                                        <td>System Architect</td>
                                                                        <td>Edinburgh</td>
                                                                        <td>61</td>
                                                                        <td>2011/04/25</td>
                                                                        <td>$320,800</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Garrett Winters</td>
                                                                        <td>Accountant</td>
                                                                        <td>Tokyo</td>
                                                                        <td>63</td>
                                                                        <td>2011/07/25</td>
                                                                        <td>$170,750</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Ashton Cox</td>
                                                                        <td>Junior Technical Author</td>
                                                                        <td>San Francisco</td>
                                                                        <td>66</td>
                                                                        <td>2009/01/12</td>
                                                                        <td>$86,000</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Cedric Kelly</td>
                                                                        <td>Senior Javascript Developer</td>
                                                                        <td>Edinburgh</td>
                                                                        <td>22</td>
                                                                        <td>2012/03/29</td>
                                                                        <td>$433,060</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Airi Satou</td>
                                                                        <td>Accountant</td>
                                                                        <td>Tokyo</td>
                                                                        <td>33</td>
                                                                        <td>2008/11/28</td>
                                                                        <td>$162,700</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Brielle Williamson</td>
                                                                        <td>Integration Specialist</td>
                                                                        <td>New York</td>
                                                                        <td>61</td>
                                                                        <td>2012/12/02</td>
                                                                        <td>$372,000</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Herrod Chandler</td>
                                                                        <td>Sales Assistant</td>
                                                                        <td>San Francisco</td>
                                                                        <td>59</td>
                                                                        <td>2012/08/06</td>
                                                                        <td>$137,500</td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <!-- end col -->
                                        

                                    </div>
                                    <!-- end row -->


                                </div><!-- container -->


                            </div> <!-- Page content Wrapper -->

                        </div> <!-- content -->

                        <!--<footer class="footer">
                            Powered By Palmarius
                        </footer>-->

                    </div>
                    <!-- End Right content here -->

                </div>
                <!-- END wrapper -->


                <!-- jQuery  -->
                <script src="assets/js/jquery.min.js"></script>
                <script src="assets/js/bootstrap.min.js"></script>
                <script src="assets/js/modernizr.min.js"></script>
                <script src="assets/js/detect.js"></script>
                <script src="assets/js/fastclick.js"></script>
                <script src="assets/js/jquery.slimscroll.js"></script>
                <script src="assets/js/jquery.blockUI.js"></script>
                <script src="assets/js/waves.js"></script>
                <script src="assets/js/wow.min.js"></script>
                <script src="assets/js/jquery.nicescroll.js"></script>
                <script src="assets/js/jquery.scrollTo.min.js"></script>

                <script src="assets/js/app.js"></script>
                <script>
                    function myFunction(selectObject) {
                        var value = selectObject.value;
                        //alert(value);
                        //function Sort_Fungsi() {
                        //var x = document.getElementById("Sorting-Select").value;
                        window.location.href="index.php?Action=Set_Hak_Akses&Hak_Akses="+value;
                    }
                </script>
            </body>
        </html>
        <?php
    }
    
}

