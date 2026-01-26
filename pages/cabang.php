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
    $Default_Profile_Picture_Dir = "../files/profile_pictures/";
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
    $Last_UserNID = $_SESSION['Last_UserNID'];
    $Nama_Lengkap_User = $_SESSION['Nama_Lengkap'];

    $Nama_Hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $Nama_Bulan = array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    $TanggalSekarang = date('Y-m-d');
    $ArrayTanggalSekarang = explode('-', $TanggalSekarang);
    $TanggalSekarang = $ArrayTanggalSekarang[2]."-".$ArrayTanggalSekarang[1]."-".$ArrayTanggalSekarang[0];

    //Ambil default hak akses
    $sql = "SELECT * FROM user_list ul
                INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                WHERE ul.Username = '".$Last_User."'
                LIMIT 1 ";
    //echo $sql.";<br>";
    $qry = mysqli_query($Connection, $sql);
    $buff = mysqli_fetch_array($qry);
    $Hak_Akses = $_SESSION['Hak_Akses'];

    $Link_Profile = "javascript:void(0)";
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');

    if(isset($_GET['Action']))
    {
        if($_GET['Action']=='Daftar')
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
                                <!--<img src="assets/images/favicon/apple-icon-60x60.png" alt="" class="logo-sm">-->
                                
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
                                                <a href="prestasi_cabang.php?Action=Daftar" class="waves-effect"><i class="fa fa-star"></i><span> Prestasi </span></a>
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
                                        <h4 class="page-title">Daftar Cabang</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <?php 
                                                if($Hak_Akses==1)
                                                {
                                                    ?>
                                                    <p><a href="cabang.php?Action=Dokumen_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
                                                    <?php
                                                }
                                                ?>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=30% rowspan=1 style="text-align:center;vertical-align:middle">Nama Cabang</th>
                                                            <th width=35% rowspan=1 style="text-align:center;vertical-align:middle">Leader</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Jumlah Anggota</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT c.*, k.Nama_Lengkap FROM cabang c 
                                                                    LEFT JOIN data_karyawan k ON k.CabangNID = c.CabangNID AND k.KaryawanNID = c.Team_Leader
                                                                    ORDER BY c.Nama_Cabang ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $CabangNID  = $buff_Data_Siswa['CabangNID'];
                                                            $Nama_Cabang = $buff_Data_Siswa['Nama_Cabang'];
                                                            $Jumlah_Anggota = $buff_Data_Siswa['Jumlah_Anggota'];
                                                            $Leader = $buff_Data_Siswa['Nama_Lengkap'];
                                                            
                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Nama_Cabang ?></td>
                                                                <td style="text-align:left"><?php echo $Leader ?></td>
                                                                <td style="text-align:center"><?php echo $Jumlah_Anggota ?></td>
                                                                <td style="text-align:center">
                                                                    <a href="cabang.php?Action=View&CabangNID=<?php echo $CabangNID ?>" title="Update Data"><span ><i class="fa fa-pencil"></i></span></a>
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
        elseif($_GET['Action']=='Daftar_Alumni')
        {
        }
        elseif($_GET['Action']=='View')
        {
            $CabangNID = $_GET['CabangNID'];
            $CabangNID = str_replace('&#39;',"'",$CabangNID);
            $CabangNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID));            

            //Ambil data siswa
            $sql = "SELECT c.*, k.Nama_Lengkap FROM cabang c 
                        LEFT JOIN data_karyawan k ON k.CabangNID = c.CabangNID AND k.KaryawanNID = c.Team_Leader 
                        WHERE c.CabangNID = '".$CabangNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            //$Username = $buff['Username'];
            //$Tanggal_Masuk = $buff['Tanggal_Masuk'];
            $Nama_Cabang = $buff['Nama_Cabang'];
            $Jumlah_Anggota = $buff['Jumlah_Anggota'];
            $Nama_Lengkap = $buff['Nama_Lengkap'];
            
            $Create_Date = $buff['Create_Date'];
            $Last_Update = $buff['Last_Update'];
            $Creator = $buff['Creator'];
            
            if($Creator==1 || $Creator==2)
            {
                if($Creator==1)
                {
                    $Creator = "SA";
                }
                else
                {
                    $Creator = "System";
                }
            }
            else
            {
                $sql = "SELECT dk.Nama_Lengkap AS Creator FROM data_karyawan dk
                                WHERE dk.NIM = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Creator = $buff['Creator'];
            }
            if($Last_User==1 || $Last_User==2)
            {
                if($Last_User==1)
                {
                    $Last_User = "SA";
                }
                else
                {
                    $Last_User = "System";
                }
            }
            else
            {
                $sql = "SELECT dk.Nama_Lengkap AS Last_User FROM data_karyawan dk
                                WHERE dk.NIM = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Last_User = $buff['Last_User'];
            }
            
            
            

            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'cabang.php?Action=Daftar';
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
                                                <a href="cabang.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="cabang.php?Action=Prestasi&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-star"></i><span> Prestasi </span></a>
                                            </li>
                                            <li>
                                                <a href="dokumen_cabang.php?Action=Daftar&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-files-o"></i><span> Dokumen </span></a>
                                            </li>
                                            <li>
                                                <a href="jurnal_cabang.php?Action=Daftar&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-pencil-square-o"></i><span> Catatan </span></a>
                                            </li>
                                            <li>
                                                <a href="cabang.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="cabang.php?Action=Prestasi&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-star"></i><span> Prestasi </span></a>
                                            </li>
                                            <li>
                                                <a href="dokumen_cabang.php?Action=Daftar&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-files-o"></i><span> Dokumen </span></a>
                                            </li>
                                            <li>
                                                <a href="jurnal_cabang.php?Action=Daftar&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="fa fa-pencil-square-o"></i><span> Catatan </span></a>
                                            </li>
                                            <li>
                                                <a href="cabang.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Data Cabang</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="cabang.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Update' type="hidden" name="Action" value="Data_Siswa_Update">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Cabang</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <?php echo $Nama_Cabang ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNamaPanggilan" class="col-sm-3 ">Jumlah Anggota</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php echo $Jumlah_Anggota ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNIS" class="col-sm-3 ">Team Leader</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php echo $Nama_Lengkap ?>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="row ">
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Creator : <?php echo $Creator ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Create Time : <?php echo $Create_Date ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last User : <?php echo $Last_User ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last Update : <?php echo $Last_Update ?>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    <?php
                                                    if($Hak_Akses==1 || $Hak_Akses==4)
                                                    {
                                                        ?>
                                                        <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                            <div class="form-group">
                                                                <a href="cabang.php?Action=Edit_Siswa&CabangNID=<?php echo $CabangNID ?>" class="btn btn-info" > Edit</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                    <!--<div class="col-sm-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-4 control-label">Nama</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="" name="Nama" value="">
                                                            </div>
                                                        </div>
                                                    </div>-->
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
                        } );
                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='View_Alumni')
        {
        }
        elseif($_GET['Action']=='Foto_Upload')
        {
        }
        elseif($_GET['Action']=='Edit_Siswa')
        {
            $CabangNID = $_GET['CabangNID'];
            $CabangNID = str_replace('&#39;',"'",$CabangNID);
            $CabangNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID));            

            //Ambil data siswa
            $sql = "SELECT c.*, k.Nama_Lengkap FROM cabang c 
                        LEFT JOIN data_karyawan k ON k.CabangNID = c.CabangNID AND k.KaryawanNID = c.Team_Leader 
                        WHERE c.CabangNID = '".$CabangNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            //$Username = $buff['Username'];
            //$Tanggal_Masuk = $buff['Tanggal_Masuk'];
            $Nama_Cabang = $buff['Nama_Cabang'];
            $Jumlah_Anggota = $buff['Jumlah_Anggota'];
            $Nama_Lengkap = $buff['Nama_Lengkap'];
            $Team_Leader = $buff['Team_Leader'];
            
            $Create_Date = $buff['Create_Date'];
            $Last_Update = $buff['Last_Update'];
            $Creator = $buff['Creator'];
            
            if($Creator==1 || $Creator==2)
            {
                if($Creator==1)
                {
                    $Creator = "SA";
                }
                else
                {
                    $Creator = "System";
                }
            }
            else
            {
                $sql = "SELECT dk.Nama_Lengkap AS Creator FROM data_karyawan dk
                                WHERE dk.NIM = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Creator = $buff['Creator'];
            }
            if($Last_User==1 || $Last_User==2)
            {
                if($Last_User==1)
                {
                    $Last_User = "SA";
                }
                else
                {
                    $Last_User = "System";
                }
            }
            else
            {
                $sql = "SELECT dk.Nama_Lengkap AS Last_User FROM data_karyawan dk
                                WHERE dk.NIM = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Last_User = $buff['Last_User'];
            }
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'cabang.php?Action=Daftar';
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
                                    if($Hak_Akses==1) //Administrator
                                    {

                                    }
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="cabang.php?Action=View&CabangNID=<?php echo $CabangNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Update Data Cabang</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="cabang.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Update' type="hidden" name="Action" value="Data_Siswa_Update">
                                                    <input id='CabangNID' type="hidden" name="CabangNID" value="<?php echo $CabangNID ?>">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Cabang</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNama_Cabang" name="Nama_Cabang" value="<?php echo $Nama_Cabang ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNamaPanggilan" class="col-sm-3 ">Jumlah Anggota</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputJumlah_Anggota" name="Jumlah_Anggota" value="<?php echo $Jumlah_Anggota ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputStatusAnak" class="col-sm-3 ">Team Leader</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT * FROM data_karyawan dk 
                                                                            WHERE dk.CabangNID = '".$CabangNID."' ";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="Team_Leader" id="Team_Leader">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Current_Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                        //$KaryawanNID  = $buff['KaryawanNID'];
                                                                        $Current_KaryawanNID  = $buff['KaryawanNID'];
                                                                        ?>
                                                                        <option value="<?php echo $Current_KaryawanNID ?>" <?php echo ($Current_KaryawanNID==$Team_Leader)?"selected":"" ?>><?php echo $Current_Nama_Lengkap ?></option>
                                                                        <?php    
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        


                                                        <div class="row ">
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Creator : <?php echo $Creator ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Create Time : <?php echo $Create_Date ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last User : <?php echo $Last_User ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last Update : <?php echo $Last_Update ?>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Filter"> Simpan</button>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-sm-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-4 control-label">Nama</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="" name="Nama" value="">
                                                            </div>
                                                        </div>
                                                    </div>-->
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
                        $( "#inputTanggalDiterima" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalLahir" ).datepicker({
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
                        } );
                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Dokumen_Tambah')
        {
            
            $Nama_Cabang = "";
            $Jumlah_Anggota = "";
            $Nama_Lengkap = "";
            $Team_Leader = "";
            
            $Create_Date = "";
            $Last_Update = "";
            $Creator = "";
            $Last_User = "";
            

            
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'cabang.php?Action=Daftar';
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
                                    if($Hak_Akses==1) //Administrator
                                    {

                                    }
                                    ?>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="cabang.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Tambah Data Cabang</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="cabang.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Update' type="hidden" name="Action" value="Data_Siswa_Tambah">
                                                    <input id='CabangNID' type="hidden" name="CabangNID" value="<?php echo $CabangNID ?>">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Cabang</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNama_Cabang" name="Nama_Cabang" value="<?php echo $Nama_Cabang ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNamaPanggilan" class="col-sm-3 ">Jumlah Anggota</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputJumlah_Anggota" name="Jumlah_Anggota" value="<?php echo $Jumlah_Anggota ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputStatusAnak" class="col-sm-3 ">Team Leader</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT * FROM data_karyawan dk 
                                                                            WHERE dk.IsLeader NOT IN (2)";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="Team_Leader" id="Team_Leader">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Current_Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                        //$KaryawanNID  = $buff['KaryawanNID'];
                                                                        $Current_KaryawanNID  = $buff['KaryawanNID'];
                                                                        ?>
                                                                        <option value="<?php echo $Current_KaryawanNID ?>" <?php echo ($Current_KaryawanNID==$Team_Leader)?"selected":"" ?>><?php echo $Current_Nama_Lengkap ?></option>
                                                                        <?php    
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        


                                                        <div class="row ">
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Creator : <?php echo $Creator ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Create Time : <?php echo $Create_Date ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last User : <?php echo $Last_User ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last Update : <?php echo $Last_Update ?>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Filter"> Simpan</button>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-sm-6 col-lg-4">
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-4 control-label">Nama</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="" name="Nama" value="">
                                                            </div>
                                                        </div>
                                                    </div>-->
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
                        $( "#inputTanggalDiterima" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
                        $( "#inputTanggalLahir" ).datepicker({
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
                        } );
                    </script>
                </body>
            </html>
            <?php
        }
        
        
    }
    elseif(isset($_POST['Action']))
    {
        if($_POST['Action']=='Prestasi_Siswa_Update' || $_POST['Action']=='Prestasi_Siswa_Tambah')
        {
            
        }
        elseif($_POST['Action']=='Filter_Siswa')
        {
            if(isset($_POST['Filter']))
            {
                $Agama = $_POST['Filter_Agama'];
                $Jenis_Kelamin = $_POST['Filter_Jenis_Kelamin'];
                
                $_SESSION['Filter_Agama_Siswa'] =  $Agama;
                $_SESSION['Filter_Gender_Siswa'] = $Jenis_Kelamin;
            }
            elseif(isset($_POST['Reset']))
            {
                $_SESSION['Filter_Agama_Siswa'] =  999;
                $_SESSION['Filter_Gender_Siswa'] = 999;
            }
            
            ?>
                <script>
                    window.location.href="cabang.php?Action=Daftar";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Filter_Tanggal_Rekap')
        {
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            //$_SESSION['Current_Page'] = "";
            if(isset($_POST['Filter']))
            {
                $Tanggal_Awal = $_POST['Tanggal_Awal'];
                
                $ArrayTanggal = explode('-', $Tanggal_Awal);
                $Tanggal_Awal = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

                $_SESSION['Tanggal_Awal'] =  $Tanggal_Awal;
            }
            elseif(isset($_POST['Reset']))
            {
                $_SESSION['Tanggal_Awal'] =  date('Y-m-d');;
            }
            
            ?>
                <script>
                    window.location.href="kehadiran_karyawan.php?Action=Rekap";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Filter_Tanggal_Rekap_Karyawan')
        {
            $Finger_PrintNID = $_POST['Finger_PrintNID'];
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            //$_SESSION['Current_Page'] = "";
            if(isset($_POST['Filter']))
            {
                $Bulan_Rekap = $_POST['FilterBulan'];
                $Tahun_Rekap = $_POST['FilterTahun'];
                
                $_SESSION['Bulan_Rekap'] =  $Bulan_Rekap;
                $_SESSION['Tahun_Rekap'] = $Tahun_Rekap;
            }
            elseif(isset($_POST['Reset']))
            {
                $_SESSION['Tahun_Rekap'] =  date("Y");
                $_SESSION['Bulan_Rekap'] = substr("0".date("m"),-2);
            }
            
            ?>
                <script>
                    window.location.href="kehadiran_karyawan.php?Action=Rekap_Karyawan&Finger_PrintNID=<?php echo $Finger_PrintNID?>";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Data_Siswa_Update')
        {
            $CabangNID = $_POST['CabangNID'];
            $CabangNID = str_replace('&#39;',"'",$CabangNID);
            $CabangNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID));

            $Nama_Cabang = $_POST['Nama_Cabang'];
            $Nama_Cabang = str_replace('&#39;',"'",$Nama_Cabang);
            $Nama_Cabang = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nama_Cabang));

            $Jumlah_Anggota = $_POST['Jumlah_Anggota'];
            $Jumlah_Anggota = str_replace('&#39;',"'",$Jumlah_Anggota);
            $Jumlah_Anggota = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Jumlah_Anggota));

            $Team_Leader = $_POST['Team_Leader'];
            $Team_Leader = str_replace('&#39;',"'",$Team_Leader);
            $Team_Leader = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Team_Leader));

            
            $sql = "SELECT * FROM cabang ds 
                        WHERE ds.Nama_Cabang = '".$Nama_Cabang."' AND ds.CabangNID <> '".$CabangNID."' ";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Update cabang
                $sql = "UPDATE cabang ds SET
                            ds.Nama_Cabang = '".$Nama_Cabang."', 
                            ds.Jumlah_Anggota = '".$Jumlah_Anggota."', 
                            ds.Team_Leader = '".$Team_Leader."', 
                            ds.Last_User = '".$Last_UserNID."'
                            WHERE ds.CabangNID = '".$CabangNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

                //update team leader

            }
            else
            {
                
            }

            ?>
                <script>
                    window.location.href="cabang.php?Action=Daftar";
                </script>
            <?php
            
            
        }
        elseif($_POST['Action']=='Data_Siswa_Tambah')
        {

            $Nama_Cabang = $_POST['Nama_Cabang'];
            $Nama_Cabang = str_replace('&#39;',"'",$Nama_Cabang);
            $Nama_Cabang = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nama_Cabang));

            $Jumlah_Anggota = $_POST['Jumlah_Anggota'];
            $Jumlah_Anggota = str_replace('&#39;',"'",$Jumlah_Anggota);
            $Jumlah_Anggota = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Jumlah_Anggota));

            $Team_Leader = $_POST['Team_Leader'];
            $Team_Leader = str_replace('&#39;',"'",$Team_Leader);
            $Team_Leader = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Team_Leader));

            
            $sql = "SELECT * FROM cabang ds 
                        WHERE ds.Nama_Cabang = '".$Nama_Cabang."'";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Update cabang
                $sql = "INSERT INTO cabang (Nama_Cabang, Jumlah_Anggota, Team_Leader, Creator, Create_Date, Last_User) VALUES (
                            '$Nama_Cabang', '$Jumlah_Anggota' , '$Team_Leader', '$Last_UserNID', now(), '$Last_UserNID') ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

                //update team leader

            }
            else
            {
                
            }

            ?>
                <script>
                    window.location.href="cabang.php?Action=Daftar";
                </script>
            <?php

            
        }
        elseif($_POST['Action']=='Foto_Upload')
        {
            if(isset($_POST['submit']))
            {
                // Count total files
                $countfiles = count($_FILES['file']['name']);
                $target_dir = "../files/profile_pictures";
                // Looping all files
                $Jumlah_Error = 0;
                $Jumlah_Sukses = 0;
                for($i=0;$i<$countfiles;$i++)
                {
                    $filename = $_FILES['file']['name'][$i];
                    $temp_Nama_File = $_FILES['file']['tmp_name'][$i];
                    $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                    //echo "Ekstensi file ".$Ekstensi_File."<br>";
                    if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg')
                    {
                        $Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                        $Nama_File = $Nama_File.".".$Ekstensi_File;
                        $Target_Lokasi_Penyimpanan = $target_dir."/".$Nama_File;
                        // Upload file
                        move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);
                        $Jumlah_Sukses++;
                        echo $filename." sukses.<br>";
                        
                        //move_uploaded_file($_FILES['file']['tmp_name'][$i],'../files/profile_pictures/'.$filename);
                    }
                    else
                    {
                        echo $filename." gagal.<br>";
                        $Jumlah_Error++;
                    }
                    
                }
                echo "Ada ".$Jumlah_Error." file yang gagal di upload, cek ekstensi file.<br>"
                ?>
                <a href="cabang.php?Action=Foto_Upload">Kembali</a>
                <?php
                ;

            }
        }
    }
    
    
}

