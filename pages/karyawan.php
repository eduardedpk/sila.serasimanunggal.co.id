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
                                    //$Hak_Akses = 1;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li class="has_sub">
                                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span> Data Karyawan </span><span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                                <ul class="list-unstyled">
                                                    <li><a href="karyawan.php?Action=Tambah_Karyawan"> <i class="mdi mdi-account-plus"></i> Tambah</a></li>
                                                    <!--<li><a href="siswa_impor.php?Action=Impor"><i class="mdi mdi-cloud-download"></i> Impor</a></li>-->
                                                </ul>
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

                                <div class="">
                                    <div class="page-header-title">
                                        <h4 class="page-title">Daftar Karyawan</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <!--<div>
                                            <a href="#demo" class="" data-toggle="collapse">Filter</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="karyawan.php" method="post" enctype="multipart/form-data">
                                                        <input id='Filter_Siswa' type="hidden" name="Action" value="Filter_Siswa">
                                                        <div class="col-sm-6 col-lg-4">
                                                            <div class="form-group">
                                                                <label for="inputAgama" class="col-sm-4 control-label">Agama</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <?php 
                                                                    $sql = "SELECT DISTINCT ds.Agama FROM data_siswa ds
                                                                                ORDER BY ds.Agama ";
                                                                    //echo $sql.";<br>";
                                                                    $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                                    ?>
                                                                    <select name="Filter_Agama" id="inputAgama">
                                                                        <option value="999">Semua</option>
                                                                        <?php
                                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                                        {
                                                                            $Agama = $buff_Data_Siswa['Agama'];
                                                                            if($Agama==$_SESSION['Filter_Agama_Siswa'])
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $Agama ?>" selected><?php echo $Agama ?></option>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $Agama ?>"><?php echo $Agama ?></option>
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
                                                                <label for="inputJenisKelamin" class="col-sm-4 control-label">Jenis Kelamin</label>
                                                                
                                                                <div class="col-sm-8 input-group date" >
                                                                    <?php 
                                                                    $sql = "SELECT lt.LookupInteger, lt.LookupName FROM lookup_table lt
                                                                                WHERE lt.LookupID = 'Jenis_Kelamin' ";
                                                                    //echo $sql.";<br>";
                                                                    $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                                    //echo "Filter ".$_SESSION['Filter_Gender_Siswa']."<br>";
                                                                    ?>
                                                                    <select name="Filter_Jenis_Kelamin" id="inputJenisKelamin">
                                                                        <option value="999">Semua</option>
                                                                        <?php
                                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                                        {
                                                                            $LookupID = $buff_Data_Siswa['LookupInteger'];
                                                                            $LookupName = $buff_Data_Siswa['LookupName'];
                                                                            if($LookupID==$_SESSION['Filter_Gender_Siswa'])
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $LookupID ?>" selected><?php echo $LookupName ?></option>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $LookupID ?>"><?php echo $LookupName ?></option>
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
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>-->
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=15% rowspan=1 style="text-align:center;vertical-align:middle">NIM</th>
                                                            <th width=25% rowspan=1 style="text-align:center;vertical-align:middle">Nama</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">No Rekening</th>
                                                            <th width=25% colspan=1 style="text-align:center;vertical-align:middle">Cabang</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Posisi/th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT dk.*, c.Nama_Cabang, c.Team_Leader FROM data_karyawan dk 
                                                                    INNER JOIN cabang c ON c.CabangNID = dk.CabangNID
                                                                    ORDER BY c.Nama_Cabang, dk.Nama_Lengkap ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $KaryawanNID = $buff_Data_Siswa['KaryawanNID'];
                                                            $NIM = $buff_Data_Siswa['NIM'];
                                                            $Nama_Lengkap = $buff_Data_Siswa['Nama_Lengkap'];
                                                            $Nama_Cabang = $buff_Data_Siswa['Nama_Cabang'];
                                                            $Nomor_Rekening = $buff_Data_Siswa['Nomor_Rekening'];
                                                            $Team_Leader = $buff_Data_Siswa['IsLeader'];
                                                            $Aktif = $buff_Data_Siswa['Aktif'];
                                                            if($Team_Leader==1)
                                                            {
                                                                $Posisi = "Team Leader";
                                                            }
                                                            elseif($Team_Leader==0)
                                                            {
                                                                $Posisi = "Anggota";
                                                            }
                                                            elseif($Team_Leader==2)
                                                            {
                                                                $Posisi = "Staff";
                                                            }

                                                            if($Aktif==1)
                                                            {
                                                                $Status_Siswa = "Aktif";
                                                            }
                                                            else
                                                            {
                                                                $Status_Siswa = "Tidak aktif";
                                                            }

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right;font-size:12px;"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:center;font-size:12px;"><?php echo $NIM ?></td>
                                                                <td style=";font-size:12px;"><?php echo $Nama_Lengkap ?></td>
                                                                <td style="text-align:center;font-size:12px;"><?php echo $Nomor_Rekening ?></td>
                                                                <td style="text-align:left;font-size:12px;"><?php echo $Nama_Cabang ?></td>
                                                                <td style="text-align:center;font-size:12px;"><?php echo $Posisi ?></td>
                                                                <td style="text-align:center;font-size:12px;">
                                                                    <a href="karyawan.php?Action=View&KaryawanNID=<?php echo $KaryawanNID ?>" title="Lihat data siswa"><span ><i class="fa fa-eye"></i></span></a>
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
        elseif($_GET['Action']=='View')
        {
            $KaryawanNID = $_GET['KaryawanNID'];
            $KaryawanNID = str_replace('&#39;',"'",$KaryawanNID);
            $KaryawanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KaryawanNID));            

            //Ambil data siswa
            $sql = "SELECT dk.*, c.Nama_Cabang, c.Team_Leader FROM data_karyawan dk 
                            INNER JOIN cabang c ON c.CabangNID = dk.CabangNID
                            WHERE dk.KaryawanNID = '".$KaryawanNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $Nama_Lengkap_Karyawan = $buff['Nama_Lengkap'];
            $NIM = $buff['NIM'];
            $Nomor_Rekening = $buff['Nomor_Rekening'];
            $Aktif = $buff['Aktif'];
            $CabangNID = $buff['CabangNID'];
            $Nama_Cabang = $buff['Nama_Cabang'];
            
            
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
                            INNER JOIN  user_list ul ON ul.Username = dk.NIM
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
                            INNER JOIN  user_list ul ON ul.Username = dk.NIM
                            WHERE ul.UserNID = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Last_User = $buff['Last_User'];
            }
            
            
            

            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'karyawan.php?Action=Daftar';
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
                                    //$Hak_Akses = 1;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karir_karyawan.php?Action=Daftar&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="fa  fa-odnoklassniki"></i><span> Jenjang Karir </span></a>
                                            </li>
                                            <li>
                                                <a href="dokumen_karyawan.php?Action=Daftar&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="fa fa-files-o"></i><span> Dokumen </span></a>
                                            </li>
                                            <li>
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karir_karyawan.php?Action=Daftar&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="fa  fa-odnoklassniki"></i><span> Jenjang Karir </span></a>
                                            </li>
                                            <li>
                                                <a href="dokumen_karyawan.php?Action=Daftar&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="fa fa-files-o"></i><span> Dokumen </span></a>
                                            </li>
                                            <li>
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Data Karyawan</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="karyawan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Update' type="hidden" name="Action" value="Data_Siswa_Update">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Lengkap</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <?php echo $Nama_Lengkap_Karyawan ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNamaPanggilan" class="col-sm-3 ">NIM</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php echo $NIM ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputUsername" class="col-sm-3 ">Nomor Rekening</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php echo $Nomor_Rekening ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputJenisKelamin" class="col-sm-3 ">Aktif</label>
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php echo ($Aktif==0)?"Tidak Aktif":"Aktif" ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputTanggalLahir" class="col-sm-3 ">Nama_Cabang</label>
                                                            
                                                            <div class="col-sm-3 input-group date pull-left" >
                                                                <?php echo $Nama_Cabang ?>
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
                                                    if($Hak_Akses==1)
                                                    {
                                                        ?>
                                                        <div class="col-sm-6 col-lg-4" style="padding-left:25px">
                                                            <div class="form-group">
                                                                <a href="karyawan.php?Action=Edit_Siswa&KaryawanNID=<?php echo $KaryawanNID ?>" class="btn btn-info" > Edit</a>
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
        elseif($_GET['Action']=='Foto_Upload')
        {
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'karyawan.php?Action=Daftar';
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

                    <!-- Dropzone css -->
                    <link href="assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">

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
                                    //$Hak_Akses = 9;
                                    if($Hak_Akses==1) //Administrator
                                    {
                                        ?>
                                        <ul>
                                            <li>
                                                <a href="index.php" class="waves-effect"><i class="ti-home"></i><span> Dashboard </span></a>
                                            </li>
                                            <li>
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Upload Foto</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal " name="form_tambah" action="karyawan.php" method="post" id="" enctype="multipart/form-data">
                                                    <input id='Foto_Upload' type="hidden" name="Action" value="Foto_Upload">
                                                    <div class="fallback">
                                                        <input type="file" name="file[]" id="file" class="image-upload" multiple>
                                                    </div>
                                                    
                                                    <?php
                                                    
                                                    if($Hak_Akses==1 || $Hak_Akses==4)
                                                    {
                                                        ?>
                                                        <div class="text-center m-t-15">
                                                            <button type="submit" name="submit" id="submit-all" class="btn btn-primary waves-effect waves-light">Upload Files</button>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>    
                                                    
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
                    <!-- Dropzone js -->
                    <script src="assets/plugins/dropzone/dist/dropzone.js"></script>
                    
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
                    <script>
                        
                            
                        
                        
                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Edit_Siswa')
        {
            $KaryawanNID = $_GET['KaryawanNID'];
            $KaryawanNID = str_replace('&#39;',"'",$KaryawanNID);
            $KaryawanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KaryawanNID));            

            //Ambil data siswa
            $sql = "SELECT dk.*, c.Nama_Cabang, c.Team_Leader FROM data_karyawan dk 
                            INNER JOIN cabang c ON c.CabangNID = dk.CabangNID
                            WHERE dk.KaryawanNID = '".$KaryawanNID."' ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $Nama_Lengkap_Karyawan = $buff['Nama_Lengkap'];
            $NIM = $buff['NIM'];
            $Tanggal_Lahir = $buff['Tanggal_Lahir'];
            $Tanggal_Lahir = substr($Tanggal_Lahir,-2)."-".substr($Tanggal_Lahir, 5,2)."-".substr($Tanggal_Lahir,0,4);
            $Nomor_Rekening = $buff['Nomor_Rekening'];
            $Aktif = $buff['Aktif'];
            $CabangNID = $buff['CabangNID'];
            $Nama_Cabang = $buff['Nama_Cabang'];
            
            
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
                            INNER JOIN  user_list ul ON ul.Username = dk.NIM
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
                            INNER JOIN  user_list ul ON ul.Username = dk.NIM
                            WHERE ul.UserNID = '".$Last_User."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Last_User = $buff['Last_User'];
            }
            
            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'karyawan.php?Action=Daftar';
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
                                            <a href="karyawan.php?Action=View&KaryawanNID=<?php echo $KaryawanNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Update Data Karyawan</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="karyawan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Update' type="hidden" name="Action" value="Data_Siswa_Update">
                                                    <input id='KaryawanNID' type="hidden" name="KaryawanNID" value="<?php echo $KaryawanNID ?>">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Lengkap</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNamaLengkap" name="Nama_Lengkap" value="<?php echo $Nama_Lengkap_Karyawan ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNIM" class="col-sm-3 ">NIM</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNIM" name="NIM" value="<?php echo $NIM ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-3 ">Tanggal Lahir</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="inputTanggalLahir" name="Tanggal_Lahir" value="<?php echo $Tanggal_Lahir ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNomor_Rekening" class="col-sm-3 ">Nomor Rekening</label>
                                                            
                                                            <div class="col-sm-3 input-group date pull-left" >
                                                                <input type="text" class="form-control " id="inputNomor_Rekening" name="Nomor_Rekening" value="<?php echo $Nomor_Rekening ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputAktif" class="col-sm-3 ">Aktif</label>
                                                            <div class="col-sm-3 input-group date" >
                                                                <select name="Aktif" id="inputAktif">
                                                                    <option value="0" <?php echo ($Aktif==0)?"selected":"" ?>>Tidak Aktif</option>
                                                                    <option value="1" <?php echo ($Aktif==1)?"selected":"" ?>>Aktif</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputCabang" class="col-sm-3 ">Cabang</label>
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php
                                                                $sql = "SELECT c.CabangNID, c.Nama_Cabang FROM cabang c 
                                                                            ORDER BY c.Nama_Cabang ";
                                                                //echo $sql.";<br>";
                                                                $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                                ?>
                                                                <select name="CabangNID" id="inputCabang">
                                                                    <?php
                                                                    while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                                    {
                                                                        $Current_CabangNID = $buff_Data_Siswa['CabangNID'];
                                                                        $Nama_Cabang = $buff_Data_Siswa['Nama_Cabang'];
                                                                        ?>
                                                                        <option value="<?php echo $Current_CabangNID ?>" <?php echo ($Current_CabangNID==$CabangNID)?"selected":"" ?>> <?php echo $Nama_Cabang ?></option>
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
        elseif($_GET['Action']=='Tambah_Karyawan')
        {
            
            $Nama_Lengkap_Karyawan  = "";
            $NIM = "";
            $Nomor_Rekening = "";
            $Tanggal_Lahir = date("d-m-Y");
            

            $Aktif = 1;
            $CabangNID = 1;
            
            

            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'karyawan.php?Action=Daftar';
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
                                            <a href="karyawan.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Tambah Data Karyawan</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="karyawan.php" method="post" enctype="multipart/form-data">
                                                    <input id='Data_Siswa_Tambah' type="hidden" name="Action" value="Data_Siswa_Tambah">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputNamaLengkap" class="col-sm-3 ">Nama Lengkap</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNamaLengkap" name="Nama_Lengkap" value="<?php echo $Nama_Lengkap_Karyawan ?>" placeholder="Nama Lengkap" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNIM" class="col-sm-3 ">NIM</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputNIM" name="NIM" value="<?php echo $NIM ?>"  placeholder="NIM"  required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputTanggal" class="col-sm-3 ">Tanggal Lahir</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="inputTanggalLahir" name="Tanggal_Lahir" value="<?php echo $Tanggal_Lahir ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputNomor_Rekening" class="col-sm-3 ">Nomor Rekening</label>
                                                            
                                                            <div class="col-sm-3 input-group date pull-left" >
                                                                <input type="text" class="form-control " id="inputNomor_Rekening" name="Nomor_Rekening" value="<?php echo $Nomor_Rekening ?>"  placeholder="Nomor Rekening"  required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputAktif" class="col-sm-3 ">Aktif</label>
                                                            <div class="col-sm-3 input-group date" >
                                                                <select name="Aktif" id="inputAktif">
                                                                    <option value="0" <?php echo ($Aktif==0)?"selected":"" ?>>Tidak Aktif</option>
                                                                    <option value="1" <?php echo ($Aktif==1)?"selected":"" ?>>Aktif</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputCabang" class="col-sm-3 ">Cabang</label>
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php
                                                                $sql = "SELECT c.CabangNID, c.Nama_Cabang FROM cabang c 
                                                                            ORDER BY c.Nama_Cabang ";
                                                                //echo $sql.";<br>";
                                                                $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                                ?>
                                                                <select name="CabangNID" id="inputCabang">
                                                                    <?php
                                                                    while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                                    {
                                                                        $Current_CabangNID = $buff_Data_Siswa['CabangNID'];
                                                                        $Nama_Cabang = $buff_Data_Siswa['Nama_Cabang'];
                                                                        ?>
                                                                        <option value="<?php echo $Current_CabangNID ?>" > <?php echo $Nama_Cabang ?></option>
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
                        $( "#inputTanggalLahir" ).datepicker({
                            format : 'dd-mm-yyyy',
                            changeMonth: true,
                            changeYear: true,
                            showOtherMonths: true,
                            selectOtherMonths: true
                        });
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
        
        
    }
    elseif(isset($_POST['Action']))
    {
        if($_POST['Action']=='Prestasi_Siswa_Update' || $_POST['Action']=='Prestasi_Siswa_Tambah')
        {
            $KaryawanNID = $_POST['KaryawanNID'];
            $KaryawanNID = str_replace('&#39;',"'",$KaryawanNID);
            $KaryawanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KaryawanNID));

            $PeriodeNID = $_POST['PeriodeNID'];
            $PeriodeNID = str_replace('&#39;',"'",$PeriodeNID);
            $PeriodeNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$PeriodeNID));

            $SemesterNID = $_POST['SemesterNID'];
            $SemesterNID = str_replace('&#39;',"'",$SemesterNID);
            $SemesterNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$SemesterNID));

            $Kategori = $_POST['Kategori'];
            $Kategori = str_replace('&#39;',"'",$Kategori);
            $Kategori = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Kategori));

            $Keterangan = $_POST['Keterangan'];
            $Keterangan = str_replace('&#39;',"'",$Keterangan);
            $Keterangan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Keterangan));

            if($_POST['Action']=='Prestasi_Siswa_Update')
            {
                $PrestasiNID = $_POST['PrestasiNID'];
                $PrestasiNID = str_replace('&#39;',"'",$PrestasiNID);
                $PrestasiNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$PrestasiNID));

                $sql = "UPDATE siswa_prestasi sp SET
                            sp.PeriodeNID = '".$PeriodeNID."', 
                            sp.SemesterNID = '".$SemesterNID."',
                            sp.Kategori = '".$Kategori."',
                            sp.Keterangan = '".$Keterangan."',
                            sp.Last_User = '".$Last_UserNID."'
                            WHERE sp.PrestasiNID = '".$PrestasiNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            elseif($_POST['Action']=='Prestasi_Siswa_Tambah')
            {
                $sql = "INSERT INTO siswa_prestasi(KaryawanNID, PeriodeNID, SemesterNID, Kategori, Keterangan, Creator, Create_Date, Last_User) VALUES 
                            ('$KaryawanNID', '$PeriodeNID', '$SemesterNID', '$Kategori', '$Keterangan', '$Last_UserNID', now(), '$Last_UserNID') ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

            }
            
            ?>
                <script>
                    window.location.href="karyawan.php?Action=Prestasi&KaryawanNID=<?php echo $KaryawanNID ?>";
                </script>
            <?php
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
                    window.location.href="karyawan.php?Action=Daftar";
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
            $KaryawanNID = $_POST['KaryawanNID'];
            $KaryawanNID = str_replace('&#39;',"'",$KaryawanNID);
            $KaryawanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$KaryawanNID));

            $Nama_Lengkap = $_POST['Nama_Lengkap'];
            $Nama_Lengkap = str_replace('&#39;',"'",$Nama_Lengkap);
            $Nama_Lengkap = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nama_Lengkap));

            $NIM = $_POST['NIM'];
            $NIM = str_replace('&#39;',"'",$NIM);
            $NIM = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$NIM));

            $Tanggal_Lahir = $_POST['Tanggal_Lahir'];
            $Tanggal_Lahir = str_replace('&#39;',"'",$Tanggal_Lahir);
            $Tanggal_Lahir = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal_Lahir));

            $Tanggal_Lahir = substr($Tanggal_Lahir, -4)."-".substr($Tanggal_Lahir, 3, 2)."-".substr($Tanggal_Lahir, 0,2);

            $Aktif = $_POST['Aktif'];
            $Aktif = str_replace('&#39;',"'",$Aktif);
            $Aktif = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Aktif));

            $CabangNID = $_POST['CabangNID'];
            $CabangNID = str_replace('&#39;',"'",$CabangNID);
            $CabangNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID));

            
            $sql = "SELECT * FROM data_karyawan ds 
                        WHERE ds.NIM = '".$NIM."' AND ds.KaryawanNID <> '".$KaryawanNID."' ";
            $qry = mysqli_query($Connection, $sql);
            //echo $sql.";<br>";
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Update
                $sql = "UPDATE data_karyawan ds SET
                            ds.NIM = '".$NIM."', 
                            ds.Nama_Lengkap = '".$Nama_Lengkap."', 
                            ds.Aktif = '".$Aktif."', 
                            ds.Tanggal_Lahir = '".$Tanggal_Lahir."', 
                            ds.CabangNID = '".$CabangNID."', 
                            ds.Last_User = '".$Last_UserNID."'
                            WHERE ds.KaryawanNID = '".$KaryawanNID."' ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                
            }
            ?>
                <script>
                    window.location.href="karyawan.php?Action=Daftar";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Data_Siswa_Tambah')
        {
            

            $Nama_Lengkap = $_POST['Nama_Lengkap'];
            $Nama_Lengkap = str_replace('&#39;',"'",$Nama_Lengkap);
            $Nama_Lengkap = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nama_Lengkap));

            $NIM = $_POST['NIM'];
            $NIM = str_replace('&#39;',"'",$NIM);
            $NIM = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$NIM));

            $Nomor_Rekening = $_POST['Nomor_Rekening'];
            $Nomor_Rekening = str_replace('&#39;',"'",$Nomor_Rekening);
            $Nomor_Rekening = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nomor_Rekening));

            $Tanggal_Lahir = $_POST['Tanggal_Lahir'];
            $Tanggal_Lahir = str_replace('&#39;',"'",$Tanggal_Lahir);
            $Tanggal_Lahir = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Tanggal_Lahir));

            $Tanggal_Lahir = substr($Tanggal_Lahir, -4)."-".substr($Tanggal_Lahir, 3, 2)."-".substr($Tanggal_Lahir, 0,2);

            $Aktif = $_POST['Aktif'];
            $Aktif = str_replace('&#39;',"'",$Aktif);
            $Aktif = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Aktif));

            $CabangNID = $_POST['CabangNID'];
            $CabangNID = str_replace('&#39;',"'",$CabangNID);
            $CabangNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$CabangNID));

            $sql = "SELECT * FROM data_karyawan ds 
                        WHERE ds.NIM = '".$NIM."'";
            $qry = mysqli_query($Connection, $sql);
            $num = mysqli_num_rows($qry);
            if($num==0)
            {
                //Insert
                $sql = "INSERT INTO data_karyawan (NIM, Nama_Lengkap, Nomor_Rekening, Tanggal_Lahir, Aktif, CabangNID, Creator, Create_Date, Last_User ) VALUES (
                                    '$NIM', '$Nama_Lengkap', '$Nomor_Rekening', '$Tanggal_Lahir','$Aktif', ".$CabangNID.", '$Last_UserNID', now(), '$Last_UserNID')";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                
            }
            ?>
                <script>
                    window.location.href="karyawan.php?Action=Daftar";
                </script>
            <?php
        }
        
    }
    
    
}

