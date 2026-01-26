<?php
ini_set('session.save_path', '../session');
session_start();
//require_once('assets/vendor/autoload.php');
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Xlsx;

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
                                                <a href="inventori_transaksi.php?Action=Daftar" class="waves-effect"><i class="fa fa-handshake-o"></i><span> Transaksi </span></a>
                                            </li>
                                            <li>
                                                <a href="inventori_kategori.php?Action=Daftar" class="waves-effect"><i class="fa fa-tv"></i><span> Kategori </span></a>
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
                                                <a href="cuti.php?Action=Impor" class="waves-effect"  title="Impor data cuti"><i class="fa fa-cloud-upload"></i><span> Impor </span></a>
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
                                        <h4 class="page-title">Daftar TL Cuti</h4>
                                    </div>
                                </div>
                                <?php
                                if(isset($_GET['Periode']))
                                {
                                    $Periode_Laporan = $_GET['Periode'];
                                    $_SESSION['Periode_Laporan'] = $Periode_Laporan;
                                }
                                else
                                {   
                                    if(!isset($_SESSION['Periode_Laporan']))
                                    {
                                        $_SESSION['Periode_Laporan'] = date('Y-m-d');
                                        $Periode_Laporan = $_SESSION['Periode_Laporan'];
                                    }
                                    else
                                    {
                                        $Periode_Laporan = $_SESSION['Periode_Laporan'];
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
                                        <div>
                                            <a href="#demo" class="" data-toggle="collapse">Filter</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <div class="col-sm-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="inputKelas" class="col-sm-3 ">Bulan</label>
                                                            
                                                            <div class="col-sm-9 input-group date" >
                                                                <?php
                                                                
                                                                if($Hak_Akses==2)
                                                                {
                                                                    $sql = "SELECT * FROM laporan_harian lh 
                                                                                INNER JOIN laporan_jenis lj ON lj.Jenis_LaporanNID = lh.Jenis_LaporanNID
                                                                                WHERE lh.CabangNID = '".$Filter_Cabang."' AND lj.Jenis_Laporan = 'Pembayaran Invoice' 
                                                                                GROUP BY lh.Periode;";
                                                                }
                                                                else
                                                                {
                                                                    $sql = "SELECT * FROM laporan_harian lh 
                                                                                INNER JOIN laporan_jenis lj ON lj.Jenis_LaporanNID = lh.Jenis_LaporanNID
                                                                                WHERE lh.CabangNID = '".$CabangNID."' AND lj.Jenis_Laporan = 'Pembayaran Invoice' 
                                                                                GROUP BY lh.Periode;";
                                                                }
                                                                //echo $Periode_Laporan;
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                ?>
                                                                <select name="Waktu" id="inputWaktu" onchange="CekWaktu()" class="form-control">
                                                                    <?php
                                                                    $Tanggal = $Periode_Laporan;
                                                                    $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                    $Tahun_Text = substr($Tanggal,0,4);
                                                                    $Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                    $Bulan_Aktif_Ada = FALSE;
                                                                    $Tanggal_Aktif = date("Y-m-d");
                                                                    $Text_Item_Aktif = $Daftar_Bulan[intval(substr($Tanggal_Aktif,5,2))]." ".substr($Tanggal_Aktif,0,4);
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

                                                                            if($Current_Text_Item==$Text_Item_Aktif)
                                                                            {
                                                                                $Bulan_Aktif_Ada = TRUE;
                                                                            }
                                                                            
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

                                                                            if($Bulan_Aktif_Ada==FALSE)
                                                                            {
                                                                                if($Text_Item==$Text_Item_Aktif)
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo date("Y-m-d")?>" selected><?php echo $Text_Item_Aktif ?></option>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <option value="<?php echo date("Y-m-d")?>" ><?php echo $Text_Item_Aktif ?></option>
                                                                                    <?php
                                                                                }
                                                                                
                                                                            }
                                                                            
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if($Hak_Akses==2)
                                                    {
                                                    }
                                                    ?>
                                                    
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <?php 
                                                if($Hak_Akses==2)
                                                {
                                                    ?>
                                                    <p><a href="cuti.php?Action=Dokumen_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
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
                                                            <th width=25% rowspan=1 style="text-align:left;vertical-align:middle">Hari, Tanggal</th>
                                                            <th width=25% rowspan=1 style="text-align:left;vertical-align:middle">Cabang</th>
                                                            <!--<th width=25% rowspan=1 style="text-align:left;vertical-align:middle">Periode</th>-->
                                                            <th width=15% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Tahun_Tanggal = substr($Periode_Laporan, 0,4);
                                                        $Bulan_Tanggal = substr($Periode_Laporan, 5,2);
                                                        $Nomor_Urut = 1;
                                                        if($Hak_Akses==2)
                                                        {
                                                            $sql = "SELECT lh.*, c.Nama_Cabang FROM laporan_harian lh 
                                                                        INNER JOIN cabang c ON c.CabangNID = lh.CabangNID 
                                                                        WHERE lh.Jenis_LaporanNID = 1 AND lh.Cuti = 1
                                                                        ORDER BY lh.Tanggal ASC;";
                                                        }
                                                        else
                                                        {
                                                            
                                                        }
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $Laporan_HarianNID = $buff_Data_Siswa['Laporan_HarianNID'];
                                                            $Nama_Cabang = $buff_Data_Siswa['Nama_Cabang'];
                                                            $Tanggal_Report = $buff_Data_Siswa['Tanggal'];
                                                            $Periode = $buff_Data_Siswa['Periode'];
                                                            $Tanggal_Report_Tampilan = strtotime($Tanggal_Report);
                                                            $Hari = date("w", $Tanggal_Report_Tampilan );


                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Daftar_Hari[$Hari].", ".date("d-m-Y", $Tanggal_Report_Tampilan) ?></td>
                                                                <td style="text-align:left"><?php echo $Nama_Cabang ?></td>
                                                                <!--<td style="text-align:left"><?php echo $Periode ?></td>-->
                                                                <td style="text-align:left">
                                                                    <a href="cuti.php?Action=Dokumen_Update&Laporan_HarianNID=<?php echo $Laporan_HarianNID ?>"><i class="ti-pencil" title="Update data"></i></a>
                                                                    <a href="cuti.php?Action=Dokumen_Hapus&Laporan_HarianNID=<?php echo $Laporan_HarianNID ?>" style="color:red;padding-left:10px" title="Hapus data"><i class="ti-trash"></i></a>
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
                            var Periode = document.getElementById("inputWaktu").value;
                            
                            window.location.href="cuti.php?Action=Daftar&Periode="+Periode;
                        }
                        function CekCabang() 
                        {
                            var Cabang = document.getElementById("inputCabang").value;
                            
                            window.location.href="cuti.php?Action=Daftar&Cabang="+Cabang;
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
        elseif($_GET['Action']=='Impor')
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
                                                <a href="inventori_transaksi.php?Action=Daftar" class="waves-effect"><i class="fa fa-handshake-o"></i><span> Transaksi </span></a>
                                            </li>
                                            <li>
                                                <a href="inventori_kategori.php?Action=Daftar" class="waves-effect"><i class="fa fa-tv"></i><span> Kategori </span></a>
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
                                                <a href="cuti.php?Action=Template" class="waves-effect"><i class="fa fa-file-excel-o"></i><span> Download Template </span></a>
                                            </li>
                                            <li>
                                                <a href="cuti.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Impor TL Cuti</h4>
                                    </div>
                                </div>
                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="table-responsive">
                                                            <form method="POST" enctype="multipart/form-data" action="cuti.php">
                                                                <input type="hidden" name="Action" value="Impor">
                                                                <table >
                                                                    <TR>
                                                                        <TD>
                                                                            Silakan Pilih File Excel : <input name="userfile" type="file" multiple="multiple"> 
                                                                        </TD>
                                                                    </TR>
                                                                    <TR>
                                                                        <TD>
                                                                            <input name="Upload_Proses" type="submit" value="import">
                                                                        </TD>
                                                                    </TR>
                                                                </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

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
                            var Periode = document.getElementById("inputWaktu").value;
                            
                            window.location.href="cuti.php?Action=Daftar&Periode="+Periode;
                        }
                        function CekCabang() 
                        {
                            var Cabang = document.getElementById("inputCabang").value;
                            
                            window.location.href="cuti.php?Action=Daftar&Cabang="+Cabang;
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
        elseif($_GET['Action']=='Template')
        {
            //error_reporting(E_ALL);
            //ini_set('display_errors', TRUE);
            //ini_set('display_startup_errors', TRUE);
            //define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            //date_default_timezone_set('Asia/Jakarta');

            //$namafile = $_FILES['userfile']['name'];
            //$tmp = $_FILES['userfile']['tmp_name'];
            //$type = $_FILES['userfile']['type'];
            //$error = $_FILES['userfile']['error'];
            //$size = $_FILES['userfile']['size'];

            //$Bidang_Studi_ID = $_GET['Bidang_Studi_ID'];
            //$Semester = $_GET['Semester'];
            
            
            $target = '../files/Template_Form_Cuti.xlsx';
            
            
            //$excel = new Spreadsheet_Excel_Reader($_FILES['userfile']['name'],false);
            
            /** PHPExcel_IOFactory */
            //require_once 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';
            //echo date('H:i:s') , " Load from Excel5 template" , EOL;
            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //$spreadsheet = new Spreadsheet();
            //$spreadsheet = new \PHPExcel();
            include 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';

            $inputFileName = './sampleData/example1.xls';

            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($target);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $spreadsheet = $objReader->load($target);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($target,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $spreadsheet->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            //$reader->setReadDataOnly(false);
            //$spreadsheet = $reader->load("../files/Template_Rekap.xlsx");
            //$spreadsheet = $reader->load($target);
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../files/Template_Rekap.xlsx");
            $ActiveSheet = 1;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);

            //ambil daftar cabang
            //Ambil default hak akses
            $sql = "SELECT * FROM cabang c
                        ORDER BY c.Nama_Cabang;";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $Baris = 4;
            $Nomor_Urut = 1;
            while($buff = mysqli_fetch_array($qry))
            {
                $Nama_Cabang = $buff['Nama_Cabang'];
                $CabangNID = $buff['CabangNID'];
                $Kode_Cabang = substr('000'.$CabangNID, -3);

                $spreadsheet->getActiveSheet()->setCellValue("A".$Baris, $Nomor_Urut);
                $spreadsheet->getActiveSheet()->setCellValue("B".$Baris, $Nama_Cabang);
                $spreadsheet->getActiveSheet()->setCellValue("C".$Baris, $Kode_Cabang);

                $Baris++;
                $Nomor_Urut++;
            }
            $ActiveSheet = 0;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);
            $Nama_File = "Template_Form_Cuti";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$Nama_File.'.xlsx"');
            header('Cache-Control: max-age=0');

            // Write file to the browser
            //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            //$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
            $writer->save('php://output');

            
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
                                                <a href="cuti.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="cuti.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="cuti.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Pembayaran Invoice <?php echo $Daftar_Hari[$Hari].", ".date("d-m-Y", $Tanggal_Report_Tampilan) ?></h4>
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
                                                    <p><a href="cuti.php?Action=Dokumen_Detail_Tambah&Tanggal=<?php echo $Tanggal_Laporan ?>" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
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
                                                            <th width=20% colspan=1 style="text-align:left;vertical-align:middle">Dokumen</th>
                                                            <th width=20% colspan=1 style="text-align:left;vertical-align:middle">Periode</th>
                                                            <th width=20% colspan=1 style="text-align:left;vertical-align:middle">Tanggal Upload</th>
                                                            <th width=35% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
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
                                                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = ".$Filter_Cabang."
                                                                                AND year(lh.Tanggal) = '".$Tahun_Tanggal."'  AND month(lh.Tanggal) = '".$Bulan_Tanggal."' AND lh.Tanggal = '".$Tanggal_Laporan."'
                                                                        ";
                                                        }
                                                        else
                                                        {
                                                            $sql = "SELECT lh.* FROM laporan_harian lh
                                                                        WHERE lh.Jenis_LaporanNID = 5 AND lh.CabangNID = ".$CabangNID."
                                                                                AND year(lh.Tanggal) = '".$Tahun_Tanggal."'  AND month(lh.Tanggal) = '".$Bulan_Tanggal."' AND lh.Tanggal = '".$Tanggal_Laporan."'
                                                                        ";
                                                        }
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $Laporan_HarianNID = $buff_Data_Siswa['Laporan_HarianNID'];
                                                            $Keterangan = $buff_Data_Siswa['Keterangan'];
                                                            $Image_Before = $buff_Data_Siswa['Image_Before'];
                                                            $Image_After = $buff_Data_Siswa['Image_After'];
                                                            $Periode = $buff_Data_Siswa['Periode'];
                                                            $IsValid = $buff_Data_Siswa['IsValid'];
                                                            $Tanggal_Report = $buff_Data_Siswa['Tanggal'];
                                                            $Tanggal_Report_Tampilan = strtotime($Tanggal_Report);
                                                            $Hari = date("w", $Tanggal_Report_Tampilan );

                                                            $Before = $Default_Dokumen_Dir."/".$Image_Before;
                                                            $After = $Default_Dokumen_Dir."/".$Image_After;
                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><a href="<?php echo ($Image_Before=="")?"":$Before ?>" target="_blank">View</a></td>
                                                                <td style="text-align:right"><?php echo $Periode ?></td>
                                                                <td style="text-align:right"><?php echo $Tanggal_Report ?></td>
                                                                <?php
                                                                if($Hak_Akses==2)
                                                                {
                                                                    ?>
                                                                    <td style="text-align:center">
                                                                        <a href="cuti.php?Action=Dokumen_Valid&Laporan_HarianNID=<?php echo $Laporan_HarianNID ?>"><i class="fa <?php echo ($IsValid==1)?"fa-check":"fa-times" ?>"></i></a>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <td style="text-align:center">
                                                                        <a href="cuti.php?Action=Dokumen_Detail_Update&Laporan_HarianNID=<?php echo $Laporan_HarianNID ?>"><i class="fa fa-pencil"></i></a>
                                                                        <a href="cuti.php?Action=Dokumen_Detail_Hapus&Laporan_HarianNID=<?php echo $Laporan_HarianNID ?>" title="Hapus laporan"><i class="fa fa-trash"></i></a>
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

                            <footer class="footer">
                                <!--Powered By Palmarius-->
                            </footer>

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
                            
                            window.location.href="cuti.php?Action=Daftar&Tanggal="+Tanggal;
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
        elseif($_GET['Action']=='Dokumen_Valid')
        {
            $Laporan_HarianNID = $_GET['Laporan_HarianNID'];
            $Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
            $Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));

            $sql = "SELECT * FROM laporan_harian sp
                        WHERE sp.Laporan_HarianNID = '".$Laporan_HarianNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $IsValid = $buff['IsValid'];
            if($IsValid==0)
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 1
                            WHERE sp.Laporan_HarianNID = '".$Laporan_HarianNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 0
                            WHERE sp.Laporan_HarianNID = '".$Laporan_HarianNID."'
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
        elseif($_GET['Action']=='Dokumen_Detail_Hapus')
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
                $Laporan_HarianNID = $_GET['Laporan_HarianNID'];
                $Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
                $Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));
                

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM laporan_harian sp
                            WHERE sp.Laporan_HarianNID = '".$Laporan_HarianNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Tanggal = $buff['Tanggal'];
                $Tanggal_Laporan = $buff['Tanggal'];
                $Periode_Laporan = $buff['Periode'];
                $Image_Before = $buff['Image_Before'];
                $Image_After = $buff['Image_After'];
                $Tanggal_Pembelian = $buff['Tanggal'];
                $Tanggal_Pembelian = substr($Tanggal_Pembelian, -2)."-".substr($Tanggal_Pembelian, 5, 2)."-".substr($Tanggal_Pembelian, 0,4);
                $Keterangan = $buff['Keterangan'];
                $Before = $Default_Dokumen_Dir."/".$Image_Before;
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
                                INNER JOIN user_list ul ON ul.Username = dk.NIM
                                WHERE ul.UserNID = '".$Creator."'
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
                                INNER JOIN user_list ul ON ul.Username = dk.NIM
                                WHERE ul.UserNID = '".$Last_Akses_User."'
                                ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $buff = mysqli_fetch_array($qry);
                    $Last_Akses_User = $buff['Last_User'];
                }
            }


            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'cuti.php?Action=Daftar';
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
                                            <a href="cuti.php?Action=Detail_Laporan&Tanggal=<?php echo $Tanggal_Laporan ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Hapus Laporan</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="cuti.php" method="post" enctype="multipart/form-data">
                                                    <input id='Dokumen_Detail_Hapus' type="hidden" name="Action" value="Dokumen_Detail_Hapus">
                                                    <input id='Laporan_HarianNID' type="hidden" name="Laporan_HarianNID" value="<?php echo $Laporan_HarianNID ?>">

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputKelas" class="col-sm-3 ">Periode</label>
                                                            
                                                            <div class="col-sm-9 input-group date" >
                                                                <?php
                                                                
                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Periode_Laporan,-2))];
                                                                $Tahun_Text = substr($Tanggal,0,4);
                                                                $Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                echo $Text_Item;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">File</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <img src="<?php echo $Before ?>" alt="" style="width: 100%;height: auto;">
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
                                                                Last User : <?php echo $Last_Akses_User ?>
                                                            </div>
                                                            <div class="col-sm-6 col-lg-6" >
                                                                Last Update : <?php echo $Last_Update ?>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    
                                                    <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info" name="submit"> Hapus</button>
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
        elseif($_GET['Action']=='Dokumen_Update' || $_GET['Action']=='Dokumen_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Dokumen_Tambah")
            {

                $Nama = "";
                $Keterangan = "";
                $KategoriNID = "";
                $Kondisi_Barang = "";
                $Keadaan_Barang = "";
                $Tanggal_Pembelian = date("d-m-Y");

                $Lampiran = "";

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
                $Tanggal_Laporan = "";
            }
            else
            {
                $Laporan_HarianNID = $_GET['Laporan_HarianNID'];
                $Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
                $Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM laporan_harian sp
                            WHERE sp.Laporan_HarianNID = '".$Laporan_HarianNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Periode = $buff['Periode'];
                $Tanggal = $buff['Tanggal'];
                $Tanggal_Laporan = $buff['Tanggal'];
                $Tanggal_Laporan = substr($Tanggal_Laporan, -2)."-".substr($Tanggal_Laporan, 5, 2)."-".substr($Tanggal_Laporan, 0,4);
                
                $Create_Date = $buff['Create_Date'];
                $Last_Update = $buff['Last_Update'];

                $Creator = $buff['Creator'];
                $Last_User = $buff['Last_User'];
                
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
                                INNER JOIN user_list ul ON ul.Username = dk.NIM
                                WHERE ul.UserNID = '".$Creator."'
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
                                INNER JOIN user_list ul ON ul.Username = dk.NIM
                                WHERE ul.UserNID = '".$Last_User."'
                                ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $buff = mysqli_fetch_array($qry);
                    $Last_User = $buff['Last_User'];
                }
            }


            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'cuti.php?Action=Daftar';
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
                                            <a href="cuti.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Data Invoice </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="cuti.php" method="post" enctype="multipart/form-data">
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
                                                        <input id='Laporan_HarianNID' type="hidden" name="Laporan_HarianNID" value="<?php echo $Laporan_HarianNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <!--<div class="form-group">
                                                            <label for="inputKelas" class="col-sm-3 ">Periode</label>
                                                            
                                                            <div class="col-sm-9 input-group date" >
                                                                <?php
                                                                

                                                                
                                                                //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                $Tanggal = $Tanggal_Laporan;
                                                                $Tanggal = date('Y-m-d');
                                                                $Tanggal_Berjalan = date('Y-m-d');
                                                                $Bulan_Berjalan = intval(date("m"));
                                                                $Tahun_Berjalan = intval(date("Y"));
                                                                //echo "Bulan berjalan : ".$Bulan_Berjalan."<br>";
                                                                //echo "Tahun berjalan : ".$Tahun_Berjalan."<br>";
                                                                if($Bulan_Berjalan==1)
                                                                {
                                                                    $Tahun_Sebelumnya = $Tahun_Berjalan - 1;
                                                                    $Bulan_Sebelumnya = 12;
                                                                }
                                                                else
                                                                {
                                                                    $Tahun_Sebelumnya = $Tahun_Berjalan;
                                                                    $Bulan_Sebelumnya = $Bulan_Berjalan - 1;
                                                                }
                                                                $Bulan_Text_Sebelumnya = $Daftar_Bulan[$Bulan_Sebelumnya];
                                                                $Text_Item_Sebelumnya = $Bulan_Text_Sebelumnya." ".$Tahun_Sebelumnya;
                                                                $Waktu_Sebelumnya = $Tahun_Sebelumnya."-".substr("0".$Bulan_Sebelumnya,-2);
                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                $Tahun_Text = substr($Tanggal,0,4);
                                                                //echo $Text_Item_Sebelumnya."<br>";
                                                                $Text_Item_Bulan_Berjalan = $Daftar_Bulan[$Bulan_Berjalan]." ".$Tahun_Text;
                                                                //$Text_Item = date("Y")." ".date("m");
                                                                //echo $Text_Item;
                                                                $sql = "SELECT * FROM laporan_harian lh 
                                                                            INNER JOIN laporan_jenis lj ON lj.Jenis_LaporanNID = lh.Jenis_LaporanNID
                                                                            WHERE lj.Jenis_Laporan = 'Pembayaran Invoice' AND lh.Periode <> '".$Tahun_Berjalan."-".date("m")."'
                                                                            GROUP BY lh.Periode
                                                                            ";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                ?>
                                                                <select name="Periode" id="inputPeriode"  class="form-control">
                                                                    
                                                                    <option value="<?php echo $Waktu_Sebelumnya?>" ><?php echo $Text_Item_Sebelumnya ?></option>
                                                                    <?php
                                                                    
                                                                    if($num==0)
                                                                    {
                                                                        $Waktu = $Tahun_Berjalan."-".date("m");
                                                                        ?>
                                                                        <option value="<?php echo $Waktu?>" selected><?php echo $Text_Item_Bulan_Berjalan ?></option>
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
                                                                            $Waktu = $Tahun_Text."-".substr($Tanggal,5,2);
                                                                            
                                                                            if($Current_Text_Item==$Text_Item_Bulan_Berjalan)
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $Waktu?>" selected><?php echo $Current_Text_Item ?></option>
                                                                                <?php
                                                                            }
                                                                            elseif($Current_Text_Item==$Text_Item_Sebelumnya)
                                                                            {

                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $Waktu?>"><?php echo $Current_Text_Item ?></option>
                                                                                <?php
                                                                            }
                                                                            
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>-->
                                                        <div class="form-group">
                                                            <label for="inputCabang" class="col-sm-3 ">Cabang</label>
                                                                
                                                                <div class="col-sm-9 input-group date" >
                                                                    <?php
                                                                    

                                                                    $sql = "SELECT c.CabangNID, c.Nama_Cabang, d.Nama_Lengkap FROM cabang c 
                                                                                INNER JOIN data_karyawan d ON d.KaryawanNID = c.Team_Leader
                                                                                INNER JOIN data_karyawan dk ON dk.CabangNID = c.CabangNID
                                                                                GROUP By c.Nama_Cabang, d.KaryawanNID
                                                                                ";
                                                                    //echo $sql.";<br>";
                                                                    //echo "Cabang : ".$Filter_Cabang."<br>";
                                                                    $qry = mysqli_query($Connection, $sql);
                                                                    $num = mysqli_num_rows($qry);
                                                                    //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                    ?>
                                                                    <select name="cabang" id="inputCabang" onchange="CekCabang()" class="form-control">
                                                                        <?php
                                                                        while ($buff = mysqli_fetch_array($qry)) 
                                                                        {
                                                                            $Current_CabangNID = $buff['CabangNID'];
                                                                            $Nama_Cabang = $buff['Nama_Cabang'];
                                                                            $Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                            ?>
                                                                            <option value="<?php echo $Current_CabangNID?>"  ><?php echo $Nama_Cabang." (".$Nama_Lengkap.")" ?></option>
                                                                            <?php
                                                                        }
                                                                        
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-3 ">Tanggal</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="inputTanggalAwal" name="Tanggal_Awal" value="<?php echo $Tanggal_Laporan ?>">
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
        }
        elseif($_GET['Action']=='Dokumen_Hapus')
        {
            
            $Laporan_HarianNID = $_GET['Laporan_HarianNID'];
            $Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
            $Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));

            $sql = "DELETE FROM laporan_harian
                        WHERE Laporan_HarianNID = '".$Laporan_HarianNID."'
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

                //$Periode  = $_POST['Periode'];
                //$Periode  = str_replace('&#39;',"'",$Periode );
                //$Periode  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Periode ));
                
                $Tanggal  = $_POST['Tanggal_Awal'];
                $Tanggal  = str_replace('&#39;',"'",$Tanggal );
                $Tanggal  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal ));
                $Tanggal = substr($Tanggal, -4)."-".substr($Tanggal, 3,2)."-".substr($Tanggal, 0,2);

                $CabangNID  = $_POST['cabang'];
                $CabangNID  = str_replace('&#39;',"'",$CabangNID );
                $CabangNID  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID ));

                $Keterangan = "";

                
                $Waktu_Upload = date("Ymdghis");
                if($_POST['Action']=='Dokumen_Siswa_Update')
                {
                    $Jenis_LaporanNID = 1; //LPH

                    $Laporan_HarianNID = $_POST['Laporan_HarianNID'];
                    $Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
                    $Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));

                    $sql = "UPDATE laporan_harian sp SET
                                    sp.Tanggal = '".$Tanggal."', 
                                    sp.CabangNID = '".$CabangNID."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Tanggal = '".$Tanggal."' AND sp.Jenis_LaporanNID=1 ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);

                    $Jenis_LaporanNID = 3; //FIA
                    $sql = "UPDATE laporan_harian sp SET
                                    sp.Tanggal = '".$Tanggal."', 
                                    sp.CabangNID = '".$CabangNID."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Tanggal = '".$Tanggal."' AND sp.Jenis_LaporanNID=3 ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    
                }
                elseif($_POST['Action']=='Dokumen_Siswa_Tambah')
                {
                    //Simpan data ke database
                    $Jenis_LaporanNID = 1; //LPH
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO laporan_harian(CabangNID, Jenis_LaporanNID, Tanggal, Cuti, Creator, Create_Date, Last_User) VALUES 
                                ('$CabangNID', '$Jenis_LaporanNID', '$Tanggal', 1, '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Laporan_HarianNID = mysqli_insert_id($Connection);

                    $Jenis_LaporanNID = 3; //FIA
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO laporan_harian(CabangNID, Jenis_LaporanNID, Tanggal, Cuti, Creator, Create_Date, Last_User) VALUES 
                                ('$CabangNID', '$Jenis_LaporanNID', '$Tanggal', 1, '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Laporan_HarianNID = mysqli_insert_id($Connection);
                }
            }
            
            ?>
                <script>
                    window.location.href="cuti.php?Action=Daftar";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Impor')
        {
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);
            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            date_default_timezone_set('Asia/Jakarta');

            $namafile = $_FILES['userfile']['name'];
            $tmp = $_FILES['userfile']['tmp_name'];
            $type = $_FILES['userfile']['type'];
            $error = $_FILES['userfile']['error'];
            $size = $_FILES['userfile']['size'];

            //$Bidang_Studi_ID = $_GET['Bidang_Studi_ID'];
            //$Semester = $_GET['Semester'];
            
            
            $target = basename($_FILES['userfile']['name']) ;
            move_uploaded_file($_FILES['userfile']['tmp_name'], $target);
            
            //$excel = new Spreadsheet_Excel_Reader($_FILES['userfile']['name'],false);
            
            /** PHPExcel_IOFactory */
            //require_once 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';
            //echo date('H:i:s') , " Load from Excel5 template" , EOL;
            //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //$spreadsheet = new Spreadsheet();
            //$spreadsheet = new \PHPExcel();
            include 'assets/plugins/PHPExcel-1.8/PHPExcel/IOFactory.php';

            $inputFileName = './sampleData/example1.xls';

            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($target);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $spreadsheet = $objReader->load($target);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($target,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $spreadsheet->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            //$reader->setReadDataOnly(false);
            //$spreadsheet = $reader->load("../files/Template_Rekap.xlsx");
            //$spreadsheet = $reader->load($target);
            //$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("../files/Template_Rekap.xlsx");
            $ActiveSheet = 0;
            //$spreadsheet = $objReader->load("../files/Template_Rekap.xlsx");
            $spreadsheet->setActiveSheetIndex ($ActiveSheet);

            /* Hitung banyak sheet */
            //$nr_sheets = count($spreadsheet->sheets);
            $Baris = 5;

            $Cek = $spreadsheet->getActiveSheet()->getCell("A".$Baris)<>"" && $spreadsheet->getActiveSheet()->getCell("B".$Baris)<>"" && $spreadsheet->getActiveSheet()->getCell("C".$Baris)<>"";
            while($Cek)
            {
                $Nomor = $spreadsheet->getActiveSheet()->getCell("A".$Baris);
                $Nomor  = str_replace('&#39;',"'",$Nomor );
                $Nomor  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nomor ));

                $Kode = $spreadsheet->getActiveSheet()->getCell("B".$Baris);
                $Kode  = str_replace('&#39;',"'",$Kode );
                $Kode  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Kode ));
                $CabangNID = intval($Kode);

                $Tanggal = $spreadsheet->getActiveSheet()->getCell("C".$Baris);
                $Tanggal  = str_replace('&#39;',"'",$Tanggal );
                $Tanggal  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal ));
                
                //echo "Tanggal Baca: ".$Tanggal."<br>";
                //$Tanggal = \PHPExcel_Shared_Date::PHPToExcel($Tanggal);
                $Tanggal = \PHPExcel_Shared_Date::ExcelToPHP($Tanggal);
                //echo "Tanggal Php: ".$Tanggal."<br>";
                //echo "Tanggal Php2: ".date('Y-m-d', $Tanggal)."<br>";
                $Tanggal = date('Y-m-d', $Tanggal);
                //$Tanggal = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($Tanggal));
                //$Tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Tanggal);
                //echo "Tanggal : ".$Tanggal."<br>";
                //$pecah = explode('-',$Tanggal);
                //echo $Tanggal_Penilaian;
                //$Tanggal = $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

                $Keterangan = "";

                
                $Waktu_Upload = date("Ymdghis");
                //Cari apakah sudah ada tanggal cuti yang sama untuk cabang yang sama
                $sql =	"SELECT * FROM laporan_harian lh
                            WHERE lh.Tanggal = '".$Tanggal."' AND lh.Jenis_LaporanNID=1 ";
                //LIMIT 1                    
                //echo $sql."<br>";
                $qry = mysqli_query($Connection, $sql);
                $num = mysqli_num_rows($qry);
                if($num==0)
                {
                    //Simpan data ke database
                    $Jenis_LaporanNID = 1; //LPH
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO laporan_harian(CabangNID, Jenis_LaporanNID, Tanggal, Cuti, Creator, Create_Date, Last_User) VALUES 
                                ('$CabangNID', '$Jenis_LaporanNID', '$Tanggal', 1, '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    //$Laporan_HarianNID = mysqli_insert_id($Connection);

                    $Jenis_LaporanNID = 3; //FIA
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO laporan_harian(CabangNID, Jenis_LaporanNID, Tanggal, Cuti, Creator, Create_Date, Last_User) VALUES 
                                ('$CabangNID', '$Jenis_LaporanNID', '$Tanggal', 1, '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    //$Laporan_HarianNID = mysqli_insert_id($Connection);
                }
                else
                {
                    $Jenis_LaporanNID = 1; //LPH

                    //$Laporan_HarianNID = $_POST['Laporan_HarianNID'];
                    //$Laporan_HarianNID = str_replace('&#39;',"'",$Laporan_HarianNID);
                    //$Laporan_HarianNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Laporan_HarianNID));

                    $sql = "UPDATE laporan_harian sp SET
                                    sp.Tanggal = '".$Tanggal."', 
                                    sp.CabangNID = '".$CabangNID."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Tanggal = '".$Tanggal."' AND sp.Jenis_LaporanNID=1 ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);

                    $Jenis_LaporanNID = 3; //FIA
                    $sql = "UPDATE laporan_harian sp SET
                                    sp.Tanggal = '".$Tanggal."', 
                                    sp.CabangNID = '".$CabangNID."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Tanggal = '".$Tanggal."' AND sp.Jenis_LaporanNID=3 ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                }
                

                //echo $Nomor."; ".$Kode."; ".$Tanggal."<br> ";
                $Baris++;
                $Cek = $spreadsheet->getActiveSheet()->getCell("A".$Baris)<>"" && $spreadsheet->getActiveSheet()->getCell("B".$Baris)<>"" && $spreadsheet->getActiveSheet()->getCell("C".$Baris)<>"";
            }
            //$MaxRow = $spreadsheet->sheets[$sheet]['numRows'];
            
            ?>
            <script>
                window.history.go(-2);
            </script>
            <?php


        }
        elseif($_POST['Action']=='Dokumen_Detail_Hapus')
        {
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

