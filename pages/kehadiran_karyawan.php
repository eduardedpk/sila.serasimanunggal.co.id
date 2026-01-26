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
        $Profile_Pictures = $_SESSION['Username'].".jpg";
    }
    $Nama_Panggilan = $_SESSION['Nama_Panggilan'];
    $Last_User = $_SESSION['Username'];
    $Last_UserNID = $_SESSION['Last_UserNID'];
    $Nama_Lengkap_User = $_SESSION['Nama_Lengkap'];
    $CabangNID = $_SESSION['CabangNID'];

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

    if(isset($_GET['Action']))
    {
        if($_GET['Action']=='Daftar')
        {
            $Tanggal_Awal = $_SESSION['Tanggal_Awal'];
            $ArrayTanggal = explode('-', $Tanggal_Awal);
            $Start_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            $Tanggal_Akhir = $_SESSION['Tanggal_Akhir'];
            $ArrayTanggal = explode('-', $Tanggal_Akhir);
            $End_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            $_SESSION['Parrent_Page'] = 'kehadiran_karyawan.php?Action=Daftar';
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
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="kehadiran_karyawan.php?Action=Rekap" class="waves-effect"><i class="fa fa-wpforms"></i><span> Rekap </span></a>
                                        </li>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="fa fa-gears (alias)"></i><span> Sinkronisasi </span></a>
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
                                        <h4 class="page-title">Absensi Karyawan Detail</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div>
                                            <a href="#demo" class="" data-toggle="collapse">Options</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="kehadiran_karyawan.php" method="post" enctype="multipart/form-data">
                                                        <input id='Filter_Tanggal' type="hidden" name="Action" value="Filter_Tanggal">
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="inputTanggal" class="col-sm-4 control-label">Awal</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control pull-right" id="inputTanggalAwal" name="Tanggal_Awal" value="<?php echo $Start_Date ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="inputTanggal" class="col-sm-4 control-label">Akhir</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control pull-right" id="inputTanggalAkhir" name="Tanggal_Akhir" value="<?php echo $End_Date ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-4" style="padding-left:30px">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-info" name="Filter"> Filter</button>
                                                                <button type="submit" class="btn btn-info" name="Reset"> Reset</button>
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
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=50% rowspan=1 style="text-align:center;vertical-align:middle">Nama</th>
                                                            <th width=30% colspan=1 style="text-align:center;vertical-align:middle">Waktu</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Status</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php 

                                                        $Daftar_Status = array(); //In atau Out
                                                        $Daftar_Tanggal = array(); //In atau Out
                                                        //Loop Data Karyawan
                                                        $sql = "SELECT dk.KaryawanNID FROM data_karyawan dk ";
                                                        //echo $sql.";<br>";
                                                        $qry = mysqli_query($Connection, $sql);
                                                        while($buff = mysqli_fetch_array($qry))
                                                        {
                                                            $KaryawanNID = $buff['KaryawanNID'];
                                                            //Isi array dengan nilai inisiasi 0
                                                            $Daftar_Status[$KaryawanNID]=0;
                                                            $Daftar_Tanggal[$KaryawanNID]=0;
                                                        }

                                                        //Loop tanggal
                                                        $sql = "SELECT kk.KehadiranNID, LEFT(kk.Waktu, 10) AS Tanggal FROM kehadiran_karyawan kk
                                                                    INNER JOIN data_karyawan dk ON dk.Finger_PrintNID = kk.Finger_PrintNID
                                                                    WHERE kk.Deleted = 0 AND dk.Aktif = 1 
                                                                    AND LEFT(kk.Waktu, 10) >= '".$Tanggal_Awal."' AND LEFT(kk.Waktu, 10) <= '".$Tanggal_Akhir."'
                                                                    GROUP BY LEFT(kk.Waktu, 10)
                                                                    ORDER BY kk.Waktu
                                                                    ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Tanggal = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Tanggal = mysqli_fetch_array($qry_Data_Tanggal))
                                                        {
                                                            $Tanggal = $buff_Data_Tanggal['Tanggal'];
                                                            
                                                            //echo "Nama Lengkap ".$Nama_Lengkap."<br>";

                                                            //Loop data karyawan
                                                            $sql = "SELECT kk.KehadiranNID, kk.Finger_PrintNID, dk.Nama_Lengkap FROM kehadiran_karyawan kk
                                                                        INNER JOIN data_karyawan dk ON dk.Finger_PrintNID = kk.Finger_PrintNID 
                                                                        WHERE LEFT(kk.Waktu, 10) = '".$Tanggal."' AND kk.Deleted = 0 AND dk.Aktif = 1
                                                                        GROUP BY kk.Finger_PrintNID
                                                                        ORDER BY dk.Nama_Lengkap
                                                                        ";
                                                            //echo $sql.";<br>";
                                                            $qry_Data_Karyawan = mysqli_query($Connection, $sql);
                                                            while($buff_Data_Karyawan = mysqli_fetch_array($qry_Data_Karyawan))
                                                            {
                                                                $Finger_PrintNID = $buff_Data_Karyawan['Finger_PrintNID'];
                                                                $Nama_Lengkap = $buff_Data_Karyawan['Nama_Lengkap'];
                                                                $Daftar_Status[$KaryawanNID]=0;
                                                                $Daftar_Tanggal[$KaryawanNID]=0;
                                                                //Loop Data kehadiran
                                                                $sql = "SELECT kk.KehadiranNID, kk.Waktu, dk.Nama_Lengkap, dk.KaryawanNID FROM kehadiran_karyawan kk 
                                                                            INNER JOIN data_karyawan dk ON dk.Finger_PrintNID = kk.Finger_PrintNID
                                                                            WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Waktu, 10) = '".$Tanggal."'
                                                                            AND kk.Deleted = 0 AND dk.Aktif = 1
                                                                            ORDER BY kk.Waktu, kk.Finger_PrintNID
                                                                            ";
                                                                //echo $sql.";<br>";
                                                                $qry_Data_Kehadiran = mysqli_query($Connection, $sql);
                                                                while($buff_Data_Kehadiran = mysqli_fetch_array($qry_Data_Kehadiran))
                                                                {
                                                                    $KehadiranNID = $buff_Data_Kehadiran['KehadiranNID'];
                                                                    $KaryawanNID = $buff_Data_Kehadiran['KaryawanNID'];
                                                                    $Waktu = $buff_Data_Kehadiran['Waktu'];
                                                                    $Nama_Lengkap = $buff_Data_Kehadiran['Nama_Lengkap'];
                                                                    //echo ($Daftar_Status[$KaryawanNID] % 2).";<br>";
                                                                    if(($Daftar_Status[$KaryawanNID] % 2)==0)
                                                                    {
                                                                        $Status = "In";
                                                                    }
                                                                    else
                                                                    {
                                                                        $Status = "Out";
                                                                    }
                                                                    //echo $Status."<br>";
                                                                    $Daftar_Status[$KaryawanNID] = $Daftar_Status[$KaryawanNID] + 1;
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $Nama_Lengkap ?></td>
                                                                        <td style="text-align:center"><?php echo $Waktu ?></td>
                                                                        <td><?php echo $Status ?></td>
                                                                        <!--<td style="text-align:center">
                                                                            <span><a href="kehadiran_karyawan.php?Action=Delete&KehadiranNID=<?php echo $KehadiranNID ?>" title="Lihat data detail"><i class="fa fa-trash"></i></a></span> 
                                                                        </td>-->
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }

                                                        $sql = "SELECT kk.KehadiranNID, kk.Waktu, dk.Nama_Lengkap, dk.KaryawanNID FROM kehadiran_karyawan kk 
                                                                    INNER JOIN data_karyawan dk ON dk.Finger_PrintNID = kk.Finger_PrintNID
                                                                    ORDER BY kk.Waktu, kk.Finger_PrintNID
                                                                    ";
                                                        //echo $sql.";<br>";
                                                        $qry = mysqli_query($Connection, $sql);
                                                        while($buff = mysqli_fetch_array($qry))
                                                        {
                                                            
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
        elseif($_GET['Action']=='Delete')
        {
            $KehadiranNID = $_GET['KehadiranNID'];
            $KehadiranNID = str_replace('&#39;',"'",$KehadiranNID);
            $KehadiranNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KehadiranNID));            

            $sql = "UPDATE kehadiran_karyawan kk SET
                        kk.Deleted = 1
                        WHERE kk.KehadiranNID = '".$KehadiranNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            ?>
            <script>
                  window.history.back();
            </script>
            <?php
            
        }
        elseif($_GET['Action']=='Rekap')
        {
            $Tanggal_Awal = $_SESSION['Tanggal_Awal'];
            $ArrayTanggal = explode('-', $Tanggal_Awal);
            $Start_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            $Tanggal_Akhir = $_SESSION['Tanggal_Akhir'];
            $ArrayTanggal = explode('-', $Tanggal_Akhir);
            $End_Date = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'kehadiran_karyawan.php?Action=Rekap';
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
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="kehadiran_karyawan_print.php?Action=Form" class="waves-effect"><i class="ti-printer"></i><span> Print </span></a>
                                        </li>
                                        <li>
                                            <a href="kehadiran_karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Absensi Karyawan tanggal <?php echo $Start_Date ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div>
                                            <a href="#demo" class="" data-toggle="collapse">Options</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="kehadiran_karyawan.php" method="post" enctype="multipart/form-data">
                                                        <input id='Filter_Tanggal_Rekap' type="hidden" name="Action" value="Filter_Tanggal_Rekap">
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="inputTanggal" class="col-sm-4 control-label">Awal</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" class="form-control pull-right" id="inputTanggalAwal" name="Tanggal_Awal" value="<?php echo $Start_Date ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-lg-4" style="padding-left:30px">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-info" name="Filter"> Filter</button>
                                                                <button type="submit" class="btn btn-info" name="Reset"> Reset</button>
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
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=2 style="text-align:center;vertical-align:middle">Nomor</th>
                                                            <th width=50% rowspan=2 style="text-align:center;vertical-align:middle">Nama</th>
                                                            <th width=40% colspan=2 style="text-align:center;vertical-align:middle">Waktu</th>
                                                            <th width=10% rowspan=2 style="text-align:center;vertical-align:middle">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th width=20% rowspan=1 style="text-align:center;vertical-align:middle">Masuk</th>
                                                            <th width=20% colspan=1 style="text-align:center;vertical-align:middle">Pulang</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php 

                                                        $Daftar_Status = array(); //In atau Out
                                                        $Daftar_Tanggal = array(); //In atau Out
                                                        //Loop Data Karyawan
                                                        $sql = "SELECT dk.KaryawanNID FROM data_karyawan dk ";
                                                        //echo $sql.";<br>";
                                                        $qry = mysqli_query($Connection, $sql);
                                                        while($buff = mysqli_fetch_array($qry))
                                                        {
                                                            $KaryawanNID = $buff['KaryawanNID'];
                                                            //Isi array dengan nilai inisiasi 0
                                                            $Daftar_Status[$KaryawanNID]=0;
                                                            $Daftar_Tanggal[$KaryawanNID]=0;
                                                        }

                                                        //Loop Karyawan
                                                        $Nomor_Urut = 0;
                                                        $sql = "SELECT dk.KaryawanNID, dk.Finger_PrintNID, dk.Nama_Lengkap FROM data_karyawan dk 
                                                                    WHERE dk.Aktif = 1
                                                                    ORDER BY dk.Nama_Lengkap";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Karyawan = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Karyawan = mysqli_fetch_array($qry_Data_Karyawan))
                                                        {
                                                            $Nomor_Urut++;
                                                            $KaryawanNID = $buff_Data_Karyawan['KaryawanNID'];
                                                            $Finger_PrintNID = $buff_Data_Karyawan['Finger_PrintNID'];
                                                            $Nama_Lengkap = $buff_Data_Karyawan['Nama_Lengkap'];
                                                            //echo $Nomor_Urut." ".$KaryawanNID." ".$Finger_PrintNID." ".$Nama_Lengkap."<br>";

                                                            //Ambil data pertama sebagai data Kehadiran Masuk
                                                            $sql = "SELECT kk.KehadiranNID, kk.Waktu FROM kehadiran_karyawan kk
                                                                        WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Waktu, 10) = '".$Tanggal_Awal."' 
                                                                        ORDER BY kk.Waktu ASC
                                                                        LIMIT 1 ";
                                                            $qry_Data_Tanggal = mysqli_query($Connection, $sql);
                                                            $num = mysqli_num_rows($qry_Data_Tanggal);
                                                            if($num==0)
                                                            {
                                                                $KehadiranNID = "";
                                                                $Waktu_Hadir = "-";
                                                            }
                                                            else
                                                            {
                                                                $buff_Data_Tanggal = mysqli_fetch_array($qry_Data_Tanggal);
                                                                $KehadiranNID = $buff_Data_Tanggal['KehadiranNID'];
                                                                $Waktu_Hadir = $buff_Data_Tanggal['Waktu'];
                                                            }
                                                            

                                                            //Ambil data terakhir sebagai data Kehadiran Pulang
                                                            $sql = "SELECT kk.KehadiranNID, kk.Waktu FROM kehadiran_karyawan kk
                                                                        WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Waktu, 10) = '".$Tanggal_Awal."' 
                                                                        ORDER BY kk.Waktu DESC
                                                                        LIMIT 1 ";
                                                            $qry_Data_Tanggal = mysqli_query($Connection, $sql);
                                                            $num = mysqli_num_rows($qry_Data_Tanggal);
                                                            if($num==0)
                                                            {
                                                                $KehadiranNID = "";
                                                                $Waktu_Pulang = "-";
                                                            }
                                                            else
                                                            {
                                                                $buff_Data_Tanggal = mysqli_fetch_array($qry_Data_Tanggal);
                                                                $KehadiranNID = $buff_Data_Tanggal['KehadiranNID'];
                                                                $Waktu_Pulang = $buff_Data_Tanggal['Waktu'];
                                                            }
                                                            
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $Nomor_Urut ?></td>
                                                                <td><a href="kehadiran_karyawan.php?Action=Rekap_Karyawan&Finger_PrintNID=<?php echo $Finger_PrintNID ?>"><?php echo $Nama_Lengkap ?></a> </td>
                                                                <td><?php echo $Waktu_Hadir ?></td>
                                                                <td><?php echo $Waktu_Pulang ?></td>
                                                                <td style="text-align:center">
                                                                    <span><a href="kehadiran_karyawan.php?Action=Update_Keterangan&Tanggal=<?php echo $Tanggal_Awal?>&Finger_PrintNID=<?php echo $Finger_PrintNID ?>" title="Lihat data detail"><i class="fa fa-pencil"></i></a></span> 
                                                                </td>
                                                            </tr>
                                                            <?php
  
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
        elseif($_GET['Action']=='Rekap_Karyawan')
        {
            $Bulan = date("m");
            $Tahun = date("Y");
            $Tanggal_Akhir_Bulan = date("t");
            if(isset($_SESSION['Bulan_Rekap']))
            {
                $Bulan_Rekap = $_SESSION['Bulan_Rekap'];
            }
            else
            {
                $Bulan_Rekap = substr("0".date("m"),-2);
                $_SESSION['Bulan_Rekap'] = $Bulan_Rekap;
            }

            if(isset($_SESSION['Tahun_Rekap']))
            {
                $Tahun_Rekap = $_SESSION['Tahun_Rekap'];
            }
            else
            {
                $Tahun_Rekap = date("Y");
                $_SESSION['Tahun_Rekap'] = $Tahun_Rekap;
                
            }

            $Finger_PrintNID = $_GET['Finger_PrintNID'];
            $Finger_PrintNID = str_replace('&#39;',"'",$Finger_PrintNID);
            $Finger_PrintNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Finger_PrintNID));
            $sql = "SELECT dk.KaryawanNID, dk.Nama_Lengkap FROM data_karyawan dk
                        WHERE dk.Finger_PrintNID = '".$Finger_PrintNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $Nama_Lengkap = $buff['Nama_Lengkap'];
            //echo "Parrent Page ".$_SESSION['Parrent_Page']."<br>";
            if($_SESSION['Parrent_Page']=='kehadiran_karyawan.php?Action=Rekap' || $_SESSION['Parrent_Page']=='kehadiran_karyawan.php?Action=Rekap_Karyawan')
            {
                $Back_Link = 'kehadiran_karyawan.php?Action=Rekap';
            }
            else
            {
                $Back_Link = 'kehadiran_karyawan.php?Action=Daftar';
            }
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'kehadiran_karyawan.php?Action=Rekap_Karyawan';
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
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="kehadiran_karyawan.php?Action=Print_Rekap_Detail&Tahun=2021&Bulan=6&ID=2" class="waves-effect"><i class="ti-printer"></i><span> Print </span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $Back_Link ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo $Nama_Lengkap ?> </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div>
                                            <a href="#demo" class="" data-toggle="collapse">Options</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="kehadiran_karyawan.php" method="post" enctype="multipart/form-data">
                                                        <input id='Filter_Tanggal_Rekap_Karyawan' type="hidden" name="Action" value="Filter_Tanggal_Rekap_Karyawan">
                                                        <input id='Finger_PrintNID' type="hidden" name="Finger_PrintNID" value="<?php echo $Finger_PrintNID ?>">
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="FilterTahun" class="col-sm-4 control-label">Tahun</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <select class="form-control" name="FilterTahun" id="FilterTahun">
                                                                        <?php
                                                                        $Tahun_Awal = 2021;
                                                                        $Tahun_Berjalan = intval(date("Y"));
                                                                        for($i=$Tahun_Awal; $i<=$Tahun_Berjalan; $i++)
                                                                        {
                                                                            if($i==$Tahun_Rekap)
                                                                            {
                                                                                ?>
                                                                                <option value=<?php echo $i ?> selected> <?php echo $i ?></option>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <option value=<?php echo $i ?>> <?php echo $i ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="FilterBulan" class="col-sm-4 control-label">Bulan</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <select class="form-control" name="FilterBulan" id="FilterBulan">
                                                                        <?php
                                                                        $Bulan_Berjalan = intval(date("m"));
                                                                        for($i=1; $i<=12; $i++)
                                                                        {
                                                                            if($i==intval($Bulan_Rekap))
                                                                            {
                                                                                ?>
                                                                                <option value=<?php echo $i ?> selected> <?php echo $Nama_Bulan[$i] ?></option>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <option value=<?php echo $i ?>> <?php echo $Nama_Bulan[$i] ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-sm-6 col-lg-4" style="padding-left:30px">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-info" name="Filter"> Filter</button>
                                                                <button type="submit" class="btn btn-info" name="Reset"> Reset</button>
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
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=20% rowspan=2 style="text-align:center;vertical-align:middle">Tanggal</th>
                                                            <th width=40% colspan=2 style="text-align:center;vertical-align:middle">Waktu</th>
                                                            <th width=40% rowspan=2 style="text-align:center;vertical-align:middle">Keterangan</th>
                                                            <th width=5% rowspan=2 style="text-align:center;vertical-align:middle">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <th width=20% rowspan=1 style="text-align:center;vertical-align:middle">Masuk</th>
                                                            <th width=20% colspan=1 style="text-align:center;vertical-align:middle">Pulang</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php 

                                                        //loop tanggal
                                                        $First_Date = 1;
                                                        $Last_Date = date_format(date_create($Tahun_Rekap."-".$Bulan_Rekap."-01"), "t");
                                                        //$Bulan_Aktif = substr($Tanggal_Awal_Rekap, 5,2);
                                                        //echo $Last_Date."<br>";
                                                        
                                                        for($Loop_Tanggal = intval($First_Date); $Loop_Tanggal <= intval($Last_Date); $Loop_Tanggal++)
                                                        {
                                                            $Current_Date = $Tahun_Rekap."-".substr("0".$Bulan_Rekap,-2)."-".substr("0".$Loop_Tanggal,-2);
                                                            //cari kehadiran pada tanggal tersebut
                                                            $sql = "SELECT kk.KehadiranNID, kk.Waktu FROM kehadiran_karyawan kk
                                                                        WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Waktu, 10) = '".$Current_Date."' 
                                                                        ORDER BY kk.Waktu ASC
                                                                        LIMIT 1";
                                                            //echo $sql.";<br>";
                                                            $qry_Tanggal = mysqli_query($Connection, $sql);
                                                            $num = mysqli_num_rows($qry_Tanggal);
                                                            if($num==0)
                                                            {
                                                                $Waktu_Hadir="-";
                                                            }
                                                            else
                                                            {
                                                                $buff_Tanggal = mysqli_fetch_array($qry_Tanggal);
                                                                $Waktu_Hadir = substr($buff_Tanggal['Waktu'], -8);
                                                            }


                                                            $sql = "SELECT kk.KehadiranNID, kk.Waktu FROM kehadiran_karyawan kk
                                                                        WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Waktu, 10) = '".$Current_Date."' 
                                                                        ORDER BY kk.Waktu DESC
                                                                        LIMIT 1";
                                                            //echo $sql.";<br>";
                                                            $qry_Tanggal = mysqli_query($Connection, $sql);
                                                            $num = mysqli_num_rows($qry_Tanggal);
                                                            if($num==0)
                                                            {
                                                                $Waktu_Pulang="-";
                                                            }
                                                            else
                                                            {
                                                                $buff_Tanggal = mysqli_fetch_array($qry_Tanggal);
                                                                $Waktu_Pulang = substr($buff_Tanggal['Waktu'], -8);
                                                            }
                                                            

                                                            //Cari keterangan jika ada
                                                            $sql = "SELECT kk.Keterangan FROM kehadiran_keterangan kk
                                                                        WHERE kk.Finger_PrintNID = '".$Finger_PrintNID."' AND LEFT(kk.Tanggal, 10) = '".$Current_Date."' ";
                                                            //echo $sql.";<br>";
                                                            $qry_Tanggal = mysqli_query($Connection, $sql);
                                                            $num = mysqli_num_rows($qry_Tanggal);
                                                            if($num==0)
                                                            {
                                                                $Keterangan="-";
                                                            }
                                                            else
                                                            {
                                                                $buff_Tanggal = mysqli_fetch_array($qry_Tanggal);
                                                                $Keterangan = $buff_Tanggal['Keterangan'];
                                                            }
                                                            $Format_Tanggal = $Nama_Hari[intval(date_format(date_create($Tahun_Rekap."-".$Bulan_Rekap."-".substr("0".$Loop_Tanggal,-2)), "w"))].", ".date_format(date_create($Tahun_Rekap."-".$Bulan_Rekap."-".substr("0".$Loop_Tanggal,-2)), "d-m-Y");
                                                            ?>
                                                            
                                                            <tr>
                                                                <td><?php echo $Format_Tanggal ?></td>
                                                                <td style="text-align:center"><?php echo $Waktu_Hadir ?></td>
                                                                <td style="text-align:center"><?php echo $Waktu_Pulang ?></td>
                                                                <td><?php echo $Keterangan ?></td>
                                                                <td style="text-align:center">
                                                                    <span><a href="kehadiran_karyawan.php?Action=Update_Keterangan&Tanggal=<?php echo $Current_Date ?>&Finger_PrintNID=<?php echo $Finger_PrintNID ?>" title="Update keterangan"><i class="fa fa-pencil"></i></a></span> 
                                                                </td>
                                                            </tr>
                                                            <?php
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
        elseif($_GET['Action']=='Update_Keterangan')
        {
            $Tanggal = $_GET['Tanggal'];
            $Tanggal = str_replace('&#39;',"'",$Tanggal);
            $Tanggal = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal));

            $Finger_PrintNID = $_GET['Finger_PrintNID'];
            $Finger_PrintNID = str_replace('&#39;',"'",$Finger_PrintNID);
            $Finger_PrintNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Finger_PrintNID));
            
            //Ambil data nama dan keterangan
            $sql = "SELECT dk.KaryawanNID, dk.Nama_Lengkap, kk.Keterangan FROM data_karyawan dk
                        INNER JOIN kehadiran_keterangan kk on kk.Finger_PrintNID = dk.Finger_PrintNID
                        WHERE dk.Finger_PrintNID = '".$Finger_PrintNID."' AND kk.Tanggal = '".$Tanggal."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $Nama_Lengkap = $buff['Nama_Lengkap'];
            $Keterangan = $buff['Keterangan'];



            if($_SESSION['Parrent_Page']=='kehadiran_karyawan.php?Action=Rekap')
            {
                $Back_Link = 'kehadiran_karyawan.php?Action=Rekap';
            }
            else
            {
                $Back_Link = 'kehadiran_karyawan.php?Action=Rekap_Karyawan&Finger_PrintNID='.$Finger_PrintNID;
            }
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            //$_SESSION['Current_Page'] = 'kehadiran_karyawan.php?Action=Rekap_Karyawan';
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

                    <!-- include summernote css -->
                    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

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
                                    <ul>
                                        <li>
                                            <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $Back_Link ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo $Nama_Lengkap ?> </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div>
                                            <div class="row">
                                                
                                            </div>
                                                
                                            
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="kehadiran_karyawan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Input_Keterangan' type="hidden" name="Action" value="Input_Keterangan">
                                                    <input id='Tanggal' type="hidden" name="Tanggal" value="<?php echo $Tanggal ?>">
                                                    <input id='Finger_PrintNID' type="hidden" name="Finger_PrintNID" value="<?php echo $Finger_PrintNID ?>">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-body">
                                                                    <h4 class="m-b-30 m-t-0">Keterangan</h4>

                                                                    <textarea id="summernote" name="Keterangan" rows=5> <?php echo $Keterangan ?> </textarea>    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!-- End row -->
                                                    
                                                    <div class="col-sm-6 col-lg-6" style="padding-left:30px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="Simpan"> Simpan</button>
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

                    <!-- include summernote js -->
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
                            $('#summernote').summernote({
                                height: 100
                            }

                            );
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
        if($_POST['Action']=='Filter_Tanggal')
        {
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            //$_SESSION['Current_Page'] = "";
            if(isset($_POST['Filter']))
            {
                $Tanggal_Awal = $_POST['Tanggal_Awal'];
                $Tanggal_Akhir = $_POST['Tanggal_Akhir'];
                
                $ArrayTanggal = explode('-', $Tanggal_Awal);
                $Tanggal_Awal = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

                $ArrayTanggal = explode('-', $Tanggal_Akhir);
                $Tanggal_Akhir = $ArrayTanggal[2]."-".$ArrayTanggal[1]."-".$ArrayTanggal[0];

                $_SESSION['Tanggal_Awal'] =  $Tanggal_Awal;
                $_SESSION['Tanggal_Akhir'] = $Tanggal_Akhir;
            }
            elseif(isset($_POST['Reset']))
            {
                $_SESSION['Tanggal_Awal'] =  date('Y-m-d');;
                $_SESSION['Tanggal_Akhir'] = date('Y-m-d');;
            }
            
            ?>
                <script>
                    window.location.href="kehadiran_karyawan.php?Action=Daftar";
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
        elseif($_POST['Action']=='Input_Keterangan')
        {
            $Finger_PrintNID = $_POST['Finger_PrintNID'];
            $Tanggal = $_POST['Tanggal'];
            $Keterangan = $_POST['Keterangan'];
            
            $sql = "SELECT * FROM kehadiran_keterangan kk 
                        WHERE kk.Tanggal = '".$Tanggal."' AND kk.Finger_PrintNID = '".$Finger_PrintNID."' ";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Insert
                $sql = "INSERT INTO kehadiran_keterangan (Keterangan, Tanggal, Finger_PrintNID, Creator, Create_Date, Last_User) VALUES 
                        ('$Keterangan', '$Tanggal', '$Finger_PrintNID', '$Last_UserNID', now() , '$Last_UserNID') ";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                //Update
                $sql = "UPDATE kehadiran_keterangan kk SET
                            kk.Keterangan = '".$Keterangan."', 
                            kk.Last_User = '".$Keterangan."'
                            WHERE kk.Tanggal = '".$Tanggal."' AND kk.Finger_PrintNID = '".$Finger_PrintNID."' ";
                $qry = mysqli_query($Connection, $sql);
            }
            ?>
                <script>
                    window.location.href="kehadiran_karyawan.php?Action=Rekap_Karyawan&Finger_PrintNID=<?php echo $Finger_PrintNID?>";
                </script>
            <?php
        }
    }
    
    
}

