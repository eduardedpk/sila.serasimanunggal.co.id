<?php
ini_set('session.save_path', '../session');
session_start();
require_once('assets/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Xlsx;

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
                                        <!--<h4 class="page-title">Generate Rekap </h4>-->
                                    </div>
                                </div>
                                <?php
                                if(isset($_GET['Tanggal']))
                                {
                                    $Tanggal_Laporan = $_GET['Tanggal'];
                                    $_SESSION['Tanggal_Laporan'] = $Tanggal_Laporan;
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
                                ?>
                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div>
                                                <div class="">
                                                    <h4 class="page-title">Generate Rekap CS </h4>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="laporan_harian.php" method="post" enctype="multipart/form-data">
                                                        <div class="col-sm-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="inputKelas" class="col-sm-3 ">Bulan</label>
                                                                
                                                                <div class="col-sm-9 input-group date" >
                                                                    <?php
                                                                    

                                                                    $sql = "SELECT * FROM laporan_harian lh 
                                                                                INNER JOIN laporan_jenis lj ON lj.Jenis_LaporanNID = lh.Jenis_LaporanNID
                                                                                WHERE lh.CabangNID = '".$CabangNID."' 
                                                                                GROUP BY year(lh.Tanggal), month(lh.Tanggal);";
                                                                    //echo $sql.";<br>";
                                                                    $qry = mysqli_query($Connection, $sql);
                                                                    $num = mysqli_num_rows($qry);
                                                                    //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                    ?>
                                                                    <select name="Waktu" id="inputWaktu" onchange="CekWaktu()" class="form-control">
                                                                        <?php
                                                                        $Tanggal = $Tanggal_Laporan;
                                                                        $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                        $Tahun_Text = substr($Tanggal,0,4);
                                                                        $Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                        if($num==0)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Tanggal?>" ><?php echo $Text_Item ?></option>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            while ($buff = mysqli_fetch_array($qry)) 
                                                                            {
                                                                                $Tanggal = $buff['Tanggal'];
                                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                                $Tahun_Text = substr($buff['Tanggal'],0,4);
                                                                                $Current_Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                                
                                                                                if($Current_Text_Item==$Text_Item)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $Tanggal?>" selected><?php echo $Current_Text_Item ?></option>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $Tanggal?>"><?php echo $Current_Text_Item ?></option>
                                                                                    <?php
                                                                                }
                                                                                
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                    
                                                </div>
                                                <?php 
                                                if($Hak_Akses==2)
                                                {
                                                    $Tahun_Tanggal = substr($Tanggal_Laporan, 0,4);
                                                    $Bulan_Tanggal = substr($Tanggal_Laporan, 5,2);
                                                    ?>
                                                    <p><a href="generate_rekap.php?Action=GenerateCS&Periode=<?php echo $Tahun_Tanggal."".$Bulan_Tanggal ?>" class="btn btn-info" title="Klik untuk download rekap"></i> Generate</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Data</p></p>
                                                    <?php
                                                }
                                                ?>
                                                

                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div>
                                                <div class="">
                                                    <h4 class="page-title">Generate Rekap Non CS </h4>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="laporan_harian.php" method="post" enctype="multipart/form-data">
                                                        <div class="col-sm-6 col-lg-6">
                                                            <div class="form-group">
                                                                <label for="inputKelas" class="col-sm-3 ">Bulan</label>
                                                                
                                                                <div class="col-sm-9 input-group date" >
                                                                    <?php
                                                                    if($Hak_Akses==2)
                                                                    {
                                                                        $sql = "SELECT * FROM laporan_non_cs ln 
                                                                                    GROUP BY ln.Periode;";
                                                                    }
                                                                    else
                                                                    {
                                                                        $sql = "SELECT * FROM laporan_non_cs ln
                                                                                    INNER JOIN indikator_user iu ON iu.Indikator_UserNID = ln.Indikator_UserNID
                                                                                    WHERE ln.Indikator_UserNID = '".$Last_UserNID."'
                                                                                    GROUP BY ln.Periode;";
                                                                    }
                                                                    //echo $Periode_Laporan;
                                                                    //echo $sql.";<br>";
                                                                    $qry = mysqli_query($Connection, $sql);
                                                                    $num = mysqli_num_rows($qry);
                                                                    //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                    ?>
                                                                    <select name="Periode" id="inpuPeriode" onchange="CekPeriode()" class="form-control">
                                                                        <?php
                                                                        $Tanggal = $Periode_Laporan;
                                                                        $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                        $Tahun_Text = substr($Tanggal,0,4);
                                                                        $Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                        if($num==0)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Tanggal?>" ><?php echo $Text_Item ?></option>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            while ($buff = mysqli_fetch_array($qry)) 
                                                                            {
                                                                                $Tanggal = $buff['Tanggal'];
                                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                                $Tahun_Text = substr($buff['Tanggal'],0,4);
                                                                                $Periode = $buff['Periode'];
                                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Periode,5,2))];
                                                                                $Tahun_Text = substr($buff['Periode'],0,4);
                                                                                $Current_Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                                
                                                                                if($Current_Text_Item==$Text_Item)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $Periode?>" selected><?php echo $Current_Text_Item ?></option>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo $Periode?>"><?php echo $Current_Text_Item ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                    
                                                </div>
                                                <?php 
                                                if($Hak_Akses==2)
                                                {
                                                    $Tahun_Tanggal = substr($Tanggal_Laporan, 0,4);
                                                    $Bulan_Tanggal = substr($Tanggal_Laporan, 5,2);
                                                    ?>
                                                    <p><a href="generate_rekap.php?Action=GenerateNonCS&Periode=<?php echo $Tahun_Tanggal."".$Bulan_Tanggal ?>" class="btn btn-info" title="Klik untuk download rekap"></i> Generate</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Data</p></p>
                                                    <?php
                                                }
                                                ?>
                                                

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
                            
                            window.location.href="generate_rekap.php?Action=Daftar&Tanggal="+Tanggal;
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
        elseif($_GET['Action']=='Generate')
        {
            
            
            $Periode_Laporan = $_GET['Periode'];
            $Periode_Laporan = str_replace('&#39;',"'",$Periode_Laporan);
            $Periode_Laporan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Periode_Laporan));
            $Tahun_Periode = substr($Periode_Laporan, 0, 4);
            $Bulan_Periode = substr($Periode_Laporan, -2);
            $Tahun_Sebelumnya = $Tahun_Periode - 1;
            $Tahun_Berikutnya = $Tahun_Periode + 1;
            if($Bulan_Periode==1)
            {
                $Bulan_Sebelumnya = 12;
            }
            else
            {
                $Bulan_Sebelumnya = $Bulan_Periode - 1;
            }
            if($Bulan_Periode==12)
            {
                $Bulan_Berikutnya = 1;
                $Tahun_Berikutnya++;  
            }
            
            else
            {
                $Bulan_Berikutnya = $Bulan_Periode + 1;
                $Tahun_Berikutnya = $Tahun_Periode;
            }
            $Bulan_Berikutnya = substr("0".$Bulan_Berikutnya, -2);

            /** Error reporting */
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            date_default_timezone_set('Asia/Jakarta');
            /** PHPExcel_IOFactory */
            //require_once 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';
            //echo date('H:i:s') , " Load from Excel5 template" , EOL;
            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $spreadsheet = new Spreadsheet();

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(false);
            $spreadsheet = $reader->load("../files/Template_Rekap.xlsx");
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../files/Template_Rekap.xlsx");
            $ActiveSheet = 1;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);

            //Ambil tanggal terakhir untuk bulan yang dipilih

            //echo "Tahun : ".$Tahun_Periode."<br>";
            //echo "Bulan : ".$Bulan_Periode."<br>";
            $a_date = $Tahun_Periode."-".$Bulan_Periode."-01";
            //echo "a_date : ".$a_date."<br>";
            //$Tanggal_Test = date("Y-m-t", strtotime($a_date));
            $Last_Day = date("t", strtotime($a_date));

            $Daftar_Tanggal_Hari_Kerja = array();
            for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
            {
                //Cek tanggal merah
                $Tanggal_Cek = $Tahun_Periode."-".$Bulan_Periode."-".substr("0".$Tanggal_Aktif, -2);
                $sql = "SELECT * FROM hari_libur h
                            WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry);
                
                //cek hari Minggu
                if(date("D",strtotime(date($Tanggal_Cek)))==="Sun" || $num>0)
                {
                    
                }
                else
                {
                    array_push( $Daftar_Tanggal_Hari_Kerja, $Tanggal_Cek);
                }
                
            }
            $Daftar_Tanggal_Masuk = "";
            $Jumlah_Tanggal_Masuk = 0;
            foreach ($Daftar_Tanggal_Hari_Kerja as $value) 
            {
                $Daftar_Tanggal_Masuk = $Daftar_Tanggal_Masuk ."'".$value."', ";
                $Jumlah_Tanggal_Masuk++;
                
            }

            $Daftar_Tanggal_Masuk = substr(trim($Daftar_Tanggal_Masuk), 0, strlen($Daftar_Tanggal_Masuk)-2);
            //echo $Daftar_Tanggal;

            //Ambil data cabang dan team leader
            $sql = "SELECT * FROM data_karyawan dk 
                        INNER JOIN (SELECT ul.Username FROM user_list ul
                                        INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                        INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                        WHERE uj.Jenis_UserNID = 3) u ON u.Username = dk.NIM
                        INNER JOIN cabang c On c.CabangNID = dk.CabangNID
                        WHERE dk.Aktif = 1 
                        ORDER BY trim(dk.Nama_Lengkap);";
            //echo $sql.";<br>";
            $qry_Data = mysqli_query($Connection, $sql);
            $Jumlah_Data = mysqli_num_rows($qry_Data);
            $Baris = 9;
            $Nomor_Urut = 1;
            $Counter_Data = 1;
            while($buff_Data = mysqli_fetch_array($qry_Data))
            {
                $KaryawanNID  = $buff_Data['KaryawanNID'];
                $NIM  = $buff_Data['NIM'];
                $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                $CabangNID  = $buff_Data['CabangNID'];
                $Jumlah_Anggota  = $buff_Data['Jumlah_Anggota'];

                //Ambil data LPH
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_LPH = $buff_Jumlah['Jumlah'];

                //Ambil data CT
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_CT = $buff_Jumlah['Jumlah'];

                //Ambil data PJ
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_PJ = $buff_Jumlah['Jumlah'];

                //Ambil data IA
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_IA = $buff_Jumlah['Jumlah'];

                $Jumlah_Invoice = 0;

                //Hitung jumlah yang tidak dilaporkan
                $Jumlah_CT_Denda = 0;
                $Jumlah_PJ_Denda = 0;
                
                
                //Ambil data LPH
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;

                //Ambil data IA
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                $Jumlah_IA_Denda = $Jumlah_Tanggal_Masuk - $num;
                

                $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-20";
                
                $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                
                //Ambil data CT
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal
                            LIMIT 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                if($num===0)
                {
                    $Jumlah_CT_Denda = 1;
                }
                else
                {
                    $Jumlah_CT_Denda = 0;
                }
                
                while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                {
                    $Tanggal_Lapor = $buff_Jumlah['Tanggal'];
                    
                    if($Tanggal_Lapor <= $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03")
                    {
                        $Jumlah_CT = 1;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-04")
                    {
                        $Jumlah_CT = 4;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-05")
                    {
                        $Jumlah_CT = 5;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-06")
                    {
                        $Jumlah_CT = 6;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_CT = 7;
                        
                    }
                    elseif($Tanggal_Lapor > $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_CT = 0;
                        $Jumlah_CT_Denda = 1;
                    }
                }

                //Ambil data PJ
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal
                            LIMIT 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                if($num===0)
                {
                    $Jumlah_PJ_Denda = 1;
                }
                else
                {
                    $Jumlah_PJ_Denda = 0;
                }
                while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                {
                    $Tanggal_Lapor = $buff_Jumlah['Tanggal'];
                    //$Tanggal_Test = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03";
                    //echo $Tanggal_Lapor ."<br>";
                    //echo $Tanggal_Test ."<br>";

                    if($Tanggal_Lapor <= $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03")
                    {
                        $Jumlah_PJ = 1;
                        //echo "Sebelum tanggal 3 ".$Jumlah_PJ."<br>";
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-04")
                    {
                        $Jumlah_PJ = 4;
                        //echo "Tanggal 4 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-05")
                    {
                        $Jumlah_PJ = 5;
                        //echo "Tanggal 5 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-06")
                    {
                        $Jumlah_PJ = 6;
                        //echo "Tanggal 6 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_PJ = 7;
                        //echo "Tanggal 7 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor > $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_PJ = 0;
                        $Jumlah_PJ_Denda = 1;
                    }
                }
                

                $spreadsheet->getActiveSheet()->setCellValue("A".$Baris, $Nomor_Urut);
                $spreadsheet->getActiveSheet()->setCellValue("B".$Baris, $Nama_Cabang);
                $spreadsheet->getActiveSheet()->setCellValue("C".$Baris, $Nama_Lengkap);
                $spreadsheet->getActiveSheet()->setCellValue("D".$Baris, $NIM);
                $spreadsheet->getActiveSheet()->setCellValue("E".$Baris, $Nomor_Rekening);
                $spreadsheet->getActiveSheet()->setCellValue("F".$Baris, $Jumlah_Anggota);
                $spreadsheet->getActiveSheet()->setCellValue("G".$Baris, $Jumlah_LPH);
                $spreadsheet->getActiveSheet()->setCellValue("I".$Baris, $Jumlah_CT);
                $spreadsheet->getActiveSheet()->setCellValue("K".$Baris, $Jumlah_PJ);
                $spreadsheet->getActiveSheet()->setCellValue("M".$Baris, $Jumlah_IA);
                $spreadsheet->getActiveSheet()->setCellValue("O".$Baris, $Jumlah_Invoice);
                $spreadsheet->getActiveSheet()->setCellValue("S".$Baris, $Jumlah_LPH_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("U".$Baris, $Jumlah_CT_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("W".$Baris, $Jumlah_PJ_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("Y".$Baris, $Jumlah_IA_Denda);

                

                $Nomor_Urut++;

                $Baris++;
                if($Baris>11 && $Nomor_Urut < $Jumlah_Data)
                {
                    $Baris_Copy = $Baris-1;
                    $Baris_Paste = $Baris;
                    //$spreadsheet->getActiveSheet()->insertNewRowBefore($Baris);
                    for ($c = 'A'; $c != 'AC'; ++$c) 
                    {
                        $cell_from = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Copy);
                        $cell_to = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Paste);
                        $cell_to->setXfIndex($cell_from->getXfIndex()); // black magic here
                        $cell_to->setValue($cell_from->getValue());
                    }
                }
                
                
            }
            
            $Nama_File = "Rekap_KPI_".$Tahun_Periode."_".$Bulan_Periode;
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$Nama_File.'.xlsx"');
            header('Cache-Control: max-age=0');

            // Write file to the browser
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');


            
        }
        elseif($_GET['Action']=='GenerateCS')
        {
            $Periode_Laporan = $_GET['Periode'];
            $Periode_Laporan = str_replace('&#39;',"'",$Periode_Laporan);
            $Periode_Laporan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Periode_Laporan));

            if($Periode_Laporan=="202203") //Masih menggunakan skema insentif yang lama
            {
                //Hapus table
                $sql = "DELETE FROM temp_rekap WHERE Creator = '".$Last_UserNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

                $Tahun_Periode = substr($Periode_Laporan, 0, 4);
                $Bulan_Periode = substr($Periode_Laporan, -2);
                $Bulan_Periode_Untuk_Nama_File = $Bulan_Periode;
                $Bulan_Periode = intval($Bulan_Periode);
                $Tahun_Sebelumnya = $Tahun_Periode - 1;
                $Tahun_Berikutnya = $Tahun_Periode + 1;
                if($Bulan_Periode==1)
                {
                    $Bulan_Sebelumnya = 12;
                }
                else
                {
                    $Bulan_Sebelumnya = $Bulan_Periode - 1;
                }
                if($Bulan_Periode==12)
                {
                    $Bulan_Berikutnya = 1;
                    $Tahun_Berikutnya++;  
                }
                
                else
                {
                    $Bulan_Berikutnya = $Bulan_Periode + 1;
                    $Tahun_Berikutnya = $Tahun_Periode;
                }
                $Bulan_Berikutnya = substr("0".$Bulan_Berikutnya, -2);

                //Simpan di database sementara

                $a_date = $Tahun_Periode."-".$Bulan_Periode."-01";
                //echo "a_date : ".$a_date."<br>";
                //$Tanggal_Test = date("Y-m-t", strtotime($a_date));
                $Last_Day = date("t", strtotime($a_date));

                $Daftar_Tanggal_Hari_Kerja = array();
                for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
                {
                    //Cek tanggal merah
                    $Tanggal_Cek = $Tahun_Periode."-".$Bulan_Periode."-".substr("0".$Tanggal_Aktif, -2);
                    $sql = "SELECT * FROM hari_libur h
                                WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry);
                    
                    //cek hari Minggu
                    if(date("D",strtotime(date($Tanggal_Cek)))==="Sun" || $num>0)
                    {
                        
                    }
                    else
                    {
                        array_push( $Daftar_Tanggal_Hari_Kerja, $Tanggal_Cek);
                    }
                    
                }
                $Daftar_Tanggal_Masuk = "";
                $Jumlah_Tanggal_Masuk = 0;
                foreach ($Daftar_Tanggal_Hari_Kerja as $value) 
                {
                    $Daftar_Tanggal_Masuk = $Daftar_Tanggal_Masuk ."'".$value."', ";
                    $Jumlah_Tanggal_Masuk++;
                    
                }

                $Daftar_Tanggal_Masuk = substr(trim($Daftar_Tanggal_Masuk), 0, strlen($Daftar_Tanggal_Masuk)-2);
                //echo $Daftar_Tanggal_Masuk."<br>";

                //Ambil data cabang dan team leader
                $sql = "SELECT * FROM data_karyawan dk 
                            INNER JOIN (SELECT ul.Username FROM user_list ul
                                            INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                            INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                            WHERE uj.Jenis_UserNID = 3) u ON u.Username = dk.NIM
                            INNER JOIN cabang c On c.CabangNID = dk.CabangNID
                            WHERE dk.Aktif = 1 
                            ORDER BY trim(dk.Nama_Lengkap)
                            LIMIT 100
                            ";
                //echo $sql.";<br>";
                $qry_Data = mysqli_query($Connection, $sql);
                $Jumlah_Data = mysqli_num_rows($qry_Data);
                $Baris = 9;
                $Nomor_Urut = 1;
                $Counter_Data = 1;
                while($buff_Data = mysqli_fetch_array($qry_Data))
                {
                    $KaryawanNID  = $buff_Data['KaryawanNID'];
                    $NIM  = $buff_Data['NIM'];
                    $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                    $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                    $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                    $CabangNID  = $buff_Data['CabangNID'];
                    $Jumlah_Anggota  = $buff_Data['Jumlah_Anggota'];

                    //Ambil data LPH
                    $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' 
                                AND lh.IsValid = 1 AND lh.Cuti=0";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_LPH = $buff_Jumlah['Jumlah'];
                    if($Jumlah_LPH>=1180)
                    {
                        $Score_LPH = 5;
                    }
                    elseif($Jumlah_LPH>=980)
                    {
                        $Score_LPH = 4;
                    }
                    elseif($Jumlah_LPH>=780)
                    {
                        $Score_LPH = 3;
                    }
                    elseif($Jumlah_LPH>=580)
                    {
                        $Score_LPH = 2;
                    }
                    elseif($Jumlah_LPH>=380)
                    {
                        $Score_LPH = 1;
                    }
                    else
                    {
                        $Score_LPH = 0;
                    }
                    $Score_LPH = $Score_LPH * 25/100;
                    
                    //echo "Jumlah LPH : ".$Jumlah_LPH."<br>";
                    //echo "Score LPH : ".$Score_LPH."<br>";

                    //Ambil data CT
                    $sql = "SELECT * FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                AND lh.IsValid = 1
                                ORDER BY lh.Tanggal, lh.Laporan_HarianNID DESC
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_CT = 0;
                    $Score_CT = 0;
                    
                    if($num<>0)
                    {
                        //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                        //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                        //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                        //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                        $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                        $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                        //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                        //echo "Bulan CT : ".$Bulan_CT."<br>";
                        $Bulan_Aktif = $Bulan_Periode + 1;
                        //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                        if($Bulan_CT==$Bulan_Aktif)
                        {
                            //echo $Tanggal_CT;
                            if($Tanggal_CT==1)
                            {
                                $Score_CT = 5;
                            }
                            elseif($Tanggal_CT==2)
                            {
                                $Score_CT = 4;
                            }
                            elseif($Tanggal_CT==3)
                            {
                                $Score_CT = 3;
                            }
                            elseif($Tanggal_CT==4)
                            {
                                $Score_CT = 2;
                            }
                            elseif($Tanggal_CT==5)
                            {
                                $Score_CT = 1;
                            }
                            elseif($Tanggal_CT>=6)
                            {
                                $Score_CT = 1;
                            }    
                        }
                        elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                        {
                            
                            if($Tanggal_CT>=25)
                            {
                                $Score_CT = 5;
                            }
                            else
                            {
                                $Score_CT = 0;
                            }
                        }
                        
                        

                        //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                        $Jumlah_CT = $Score_CT;
                        $Score_CT = $Score_CT * 15/100;
                        //echo "Score CT : ".$Score_CT."<br>";
                    }
                    else
                    {
                        $Jumlah_CT = 0;
                        $Score_CT = $Score_CT * 15/100;
                    }
                    //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                    //echo "Score CT : ".$Score_CT."<br>";

                    //Pembayaran Invoice
                    $sql = "SELECT * FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 6 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                AND lh.IsValid = 1
                                ORDER BY lh.Tanggal, lh.Laporan_HarianNID DESC
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_Invoice = 0;
                    $Score_Invoice = 0;
                    
                    if($num<>0)
                    {
                        //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                        //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                        //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                        //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                        $Tanggal_Invoice = intval(substr($buff_Jumlah['Tanggal'],-2));
                        $Bulan_Invoice = intval(substr($buff_Jumlah['Tanggal'],5,2));
                        //echo "Tanggal_Invoice : ".$buff_Jumlah['Tanggal']."<br>";
                        //echo "Tanggal_Invoice : ".$Tanggal_Invoice."<br>";
                        //echo "Bulan_Invoice : ".$Bulan_Invoice."<br>";
                        $Bulan_Aktif = $Bulan_Periode + 1;
                        //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                        if($Bulan_Invoice==$Bulan_Aktif)
                        {
                            //echo "Test1<br>";
                            //Lewat akhir periode
                            $Score_Invoice = 1;
                        }
                        elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                        {
                            //echo "Test2<br>";
                            if($Tanggal_Invoice>=22)
                            {
                                $Score_Invoice = 1;
                            }
                            elseif($Tanggal_Invoice>=21)
                            {
                                $Score_Invoice = 2;
                            }
                            if($Tanggal_Invoice>=20)
                            {
                                $Score_Invoice = 3;
                            }
                            if($Tanggal_Invoice>=19)
                            {
                                $Score_Invoice = 4;
                            }
                            else
                            {
                                $Score_Invoice = 5;
                            }
                        }
                        
                        

                        //echo "Score CT Sebelum persentase : ".$Score_Invoice."<br>";
                        $Jumlah_Invoice = $Score_Invoice;
                        $Score_Invoice = $Score_Invoice * 25/100;
                        //echo "Score_Invoice : ".$Score_Invoice."<br>";
                    }
                    else
                    {
                        //echo "Test3<br>";
                        $Jumlah_Invoice = 0;
                        $Score_Invoice = $Score_Invoice * 25/100;
                    }
                    //echo "Jumlah_Invoice CT : ".$Jumlah_Invoice."<br>";
                    //echo "Score_Invoice : ".$Score_Invoice."<br>";
                    

                    //Ambil data PJ
                    $sql = "SELECT * FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                AND lh.IsValid = 1
                                ORDER BY lh.Tanggal, lh.Laporan_HarianNID DESC
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_PJ = 0;
                    $Score_PJ = 0;
                    
                    if($num<>0)
                    {
                        //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                        //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                        //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                        //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                        $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                        $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                        //echo "Tanggal PJ : ".$Tanggal_PJ."<br>";
                        //echo "Bulan PJ : ".$Bulan_PJ."<br>";
                        $Bulan_Aktif = $Bulan_Periode + 1;
                        //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                        if($Bulan_PJ==$Bulan_Aktif)
                        {
                            //echo $Tanggal_CT;
                            if($Tanggal_PJ==1)
                            {
                                $Score_PJ = 5;
                            }
                            elseif($Tanggal_PJ==2)
                            {
                                $Score_PJ = 4;
                            }
                            elseif($Tanggal_PJ==3)
                            {
                                $Score_PJ = 3;
                            }
                            elseif($Tanggal_PJ==4)
                            {
                                $Score_PJ = 2;
                            }
                            elseif($Tanggal_PJ==5)
                            {
                                $Score_PJ = 1;
                            }
                            elseif($Tanggal_PJ>=6)
                            {
                                $Score_PJ = 1;
                            }    
                        }
                        elseif($Bulan_Periode==($Bulan_Aktif-1))
                        {
                            
                            if($Tanggal_PJ>=25)
                            {
                                $Score_PJ = 5;
                            }
                            else
                            {
                                $Score_PJ = 0;
                            }
                        }
                        
                        //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                        $Jumlah_PJ = $Score_PJ;
                        $Score_PJ = $Score_PJ * 10/100;
                        //echo "Score PJ : ".$Score_PJ."<br>";
                    }
                    else
                    {
                        
                        $Jumlah_PJ = 0;
                        $Score_PJ = $Score_PJ * 10/100;
                        
                    }
                    

                    //Ambil data IA
                    $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' AND lh.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                AND lh.IsValid = 1  AND lh.Cuti=0
                                GROUP BY lh.Tanggal
                                ";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    
                    $Jumlah_IA = $num;

                    if($Jumlah_IA>=26)
                    {
                        $Score_IA = 5;
                    }
                    elseif($Jumlah_IA>=24)
                    {
                        $Score_IA = 4;
                    }
                    elseif($Jumlah_IA>=23)
                    {
                        $Score_IA = 3;
                    }
                    elseif($Jumlah_IA>=21)
                    {
                        $Score_IA = 2;
                    }
                    elseif($Jumlah_IA>=20)
                    {
                        $Score_IA = 1;
                    }
                    elseif($Jumlah_IA>=1)
                    {
                        $Score_IA = 1;
                    }
                    else
                    {
                        $Score_IA = 0;
                    }
                    $Score_IA = $Score_IA * 25/100;

                    //echo "Jumlah IA : ".$Jumlah_IA."<br>";
                    //echo "Score IA : ".$Score_IA."<br>";
                    //$Jumlah_Invoice = 0;

                    //Hitung jumlah yang tidak dilaporkan
                    $Jumlah_CT_Denda = 0;
                    $Jumlah_PJ_Denda = 0;
                    
                    
                    //Ambil data LPH
                    $sql = "SELECT * FROM laporan_harian l 
                                WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                AND l.IsValid = 1
                                GROUP BY l.Tanggal";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                    $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;

                    //Ambil data IA
                    $sql = "SELECT * FROM laporan_harian l 
                                WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                AND l.IsValid = 1
                                GROUP BY l.Tanggal";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $Jumlah_IA_Denda = $Jumlah_Tanggal_Masuk - $num;
                    $Nilai_Denda_IA = $Jumlah_IA_Denda * 5000;
                    

                    $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-20";
                    
                    $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                    
                    //Ambil data CT
                    $sql = "SELECT * FROM laporan_harian l 
                                WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                AND l.IsValid = 1
                                GROUP BY l.Tanggal
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    if($num===0)
                    {
                        $Jumlah_CT_Denda = 1;
                    }
                    else
                    {
                        $Jumlah_CT_Denda = 0;
                    }
                    $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                    
                    //Ambil data PJ
                    $sql = "SELECT * FROM laporan_harian l 
                                WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                AND l.IsValid = 1
                                GROUP BY l.Tanggal
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    if($num===0)
                    {
                        $Jumlah_PJ_Denda = 1;
                    }
                    else
                    {
                        $Jumlah_PJ_Denda = 0;
                    }
                    $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                    
                    if($Jumlah_Anggota<=10)
                    {
                        $Insentif_Jumlah_Anggota = 150000;
                    }
                    elseif($Jumlah_Anggota<=15)
                    {
                        $Insentif_Jumlah_Anggota = 250000;
                    }
                    elseif($Jumlah_Anggota<=20)
                    {
                        $Insentif_Jumlah_Anggota = 400000;
                    }
                    else
                    {
                        $Insentif_Jumlah_Anggota = 500000;
                    }
                    
                    $Total_Score_KPI = $Score_LPH + $Score_CT + $Score_PJ + $Score_IA;
                    
                    $Total_Potongan = $Nilai_Denda_LPH + $Nilai_Denda_CT + $Nilai_Denda_IA + $Nilai_Denda_PJ;
                    
                    //Proses menulis ke database sementara
                    $Total_Potongan = $Nilai_Denda_LPH + $Nilai_Denda_CT + $Nilai_Denda_IA + $Nilai_Denda_PJ;
                    $Total_Score_KPI = $Score_LPH + $Score_CT + $Score_PJ + $Score_IA + $Score_Invoice;
                    $Total_Insentif = $Insentif_Jumlah_Anggota * ($Total_Score_KPI*20/100);
                    //Proses menulis ke database sementara
                    $sql = "INSERT INTO temp_rekap (CabangNID, Hasil_LPH, Nilai_LPH, Hasil_CL, Nilai_CL, Hasil_PJ, Nilai_PJ, Hasil_IA, Nilai_IA, Hasil_Invoice, Nilai_Invoice,
                                                    Jumlah_Denda_LPH, Nilai_Denda_LPH, Jumlah_Denda_CL, Nilai_Denda_CL, Jumlah_Denda_PJ, Nilai_Denda_PJ, Jumlah_Denda_IA, Nilai_Denda_IA,
                                                    Total_Score_KPI, Total_Potongan, Total_Insentif, Creator) VALUES
                                                    ('$CabangNID', '$Jumlah_LPH','$Score_LPH', '$Jumlah_CT', '$Score_CT', '$Jumlah_PJ', '$Score_PJ', '$Jumlah_IA', '$Score_IA', '$Jumlah_Invoice', '$Score_Invoice',
                                                    '$Jumlah_LPH_Denda', '$Nilai_Denda_LPH', '$Jumlah_CT_Denda', '$Nilai_Denda_CT', '$Jumlah_PJ_Denda', '$Nilai_Denda_PJ', '$Jumlah_IA_Denda', '$Nilai_Denda_IA', 
                                                    '$Total_Score_KPI', '$Total_Potongan', '$Total_Insentif','$Last_UserNID' )";
                    //echo $sql."<br>";
                    $qry_Simpan_Ke_Temp = mysqli_query($Connection, $sql);
                }
            }//end skema insentif yang lama
            elseif($Periode_Laporan=="202204") //Masih untuk target jumlah hari maksimal belum disesuaikan dengan jumlah hari aktif
            {
                
                
                //Hapus table
                $sql = "DELETE FROM temp_rekap WHERE Creator = '".$Last_UserNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

                $Tahun_Periode = substr($Periode_Laporan, 0, 4);
                $Bulan_Periode = substr($Periode_Laporan, -2);
                $Bulan_Periode_Untuk_Nama_File = $Bulan_Periode;
                $Bulan_Periode = intval($Bulan_Periode);
                $Tahun_Sebelumnya = $Tahun_Periode - 1;
                $Tahun_Berikutnya = $Tahun_Periode + 1;
                if($Bulan_Periode==1)
                {
                    $Bulan_Sebelumnya = 12;
                }
                else
                {
                    $Bulan_Sebelumnya = $Bulan_Periode - 1;
                }
                if($Bulan_Periode==12)
                {
                    $Bulan_Berikutnya = 1;
                    $Tahun_Berikutnya++;  
                }
                
                else
                {
                    $Bulan_Berikutnya = $Bulan_Periode + 1;
                    $Tahun_Berikutnya = $Tahun_Periode;
                }
                $Bulan_Berikutnya = substr("0".$Bulan_Berikutnya, -2);

                //Simpan di database sementara

                $a_date = $Tahun_Periode."-".$Bulan_Periode."-01";
                //echo "a_date : ".$a_date."<br>";
                //$Tanggal_Test = date("Y-m-t", strtotime($a_date));
                $Last_Day = date("t", strtotime($a_date));

                $Daftar_Tanggal_Hari_Kerja = array();
                
                for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
                {
                    //Cek tanggal merah
                    $Tanggal_Cek = $Tahun_Periode."-".substr('0'.$Bulan_Periode,-2)."-".substr("0".$Tanggal_Aktif, -2);
                    $sql = "SELECT * FROM hari_libur h
                                WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry);
                    
                    //cek hari Minggu
                    if(date("D",strtotime(date($Tanggal_Cek)))==="Sun" || $num>0)
                    {
                        
                    }
                    else
                    {
                        array_push( $Daftar_Tanggal_Hari_Kerja, $Tanggal_Cek);
                    }
                    
                }
                
                $Daftar_Tanggal_Hari_Kerja_Sidoarjo = array();
                for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
                {
                    //Cek tanggal merah
                    $Tanggal_Cek = $Tahun_Periode."-".substr('0'.$Bulan_Periode,-2)."-".substr("0".$Tanggal_Aktif, -2);
                    $sql = "SELECT * FROM hari_libur h
                                WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry);
                    
                    array_push( $Daftar_Tanggal_Hari_Kerja_Sidoarjo, $Tanggal_Cek);
                    //cek hari Minggu
                    if(date("D",strtotime(date($Tanggal_Cek)))==="Sat" || $num>0)
                    {
                        
                    }
                    else
                    {
                        
                    }
                    
                }
                
                $Daftar_Tanggal_Masuk = "";
                $Jumlah_Tanggal_Masuk = 0;
                foreach ($Daftar_Tanggal_Hari_Kerja as $value) 
                {
                    $Daftar_Tanggal_Masuk = $Daftar_Tanggal_Masuk ."'".$value."', ";
                    $Jumlah_Tanggal_Masuk++;
                    
                }
                $Daftar_Tanggal_Masuk = substr(trim($Daftar_Tanggal_Masuk), 0, strlen($Daftar_Tanggal_Masuk)-2);

                $Daftar_Tanggal_Masuk_Sidoarjo = "";
                $Jumlah_Tanggal_Masuk_Sidoarjo = 0;
                foreach ($Daftar_Tanggal_Hari_Kerja_Sidoarjo as $value) 
                {
                    $Daftar_Tanggal_Masuk_Sidoarjo = $Daftar_Tanggal_Masuk_Sidoarjo ."'".$value."', ";
                    $Jumlah_Tanggal_Masuk_Sidoarjo++;
                    
                }
                $Daftar_Tanggal_Masuk_Sidoarjo = substr(trim($Daftar_Tanggal_Masuk_Sidoarjo), 0, strlen($Daftar_Tanggal_Masuk_Sidoarjo)-2);
                
                //echo $Daftar_Tanggal_Masuk."<br>";
                //echo $Daftar_Tanggal_Masuk_Sidoarjo."<br>";

                //Ambil data cabang dan team leader
                $sql = "SELECT * FROM data_karyawan dk 
                            INNER JOIN (SELECT ul.Username FROM user_list ul
                                            INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                            INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                            WHERE uj.Jenis_UserNID = 3) u ON u.Username = dk.NIM
                            INNER JOIN cabang c On c.CabangNID = dk.CabangNID
                            WHERE dk.Aktif = 1 
                            ORDER BY trim(dk.Nama_Lengkap)
                            LIMIT 100
                            ";
                //echo $sql.";<br>";
                $qry_Data = mysqli_query($Connection, $sql);
                $Jumlah_Data = mysqli_num_rows($qry_Data);
                $Baris = 9;
                $Nomor_Urut = 1;
                $Counter_Data = 1;
                while($buff_Data = mysqli_fetch_array($qry_Data))
                {
                    $KaryawanNID  = $buff_Data['KaryawanNID'];
                    $NIM  = $buff_Data['NIM'];
                    $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                    $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                    $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                    $CabangNID  = $buff_Data['CabangNID'];
                    $Jumlah_Anggota  = $buff_Data['Jumlah_Anggota'];

                    //Ambil data LPH
                    $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' 
                                AND lh.IsValid = 1  AND lh.Cuti=0";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_LPH = $buff_Jumlah['Jumlah'];
                    if($Jumlah_LPH>=1180)
                    {
                        $Score_LPH = 5;
                    }
                    elseif($Jumlah_LPH>=980)
                    {
                        $Score_LPH = 4;
                    }
                    elseif($Jumlah_LPH>=780)
                    {
                        $Score_LPH = 3;
                    }
                    elseif($Jumlah_LPH>=580)
                    {
                        $Score_LPH = 2;
                    }
                    elseif($Jumlah_LPH>=380)
                    {
                        $Score_LPH = 1;
                    }
                    else
                    {
                        $Score_LPH = 0;
                    }
                    $Score_LPH = $Score_LPH * 25/100;
                    
                    //echo "Jumlah LPH : ".$Jumlah_LPH."<br>";
                    //echo "Score LPH : ".$Score_LPH."<br>";

                    //Pembayaran Invoice
                    $sql = "SELECT * FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 6 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                AND lh.IsValid = 1
                                ORDER BY lh.Tanggal, lh.Laporan_HarianNID DESC
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_Invoice = 0;
                    $Score_Invoice = 0;
                    
                    if($num<>0)
                    {
                        //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                        //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                        //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                        //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                        $Tanggal_Invoice = intval(substr($buff_Jumlah['Tanggal'],-2));
                        $Bulan_Invoice = intval(substr($buff_Jumlah['Tanggal'],5,2));
                        //echo "Tanggal Invoice : ".$Tanggal_Invoice."<br>";
                        //echo "Bulan Invoice : ".$Bulan_Invoice."<br>";
                        $Bulan_Aktif = $Bulan_Periode + 1;
                        //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                        if($Bulan_Invoice==$Bulan_Aktif)
                        {
                            //Lewat akhir periode
                            $Score_Invoice = 1;
                        }
                        elseif(intval($Bulan_Periode)==($Bulan_Aktif-1) && $Bulan_Invoice==$Bulan_Periode)
                        {
                            
                            if($Tanggal_Invoice>=22)
                            {
                                $Score_Invoice = 1;
                            }
                            elseif($Tanggal_Invoice>=21)
                            {
                                $Score_Invoice = 2;
                            }
                            if($Tanggal_Invoice>=20)
                            {
                                $Score_Invoice = 3;
                            }
                            if($Tanggal_Invoice>=19)
                            {
                                $Score_Invoice = 4;
                            }
                            else
                            {
                                $Score_Invoice = 5;
                            }
                        }else
                        {
                            $Score_Invoice = 5;
                        }

                        //echo "Score_Invoice Sebelum persentase : ".$Score_Invoice."<br>";
                        $Jumlah_Invoice = $Score_Invoice;
                        $Score_Invoice = $Score_Invoice * 25/100;
                        //echo "Score_Invoice : ".$Score_Invoice."<br>";
                    }
                    else
                    {
                        $Jumlah_Invoice = 0;
                        $Score_Invoice = $Score_Invoice * 25/100;
                    }
                    //echo "Jumlah_Invoice CT : ".$Jumlah_Invoice."<br>";
                    //echo "Score_Invoice : ".$Score_Invoice."<br>";

                    //Ambil data IA
                    if($CabangNID==15 || $CabangNID==16)
                    {
                        $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' AND lh.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                    AND lh.IsValid = 1  AND lh.Cuti=0
                                    GROUP BY lh.Tanggal
                                    ";
                    }
                    else
                    {
                        $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' AND lh.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                    AND lh.IsValid = 1  AND lh.Cuti=0
                                    GROUP BY lh.Tanggal
                                    ";
                    }
                    
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    
                    $Jumlah_IA = $num;

                    if($Jumlah_IA>=20)
                    {
                        $Score_IA = 5;
                    }
                    elseif($Jumlah_IA>=19)
                    {
                        $Score_IA = 4;
                    }
                    elseif($Jumlah_IA>=18)
                    {
                        $Score_IA = 3;
                    }
                    elseif($Jumlah_IA>=17)
                    {
                        $Score_IA = 2;
                    }
                    elseif($Jumlah_IA>=16)
                    {
                        $Score_IA = 1;
                    }
                    elseif($Jumlah_IA>=1)
                    {
                        $Score_IA = 1;
                    }
                    else
                    {
                        $Score_IA = 0;
                    }
                    $Score_IA = $Score_IA * 25/100;

                    //echo "Jumlah IA : ".$Jumlah_IA."<br>";
                    //echo "Score IA : ".$Score_IA."<br>";
                    //$Jumlah_Invoice = 0;

                    //Hitung jumlah yang tidak dilaporkan
                    $Jumlah_CT_Denda = 0;
                    $Jumlah_PJ_Denda = 0;

                    if( //$CabangNID==6 || $CabangNID==2 ||      //Bandung 1 (6) dan Bandung 2(2)
                        $CabangNID==41 || $CabangNID==42 ||    //Bekasi 1(41) dan Bekasi 2 (42)
                        $CabangNID==3 || $CabangNID==12 ||     //Cilacap 1(3) dan Cilacap 2 (12)
                        $CabangNID==35 || $CabangNID==36 ||    //Cileungsi 1(36) dan Cileungsi 2(25)
                        $CabangNID==4 || $CabangNID==5 ||      //Jember 1(4) dan Jember 5(5)
                        $CabangNID==15 || $CabangNID==16)      //Sidoarjo 1(15) dan Sidoarjo 2(16)
                    {
                        

                        if($CabangNID==41 || $CabangNID==42 )
                        {
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 41 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 42 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 41 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 42 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 41 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 42 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 41 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 42 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 41 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 42 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                        }
                        elseif($CabangNID==3 || $CabangNID==12)
                        {
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 3 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 12 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 3 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 12 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 3 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 12 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;
                            

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }
                            //echo "Jumlah_LPH_Denda".$Jumlah_LPH_Denda."<br>";
                            //echo "Nilai_Denda_LPH".$Nilai_Denda_LPH."<br>";

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 3 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 12 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 3 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 12 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                        }
                        elseif($CabangNID==35 || $CabangNID==36)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 35 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 36 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 35 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 36 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 35 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            if($CabangNID==35)
                            {
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 36 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            if($CabangNID==36)
                            {
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 35 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 36 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 35 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 36 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                        }
                        elseif($CabangNID==4 || $CabangNID==5)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 4 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 5 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 4 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 5 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 0;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 4 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            if($CabangNID==4)
                            {
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;
                            

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 5 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            if($CabangNID==5)
                            {
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 4 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 5 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 4 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 5 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                        }
                        elseif($CabangNID==15 || $CabangNID==16)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 15 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 16 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 15 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 16 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 15 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 16 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 15 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 16 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 15 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 16 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                        }
                        
                    }
                    else
                    {
                        //Ambil data CT
                        $sql = "SELECT * FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                    AND lh.IsValid = 1
                                    ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                        $Jumlah_CT = 0;
                        $Score_CT = 0;
                        
                        if($num<>0)
                        {
                            //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                            //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                            //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                            //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                            $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                            $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                            //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                            //echo "Bulan CT : ".$Bulan_CT."<br>";
                            $Bulan_Aktif = $Bulan_Periode + 1;
                            //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                            if($Bulan_CT==$Bulan_Aktif)
                            {
                                //echo $Tanggal_CT;
                                if($Tanggal_CT==1)
                                {
                                    $Score_CT = 5;
                                }
                                elseif($Tanggal_CT==2)
                                {
                                    $Score_CT = 4;
                                }
                                elseif($Tanggal_CT==3)
                                {
                                    $Score_CT = 3;
                                }
                                elseif($Tanggal_CT==4)
                                {
                                    $Score_CT = 2;
                                }
                                elseif($Tanggal_CT==5)
                                {
                                    $Score_CT = 1;
                                }
                                elseif($Tanggal_CT>=6)
                                {
                                    $Score_CT = 1;
                                }    
                            }
                            elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                            {
                                
                                if($Tanggal_CT>=25)
                                {
                                    $Score_CT = 5;
                                }
                                else
                                {
                                    $Score_CT = 5;
                                }
                            }
                            
                            

                            //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                            $Jumlah_CT = $Score_CT;
                            $Score_CT = $Score_CT * 15/100;
                            //echo "Score CT : ".$Score_CT."<br>";
                        }
                        else
                        {
                            $Jumlah_CT = 0;
                            $Score_CT = $Score_CT * 15/100;
                        }
                        //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                        //echo "Score CT : ".$Score_CT."<br>";

                        //Ambil data PJ
                        $sql = "SELECT * FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                    AND lh.IsValid = 1
                                    ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                        $Jumlah_PJ = 0;
                        $Score_PJ = 0;
                        
                        if($num<>0)
                        {
                            //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                            //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                            //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                            //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                            $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                            $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                            //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                            //echo "Bulan CT : ".$Bulan_PJ."<br>";
                            $Bulan_Aktif = $Bulan_Periode + 1;
                            //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                            if($Bulan_PJ==$Bulan_Aktif)
                            {
                                //echo $Tanggal_CT;
                                if($Tanggal_PJ==1)
                                {
                                    $Score_PJ = 5;
                                }
                                elseif($Tanggal_PJ==2)
                                {
                                    $Score_PJ = 4;
                                }
                                elseif($Tanggal_PJ==3)
                                {
                                    $Score_PJ = 3;
                                }
                                elseif($Tanggal_PJ==4)
                                {
                                    $Score_PJ = 2;
                                }
                                elseif($Tanggal_PJ==5)
                                {
                                    $Score_PJ = 1;
                                }
                                elseif($Tanggal_PJ>=6)
                                {
                                    $Score_PJ = 1;
                                }    
                            }
                            elseif($Bulan_Periode==($Bulan_Aktif-1))
                            {
                                
                                if($Tanggal_PJ>=25)
                                {
                                    $Score_PJ = 5;
                                }
                                else
                                {
                                    $Score_PJ = 5;
                                }
                            }
                            
                            //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                            $Jumlah_PJ = $Score_PJ;
                            $Score_PJ = $Score_PJ * 10/100;
                            //echo "Score PJ : ".$Score_PJ."<br>";
                        }
                        else
                        {
                            
                            $Jumlah_PJ = 0;
                            $Score_PJ = $Score_PJ * 10/100;
                            
                        }
                        

                        

                        //echo "Jumlah IA : ".$Jumlah_IA."<br>";
                        //echo "Score IA : ".$Score_IA."<br>";
                        //$Jumlah_Invoice = 0;

                        //Hitung jumlah yang tidak dilaporkan
                        $Jumlah_CT_Denda = 0;
                        $Jumlah_PJ_Denda = 0;
                        
                        
                        //Ambil data LPH
                        if($CabangNID==15 || $CabangNID == 16)
                        {
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                        }
                        else
                        {
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                        }
                        
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                        $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                        //echo "Jumlah_LPH_Denda : ".$Jumlah_LPH_Denda."<br>";
                        //echo "Nilai_Denda_LPH : ".$Nilai_Denda_LPH."<br>";

                        $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                        
                        $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                        
                        //Ambil data CT
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        if($num===0)
                        {
                            $Jumlah_CT_Denda = 1;
                        }
                        else
                        {
                            $Jumlah_CT_Denda = 0;
                        }
                        $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                        
                        
                        //Ambil data PJ
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        if($num===0)
                        {
                            $Jumlah_PJ_Denda = 1;
                        }
                        else
                        {
                            $Jumlah_PJ_Denda = 0;
                        }
                        $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                    }
                    //Ambil data IA
                    if($CabangNID==15 || $CabangNID == 16)
                    {
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal";
                    }
                    else
                    {
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal";
                    }
                    
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $Jumlah_IA_Denda = $Jumlah_Tanggal_Masuk - $num;
                    $Nilai_Denda_IA = $Jumlah_IA_Denda * 5000;
                    
                    
                    $Total_Potongan = $Nilai_Denda_LPH + $Nilai_Denda_CT + $Nilai_Denda_IA + $Nilai_Denda_PJ;
                    $Total_Score_KPI = $Score_LPH + $Score_CT + $Score_PJ + $Score_IA + $Score_Invoice;
                    //Proses menulis ke database sementara
                    $sql = "INSERT INTO temp_rekap (CabangNID, Hasil_LPH, Nilai_LPH, Hasil_CL, Nilai_CL, Hasil_PJ, Nilai_PJ, Hasil_IA, Nilai_IA, Hasil_Invoice, Nilai_Invoice,
                                                    Jumlah_Denda_LPH, Nilai_Denda_LPH, Jumlah_Denda_CL, Nilai_Denda_CL, Jumlah_Denda_PJ, Nilai_Denda_PJ, Jumlah_Denda_IA, Nilai_Denda_IA,
                                                    Total_Score_KPI, Total_Potongan, Creator) VALUES
                                                    ('$CabangNID', '$Jumlah_LPH','$Score_LPH', '$Jumlah_CT', '$Score_CT', '$Jumlah_PJ', '$Score_PJ', '$Jumlah_IA', '$Score_IA', '$Jumlah_Invoice', '$Score_Invoice',
                                                    '$Jumlah_LPH_Denda', '$Nilai_Denda_LPH', '$Jumlah_CT_Denda', '$Nilai_Denda_CT', '$Jumlah_PJ_Denda', '$Nilai_Denda_PJ', '$Jumlah_IA_Denda', '$Nilai_Denda_IA', 
                                                    '$Total_Score_KPI', '$Total_Potongan', '$Last_UserNID' )";
                    //echo $sql."<br>";
                    $qry_Simpan_Ke_Temp = mysqli_query($Connection, $sql);
                }
            }
            else
            {
                
                
                //Hapus table
                $sql = "DELETE FROM temp_rekap WHERE Creator = '".$Last_UserNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

                $Tahun_Periode = substr($Periode_Laporan, 0, 4);
                $Bulan_Periode = substr($Periode_Laporan, -2);
                $Bulan_Periode_Untuk_Nama_File = $Bulan_Periode;
                $Bulan_Periode = intval($Bulan_Periode);
                $Tahun_Sebelumnya = $Tahun_Periode - 1;
                $Tahun_Berikutnya = $Tahun_Periode + 1;
                if($Bulan_Periode==1)
                {
                    $Bulan_Sebelumnya = 12;
                }
                else
                {
                    $Bulan_Sebelumnya = $Bulan_Periode - 1;
                }
                if($Bulan_Periode==12)
                {
                    $Bulan_Berikutnya = 1;
                    $Tahun_Berikutnya++;  
                }
                
                else
                {
                    $Bulan_Berikutnya = $Bulan_Periode + 1;
                    $Tahun_Berikutnya = $Tahun_Periode;
                }
                $Bulan_Berikutnya = substr("0".$Bulan_Berikutnya, -2);

                //Simpan di database sementara

                $a_date = $Tahun_Periode."-".$Bulan_Periode."-01";
                //echo "a_date : ".$a_date."<br>";
                //$Tanggal_Test = date("Y-m-t", strtotime($a_date));
                $Last_Day = date("t", strtotime($a_date));

                $Daftar_Tanggal_Hari_Kerja = array();
                
                for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
                {
                    //Cek tanggal merah
                    $Tanggal_Cek = $Tahun_Periode."-".substr('0'.$Bulan_Periode,-2)."-".substr("0".$Tanggal_Aktif, -2);
                    $sql = "SELECT * FROM hari_libur h
                                WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry);
                    
                    //cek hari Minggu
                    if(date("D",strtotime(date($Tanggal_Cek)))==="Sun" || $num>0)
                    {
                        
                    }
                    else
                    {
                        array_push( $Daftar_Tanggal_Hari_Kerja, $Tanggal_Cek);
                    }
                    
                }
                $Jumlah_Maksimal_Hari_Aktif = count($Daftar_Tanggal_Hari_Kerja);
                //echo $Jumlah_Maksimal_Hari_Aktif."<br>";

                $Daftar_Tanggal_Hari_Kerja_Sidoarjo = array();
                for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
                {
                    //Cek tanggal merah
                    $Tanggal_Cek = $Tahun_Periode."-".substr('0'.$Bulan_Periode,-2)."-".substr("0".$Tanggal_Aktif, -2);
                    $sql = "SELECT * FROM hari_libur h
                                WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry);
                    
                    array_push( $Daftar_Tanggal_Hari_Kerja_Sidoarjo, $Tanggal_Cek);
                    //cek hari Minggu
                    if(date("D",strtotime(date($Tanggal_Cek)))==="Sat" || $num>0)
                    {
                        
                    }
                    else
                    {
                        
                    }
                    
                }
                $Jumlah_Maksimal_Hari_Aktif_Sidoarjo = count($Daftar_Tanggal_Hari_Kerja_Sidoarjo);
                //echo $Jumlah_Maksimal_Hari_Aktif_Sidoarjo."<br>";
                
                $Daftar_Tanggal_Masuk = "";
                $Jumlah_Tanggal_Masuk = 0;
                foreach ($Daftar_Tanggal_Hari_Kerja as $value) 
                {
                    $Daftar_Tanggal_Masuk = $Daftar_Tanggal_Masuk ."'".$value."', ";
                    $Jumlah_Tanggal_Masuk++;
                    
                }
                $Daftar_Tanggal_Masuk = substr(trim($Daftar_Tanggal_Masuk), 0, strlen($Daftar_Tanggal_Masuk)-2);

                $Daftar_Tanggal_Masuk_Sidoarjo = "";
                $Jumlah_Tanggal_Masuk_Sidoarjo = 0;
                foreach ($Daftar_Tanggal_Hari_Kerja_Sidoarjo as $value) 
                {
                    $Daftar_Tanggal_Masuk_Sidoarjo = $Daftar_Tanggal_Masuk_Sidoarjo ."'".$value."', ";
                    $Jumlah_Tanggal_Masuk_Sidoarjo++;
                    
                }
                $Daftar_Tanggal_Masuk_Sidoarjo = substr(trim($Daftar_Tanggal_Masuk_Sidoarjo), 0, strlen($Daftar_Tanggal_Masuk_Sidoarjo)-2);
                
                //echo $Daftar_Tanggal_Masuk."<br>";
                //echo $Daftar_Tanggal_Masuk_Sidoarjo."<br>";

                //Ambil data cabang dan team leader
                $sql = "SELECT * FROM data_karyawan dk 
                            INNER JOIN (SELECT ul.Username FROM user_list ul
                                            INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                            INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                            WHERE uj.Jenis_UserNID = 3) u ON u.Username = dk.NIM
                            INNER JOIN cabang c On c.CabangNID = dk.CabangNID
                            WHERE dk.Aktif = 1 
                            ORDER BY trim(dk.Nama_Lengkap)
                            LIMIT 100
                            ";
                //limit 100
                //echo $sql.";<br>";
                $qry_Data = mysqli_query($Connection, $sql);
                $Jumlah_Data = mysqli_num_rows($qry_Data);
                $Baris = 9;
                $Nomor_Urut = 1;
                $Counter_Data = 1;
                while($buff_Data = mysqli_fetch_array($qry_Data))
                {
                    $KaryawanNID  = $buff_Data['KaryawanNID'];
                    $NIM  = $buff_Data['NIM'];
                    $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                    $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                    $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                    $CabangNID  = $buff_Data['CabangNID'];
                    $Jumlah_Anggota  = $buff_Data['Jumlah_Anggota'];
                    //echo $Nama_Cabang."-".$Nama_Lengkap."<br>";

                    //Ambil data LPH
                    $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' 
                                AND lh.IsValid = 1  AND lh.Cuti=0";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_LPH = $buff_Jumlah['Jumlah'];
                    if($Jumlah_LPH>=1180)
                    {
                        $Score_LPH = 5;
                    }
                    elseif($Jumlah_LPH>=980)
                    {
                        $Score_LPH = 4;
                    }
                    elseif($Jumlah_LPH>=780)
                    {
                        $Score_LPH = 3;
                    }
                    elseif($Jumlah_LPH>=580)
                    {
                        $Score_LPH = 2;
                    }
                    elseif($Jumlah_LPH>=380)
                    {
                        $Score_LPH = 1;
                    }
                    else
                    {
                        $Score_LPH = 0;
                    }
                    $Score_LPH = $Score_LPH * 25/100;
                    
                    //echo "Jumlah LPH : ".$Jumlah_LPH."<br>";
                    //echo "Score LPH : ".$Score_LPH."<br>";

                    //Pembayaran Invoice
                    $sql = "SELECT * FROM laporan_harian lh
                                WHERE lh.Jenis_LaporanNID = 6 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                AND lh.IsValid = 1
                                ORDER BY lh.Tanggal, lh.Laporan_HarianNID DESC
                                LIMIT 1";
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    $Jumlah_Invoice = 0;
                    $Score_Invoice = 0;
                    
                    if($num<>0)
                    {
                        //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                        //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                        //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                        //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                        $Tanggal_Invoice = intval(substr($buff_Jumlah['Tanggal'],-2));
                        $Bulan_Invoice = intval(substr($buff_Jumlah['Tanggal'],5,2));
                        //echo "Tanggal Invoice : ".$Tanggal_Invoice."<br>";
                        //echo "Bulan Invoice : ".$Bulan_Invoice."<br>";
                        $Bulan_Aktif = $Bulan_Periode + 1;
                        //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                        if($Bulan_Invoice==$Bulan_Aktif)
                        {
                            //Lewat akhir periode
                            $Score_Invoice = 1;
                        }
                        elseif(intval($Bulan_Periode)==($Bulan_Aktif-1) && $Bulan_Invoice==$Bulan_Periode)
                        {
                            
                            if($Tanggal_Invoice>=22)
                            {
                                $Score_Invoice = 1;
                            }
                            elseif($Tanggal_Invoice>=21)
                            {
                                $Score_Invoice = 2;
                            }
                            if($Tanggal_Invoice>=20)
                            {
                                $Score_Invoice = 3;
                            }
                            if($Tanggal_Invoice>=19)
                            {
                                $Score_Invoice = 4;
                            }
                            else
                            {
                                $Score_Invoice = 5;
                            }
                        }else
                        {
                            $Score_Invoice = 5;
                        }

                        //echo "Score_Invoice Sebelum persentase : ".$Score_Invoice."<br>";
                        $Jumlah_Invoice = $Score_Invoice;
                        $Score_Invoice = $Score_Invoice * 25/100;
                        //echo "Score_Invoice : ".$Score_Invoice."<br>";
                    }
                    else
                    {
                        $Jumlah_Invoice = 0;
                        $Score_Invoice = $Score_Invoice * 25/100;
                    }
                    //echo "Jumlah_Invoice CT : ".$Jumlah_Invoice."<br>";
                    //echo "Score_Invoice : ".$Score_Invoice."<br>";

                    //Ambil data IA
                    if($CabangNID==15 || $CabangNID==16)
                    {
                        $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' AND lh.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                    AND lh.IsValid = 1  AND lh.Cuti=0
                                    GROUP BY lh.Tanggal
                                    ";
                    }
                    else
                    {
                        $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."' AND lh.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                    AND lh.IsValid = 1  AND lh.Cuti=0
                                    GROUP BY lh.Tanggal
                                    ";
                    }
                    
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                    
                    $Jumlah_IA = $num;

                    if($Jumlah_IA>=$Jumlah_Maksimal_Hari_Aktif)
                    {
                        $Score_IA = 5;
                    }
                    elseif($Jumlah_IA>=($Jumlah_Maksimal_Hari_Aktif-1))
                    {
                        $Score_IA = 4;
                    }
                    elseif($Jumlah_IA>=($Jumlah_Maksimal_Hari_Aktif-2))
                    {
                        $Score_IA = 3;
                    }
                    elseif($Jumlah_IA>=($Jumlah_Maksimal_Hari_Aktif-3))
                    {
                        $Score_IA = 2;
                    }
                    elseif($Jumlah_IA>=($Jumlah_Maksimal_Hari_Aktif-4))
                    {
                        $Score_IA = 1;
                    }
                    elseif($Jumlah_IA>=1)
                    {
                        $Score_IA = 1;
                    }
                    else
                    {
                        $Score_IA = 0;
                    }
                    $Score_IA = $Score_IA * 25/100;

                    //echo "Jumlah IA : ".$Jumlah_IA."<br>";
                    //echo "Score IA : ".$Score_IA."<br>";
                    //$Jumlah_Invoice = 0;

                    //Hitung jumlah yang tidak dilaporkan
                    $Jumlah_CT_Denda = 0;
                    $Jumlah_PJ_Denda = 0;

                    if( //$CabangNID==6 || $CabangNID==2 ||      //Bandung 1 (6) dan Bandung 2(2)
                        $CabangNID==41 || $CabangNID==42 ||    //Bekasi 1(41) dan Bekasi 2 (42)
                        $CabangNID==3 || $CabangNID==12 ||     //Cilacap 1(3) dan Cilacap 2 (12)
                        $CabangNID==35 || $CabangNID==36 ||    //Cileungsi 1(36) dan Cileungsi 2(25)
                        $CabangNID==4 || $CabangNID==5 ||      //Jember 1(4) dan Jember 5(5)
                        $CabangNID==15 || $CabangNID==16)      //Sidoarjo 1(15) dan Sidoarjo 2(16)
                    {
                        

                        if($CabangNID==41 || $CabangNID==42 )
                        {
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 41 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 42 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 41 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 42 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            if($Jumlah_CT1 < $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;    
                            }
                            elseif($Jumlah_CT1 > $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                            }
                            if($Score_CT1 < $Score_CT2)
                            {
                                $Score_CT = $Score_CT2;    
                            }
                            elseif($Score_CT1 > $Score_CT2)
                            {
                                $Score_CT = $Score_CT1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 41 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 42 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 41 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 42 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 41 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 42 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                        }
                        elseif($CabangNID==3 || $CabangNID==12)
                        {
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 3 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 12 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 3 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 12 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            if($Jumlah_CT1 < $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;    
                            }
                            elseif($Jumlah_CT1 > $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                            }
                            if($Score_CT1 < $Score_CT2)
                            {
                                $Score_CT = $Score_CT2;    
                            }
                            elseif($Score_CT1 > $Score_CT2)
                            {
                                $Score_CT = $Score_CT1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 3 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 12 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;
                            

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }
                            //echo "Jumlah_LPH_Denda".$Jumlah_LPH_Denda."<br>";
                            //echo "Nilai_Denda_LPH".$Nilai_Denda_LPH."<br>";

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 3 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 12 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 3 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 12 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                        }
                        elseif($CabangNID==35 || $CabangNID==36)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT BRANCH CILEUNGSI 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 35 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT BRANCH CILEUNGSI 2
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 36 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            if($Jumlah_CT1 < $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;    
                            }
                            elseif($Jumlah_CT1 > $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                            }
                            if($Score_CT1 < $Score_CT2)
                            {
                                $Score_CT = $Score_CT2;    
                            }
                            elseif($Score_CT1 > $Score_CT2)
                            {
                                $Score_CT = $Score_CT1;
                            }
                            //echo $Jumlah_CT."<br>";
                            //echo $Score_CT."<br>";
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 35 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 36 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            $Nilai_Denda_LPH = 0;
                            $Jumlah_LPH_Denda = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 35 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            
                            if($CabangNID==35)
                            {
                                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;
                            

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 36 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            if($CabangNID==36)
                            {
                                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            //echo $Nilai_Denda_LPH."<br>";
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 35 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 36 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            //echo $Nilai_Denda_CT."<br>";
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 35 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 36 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                            //echo $Nilai_Denda_PJ."<br>";
                        }
                        elseif($CabangNID==4 || $CabangNID==5)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 4 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 5 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            if($Jumlah_CT1 < $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;    
                            }
                            elseif($Jumlah_CT1 > $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                            }
                            if($Score_CT1 < $Score_CT2)
                            {
                                $Score_CT = $Score_CT2;    
                            }
                            elseif($Score_CT1 > $Score_CT2)
                            {
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 4 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 5 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 0;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            $Nilai_Denda_LPH = 0;
                            $Jumlah_LPH_Denda = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 4 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            
                            if($CabangNID==4)
                            {
                                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 5 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            
                            if($CabangNID==5)
                            {
                                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                                $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            }
                            
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 4 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 5 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 4 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 5 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                        }
                        elseif($CabangNID==15 || $CabangNID==16)
                        {
                            
                            
                            $Jumlah_CT1 = 0;
                            $Jumlah_CT2 = 0;
                            $Score_CT1 = 0;
                            $Score_CT2 = 0;
                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 15 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT1 = $Jumlah_CT;
                            $Score_CT1 = $Score_CT;

                            //Ambil data CT Bandung 1
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = 16 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_CT = 0;
                            $Score_CT = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                                //echo "Bulan CT : ".$Bulan_CT."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_CT==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_CT==1)
                                    {
                                        $Score_CT = 5;
                                    }
                                    elseif($Tanggal_CT==2)
                                    {
                                        $Score_CT = 4;
                                    }
                                    elseif($Tanggal_CT==3)
                                    {
                                        $Score_CT = 3;
                                    }
                                    elseif($Tanggal_CT==4)
                                    {
                                        $Score_CT = 2;
                                    }
                                    elseif($Tanggal_CT==5)
                                    {
                                        $Score_CT = 1;
                                    }
                                    elseif($Tanggal_CT>=6)
                                    {
                                        $Score_CT = 1;
                                    }    
                                }
                                elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_CT>=25)
                                    {
                                        $Score_CT = 5;
                                    }
                                    else
                                    {
                                        $Score_CT = 5;
                                    }
                                }
                                //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                                $Jumlah_CT = $Score_CT;
                                $Score_CT = $Score_CT * 15/100;
                                //echo "Score CT : ".$Score_CT."<br>";
                            }
                            else
                            {
                                $Jumlah_CT = 0;
                                $Score_CT = $Score_CT * 15/100;
                            }
                            //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                            //echo "Score CT : ".$Score_CT."<br>";
                            $Jumlah_CT2 = $Jumlah_CT;
                            $Score_CT2 = $Score_CT;
                            if($Jumlah_CT1< $Jumlah_CT2 || $Score_CT1 < $Score_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;
                                $Score_CT = $Score_CT2;
                            }
                            elseif($Jumlah_CT2< $Jumlah_CT1 || $Score_CT2 < $Score_CT1)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                                $Score_CT = $Score_CT1;
                            }
                            if($Jumlah_CT1 < $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT2;    
                            }
                            elseif($Jumlah_CT1 > $Jumlah_CT2)
                            {
                                $Jumlah_CT = $Jumlah_CT1;
                            }
                            if($Score_CT1 < $Score_CT2)
                            {
                                $Score_CT = $Score_CT2;    
                            }
                            elseif($Score_CT1 > $Score_CT2)
                            {
                                $Score_CT = $Score_CT1;
                            }
                            
                            
                            $Jumlah_PJ1 = 0;
                            $Score_PJ1 = 0;
                            $Jumlah_PJ2 = 0;
                            $Score_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 15 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ1 = $Jumlah_PJ;
                            $Score_PJ1 = $Score_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian lh
                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = 16 AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                        AND lh.IsValid = 1
                                        ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                            $Jumlah_PJ = 0;
                            $Score_PJ = 0;
                            
                            if($num<>0)
                            {
                                //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                                //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                                //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                                $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                                //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                                //echo "Bulan CT : ".$Bulan_PJ."<br>";
                                $Bulan_Aktif = $Bulan_Periode + 1;
                                //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                                if($Bulan_PJ==$Bulan_Aktif)
                                {
                                    //echo $Tanggal_CT;
                                    if($Tanggal_PJ==1)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    elseif($Tanggal_PJ==2)
                                    {
                                        $Score_PJ = 4;
                                    }
                                    elseif($Tanggal_PJ==3)
                                    {
                                        $Score_PJ = 3;
                                    }
                                    elseif($Tanggal_PJ==4)
                                    {
                                        $Score_PJ = 2;
                                    }
                                    elseif($Tanggal_PJ==5)
                                    {
                                        $Score_PJ = 1;
                                    }
                                    elseif($Tanggal_PJ>=6)
                                    {
                                        $Score_PJ = 1;
                                    }    
                                }
                                elseif($Bulan_Periode==($Bulan_Aktif-1))
                                {
                                    
                                    if($Tanggal_PJ>=25)
                                    {
                                        $Score_PJ = 5;
                                    }
                                    else
                                    {
                                        $Score_PJ = 5;
                                    }
                                }
                                
                                //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                                $Jumlah_PJ = $Score_PJ;
                                $Score_PJ = $Score_PJ * 10/100;
                                //echo "Score PJ : ".$Score_PJ."<br>";
                            }
                            else
                            {
                                
                                $Jumlah_PJ = 0;
                                $Score_PJ = $Score_PJ * 10/100;
                                
                            }
                            $Jumlah_PJ2 = $Jumlah_PJ;
                            $Score_PJ2 = $Score_PJ;

                            if($Jumlah_PJ1< $Jumlah_PJ2 || $Score_PJ1 < $Score_PJ2)
                            {
                                $Jumlah_PJ = $Jumlah_PJ2;
                                $Score_PJ = $Score_PJ2;
                            }
                            elseif($Jumlah_PJ2< $Jumlah_PJ1 || $Score_PJ2 < $Score_PJ1)
                            {
                                $Jumlah_PJ = $Jumlah_PJ1;
                                $Score_PJ = $Score_PJ1;
                            }
                            
                            $Nilai_Denda_LPH1 = 0;
                            $Nilai_Denda_LPH2 = 0;
                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 15 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH1 = $Nilai_Denda_LPH;

                            //Ambil data LPH
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = 16 AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                            $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                            $Nilai_Denda_LPH2 = $Nilai_Denda_LPH;

                            if($Nilai_Denda_LPH2<$Nilai_Denda_LPH1)
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH1;
                            }
                            else
                            {
                                //$Nilai_Denda_LPH = $Nilai_Denda_LPH2;
                            }

                            
                            

                            $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                            
                            $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                            $Nilai_Denda_CT1 = 0;
                            $Nilai_Denda_CT2 = 0;
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 15 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT1 = $Nilai_Denda_CT;
                            
                            //Ambil data CT
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = 16 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_CT_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_CT_Denda = 0;
                            }
                            $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                            $Nilai_Denda_CT2 = $Nilai_Denda_CT;

                            if($Nilai_Denda_CT1 < $Nilai_Denda_CT2)
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT2;
                            }
                            else
                            {
                                $Nilai_Denda_CT = $Nilai_Denda_CT1;
                            }
                            
                            $Nilai_Denda_PJ1 = 0;
                            $Nilai_Denda_PJ2 = 0;
                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 15 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ1 = $Nilai_Denda_PJ;

                            //Ambil data PJ
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = 16 AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal
                                        LIMIT 1";
                            //echo $sql.";<br>";
                            $qry_Jumlah = mysqli_query($Connection, $sql);
                            $num = mysqli_num_rows($qry_Jumlah);
                            if($num===0)
                            {
                                $Jumlah_PJ_Denda = 1;
                            }
                            else
                            {
                                $Jumlah_PJ_Denda = 0;
                            }
                            $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                            $Nilai_Denda_PJ2 = $Nilai_Denda_PJ;

                            if($Nilai_Denda_PJ1 < $Nilai_Denda_PJ2)
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ1;
                            }
                            else
                            {
                                $Nilai_Denda_PJ = $Nilai_Denda_PJ2;
                            }
                        }
                        
                    }
                    else
                    {
                        //Ambil data CT
                        $sql = "SELECT * FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                    AND lh.IsValid = 1
                                    ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                        $Jumlah_CT = 0;
                        $Score_CT = 0;
                        
                        if($num<>0)
                        {
                            //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                            //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                            //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                            //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                            $Tanggal_CT = intval(substr($buff_Jumlah['Tanggal'],-2));
                            $Bulan_CT = intval(substr($buff_Jumlah['Tanggal'],5,2));
                            //echo "Tanggal CT : ".$Tanggal_CT."<br>";
                            //echo "Bulan CT : ".$Bulan_CT."<br>";
                            $Bulan_Aktif = $Bulan_Periode + 1;
                            //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                            if($Bulan_CT==$Bulan_Aktif)
                            {
                                //echo $Tanggal_CT;
                                if($Tanggal_CT==1)
                                {
                                    $Score_CT = 5;
                                }
                                elseif($Tanggal_CT==2)
                                {
                                    $Score_CT = 4;
                                }
                                elseif($Tanggal_CT==3)
                                {
                                    $Score_CT = 3;
                                }
                                elseif($Tanggal_CT==4)
                                {
                                    $Score_CT = 2;
                                }
                                elseif($Tanggal_CT==5)
                                {
                                    $Score_CT = 1;
                                }
                                elseif($Tanggal_CT>=6)
                                {
                                    $Score_CT = 1;
                                }    
                            }
                            elseif(intval($Bulan_Periode)==($Bulan_Aktif-1))
                            {
                                
                                if($Tanggal_CT>=25)
                                {
                                    $Score_CT = 5;
                                }
                                else
                                {
                                    $Score_CT = 5;
                                }
                            }
                            
                            

                            //echo "Score CT Sebelum persentase : ".$Score_CT."<br>";
                            $Jumlah_CT = $Score_CT;
                            $Score_CT = $Score_CT * 15/100;
                            //echo "Score CT : ".$Score_CT."<br>";
                        }
                        else
                        {
                            $Jumlah_CT = 0;
                            $Score_CT = $Score_CT * 15/100;
                        }
                        //echo "Jumlah CT : ".$Jumlah_CT."<br>";
                        //echo "Score CT : ".$Score_CT."<br>";

                        //Ambil data PJ
                        $sql = "SELECT * FROM laporan_harian lh
                                    WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = '".$CabangNID."' AND lh.Periode = '".$Tahun_Periode."-".substr("0".$Bulan_Periode,-2)."'
                                    AND lh.IsValid = 1
                                    ORDER BY lh.Tanggal DESC, lh.Laporan_HarianNID DESC
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                        $Jumlah_PJ = 0;
                        $Score_PJ = 0;
                        
                        if($num<>0)
                        {
                            //echo "Tahun Periode : ".$Tahun_Periode."<br>";
                            //echo "Bulan Periode : ".$Bulan_Periode."<br>";
                            //echo "Tahun Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                            //echo "Bulan Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                            $Tanggal_PJ = intval(substr($buff_Jumlah['Tanggal'],-2));
                            $Bulan_PJ = intval(substr($buff_Jumlah['Tanggal'],5,2));
                            //echo "Tanggal CT : ".$Tanggal_PJ."<br>";
                            //echo "Bulan CT : ".$Bulan_PJ."<br>";
                            $Bulan_Aktif = $Bulan_Periode + 1;
                            //echo "Bulan Aktif : ".$Bulan_Aktif."<br>";
                            if($Bulan_PJ==$Bulan_Aktif)
                            {
                                //echo $Tanggal_CT;
                                if($Tanggal_PJ==1)
                                {
                                    $Score_PJ = 5;
                                }
                                elseif($Tanggal_PJ==2)
                                {
                                    $Score_PJ = 4;
                                }
                                elseif($Tanggal_PJ==3)
                                {
                                    $Score_PJ = 3;
                                }
                                elseif($Tanggal_PJ==4)
                                {
                                    $Score_PJ = 2;
                                }
                                elseif($Tanggal_PJ==5)
                                {
                                    $Score_PJ = 1;
                                }
                                elseif($Tanggal_PJ>=6)
                                {
                                    $Score_PJ = 1;
                                }    
                            }
                            elseif($Bulan_Periode==($Bulan_Aktif-1))
                            {
                                
                                if($Tanggal_PJ>=25)
                                {
                                    $Score_PJ = 5;
                                }
                                else
                                {
                                    $Score_PJ = 5;
                                }
                            }
                            
                            //echo "Score CT Sebelum persentase : ".$Score_PJ."<br>";
                            $Jumlah_PJ = $Score_PJ;
                            $Score_PJ = $Score_PJ * 10/100;
                            //echo "Score PJ : ".$Score_PJ."<br>";
                        }
                        else
                        {
                            
                            $Jumlah_PJ = 0;
                            $Score_PJ = $Score_PJ * 10/100;
                            
                        }
                        

                        

                        //echo "Jumlah IA : ".$Jumlah_IA."<br>";
                        //echo "Score IA : ".$Score_IA."<br>";
                        //$Jumlah_Invoice = 0;

                        //Hitung jumlah yang tidak dilaporkan
                        $Jumlah_CT_Denda = 0;
                        $Jumlah_PJ_Denda = 0;
                        
                        
                        //Ambil data LPH
                        if($CabangNID==15 || $CabangNID == 16)
                        {
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                        }
                        else
                        {
                            $sql = "SELECT * FROM laporan_harian l 
                                        WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                        AND l.IsValid = 1
                                        GROUP BY l.Tanggal";
                        }
                        
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        

                        $num = mysqli_num_rows($qry_Jumlah);
                        $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;
                        $Nilai_Denda_LPH = $Jumlah_LPH_Denda * 5000;
                        //echo $Jumlah_LPH_Denda."<br>";
                        if($Jumlah_LPH_Denda>0 || $Nama_Cabang = 'BRANCH LOMBOK')
                        {
                            $Temp = "";
                            while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                            {
                                $Temp = $Temp.$buff_Jumlah['Tanggal'].", <br>";
                            }
                            //echo $Temp."<br>";
                        }
                        //echo "Jumlah_LPH_Denda : ".$Jumlah_LPH_Denda."<br>";
                        //echo "Nilai_Denda_LPH : ".$Nilai_Denda_LPH."<br>";

                        $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                        
                        $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                        
                        //Ambil data CT
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        if($num===0)
                        {
                            $Jumlah_CT_Denda = 1;
                        }
                        else
                        {
                            $Jumlah_CT_Denda = 0;
                        }
                        $Nilai_Denda_CT = $Jumlah_CT_Denda * 25000;
                        
                        
                        //Ambil data PJ
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal
                                    LIMIT 1";
                        //echo $sql.";<br>";
                        $qry_Jumlah = mysqli_query($Connection, $sql);
                        $num = mysqli_num_rows($qry_Jumlah);
                        if($num===0)
                        {
                            $Jumlah_PJ_Denda = 1;
                        }
                        else
                        {
                            $Jumlah_PJ_Denda = 0;
                        }
                        $Nilai_Denda_PJ = $Jumlah_PJ_Denda * 10000;
                    }
                    //Ambil data IA
                    if($CabangNID==15 || $CabangNID == 16)
                    {
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk_Sidoarjo.")
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal";
                    }
                    else
                    {
                        $sql = "SELECT * FROM laporan_harian l 
                                    WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                                    AND l.IsValid = 1
                                    GROUP BY l.Tanggal";
                    }
                    
                    //echo $sql.";<br>";
                    $qry_Jumlah = mysqli_query($Connection, $sql);
                    $num = mysqli_num_rows($qry_Jumlah);
                    $Jumlah_IA_Denda = $Jumlah_Tanggal_Masuk - $num;
                    $Nilai_Denda_IA = $Jumlah_IA_Denda * 5000;
                    if($Jumlah_IA_Denda>0)
                        {
                            $Temp = "";
                            while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                            {
                                $Temp = $Temp.$buff_Jumlah['Tanggal'].", <br>";
                            }
                            //echo $Temp."<br>";
                        }
                    
                    
                    $Total_Potongan = $Nilai_Denda_LPH + $Nilai_Denda_CT + $Nilai_Denda_IA + $Nilai_Denda_PJ;
                    $Total_Score_KPI = $Score_LPH + $Score_CT + $Score_PJ + $Score_IA + $Score_Invoice;
                    //Proses menulis ke database sementara
                    $sql = "INSERT INTO temp_rekap (CabangNID, Hasil_LPH, Nilai_LPH, Hasil_CL, Nilai_CL, Hasil_PJ, Nilai_PJ, Hasil_IA, Nilai_IA, Hasil_Invoice, Nilai_Invoice,
                                                    Jumlah_Denda_LPH, Nilai_Denda_LPH, Jumlah_Denda_CL, Nilai_Denda_CL, Jumlah_Denda_PJ, Nilai_Denda_PJ, Jumlah_Denda_IA, Nilai_Denda_IA,
                                                    Total_Score_KPI, Total_Potongan, Creator) VALUES
                                                    ('$CabangNID', '$Jumlah_LPH','$Score_LPH', '$Jumlah_CT', '$Score_CT', '$Jumlah_PJ', '$Score_PJ', '$Jumlah_IA', '$Score_IA', '$Jumlah_Invoice', '$Score_Invoice',
                                                    '$Jumlah_LPH_Denda', '$Nilai_Denda_LPH', '$Jumlah_CT_Denda', '$Nilai_Denda_CT', '$Jumlah_PJ_Denda', '$Nilai_Denda_PJ', '$Jumlah_IA_Denda', '$Nilai_Denda_IA', 
                                                    '$Total_Score_KPI', '$Total_Potongan', '$Last_UserNID' )";
                    //echo $sql."<br>";
                    $qry_Simpan_Ke_Temp = mysqli_query($Connection, $sql);
                }
            }//end else skema insentif yang baru
            

            /** Error reporting */
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            date_default_timezone_set('Asia/Jakarta');
            /** PHPExcel_IOFactory */
            //require_once 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';
            //echo date('H:i:s') , " Load from Excel5 template" , EOL;
            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $spreadsheet = new Spreadsheet();

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(false);
            $spreadsheet = $reader->load("../files/Template_Rekap.xlsx");
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../files/Template_Rekap.xlsx");
            $ActiveSheet = 1;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);
            //Nama bulan
            $spreadsheet->getActiveSheet()->setCellValue("A4", $Daftar_Bulan[intval($Bulan_Periode)]." ".$Tahun_Periode);
            //Ambil Insentif
            $Daftar_Insentif = array();
            $sql = "SELECT * FROM daftar_insentif di ;";
            //echo $sql.";<br>";
            $qry_Data = mysqli_query($Connection, $sql);
            $Counter_Data = 1;
            while($buff_Data = mysqli_fetch_array($qry_Data))
            {
                $Daftar_Insentif[$Counter_Data] = $buff_Data['Insentif'];
                $Counter_Data++;
            }
            //Ambil data cabang dan team leader
            if($Periode_Laporan=="202203")
            {
                $sql = "SELECT tr.*, dk.Nama_Lengkap, dk.Nomor_Rekening, dk.NIM, c.Nama_Cabang, c.Jumlah_Anggota FROM temp_rekap tr 
                            INNER JOIN cabang c ON c.CabangNID = tr.CabangNID
                            INNER JOIN data_karyawan dk ON dk.KaryawanNID = c.Team_Leader
                            WHERE tr.Creator = '".$Last_UserNID."' AND c.CabangNID NOT IN (34,44)
                            ORDER BY Total_Score_KPI desc, tr.Hasil_LPH DESC 
                            ;";
            }
            else
            {
                $sql = "SELECT tr.*, dk.Nama_Lengkap, dk.Nomor_Rekening, dk.NIM, c.Nama_Cabang, c.Jumlah_Anggota FROM temp_rekap tr 
                            INNER JOIN cabang c ON c.CabangNID = tr.CabangNID
                            INNER JOIN data_karyawan dk ON dk.KaryawanNID = c.Team_Leader
                            WHERE tr.Creator = '".$Last_UserNID."' AND c.CabangNID NOT IN (34,44)
                            ORDER BY Total_Score_KPI desc, tr.Hasil_LPH DESC 
                            ;";
            }
            
            //echo $sql.";<br>";
            $qry_Data = mysqli_query($Connection, $sql);
            $Jumlah_Data = mysqli_num_rows($qry_Data);
            $Baris = 9;
            $Nomor_Urut = 1;
            $Counter_Data = 1;
            while($buff_Data = mysqli_fetch_array($qry_Data))
            {
                
                $NIM  = $buff_Data['NIM'];
                $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                $Hasil_LPH  = $buff_Data['Hasil_LPH'];
                $Nilai_LPH  = $buff_Data['Nilai_LPH'];
                $Hasil_CL  = $buff_Data['Hasil_CL'];
                $Nilai_CL  = $buff_Data['Nilai_CL'];
                $Hasil_PJ  = $buff_Data['Hasil_PJ'];
                $Nilai_PJ  = $buff_Data['Nilai_PJ'];
                $Hasil_IA  = $buff_Data['Hasil_IA'];
                $Nilai_IA  = $buff_Data['Nilai_IA'];
                $Hasil_Invoice  = $buff_Data['Hasil_Invoice'];
                $Nilai_Invoice  = $buff_Data['Nilai_Invoice'];
                $Jumlah_Anggota = $buff_Data['Jumlah_Anggota'];

                $Jumlah_Denda_LPH  = $buff_Data['Jumlah_Denda_LPH'];
                $Nilai_Denda_LPH  = $buff_Data['Nilai_Denda_LPH'];
                $Jumlah_Denda_CL  = $buff_Data['Jumlah_Denda_CL'];
                $Nilai_Denda_CL  = $buff_Data['Nilai_Denda_CL'];
                $Jumlah_Denda_PJ  = $buff_Data['Jumlah_Denda_PJ'];
                $Nilai_Denda_PJ  = $buff_Data['Nilai_Denda_PJ'];
                $Jumlah_Denda_IA  = $buff_Data['Jumlah_Denda_IA'];
                $Nilai_Denda_IA  = $buff_Data['Nilai_Denda_IA'];
                $Total_Score_KPI  = $buff_Data['Total_Score_KPI'];
                $Total_Potongan  = $buff_Data['Total_Potongan'];
                $Total_Insentif  = $buff_Data['Total_Insentif'];

                $spreadsheet->getActiveSheet()->setCellValue("A".$Baris, $Nomor_Urut);
                $spreadsheet->getActiveSheet()->setCellValue("B".$Baris, $Nama_Cabang);
                $spreadsheet->getActiveSheet()->setCellValue("C".$Baris, $Nama_Lengkap);
                $spreadsheet->getActiveSheet()->setCellValue("D".$Baris, $NIM);
                $spreadsheet->getActiveSheet()->setCellValue("E".$Baris, $Nomor_Rekening);
                $spreadsheet->getActiveSheet()->setCellValue("F".$Baris, $Jumlah_Anggota);
                $spreadsheet->getActiveSheet()->setCellValue("G".$Baris, $Hasil_LPH);
                $spreadsheet->getActiveSheet()->setCellValue("H".$Baris, $Nilai_LPH);
                $spreadsheet->getActiveSheet()->setCellValue("I".$Baris, $Hasil_CL);
                $spreadsheet->getActiveSheet()->setCellValue("J".$Baris, $Nilai_CL);
                $spreadsheet->getActiveSheet()->setCellValue("K".$Baris, $Hasil_PJ);
                $spreadsheet->getActiveSheet()->setCellValue("L".$Baris, $Nilai_PJ);
                $spreadsheet->getActiveSheet()->setCellValue("M".$Baris, $Hasil_IA);
                $spreadsheet->getActiveSheet()->setCellValue("N".$Baris, $Nilai_IA);
                $spreadsheet->getActiveSheet()->setCellValue("O".$Baris, $Hasil_Invoice);
                $spreadsheet->getActiveSheet()->setCellValue("P".$Baris, $Nilai_Invoice);
                $spreadsheet->getActiveSheet()->setCellValue("Q".$Baris, $Total_Score_KPI);
                if($Periode_Laporan=="202203")
                {
                    $spreadsheet->getActiveSheet()->setCellValue("R".$Baris, $Total_Insentif);
                }
                else
                {
                    
                    if($Hasil_LPH==0 || $Hasil_CL==0 || $Hasil_IA==0 || $Hasil_PJ==0)
                    {
                        $Insentif = 0;
                        $spreadsheet->getActiveSheet()->setCellValue("R".$Baris, 0);
                    }
                    else
                    {
                        $Insentif = $Daftar_Insentif[$Nomor_Urut];
                        $spreadsheet->getActiveSheet()->setCellValue("R".$Baris, $Daftar_Insentif[$Nomor_Urut]);
                    }
                    
                    
                    $spreadsheet->getActiveSheet()->setCellValue("S".$Baris, $Jumlah_Denda_LPH);
                    $spreadsheet->getActiveSheet()->setCellValue("T".$Baris, $Nilai_Denda_LPH);
                    $spreadsheet->getActiveSheet()->setCellValue("U".$Baris, $Jumlah_Denda_CL);
                    $spreadsheet->getActiveSheet()->setCellValue("V".$Baris, $Nilai_Denda_CL);
                    $spreadsheet->getActiveSheet()->setCellValue("W".$Baris, $Jumlah_Denda_PJ);
                    $spreadsheet->getActiveSheet()->setCellValue("X".$Baris, $Nilai_Denda_PJ);
                    $spreadsheet->getActiveSheet()->setCellValue("Y".$Baris, $Jumlah_Denda_IA);
                    $spreadsheet->getActiveSheet()->setCellValue("Z".$Baris, $Nilai_Denda_IA);
                    $spreadsheet->getActiveSheet()->setCellValue("AA".$Baris, $Total_Potongan);
                    $spreadsheet->getActiveSheet()->setCellValue("AB".$Baris, $Insentif-$Total_Potongan);
                }
                
                

                

                $Nomor_Urut++;

                $Baris++;
                if($Baris>11 && $Nomor_Urut < $Jumlah_Data)
                {
                    $Baris_Copy = $Baris-1;
                    $Baris_Paste = $Baris;
                    //$spreadsheet->getActiveSheet()->insertNewRowBefore($Baris);
                    for ($c = 'A'; $c != 'AC'; ++$c) 
                    {
                        $cell_from = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Copy);
                        $cell_to = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Paste);
                        $cell_to->setXfIndex($cell_from->getXfIndex()); // black magic here
                        $cell_to->setValue($cell_from->getValue());
                    }
                }
            }

            //Ambil petugas yang melakukan generate rekap
            $sql = "SELECT dk.Nama_Lengkap FROM data_karyawan dk
                        INNER JOIN user_list ul ON ul.Username = dk.NIM
                        WHERE ul.UserNID = '".$Last_UserNID."' 
                        ;";
            
            //echo $sql.";<br>";
            $qry_Data = mysqli_query($Connection, $sql);
            $Jumlah_Data = mysqli_num_rows($qry_Data);
            $Baris = $Baris + 2;
            $buff_Data = mysqli_fetch_array($qry_Data);
            $Nama_Lengkap_User = $buff_Data['Nama_Lengkap'];
            $spreadsheet->getActiveSheet()->setCellValue("A".$Baris, "Generate By ".$Nama_Lengkap_User." ");

            
            $Nama_File = "Rekap_KPI_".$Tahun_Periode."_".$Bulan_Periode;
            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            header('Content-Disposition: attachment;filename="'.$Nama_File.'.xlsx"');
            header('Cache-Control: max-age=0');

            // Write file to the browser
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');


            
        }
        elseif($_GET['Action']=='GenerateNonCS')
        {
            
            
            $Periode_Laporan = $_GET['Periode'];
            $Periode_Laporan = str_replace('&#39;',"'",$Periode_Laporan);
            $Periode_Laporan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Periode_Laporan));
            $Tahun_Periode = substr($Periode_Laporan, 0, 4);
            $Bulan_Periode = substr($Periode_Laporan, -2);
            $Tahun_Sebelumnya = $Tahun_Periode - 1;
            $Tahun_Berikutnya = $Tahun_Periode + 1;
            if($Bulan_Periode==1)
            {
                $Bulan_Sebelumnya = 12;
            }
            else
            {
                $Bulan_Sebelumnya = $Bulan_Periode - 1;
            }
            if($Bulan_Periode==12)
            {
                $Bulan_Berikutnya = 1;
                $Tahun_Berikutnya++;  
            }
            
            else
            {
                $Bulan_Berikutnya = $Bulan_Periode + 1;
                $Tahun_Berikutnya = $Tahun_Periode;
            }
            $Bulan_Berikutnya = substr("0".$Bulan_Berikutnya, -2);

            /** Error reporting */
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            date_default_timezone_set('Asia/Jakarta');
            /** PHPExcel_IOFactory */
            //require_once 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';
            //echo date('H:i:s') , " Load from Excel5 template" , EOL;
            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $spreadsheet = new Spreadsheet();

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(false);
            $spreadsheet = $reader->load("../files/Template_Rekap.xlsx");
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../files/Template_Rekap.xlsx");
            $ActiveSheet = 1;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);

            //Ambil tanggal terakhir untuk bulan yang dipilih

            //echo "Tahun : ".$Tahun_Periode."<br>";
            //echo "Bulan : ".$Bulan_Periode."<br>";
            $a_date = $Tahun_Periode."-".$Bulan_Periode."-01";
            //echo "a_date : ".$a_date."<br>";
            //$Tanggal_Test = date("Y-m-t", strtotime($a_date));
            $Last_Day = date("t", strtotime($a_date));

            $Daftar_Tanggal_Hari_Kerja = array();
            for($Tanggal_Aktif=1; $Tanggal_Aktif<=$Last_Day; $Tanggal_Aktif++)
            {
                //Cek tanggal merah
                $Tanggal_Cek = $Tahun_Periode."-".$Bulan_Periode."-".substr("0".$Tanggal_Aktif, -2);
                $sql = "SELECT * FROM hari_libur h
                            WHERE h.Tanggal = '".$Tanggal_Cek."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry);
                
                //cek hari Minggu
                if(date("D",strtotime(date($Tanggal_Cek)))==="Sun" || $num>0)
                {
                    
                }
                else
                {
                    array_push( $Daftar_Tanggal_Hari_Kerja, $Tanggal_Cek);
                }
                
            }
            $Daftar_Tanggal_Masuk = "";
            $Jumlah_Tanggal_Masuk = 0;
            foreach ($Daftar_Tanggal_Hari_Kerja as $value) 
            {
                $Daftar_Tanggal_Masuk = $Daftar_Tanggal_Masuk ."'".$value."', ";
                $Jumlah_Tanggal_Masuk++;
                
            }

            $Daftar_Tanggal_Masuk = substr(trim($Daftar_Tanggal_Masuk), 0, strlen($Daftar_Tanggal_Masuk)-2);
            //echo $Daftar_Tanggal;

            //Ambil data cabang dan team leader
            $sql = "SELECT * FROM data_karyawan dk 
                        INNER JOIN (SELECT ul.Username FROM user_list ul
                                        INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                        INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                        WHERE uj.Jenis_UserNID = 3) u ON u.Username = dk.NIM
                        INNER JOIN cabang c On c.CabangNID = dk.CabangNID
                        WHERE dk.Aktif = 1 ab
                        ORDER BY trim(dk.Nama_Lengkap);";
            //echo $sql.";<br>";
            $qry_Data = mysqli_query($Connection, $sql);
            $Jumlah_Data = mysqli_num_rows($qry_Data);
            $Baris = 9;
            $Nomor_Urut = 1;
            $Counter_Data = 1;
            while($buff_Data = mysqli_fetch_array($qry_Data))
            {
                $KaryawanNID  = $buff_Data['KaryawanNID'];
                $NIM  = $buff_Data['NIM'];
                $Nomor_Rekening  = $buff_Data['Nomor_Rekening'];
                $Nama_Lengkap  = $buff_Data['Nama_Lengkap'];
                $Nama_Cabang  = $buff_Data['Nama_Cabang'];
                $CabangNID  = $buff_Data['CabangNID'];
                $Jumlah_Anggota  = $buff_Data['Jumlah_Anggota'];

                //Ambil data LPH
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 1 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_LPH = $buff_Jumlah['Jumlah'];

                //Ambil data CT
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 2 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_CT = $buff_Jumlah['Jumlah'];

                //Ambil data PJ
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_PJ = $buff_Jumlah['Jumlah'];

                //Ambil data IA
                $sql = "SELECT count(*) AS Jumlah FROM laporan_harian lh
                            WHERE lh.Jenis_LaporanNID = 3 AND lh.CabangNID = '".$CabangNID."' AND year(lh.Tanggal) = '".$Tahun_Periode."' AND month(lh.Tanggal) = '".$Bulan_Periode."'
                            AND lh.IsValid = 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $buff_Jumlah = mysqli_fetch_array($qry_Jumlah);
                $Jumlah_IA = $buff_Jumlah['Jumlah'];

                $Jumlah_Invoice = 0;

                //Hitung jumlah yang tidak dilaporkan
                $Jumlah_CT_Denda = 0;
                $Jumlah_PJ_Denda = 0;
                
                
                //Ambil data LPH
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 1 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                $Jumlah_LPH_Denda = $Jumlah_Tanggal_Masuk - $num;

                //Ambil data IA
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 3 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal IN (".$Daftar_Tanggal_Masuk.")
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                $Jumlah_IA_Denda = $Jumlah_Tanggal_Masuk - $num;
                

                $Batas_Bawah = $Tahun_Periode."-".$Bulan_Periode."-01";
                
                $Batas_Atas = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07";
                
                //Ambil data CT
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 2 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal
                            LIMIT 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                if($num===0)
                {
                    $Jumlah_CT_Denda = 1;
                }
                else
                {
                    $Jumlah_CT_Denda = 0;
                }
                
                while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                {
                    $Tanggal_Lapor = $buff_Jumlah['Tanggal'];
                    
                    if($Tanggal_Lapor <= $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03")
                    {
                        $Jumlah_CT = 1;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-04")
                    {
                        $Jumlah_CT = 4;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-05")
                    {
                        $Jumlah_CT = 5;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-06")
                    {
                        $Jumlah_CT = 6;
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_CT = 7;
                        
                    }
                    elseif($Tanggal_Lapor > $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_CT = 0;
                        $Jumlah_CT_Denda = 1;
                    }
                }

                //Ambil data PJ
                $sql = "SELECT * FROM laporan_harian l 
                            WHERE l.Jenis_LaporanNID = 5 AND l.CabangNID = '".$CabangNID."' AND l.Tanggal >= '".$Batas_Bawah."' AND l.Tanggal <= '".$Batas_Atas."'
                            AND l.IsValid = 1
                            GROUP BY l.Tanggal
                            LIMIT 1";
                //echo $sql.";<br>";
                $qry_Jumlah = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry_Jumlah);
                if($num===0)
                {
                    $Jumlah_PJ_Denda = 1;
                }
                else
                {
                    $Jumlah_PJ_Denda = 0;
                }
                while($buff_Jumlah = mysqli_fetch_array($qry_Jumlah))
                {
                    $Tanggal_Lapor = $buff_Jumlah['Tanggal'];
                    //$Tanggal_Test = $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03";
                    //echo $Tanggal_Lapor ."<br>";
                    //echo $Tanggal_Test ."<br>";

                    if($Tanggal_Lapor <= $Tahun_Berikutnya."-".$Bulan_Berikutnya."-03")
                    {
                        $Jumlah_PJ = 1;
                        //echo "Sebelum tanggal 3 ".$Jumlah_PJ."<br>";
                        
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-04")
                    {
                        $Jumlah_PJ = 4;
                        //echo "Tanggal 4 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-05")
                    {
                        $Jumlah_PJ = 5;
                        //echo "Tanggal 5 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-06")
                    {
                        $Jumlah_PJ = 6;
                        //echo "Tanggal 6 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor == $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_PJ = 7;
                        //echo "Tanggal 7 ".$Jumlah_PJ."<br>";
                    }
                    elseif($Tanggal_Lapor > $Tahun_Berikutnya."-".$Bulan_Berikutnya."-07")
                    {
                        $Jumlah_PJ = 0;
                        $Jumlah_PJ_Denda = 1;
                    }
                }
                

                $spreadsheet->getActiveSheet()->setCellValue("A".$Baris, $Nomor_Urut);
                $spreadsheet->getActiveSheet()->setCellValue("B".$Baris, $Nama_Cabang);
                $spreadsheet->getActiveSheet()->setCellValue("C".$Baris, $Nama_Lengkap);
                $spreadsheet->getActiveSheet()->setCellValue("D".$Baris, $NIM);
                $spreadsheet->getActiveSheet()->setCellValue("E".$Baris, $Nomor_Rekening);
                $spreadsheet->getActiveSheet()->setCellValue("F".$Baris, $Jumlah_Anggota);
                $spreadsheet->getActiveSheet()->setCellValue("G".$Baris, $Jumlah_LPH);
                $spreadsheet->getActiveSheet()->setCellValue("I".$Baris, $Jumlah_CT);
                $spreadsheet->getActiveSheet()->setCellValue("K".$Baris, $Jumlah_PJ);
                $spreadsheet->getActiveSheet()->setCellValue("M".$Baris, $Jumlah_IA);
                $spreadsheet->getActiveSheet()->setCellValue("O".$Baris, $Jumlah_Invoice);
                $spreadsheet->getActiveSheet()->setCellValue("S".$Baris, $Jumlah_LPH_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("U".$Baris, $Jumlah_CT_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("W".$Baris, $Jumlah_PJ_Denda);
                $spreadsheet->getActiveSheet()->setCellValue("Y".$Baris, $Jumlah_IA_Denda);

                

                $Nomor_Urut++;

                $Baris++;
                if($Baris>11 && $Nomor_Urut < $Jumlah_Data)
                {
                    $Baris_Copy = $Baris-1;
                    $Baris_Paste = $Baris;
                    //$spreadsheet->getActiveSheet()->insertNewRowBefore($Baris);
                    for ($c = 'A'; $c != 'AC'; ++$c) 
                    {
                        $cell_from = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Copy);
                        $cell_to = $spreadsheet->getActiveSheet()->getCell($c.$Baris_Paste);
                        $cell_to->setXfIndex($cell_from->getXfIndex()); // black magic here
                        $cell_to->setValue($cell_from->getValue());
                    }
                }
                
                
            }
            
            $Nama_File = "Rekap_KPI_".$Tahun_Periode."_".$Bulan_Periode;
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$Nama_File.'.xlsx"');
            header('Cache-Control: max-age=0');

            // Write file to the browser
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');


            
        }
        
    }

}

