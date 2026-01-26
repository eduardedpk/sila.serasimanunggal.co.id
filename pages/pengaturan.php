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
    $CabangNID = $_SESSION['CabangNID'];

    
    $Link_Profile = "javascript:void(0)";
    $Hak_Akses = $_SESSION['Hak_Akses'];
    $_SESSION['Tanggal_Awal'] = date('Y-m-d');
    $_SESSION['Tanggal_Akhir'] = date('Y-m-d');
    $_SESSION['Filter_Agama_Siswa'] = '999';
    $_SESSION['Filter_Gender_Siswa'] = '999';
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
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
        elseif($_GET['Action']=='Main_Page')
        {
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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                    
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <?php
                                    //$Hak_Akses = 1;
                                    //$_SESSION['Hak_Akses']= $Hak_Akses;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Daftar_User" class="waves-effect"><i class="ti-user"></i><span> User </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==2) //Kepala Sekolah
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Daftar_User" class="waves-effect"><i class="ti-user"></i><span> User </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==3) //Guru
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==4) //Tata Usaha
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==5) //Bendahara
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
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
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
                                            </li>
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
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
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
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
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
                                                <a href="pengaturan.php?Action=Ganti_Password&UserNID=<?php echo $_SESSION['Last_UserNID'] ?>" class="waves-effect"><i class="mdi mdi-key-variant"></i><span> Ganti Password </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-right"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Pengaturan</h4>
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
                                                                <?php 
                                                                //Total Inventory
                                                                $sql = "SELECT * FROM inventory_daftar id
                                                                            WHERE id.Status_Barang NOT IN (6,7)";
                                                                //echo $sql."<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                ?>
                                                                <p class=" m-b-0 m-t-20 text-muted text-full">Total Inventory : <b><?php echo $num ?></b></p>
                                                                <?php 
                                                                //Total Inventory
                                                                $sql = "SELECT * FROM inventory_daftar id
                                                                            WHERE id.Status_Barang IN (4,5)";
                                                                //echo $sql."<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                ?>
                                                                <p class=" m-b-0 m-t-20 text-muted text-full">Inventory diluar : <b><?php echo $num ?></b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
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
        elseif($_GET['Action']=='Daftar_User')
        {
            
            //$Tanggal_Awal = $_SESSION['Tanggal_Awal'];
            //$ArrayTanggal = explode('-', $Tanggal_Awal);
            //$Start_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            //$Tanggal_Akhir = $_SESSION['Tanggal_Akhir'];
            //$ArrayTanggal = explode('-', $Tanggal_Akhir);
            //$End_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            $_SESSION['Parrent_Page'] = 'kehadiran_karyawan.php?Action=Daftar';
            //$_SESSION['Filter_Agama_Siswa'] = 'Katolik';
            if($_SESSION['Filter_Agama_Siswa']==999)
            {
                $Filter_Agama = '';
            }
            else
            {
                $Filter_Agama = " AND ds.Agama = '".$_SESSION['Filter_Agama_Siswa']."'";
            }
            //echo "Filter Agama : ".$Filter_Agama."<br>";
            //$_SESSION['Filter_Gender_Siswa'] = 1;
            if($_SESSION['Filter_Gender_Siswa']==999)
            {
                $Filter_Gender = '';
            }
            else
            {
                $Filter_Gender = " AND ds.Jenis_Kelamin = '".$_SESSION['Filter_Gender_Siswa']."'";
            }

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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <?php
                                    //$Hak_Akses = 2;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==2) //Kepala Sekolah
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="prestasi_siswa.php?Action=Daftar" class="waves-effect"><i class="fa fa-star"></i><span> Prestasi </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==3) //Guru
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Daftar User</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <p><a href="pengaturan.php?Action=User_Tambah" class="btn btn-info" title="Klik untuk tambah data user"><i class="fa fa-plus"></i> User</a></p>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=15% rowspan=1 style="text-align:center;vertical-align:middle">NIM</th>
                                                            <th width=35% rowspan=1 style="text-align:center;vertical-align:middle">Nama</th>
                                                            <th width=35% colspan=1 style="text-align:center;vertical-align:middle">Hak Akses</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT ul.UserNID, ul.Username, dk.Nama_Lengkap FROM user_list ul 
                                                                    INNER JOIN data_karyawan dk ON ul.Username = dk.NIM 
                                                                    ORDER BY dk.Nama_Lengkap;
                                                                    ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Karyawan = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Karyawan = mysqli_fetch_array($qry_Data_Karyawan))
                                                        {
                                                            $UserNID = $buff_Data_Karyawan['UserNID'];
                                                            $Username = $buff_Data_Karyawan['Username'];
                                                            $Nama_Lengkap = $buff_Data_Karyawan['Nama_Lengkap'];

                                                            //Cari hak akses tiap user 
                                                            $sql = "SELECT uh.Hak_UserNID, uj.Jenis_User FROM user_hak uh
                                                                        INNER JOIN user_list ul ON ul.UserNID = uh.UserNID
                                                                        INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                                        WHERE uh.UserNID = '".$UserNID."' AND uh.Jenis_UserNID <> 6
                                                                        ORDER BY uj.Jenis_User";
                                                            //echo $sql."<br>";
                                                            $qry_Hak_Akses = mysqli_query($Connection, $sql);
                                                            $Daftar_Hak_Akses = '';
                                                            while($buff_Hak_Akses = mysqli_fetch_array($qry_Hak_Akses))
                                                            {
                                                                $Daftar_Hak_Akses = $Daftar_Hak_Akses.$buff_Hak_Akses['Jenis_User'].", ";
                                                            }

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:center"><?php echo $Username ?></td>
                                                                <td style="text-align:left"><a href="pengaturan.php?Action=Daftar_Hak_Akses&UserNID=<?php echo $UserNID ?>"><?php echo $Nama_Lengkap ?></a></td>
                                                                <td style="text-align:center"><?php echo $Daftar_Hak_Akses ?></td>
                                                                <td style="text-align:center"> 
                                                                    <a href="pengaturan.php?Action=User_Hapus&UserNID=<?php echo $UserNID ?>"><i class="fa fa-trash" title="Menghapus data user" style="padding-right:10px"></i></a> 
                                                                    <a href="pengaturan.php?Action=User_Reset_Password&UserNID=<?php echo $UserNID ?>"><i class="fa fa-key" title="Reset password menjadi 123456"></i></a> 
                                                                </td>
                                                                
                                                            </tr>
                                                            <?php
                                                            $Nomor_Urut++;
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalAwal" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalAkhir" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                        } );
                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='User_Hapus')
        {
            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            //hapus dari tabel user_hak
            $sql = "DELETE FROM user_hak 
                        WHERE UserNID = '".$UserNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);

            //hapus dari tabel user_list
            $sql = "DELETE FROM user_list 
                        WHERE UserNID = '".$UserNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);

            ?>
                <script>
                    window.location.href="pengaturan.php?Action=Daftar_User";
                </script>
            <?php
        }
        elseif($_GET['Action']=='User_Reset_Password')
        {
            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            $Password = "123456";  //Password default
			$hashed_password = password_hash($Password, PASSWORD_DEFAULT);
            

            //Update password
            $sql = "UPDATE user_list ul SET
                        Password = '".$hashed_password."'
                        WHERE UserNID = '".$UserNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);

            ?>
                <script>
                    window.location.href="javascript:window.history.back()";
                </script>
            <?php
        }
        elseif($_GET['Action']=='Hak_User_Hapus')
        {
            $Hak_UserNID = $_GET['Hak_UserNID'];
            $Hak_UserNID = str_replace('&#39;',"'",$Hak_UserNID);
            $Hak_UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hak_UserNID));

            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            //hapus dari tabel user_hak
            $sql = "DELETE FROM user_hak 
                        WHERE Hak_UserNID = '".$Hak_UserNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);

            ?>
                <script>
                    window.location.href="pengaturan.php?Action=Daftar_Hak_Akses&UserNID=<?php echo $UserNID ?>";
                </script>
            <?php
        }
        elseif($_GET['Action']=='Daftar_Hak_Akses')
        {
            
            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            //Ambil nama User
            $sql = "SELECT ul.UserNID, ds.Nama_Lengkap, ul.Username FROM data_karyawan ds
                        INNER JOIN user_list ul ON ul.Username = ds.NIM
                        WHERE ul.UserNID = '".$UserNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $UserNID = $buff['UserNID'];
            $Nama_Lengkap_User = $buff['Nama_Lengkap'];
           

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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <?php
                                    //$Hak_Akses = 2;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="pengaturan.php?Action=Daftar_User" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==2) //Kepala Sekolah
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="prestasi_siswa.php?Action=Daftar" class="waves-effect"><i class="fa fa-star"></i><span> Prestasi </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==3) //Guru
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Daftar Hak Akses <?php echo $Nama_Lengkap_User ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <p><a href="pengaturan.php?Action=Hak_User_Tambah&UserNID=<?php echo $UserNID ?>" class="btn btn-info" title="Klik untuk tambah data hak user"><i class="fa fa-plus"></i> Hak User</a></p>
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=15% rowspan=1 style="text-align:center;vertical-align:middle">Hak Akses</th>
                                                            <th width=45% rowspan=1 style="text-align:center;vertical-align:middle">Keterangan</th>
                                                            <th width=35% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT uh.Hak_UserNID, uj.Jenis_User, uj.Keterangan FROM user_hak uh
                                                                    INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                                    WHERE uh.UserNID = '".$UserNID."' 
                                                                    ORDER BY uj.Jenis_User
                                                                    ";
                                                        //echo $sql.";<br>";
                                                        $qry = mysqli_query($Connection, $sql);
                                                        while($buff = mysqli_fetch_array($qry))
                                                        {
                                                            $Hak_UserNID = $buff['Hak_UserNID'];
                                                            $Jenis_User = $buff['Jenis_User'];
                                                            $Keterangan = $buff['Keterangan'];

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Jenis_User ?></td>
                                                                <td style="text-align:left"><?php echo $Keterangan ?></td>
                                                                <td style="text-align:center"> <a href="pengaturan.php?Action=Hak_User_Hapus&Hak_UserNID=<?php echo $Hak_UserNID ?>&UserNID=<?php echo $UserNID ?>"><i class="fa fa-trash"></i></a> </td>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $Nomor_Urut++;
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalAwal" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalAkhir" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                        } );
                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='User_Tambah')
        {
            
            
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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

                    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

                    <!-- include summernote css/js -->
                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Daftar_User" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                        </li>
                                    </ul>
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
                                        <h4 class="page-title">Tambah User </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="pengaturan.php" method="post" enctype="multipart/form-data">
                                                    <input id='User_Tambah' type="hidden" name="Action" value="User_Tambah">

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputPeriodeID" class="col-sm-3 ">Nama</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT dk.KaryawanNID, dk.NIM, dk.Nama_Lengkap, c.Nama_Cabang, c.Team_Leader, ul.UserNID, dk.IsLeader FROM data_karyawan dk
                                                                            INNER JOIN cabang c ON c.CabangNID = dk.CabangNID
                                                                            LEFT JOIN user_list ul ON ul.Username = dk.NIM
                                                                            ORDER BY trim(dk.Nama_Lengkap)";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="KaryawanNID" id="KaryawanNID">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $KaryawanNID = $buff['KaryawanNID'];
                                                                        $Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                        $Nama_Cabang = $buff['Nama_Cabang'];
                                                                        $Team_Leader = $buff['Team_Leader'];
                                                                        $Keanggotaan = ($Team_Leader==$KaryawanNID)?"Team Leader":"Anggota";
                                                                        $UserNID = $buff['UserNID'];
                                                                        //Kalau UserNID ada isinya berari sudah jadi user, dan tidak ditampilkan lagi
                                                                        if($UserNID=="")
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $KaryawanNID ?>" ><?php echo $Nama_Lengkap." (".$Nama_Cabang."/".$Keanggotaan.")" ?></option>
                                                                            <?php    
                                                                        }
                                                                        
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Filter"> Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- include summernote css/js -->
                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalDiterima" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalKeluar" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                            $('#inputKeterangan').summernote({
                                tabsize: 5,
                                height: 100,                 // set editor height
                                minHeight: null,             // set minimum height of editor
                                maxHeight: null,             // set maximum height of editor
                                toolbar: [
                                ['view', ['fullscreen', 'codeview']]
                                ],
                                callbacks: {
                                    onImageUpload: function (data) {
                                        data.pop();
                                    }
                                },
                                
                            });
                        } );

                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Hak_User_Tambah')
        {
            
            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));
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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

                    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

                    <!-- include summernote css/js -->
                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="pengaturan.php?Action=Daftar_Hak_Akses&UserNID=<?php echo $UserNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                        </li>
                                    </ul>
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
                                        <h4 class="page-title">Tambah Hak Akses </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="pengaturan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Hak_User_Tambah' type="hidden" name="Action" value="Hak_User_Tambah">
                                                    <input id='UserNID' type="hidden" name="UserNID" value="<?php echo $UserNID ?>">

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputPeriodeID" class="col-sm-3 ">Hak Akses</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT dk.Jenis_UserNID, dk.Jenis_User FROM user_jenis dk
                                                                            WHERE dk.Jenis_UserNID NOT IN (6)
                                                                            ORDER BY trim(dk.Jenis_User)";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="Jenis_UserNID" id="Jenis_UserNID">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Jenis_UserNID = $buff['Jenis_UserNID'];
                                                                        $Jenis_User = $buff['Jenis_User'];
                                                                        ?>
                                                                        <option value="<?php echo $Jenis_UserNID ?>" ><?php echo $Jenis_User ?></option>
                                                                        <?php    
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Filter"> Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- include summernote css/js -->
                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalDiterima" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalKeluar" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                            $('#inputKeterangan').summernote({
                                tabsize: 5,
                                height: 100,                 // set editor height
                                minHeight: null,             // set minimum height of editor
                                maxHeight: null,             // set maximum height of editor
                                toolbar: [
                                ['view', ['fullscreen', 'codeview']]
                                ],
                                callbacks: {
                                    onImageUpload: function (data) {
                                        data.pop();
                                    }
                                },
                                
                            });
                        } );

                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Profile_Picture')
        {
            
            
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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

                    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
                    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

                    <!-- include summernote css/js -->
                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                        </li>
                                    </ul>
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
                                        <h4 class="page-title">Upload Profile Picture </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="pengaturan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Simpan_PP' type="hidden" name="Action" value="Simpan_PP">
                                                    

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">File</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="file" name="inputFileBefore" id="inputFileBefore" class="image-upload" onchange="readURL(this);">
                                                                <img id="gambar" src="#" alt="" class="img-responsive">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Filter"> Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- include summernote css/js -->
                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalDiterima" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalKeluar" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    $('#gambar')
                                        .attr('src', e.target.result)
                                        .width(300)
                                        ;
                                };

                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                            $('#inputKeterangan').summernote({
                                tabsize: 5,
                                height: 100,                 // set editor height
                                minHeight: null,             // set minimum height of editor
                                maxHeight: null,             // set maximum height of editor
                                toolbar: [
                                ['view', ['fullscreen', 'codeview']]
                                ],
                                callbacks: {
                                    onImageUpload: function (data) {
                                        data.pop();
                                    }
                                },
                                
                            });
                        } );

                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Ganti_Password')
        {
            
            $UserNID = $_GET['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            if($UserNID==1)
            {
                $Nama_Lengkap_User = "Administrator";
            }
            elseif($UserNID==2)
            {
                $Nama_Lengkap_User = "Sistem";
            }
            else
            {
                //Ambil nama User
                $sql = "SELECT ul.UserNID, ds.Nama_Lengkap FROM data_karyawan ds
                            INNER JOIN user_list ul ON ul.Username = ds.NIM
                            WHERE ul.UserNID = '".$UserNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                //$UserNID = $buff['UserNID'];
                $Nama_Lengkap_User = $buff['Nama_Lengkap'];
            }
            
           

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

                    <!-- DataTables -->
                    
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
                    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

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
                                        <img src="../files/profile_pictures/<?php echo $Profile_Pictures ?>" alt="" class="img-circle">
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
                                </div>
                                <!--- Divider -->


                                <div id="sidebar-menu">
                                    <?php
                                    //$Hak_Akses = 2;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==2) //Kepala Sekolah
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==3) //Guru
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==4) //Tata Usaha
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    elseif($Hak_Akses==5) //Bendahara
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
                                            </li>
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
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="index.php" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Ganti Password <?php echo $Nama_Lengkap_User ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="col-sm-6 col-sm-offset-3">

                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                
                                                <form name="GantiPassword" action="pengaturan.php" id="form" method="post">
                                                    <input id='Ganti_Password' type="hidden" name="Action" value="Ganti_Password">
                                                    <input id='UserNID' type="hidden" name="UserNID" value="<?php echo $UserNID ?>">
                                                    <table border="0" cellpadding="1" cellspacing="0" style="border: solid 1px #606060;">
                                                        <tr>
                                                            <td>
                                                                <table border="0" cellpadding="0" width="220">
                                                                    <tr style="height: 50px; padding: 10px 10px 10px 10px" class="w3-color w3-tableheadercolor">
                                                                        <td align="center" colspan="2" style="text-align: center; vertical-align:middle; ;
                                                                            color: #FFF">
                                                                            Ganti Password
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" style="width:160px">
                                                                            <label for="CurrentPassword" id="CurrentPasswordLabel">Password Saat Ini:</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width:200px" align="center">
                                                                            <input name="CurrentPassword" type="password" id="CurrentPassword" class="txt" style="width:200px;" />
                                                                            <span id="CurrentPasswordRequired" title="Password is required." style="color:Red;display:none;">Password is required.</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <label for="NewPassword" id="NewPasswordLabel">Password baru:</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <input name="NewPassword" type="password" id="NewPassword" class="txt" style="width:200px;" />
                                                                            <span id="RegExVNewPassword" style="color:Red;display:none;">Minimum Password length 8</span>
                                                                            <span id="NewPasswordRequired" title="New Password is required." style="color:Red;display:none;">New Password is required.</span><br /><span id="CompareValidator1" style="color:Red;display:none;">Current Password and New Password should not be the same</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <label for="ConfirmNewPassword" id="ConfirmNewPasswordLabel">Ulangi password baru:</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center">
                                                                            <input name="ConfirmNewPassword" type="password" id="ConfirmNewPassword" class="txt" style="width:200px;" />
                                                                            <span id="ConfirmNewPasswordRequired" title="Confirm New Password is required." style="color:Red;display:none;">Confirm New Password is required.</span>
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" colspan="2">
                                                                            <span id="NewPasswordCompare" style="color:Red;display:none;">The Confirm New Password must match the New Password entry.</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" colspan="2" style="color: Red;">
                                                                            <span id="lblError"></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" colspan="2" style="color: Red;">
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <br>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align:center">
                                                                            <input type="submit" name="ChangePassword" value="Ganti Password" onclick="" id="ChangePasswordPushButton" class="smallbtn" onsubmit="" />
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>                                         
                                                </form>

                                            </div>
                                        </div>

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

                    <!-- Datatables-->
                    
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
                    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

                    <!-- Datatable init js -->
                    <script src="assets/pages/datatables.init.js"></script>
                    <script src="assets/js/app.js"></script>
                    <script type="text/javascript">
                        //Date picker
                        $( "#inputTanggalAwal" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalAkhir" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });

                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#data-kehadiran').DataTable( {
                                "ordering": false,
                                "pageLength": 50,
                            } );
                        } );
                    </script>
                </body>
            </html>
            <?php
        }

    }
    elseif(isset($_POST['Action']))
    {
        if($_POST['Action']=='User_Tambah')
        {
            $KaryawanNID = $_POST['KaryawanNID'];
            $KaryawanNID = str_replace('&#39;',"'",$KaryawanNID);
            $KaryawanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KaryawanNID));
            
            //Ambil data Username 
            $sql = "SELECT * FROM data_karyawan ul
                        WHERE ul.KaryawanNID = '".$KaryawanNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $NIM = $buff['NIM'];
            $Nama_Lengkap = $buff['Nama_Lengkap'];
            $Tanggal_Lahir = $buff['Tanggal_Lahir'];
            $Nama_Password = strtoupper(substr($Nama_Lengkap,0,1));
            $Tanggal_Lahir_Password = substr($Tanggal_Lahir,0,4).substr($Tanggal_Lahir,5,2).substr($Tanggal_Lahir,-2);
            

            //cek apakah user sudah ada
            $sql = "SELECT * FROM user_list ul
                        WHERE ul.Username = '".$NIM."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                
                $Password = "smartsoftware";  //Password default
                $Password = $Nama_Password.$Tanggal_Lahir_Password;
                //echo $Password."<br>";
			    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);
                //Tambah data user ke tabel user_list
                $sql = "INSERT INTO user_list (Username, Password, Login_Retry, Creator, Create_Date, Last_User) VALUES 
                            ('$NIM', '$hashed_password', 0, '$Last_UserNID', now(), '$Last_UserNID' )";
                //echo $sql."<br>";
                $qry = mysqli_query($Connection, $sql);
                $UserNID = mysqli_insert_id($Connection);

                //Tambah data hak akses karyawan ke table user_hak
                $sql = "INSERT INTO user_hak (Jenis_UserNID, UserNID, Creator, Create_Date, Last_User) VALUES 
                            (3, '$UserNID', '$Last_UserNID', now(), '$Last_UserNID')";
                //echo $sql."<br>";
                $qry = mysqli_query($Connection, $sql);
                            
            }
            ?>
                <script>
                    window.location.href="pengaturan.php?Action=Daftar_User";
                </script>
            <?php

        }
        elseif($_POST['Action']=='Hak_User_Tambah')
        {
            
            $UserNID = $_POST['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            $Jenis_UserNID = $_POST['Jenis_UserNID'];
            $Jenis_UserNID = str_replace('&#39;',"'",$Jenis_UserNID);
            $Jenis_UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Jenis_UserNID));
            
            //cek apakah user sudah ada
            $sql = "SELECT * FROM user_hak ul
                        WHERE ul.UserNID = '".$UserNID."' AND ul.Jenis_UserNID = '".$Jenis_UserNID."' ";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Tambah data user ke tabel user_list
                $sql = "INSERT INTO user_hak (UserNID, Jenis_UserNID, Creator, Create_Date, Last_User) VALUES 
                            ('$UserNID', '$Jenis_UserNID', '$KaryawanNID', now(), '$KaryawanNID' )";
                //echo $sql."<br>";
                $qry = mysqli_query($Connection, $sql);
                            
            }
            ?>
                <script>
                    window.location.href="pengaturan.php?Action=Daftar_Hak_Akses&UserNID=<?php echo $UserNID ?>";
                </script>
            <?php

        }
        elseif($_POST['Action']=='Ganti_Password')
        {
            //echo "test";
            //$CurrentPassword = $_POST['CurrentPassword'];
            //$NewPassword = $_POST['NewPassword'];
            //$ConfirmNewPassword = $_POST['ConfirmNewPassword'];
            //echo "UserNID : ".$UserNID."<br>";
            //echo "CurrentPassword : ".$CurrentPassword."<br>";
            //echo "NewPassword : ".$NewPassword."<br>";
            //echo "ConfirmNewPassword : ".$ConfirmNewPassword."<br>";
            
            $UserNID = $_POST['UserNID'];
            $UserNID = str_replace('&#39;',"'",$UserNID);
            $UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID));

            $CurrentPassword = $_POST['CurrentPassword'];
            $CurrentPassword = str_replace('&#39;',"'",$CurrentPassword);
            $CurrentPassword = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CurrentPassword));

            $NewPassword = $_POST['NewPassword'];
            $NewPassword = str_replace('&#39;',"'",$NewPassword);
            $NewPassword = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$NewPassword));

            $ConfirmNewPassword = $_POST['ConfirmNewPassword'];
            $ConfirmNewPassword = str_replace('&#39;',"'",$ConfirmNewPassword);
            $ConfirmNewPassword = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$ConfirmNewPassword));

            //echo "UserNID : ".$UserNID."<br>";
            //echo "CurrentPassword : ".$CurrentPassword."<br>";
            //echo "NewPassword : ".$NewPassword."<br>";
            //echo "ConfirmNewPassword : ".$ConfirmNewPassword."<br>";
            
            //ambil password saat ini
            $sql = 	"SELECT * FROM user_list ul
                        WHERE ul.UserNID='".$UserNID."'";
            //echo $sql."<br>";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            //echo $num;
            $buff = mysqli_fetch_array($qry);
            $Password = $buff['Password'];
            $hashed_password = password_hash($CurrentPassword, PASSWORD_DEFAULT);
            //echo $Password."<br>";
            //echo $hashed_password."<br>";
            if(password_verify($CurrentPassword, $Password))
            {
                //echo "Password lama sesuai";
                if($NewPassword==$ConfirmNewPassword)
                {
                    if($NewPassword=="")
                    {
                        ?>
                        <script>
                            alert("Password baru tidak boleh kosong")
                            window.location=history.go(-1);
                        </script>
                        <?php
                    }
                    else
                    {
                        $hashed_password = password_hash($NewPassword, PASSWORD_DEFAULT);
                        $sql = 	"UPDATE user_list SET Password='".$hashed_password."'  WHERE UserNID='".$UserNID."'";
                        //echo $sql."<br>";
                        $qry = mysqli_query($Connection, $sql);
                        ?>
                        <script>
                            alert("Sukses")
                            window.location='index.php';
                        </script>
                        <?php
                    }
                }
                else
                {
                    ?>
                        <script>
                            alert("New Password dan Confirm New Password tidak sama")
                            window.location=history.go(-1);
                        </script>
                        <?php
                }
            }
            else
            {
                ?>
                <script>
                    alert("Password saat ini salah!")
                    window.location=history.go(-1);
                </script>
                <?php
            }
            
            ?>
                <script>
                    window.location.href="index.php";
                </script>
            <?php

        }
        elseif($_POST['Action']=='Simpan_PP')
        {
            if($_FILES['inputFileBefore']['name']<>"")
            {
                $Default_PP_Dir = "../files/profile_pictures/";
                $filename = $_FILES['inputFileBefore']['name'];
                $temp_Nama_File = $_FILES['inputFileBefore']['tmp_name'];
                $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                {
                    //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                    $Nama_File = $Last_User.".".$Ekstensi_File;
                    $Lampiran = $Nama_File;
                    $Target_Lokasi_Penyimpanan = $Default_PP_Dir.$Nama_File;
                    // Upload file
                    move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);

                    //Jika file gambar, maka gambar akan dikecilkan
                    if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                    {
                        $Max_Width = 500;
                        if(strtolower($Ekstensi_File) == 'jpeg' || strtolower($Ekstensi_File) == 'jpg')
                        {
                            //Resize file
                            list($width, $height, $type, $attr) = getimagesize($Target_Lokasi_Penyimpanan );
                            if($width > $Max_Width)
                            {
                                $target_filename = $Target_Lokasi_Penyimpanan;

                                //ambil rasio gambar
                                //$ratio = $width/$height;
                                $ratio = $height/$width;
                                $New_Width = $Max_Width;
                                $New_Height = $New_Width*$ratio;

                                $src = imagecreatefromstring( file_get_contents( $Target_Lokasi_Penyimpanan ) );
                                $dst = imagecreatetruecolor( $New_Width, $New_Height );
                                imagecopyresampled( $dst, $src, 0, 0, 0, 0, $New_Width, $New_Height, $width, $height );
                                imagedestroy( $src );
                                imagejpeg( $dst, $target_filename ); // adjust format as needed
                                imagedestroy( $dst );
                            }

                        }
                        elseif(strtolower($Ekstensi_File) == 'png')
                        {

                            //Resize file
                            list($width, $height, $type, $attr) = getimagesize($Target_Lokasi_Penyimpanan );
                            if($width > $Max_Width)
                            {
                                $target_filename = $Target_Lokasi_Penyimpanan;

                                //ambil rasio gambar
                                //$ratio = $width/$height;
                                $ratio = $height/$width;
                                $New_Width = $Max_Width;
                                $New_Height = $New_Width*$ratio;

                                $src = imagecreatefromstring( file_get_contents( $Target_Lokasi_Penyimpanan ) );
                                $dst = imagecreatetruecolor( $New_Width, $New_Height );
                                imagecopyresampled( $dst, $src, 0, 0, 0, 0, $New_Width, $New_Height, $width, $height );
                                imagedestroy( $src );
                                imagepng( $dst, $target_filename ); // adjust format as needed
                                imagedestroy( $dst );
                            }
                            //imagealphablending($rotate, false);
                            //imagesavealpha($rotate, true);

                        }
                        elseif(strtolower($Ekstensi_File) == 'bmp')
                        {
                            //Resize file
                            list($width, $height, $type, $attr) = getimagesize($Target_Lokasi_Penyimpanan );
                            if($width > $Max_Width)
                            {
                                $target_filename = $Target_Lokasi_Penyimpanan;

                                //ambil rasio gambar
                                //$ratio = $width/$height;
                                $ratio = $height/$width;
                                $New_Width = $Max_Width;
                                $New_Height = $New_Width*$ratio;

                                $src = imagecreatefromstring( file_get_contents( $Target_Lokasi_Penyimpanan ) );
                                $dst = imagecreatetruecolor( $New_Width, $New_Height );
                                imagecopyresampled( $dst, $src, 0, 0, 0, 0, $New_Width, $New_Height, $width, $height );
                                imagedestroy( $src );
                                imagebmp( $dst, $target_filename ); // adjust format as needed
                                imagedestroy( $dst );
                            }
                        }
                    }
                    //$Jumlah_Sukses++;
                    //echo $filename." sukses.<br>";
                    $sql = "UPDATE data_karyawan sp SET
                                sp.Profile_Picture = '".$Lampiran."', 
                                sp.Last_User = '".$Last_UserNID."'
                                WHERE sp.KaryawanNID = '".$KaryawanNID."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Simpan_File_Berhasil = 1;
                    ?>
                        <script>
                            window.location.href="index.php";
                        </script>
                    <?php

                }
                else
                {
                    $Simpan_File_Berhasil = 0;
                    echo " Proses update gagal, silahkan cek ekstensi file. Ekstensi file yang bisa diterima jpg, jpeg, dan pdf.<br>";
                    ?>
                    <a href="javascript:window.history.back()">Kembali</a>
                    <?php
                    //$Jumlah_Error++;
                }
            }
        }
        
        
    }
    
}

