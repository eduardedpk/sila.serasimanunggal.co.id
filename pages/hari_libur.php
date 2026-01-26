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
    $Default_Dokumen_Dir = "../files/laporan_harian/";
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
    $CabangNID = $_SESSION['CabangNID'];

    $Daftar_Bulan = Array(1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember' );
    $Daftar_Hari = Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

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
                                    //$Hak_Akses = 3;
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
                                <?php
                                //cari nama cabang
                                ?>    
                                <div class="">
                                    <div class="page-header-title">
                                        <h4 class="page-title">Daftar Hari Libur (Tanggal Merah) </h4>
                                    </div>
                                </div>
                                <?php
                                if(isset($_GET['Tanggal']))
                                {
                                    $Tanggal_Laporan = $_GET['Tanggal'];
                                    $_SESSION['Periode_Laporan'] = $Tanggal_Laporan;
                                }
                                else
                                {   
                                    if(!isset($_SESSION['Tanggal_Laporan']))
                                    {
                                        $_SESSION['Tanggal_Laporan'] = date('Y-m-d');
                                        $Tanggal_Laporan = $_SESSION['Tanggal_Laporan'];
                                    }
                                    else
                                    {
                                        $Tanggal_Laporan = $_SESSION['Tanggal_Laporan'];
                                    }
                                    
                                }

                                if(isset($_GET['Cabang']))
                                {
                                    $Filter_Cabang = $_GET['Cabang'];
                                    $_SESSION['Filter_Cabang'] = $Filter_Cabang;
                                }
                                else
                                {   

                                    if(!isset($_SESSION['Filter_Cabang']))
                                    {
                                        $_SESSION['Filter_Cabang'] = 1;
                                        $Filter_Cabang = $_SESSION['Filter_Cabang'];
                                    }
                                    else
                                    {
                                        $Filter_Cabang = $_SESSION['Filter_Cabang'];
                                    }
                                    //echo "Cabang : ".$Filter_Cabang."<br>";
                                    
                                }
                                ?>
                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <?php 
                                                if($Hak_Akses==1)
                                                {
                                                    ?>
                                                    <p><a href="hari_libur.php?Action=Dokumen_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Data</p></p>
                                                    <?php
                                                }
                                                ?>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=10% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=35% rowspan=1 style="text-align:left;vertical-align:middle">Hari, Tanggal</th>
                                                            <th width=45% colspan=1 style="text-align:left;vertical-align:middle">Keterangan</th>
                                                            <th width=10% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $Tahun_Tanggal = substr($Tanggal_Laporan, 0,4);
                                                        $Bulan_Tanggal = substr($Tanggal_Laporan, 5,2);
                                                        $Nomor_Urut = 1;
                                                        if($Hak_Akses==1)
                                                        {
                                                            $sql = "SELECT * FROM hari_libur h 
                                                                        ORDER BY h.Tanggal DESC";
                                                        }
                                                        else
                                                        {
                                                            
                                                        }
                                                        
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $Hari_LiburNID = $buff_Data_Siswa['Hari_LiburNID'];
                                                            $Tanggal_Report = $buff_Data_Siswa['Tanggal'];
                                                            $Keterangan = $buff_Data_Siswa['Deskripsi'];
                                                            $Tanggal_Report_Tampilan = strtotime($Tanggal_Report);
                                                            $Hari = date("w", $Tanggal_Report_Tampilan );


                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><a href="hari_libur.php?Action=Dokumen_Update&Hari_LiburNID=<?php echo $Hari_LiburNID ?>"><?php echo $Daftar_Hari[$Hari].", ".date("d-m-Y", $Tanggal_Report_Tampilan) ?></a></td>
                                                                <td style="text-align:left"><?php echo $Keterangan ?></td>
                                                                <td style="text-align:center">
                                                                    <a href="hari_libur.php?Action=Dokumen_Hapus&Hari_LiburNID=<?php echo $Hari_LiburNID ?>"><i class="fa fa-trash"></i></a>
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
                    <script>
                        function CekWaktu() 
                        {
                            var Tanggal = document.getElementById("inputWaktu").value;
                            
                            window.location.href="hari_libur.php?Action=Daftar&Tanggal="+Tanggal;
                        }
                        function CekCabang() 
                        {
                            var Cabang = document.getElementById("inputCabang").value;
                            
                            window.location.href="hari_libur.php?Action=Daftar&Cabang="+Cabang;
                        }
                        
                    </script>
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
        elseif($_GET['Action']=='Detail_Laporan')
        {
            $Tanggal_Laporan = $_GET['Tanggal'];
            $Tanggal_Laporan = str_replace('&#39;',"'",$Tanggal_Laporan);
            $Tanggal_Laporan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal_Laporan));

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
                                    //$Hak_Akses = 3;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="hari_libur.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="hari_libur.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="hari_libur.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                            <?php
                                
                                $Tanggal_Report = $Tanggal_Laporan;
                                $Tanggal_Report_Tampilan = strtotime($Tanggal_Report);
                                $Hari = date("w", $Tanggal_Report_Tampilan );
                                
                                ?>
                                <div class="">
                                    <div class="page-header-title">
                                        <h4 class="page-title">Laporan Harian <?php echo $Daftar_Hari[$Hari].", ".date("d-m-Y", $Tanggal_Report_Tampilan) ?></h4>
                                    </div>
                                </div>
                                
                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <?php 
                                                if($Hak_Akses==3)
                                                {
                                                    ?>
                                                    <p><a href="hari_libur.php?Action=Dokumen_Detail_Tambah&Tanggal=<?php echo $Tanggal_Laporan ?>" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Data</p></p>
                                                    <?php
                                                }
                                                ?>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=35% rowspan=1 style="text-align:left;vertical-align:middle">Keterangan</th>
                                                            <th width=25% colspan=1 style="text-align:left;vertical-align:middle">Before</th>
                                                            <th width=25% colspan=1 style="text-align:left;vertical-align:middle">After</th>
                                                            <th width=10% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Tahun_Tanggal = substr($Tanggal_Laporan, 0,4);
                                                        $Bulan_Tanggal = substr($Tanggal_Laporan, 5,2);
                                                        $Nomor_Urut = 1;
                                                        if($Hak_Akses==2)
                                                        {
                                                            $Filter_Cabang = $_SESSION['Filter_Cabang'];
                                                            $sql = "SELECT lh.* FROM laporan_harian lh
                                                                        WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = ".$Filter_Cabang."
                                                                                AND year(lh.Tanggal) = '".$Tahun_Tanggal."'  AND month(lh.Tanggal) = '".$Bulan_Tanggal."'
                                                                        ";
                                                        }
                                                        else
                                                        {
                                                            $sql = "SELECT lh.* FROM laporan_harian lh
                                                                        WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = ".$CabangNID."
                                                                                AND year(lh.Tanggal) = '".$Tahun_Tanggal."'  AND month(lh.Tanggal) = '".$Bulan_Tanggal."'
                                                                        ";
                                                        }
                                                        
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $Hari_LiburNID = $buff_Data_Siswa['Hari_LiburNID'];
                                                            $Keterangan = $buff_Data_Siswa['Keterangan'];
                                                            $Image_Before = $buff_Data_Siswa['Image_Before'];
                                                            $Image_After = $buff_Data_Siswa['Image_After'];
                                                            $IsValid = $buff_Data_Siswa['IsValid'];
                                                            $Tanggal_Report = $buff_Data_Siswa['Tanggal'];
                                                            $Tanggal_Report_Tampilan = strtotime($Tanggal_Report);
                                                            $Hari = date("w", $Tanggal_Report_Tampilan );

                                                            $Before = $Default_Dokumen_Dir."/".$Image_Before;
                                                            $After = $Default_Dokumen_Dir."/".$Image_After;
                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Keterangan ?></td>
                                                                <td style="text-align:center"><a href="" judul="" data-toggle="modal" src="<?php echo $Before ?>" data-target=".new-project-modal" class="popup"><img src="<?php echo $Before ?>" alt="" style="width: 100%;height: auto;"></a> </td>
                                                                <td style="text-align:center"><a href="" judul="" data-toggle="modal" src="<?php echo $After ?>" data-target=".new-project-modal" class="popup"><img src="<?php echo $After ?>" alt="" style="width: 100%;height: auto;"></a> </td>
                                                                <?php
                                                                if($Hak_Akses==2)
                                                                {
                                                                    ?>
                                                                    
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <td style="text-align:center">
                                                                        <a href="hari_libur.php?Action=Dokumen_Detail_Update&Hari_LiburNID=<?php echo $Hari_LiburNID ?>"><i class="fa fa-pencil"></i></a>
                                                                    </td>
                                                                    <?php
                                                                }

                                                                ?>
                                                                
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

                    <!-- Show Image -->
                    <div class="modal fade show-image-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <img class="" id="popup-img" src="" alt="image">
                            </div>
                        </div>
                    </div>

                    


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
                    <script>
                        function CekWaktu() 
                        {
                            var Tanggal = document.getElementById("inputWaktu").value;
                            
                            window.location.href="hari_libur.php?Action=Daftar&Tanggal="+Tanggal;
                        }
                        
                    </script>
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
                    <script type="text/javascript">
                        $('.popup').click(function(){
                            var src = $(this).attr('src');
                            //alert(src);
                            $('.show-image-modal').modal('show');
                            $('#popup-img').attr('src', src);
                            //alert(src);
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
        elseif($_GET['Action']=='Dokumen_Valid')
        {
            $Hari_LiburNID = $_GET['Hari_LiburNID'];
            $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
            $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));

            $sql = "SELECT * FROM laporan_harian sp
                        WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $IsValid = $buff['IsValid'];
            if($IsValid==0)
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 1
                            WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 0
                            WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            ?>
                <script>
                    window.location.href="javascript:window.history.back()";
                </script>
            <?php
        }
        elseif($_GET['Action']=='Dokumen_Update' || $_GET['Action']=='Dokumen_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Dokumen_Tambah")
            {

                $Nama = "";
                $Keterangan = "";
                $Tanggal_Pembelian = date("d-m-Y");

                $Lampiran = "";

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
            }
            else
            {
                $Hari_LiburNID = $_GET['Hari_LiburNID'];
                $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
                $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM hari_libur sp
                            WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Keterangan = $buff['Deskripsi'];
                $Tanggal_Pembelian = $buff['Tanggal'];
                $Tanggal_Pembelian = substr($Tanggal_Pembelian, -2)."-".substr($Tanggal_Pembelian, 5, 2)."-".substr($Tanggal_Pembelian, 0,4);

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
            }


            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'hari_libur.php?Action=Daftar';
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
                                            <a href="hari_libur.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Foto </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="hari_libur.php" method="post" enctype="multipart/form-data">
                                                    <?php 
                                                    if($Action=="Dokumen_Tambah")
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Siswa_Tambah' type="hidden" name="Action" value="Dokumen_Siswa_Tambah">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Siswa_Update' type="hidden" name="Action" value="Dokumen_Siswa_Update">
                                                        <input id='Hari_LiburNID' type="hidden" name="Hari_LiburNID" value="<?php echo $Hari_LiburNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-3 ">Tanggal</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="inputTanggalAwal" name="Tanggal_Awal" value="<?php echo $Tanggal_Pembelian ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNama" class="col-sm-3 ">Keterangan</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="Keterangan" name="Keterangan" value="<?php echo $Keterangan ?>"   placeholder="Keterangan">
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
                                                            <button type="submit" class="btn btn-info" name="submit"> Simpan</button>
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
                        $( "#inputTanggalAwal" ).datepicker({
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
        elseif($_GET['Action']=='Dokumen_Detail_Update' || $_GET['Action']=='Dokumen_Detail_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            

            if($Action=="Dokumen_Detail_Tambah")
            {

                $Tanggal_Laporan = $_GET['Tanggal'];
                $Tanggal_Laporan = str_replace('&#39;',"'",$Tanggal_Laporan);
                $Tanggal_Laporan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal_Laporan));

                $Tanggal_Report_Tampilan = date("d-m-Y", strtotime($Tanggal_Laporan));
                                
                
                $Nama = "";
                $Keterangan = "";
                $KategoriNID = "";
                $Kondisi_Barang = "";
                $Keadaan_Barang = "";
                $Tanggal_Pembelian = $Tanggal_Report_Tampilan;

                $Lampiran = "";

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
            }
            else
            {
                $Hari_LiburNID = $_GET['Hari_LiburNID'];
                $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
                $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));
                

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM laporan_harian sp
                            WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Tanggal = $buff['Tanggal'];
                $Tanggal_Laporan = $buff['Tanggal'];
                $Image_Before = $buff['Image_Before'];
                $Image_After = $buff['Image_After'];
                $Tanggal_Pembelian = $buff['Tanggal'];
                $Tanggal_Pembelian = substr($Tanggal_Pembelian, -2)."-".substr($Tanggal_Pembelian, 5, 2)."-".substr($Tanggal_Pembelian, 0,4);
                $Keterangan = $buff['Keterangan'];
                
                $Create_Date = $buff['Create_Date'];
                $Last_Update = $buff['Last_Update'];

                $Creator = $buff['Creator'];
                $Last_Akses_User = $buff['Last_User'];
                
                
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
                if($Last_Akses_User==1 || $Last_Akses_User==2)
                {
                    if($Last_Akses_User==1)
                    {
                        $Last_Akses_User = "SA";
                    }
                    else
                    {
                        $Last_Akses_User = "System";
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
                    $Last_Akses_User = $buff['Last_User'];
                }
            }


            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'hari_libur.php?Action=Daftar';
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
                                            <a href="hari_libur.php?Action=Detail_Laporan&Tanggal=<?php echo $Tanggal_Laporan ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Foto </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="hari_libur.php" method="post" enctype="multipart/form-data">
                                                    <?php 
                                                    if($Action=="Dokumen_Detail_Tambah")
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Detail_Tambah' type="hidden" name="Action" value="Dokumen_Detail_Tambah">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Detail_Update' type="hidden" name="Action" value="Dokumen_Detail_Update">
                                                        <input id='Hari_LiburNID' type="hidden" name="Hari_LiburNID" value="<?php echo $Hari_LiburNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-3 ">Tanggal</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="inputTanggalAwal" name="Tanggal_Awal" value="<?php echo $Tanggal_Pembelian ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNama" class="col-sm-3 ">Keterangan</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="Keterangan" name="Keterangan" value="<?php echo $Keterangan ?>"   placeholder="Keterangan">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">Before</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="file" name="inputFileBefore" id="inputFileBefore" class="image-upload" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">After</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="file" name="inputFileAfter" id="inputFileAfter" class="image-upload" >
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
                                                            <button type="submit" class="btn btn-info" name="submit"> Simpan</button>
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
                        $( "#inputTanggalAwal" ).datepicker({
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
        elseif($_GET['Action']=='Dokumen_Hapus')
        {
            
            $Hari_LiburNID = $_GET['Hari_LiburNID'];
            $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
            $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));
           
            
            //Ambil data prestasi siswa
            $sql = "DELETE FROM hari_libur 
                        WHERE Hari_LiburNID = '".$Hari_LiburNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            ?>
            <script>
                  window.history.back();
            </script>
            <?php
            
        }
    }
    elseif(isset($_POST['Action']))
    {
        if($_POST['Action']=='Dokumen_Siswa_Update' || $_POST['Action']=='Dokumen_Siswa_Tambah')
        {
            if(isset($_POST['submit']))
            {

                $Tanggal  = $_POST['Tanggal_Awal'];
                $Tanggal  = str_replace('&#39;',"'",$Tanggal );
                $Tanggal  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal ));
                $Tanggal = substr($Tanggal, -4)."-".substr($Tanggal, 3, 2)."-".substr($Tanggal, 0,2);

                $Keterangan = $_POST['Keterangan'];
                $Keterangan = str_replace('&#39;',"'",$Keterangan);
                $Keterangan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Keterangan));

                $Jenis_LaporanNID = 1; //LPH
                $Waktu_Upload = date("Ymdghis");
                if($_POST['Action']=='Dokumen_Siswa_Update')
                {
                    $Hari_LiburNID = $_POST['Hari_LiburNID'];
                    $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
                    $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));

                    $sql = "UPDATE hari_libur sp SET
                                    sp.Tanggal = '".$Tanggal."', 
                                    sp.Deskripsi = '".$Keterangan."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    
                }
                elseif($_POST['Action']=='Dokumen_Siswa_Tambah')
                {
                    //Simpan data ke database
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO hari_libur(Tanggal, Deskripsi, Creator, Create_Date, Last_User) VALUES 
                                ('$Tanggal', '$Keterangan', '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Hari_LiburNID  = mysqli_insert_id($Connection);
                    
                }
            }
            
            ?>
                <script>
                    window.location.href="hari_libur.php?Action=Daftar";
                </script>
            <?php
        }
        if($_POST['Action']=='Dokumen_Detail_Update' || $_POST['Action']=='Dokumen_Detail_Tambah')
        {
            if(isset($_POST['submit']))
            {

                $Tanggal  = $_POST['Tanggal_Awal'];
                $Tanggal  = str_replace('&#39;',"'",$Tanggal );
                $Tanggal  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal ));
                $Tanggal = substr($Tanggal, -4)."-".substr($Tanggal, 3, 2)."-".substr($Tanggal, 0,2);

                $Keterangan = $_POST['Keterangan'];
                $Keterangan = str_replace('&#39;',"'",$Keterangan);
                $Keterangan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Keterangan));

                $Jenis_LaporanNID = 1; //LPH
                $Waktu_Upload = date("Ymdghis");
                if($_POST['Action']=='Dokumen_Detail_Update')
                {
                    $Hari_LiburNID = $_POST['Hari_LiburNID'];
                    $Hari_LiburNID = str_replace('&#39;',"'",$Hari_LiburNID);
                    $Hari_LiburNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Hari_LiburNID));

                    
                    $Simpan_File_Berhasil = 0;
                    //cek apakah ada file baru yang diupload 
                    if($_FILES['inputFileBefore']['name']<>"")
                    {
                        //Ambil file yang lama
                        $sql = "SELECT * from laporan_harian sd
                                    WHERE sd.Hari_LiburNID = '".$Hari_LiburNID."'";
                        //echo $sql.";<br>";
                        $qry_Lampiran = mysqli_query($Connection, $sql);
                        $buff_Lampiran = mysqli_fetch_array($qry_Lampiran);
                        $Old_Lampiran = $buff_Lampiran['Image_Before'];
                        if($Old_Lampiran<>"")
                        {
                            //Hapus yang lama
                            if(file_exists($Default_Dokumen_Dir.$Old_Lampiran))
                            {
                                unlink($Default_Dokumen_Dir.$Old_Lampiran);
                            }
                        }
                        
                        $filename = $_FILES['inputFileBefore']['name'];
                        $temp_Nama_File = $_FILES['inputFileBefore']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                        {
                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $Last_UserNID."-".$CabangNID."-".$Waktu_Upload."-Before.".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);

                            //Jika file gambar, maka gambar akan dikecilkan
                            if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                            {
                                $Max_Width = 1000;
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
                            $sql = "UPDATE laporan_harian sp SET
                                        sp.Image_Before = '".$Lampiran."', 
                                        sp.Last_User = '".$Last_UserNID."'
                                        WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            $Simpan_File_Berhasil = 1;

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

                    if($_FILES['inputFileAfter']['name']<>"")
                    {
                        //Ambil file yang lama
                        $sql = "SELECT * from laporan_harian sd
                                    WHERE sd.Hari_LiburNID = '".$Hari_LiburNID."'";
                        //echo $sql.";<br>";
                        $qry_Lampiran = mysqli_query($Connection, $sql);
                        $buff_Lampiran = mysqli_fetch_array($qry_Lampiran);
                        $Old_Lampiran = $buff_Lampiran['Image_After'];
                        if($Old_Lampiran<>"")
                        {
                            //Hapus yang lama
                            if(file_exists($Default_Dokumen_Dir.$Old_Lampiran))
                            {
                                unlink($Default_Dokumen_Dir.$Old_Lampiran);
                            }
                        }
                        
                        $filename = $_FILES['inputFileAfter']['name'];
                        $temp_Nama_File = $_FILES['inputFileAfter']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                        {
                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $Last_UserNID."-".$CabangNID."-".$Waktu_Upload."-After.".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);

                            //Jika file gambar, maka gambar akan dikecilkan
                            if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                            {
                                $Max_Width = 1000;
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
                            $sql = "UPDATE laporan_harian sp SET
                                        sp.Image_After = '".$Lampiran."', 
                                        sp.Last_User = '".$Last_UserNID."'
                                        WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            $Simpan_File_Berhasil = 1;

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
                    
                    if($Simpan_File_Berhasil==1)
                    {
                       
                        $sql = "UPDATE laporan_harian sp SET
                                        sp.Tanggal = '".$Tanggal."', 
                                        sp.Keterangan = '".$Keterangan."', 
                                        sp.Last_User = '".$Last_UserNID."'
                                        WHERE sp.Hari_LiburNID = '".$Hari_LiburNID."' ";
                        //echo $sql.";<br>";
                        $qry = mysqli_query($Connection, $sql);
                    }
                }
                elseif($_POST['Action']=='Dokumen_Detail_Tambah')
                {
                    //Simpan data ke database
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO laporan_harian(CabangNID, Jenis_LaporanNID, Tanggal, Image_Before, Image_After, Keterangan, Creator, Create_Date, Last_User) VALUES 
                                ('$CabangNID', '$Jenis_LaporanNID', '$Tanggal', '$Image_Before', '$Image_After', '$Keterangan', '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Hari_LiburNID = mysqli_insert_id($Connection);

                    $Simpan_File_Berhasil = 0;
                    if($_FILES['inputFileBefore']['name']<>"")
                    {
                        $filename = $_FILES['inputFileBefore']['name'];
                        $temp_Nama_File = $_FILES['inputFileBefore']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                        {
                            
                            
                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $Last_UserNID."-".$CabangNID."-".$Waktu_Upload."-Before.".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);

                            //Jika file gambar, maka gambar akan dikecilkan
                            if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                            {
                                $Max_Width = 1000;
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

                            $sql = "UPDATE laporan_harian kk SET
                                        kk.Image_Before = '".$Lampiran."'
                                        WHERE kk.Hari_LiburNID = '".$Hari_LiburNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            $Simpan_File_Berhasil = 1;
                            
                        }
                        else
                        {
                            $Simpan_File_Berhasil = 0;
                            echo " Proses upload gagal, silahkan cek ekstensi file. Ekstensi file yang bisa diterima jpg, jpeg, dan pdf.<br>";
                            ?>
                            <a href="javascript:window.history.back()">Kembali</a>
                            <?php
                            //$Jumlah_Error++;
                        }
                    }

                    if($_FILES['inputFileAfter']['name']<>"")
                    {
                        $filename = $_FILES['inputFileAfter']['name'];
                        $temp_Nama_File = $_FILES['inputFileAfter']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                        {
                            
                            
                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $Last_UserNID."-".$CabangNID."-".$Waktu_Upload."-After.".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);

                            //Jika file gambar, maka gambar akan dikecilkan
                            if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='png' || strtolower($Ekstensi_File)=='bmp')
                            {
                                $Max_Width = 1000;
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

                            $sql = "UPDATE laporan_harian kk SET
                                        kk.Image_After = '".$Lampiran."'
                                        WHERE kk.Hari_LiburNID = '".$Hari_LiburNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            $Simpan_File_Berhasil = 1;
                            
                        }
                        else
                        {
                            $Simpan_File_Berhasil = 0;
                            echo " Proses upload gagal, silahkan cek ekstensi file. Ekstensi file yang bisa diterima jpg, jpeg, dan pdf.<br>";
                            ?>
                            <a href="javascript:window.history.back()">Kembali</a>
                            <?php
                            //$Jumlah_Error++;
                        }
                    }
                }
            }
            
            ?>
                <script>
                    window.location.href="hari_libur.php?Action=Detail_Laporan&Tanggal=<?php echo $Tanggal ?>";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Filter_Tanggal_Rekap')
        {
        }
        elseif($_POST['Action']=='Filter_Tanggal_Rekap_Karyawan')
        {
        }
        elseif($_POST['Action']=='Input_Keterangan')
        {
        }
    }
    
    
}

