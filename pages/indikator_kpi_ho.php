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
                                        <h4 class="page-title">Indikator Penilaian </h4>
                                    </div>
                                </div>
                                <?php
                                if(isset($_GET['UserNID']))
                                {
                                    $Filter_UserNID = $_GET['UserNID'];
                                    $_SESSION['Filter_UserNID'] = $Filter_UserNID;
                                }
                                else
                                {   
                                    if(!isset($_SESSION['Filter_UserNID']))
                                    {
                                        $sql = "SELECT ul.UserNID, ul.Username, uj.Jenis_User, dk.Nama_Lengkap FROM user_list ul
                                                    INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                                    INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                    INNER JOIN data_karyawan dk ON dk.NIM = ul.Username
                                                    WHERE uj.Jenis_User IN ('Head Office', 'Operasional')
                                                    GROUP BY ul.Username
                                                    ORDER BY dk.Nama_Lengkap
                                                    LIMIT 1;";
                                        //echo $sql.";<br>";
                                        $qry = mysqli_query($Connection, $sql);
                                        $buff = mysqli_fetch_array($qry);
                                        $_SESSION['Filter_UserNID'] = 99999;
                                        $Filter_UserNID = $_SESSION['Filter_UserNID'];
                                    }
                                    else
                                    {
                                        $Filter_UserNID = $_SESSION['Filter_UserNID'];
                                    }
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
                                                            <label for="inputKelas" class="col-sm-3 ">User</label>
                                                            
                                                            <div class="col-sm-9 input-group date" >
                                                                <?php
                                                                
                                                                
                                                                $sql = "SELECT ul.UserNID, ul.Username, uj.Jenis_User, dk.Nama_Lengkap FROM user_list ul
                                                                            INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                                                            INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                                            INNER JOIN data_karyawan dk ON dk.NIM = ul.Username
                                                                            WHERE uj.Jenis_User IN ('Head Office', 'Operasional')
                                                                            GROUP BY ul.Username
                                                                            ORDER BY dk.Nama_Lengkap;";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                ?>
                                                                <select name="User" id="inputUser" onchange="CekUser()" class="form-control">
                                                                    <option value="99999">All</option>
                                                                    <?php
                                                                    while ($buff = mysqli_fetch_array($qry)) 
                                                                    {
                                                                        $Current_UserNID = $buff['UserNID'];
                                                                        $Username = $buff['Username'];
                                                                        $Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                        $Jenis_User = $buff['Jenis_User'];
                                                                        
                                                                        if($Current_UserNID==$Filter_UserNID)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_UserNID?>" selected><?php echo $Nama_Lengkap ?></option>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_UserNID?>"><?php echo $Nama_Lengkap ?></option>
                                                                            <?php
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
                                                if($Hak_Akses==1)
                                                {
                                                    ?>
                                                    <p><a href="indikator_kpi_ho.php?Action=Dokumen_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
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
                                                            <th width=40% rowspan=1 style="text-align:left;vertical-align:middle">Indikator</th>
                                                            <th width=15% rowspan=1 style="text-align:left;vertical-align:middle">Measurement</th>
                                                            <th width=10% rowspan=1 style="text-align:left;vertical-align:middle">Target</th>
                                                            <th width=10% rowspan=1 style="text-align:left;vertical-align:middle">Weight</th>
                                                            <th width=15% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $Query_User = ($Filter_UserNID==99999)?"":" AND iu.UserNID = ".$Filter_UserNID;
                                                        $sql = "SELECT iu.*, dk.Nama_Lengkap FROM indikator_user iu
                                                                    INNER JOIN user_list ul ON ul.UserNID = iu.UserNID
                                                                    INNER JOIN data_karyawan dk ON dk.NIM = ul.Username
                                                                    WHERE 1 ".$Query_User."
                                                                    ORDER BY dk.Nama_Lengkap, iu.Jenis_Penilaian, iu.Indikator_UserNID;";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $Indikator_UserNID = $buff_Data_Siswa['Indikator_UserNID'];
                                                            $Bobot = $buff_Data_Siswa['Bobot'];
                                                            $Indikator = $buff_Data_Siswa['Indikator'];
                                                            $Jenis_Penilaian = $buff_Data_Siswa['Jenis_Penilaian'];
                                                            $Nilai_Target = $buff_Data_Siswa['Nilai_Target'];

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Indikator ?></td>
                                                                <td style="text-align:left"><?php echo ($Jenis_Penilaian==1)?"Tanggal":"Jumlah" ?></td>
                                                                <td style="text-align:left"><?php echo $Nilai_Target ?></td>
                                                                <td style="text-align:left"><?php echo $Bobot ?></td>
                                                                <td style="text-align:left">
                                                                    <a href="indikator_kpi_ho.php?Action=Dokumen_Update&Indikator_UserNID=<?php echo $Indikator_UserNID ?>"><i class="ti-pencil" title="Update data"></i></a>
                                                                    <a href="indikator_kpi_ho.php?Action=Dokumen_Hapus&Indikator_UserNID=<?php echo $Indikator_UserNID ?>" style="color:red;padding-left:10px" title="Hapus data"><i class="ti-trash"></i></a>
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
                        function CekUser() 
                        {
                            var UserNID = document.getElementById("inputUser").value;
                            
                            window.location.href="indikator_kpi_ho.php?Action=Daftar&UserNID="+UserNID;
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
        }
        elseif($_GET['Action']=='Dokumen_Valid')
        {
        }
        elseif($_GET['Action']=='Dokumen_Detail_Hapus')
        {
        }
        elseif($_GET['Action']=='Dokumen_Update' || $_GET['Action']=='Dokumen_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Dokumen_Tambah")
            {

                $UserNID = "";
                $Measurement = "1"; //Tanggal
                $Bobot = "1";
                $Target = "0";
                $Indikator = "";
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
                $Indikator_UserNID = $_GET['Indikator_UserNID'];
                $Indikator_UserNID = str_replace('&#39;',"'",$Indikator_UserNID);
                $Indikator_UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Indikator_UserNID));

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM indikator_user sp
                            WHERE sp.Indikator_UserNID = '".$Indikator_UserNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $UserNID = $buff['UserNID'];
                $Bobot = $buff['Bobot'];
                $Target = $buff['Nilai_Target'];
                $Measurement = $buff['Jenis_Penilaian'];
                $Indikator = $buff['Indikator'];
                
                
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
            $_SESSION['Parrent_Page'] = 'indikator_kpi_ho.php?Action=Daftar';
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
                                            <a href="indikator_kpi_ho.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Indikator Penilaian User </h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="indikator_kpi_ho.php" method="post" enctype="multipart/form-data">
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
                                                        <input id='Indikator_UserNID' type="hidden" name="Indikator_UserNID" value="<?php echo $Indikator_UserNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputKelas" class="col-sm-3 ">User</label>
                                                            
                                                            <div class="col-sm-9 input-group date" >
                                                                <?php
                                                                $Filter_UserNID = $_SESSION['Filter_UserNID'];
                                                                $UserNID = ($Filter_UserNID==99999)?"":" AND ul.UserNID =".$Filter_UserNID;
                                                                $sql = "SELECT ul.UserNID, ul.Username, uj.Jenis_User, dk.Nama_Lengkap FROM user_list ul
                                                                            INNER JOIN user_hak uh ON uh.UserNID = ul.UserNID
                                                                            INNER JOIN user_jenis uj ON uj.Jenis_UserNID = uh.Jenis_UserNID
                                                                            INNER JOIN data_karyawan dk ON dk.NIM = ul.Username
                                                                            WHERE uj.Jenis_User IN ('Head Office', 'Operasional') ".$UserNID."
                                                                            GROUP BY ul.Username
                                                                            ORDER BY dk.Nama_Lengkap;";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                $num = mysqli_num_rows($qry);
                                                                ?>
                                                                <select name="UserNID" id="inputUserNID"  class="form-control">
                                                                    
                                                                    <?php
                                                                    while ($buff = mysqli_fetch_array($qry)) 
                                                                    {
                                                                        $Current_UserNID = $buff['UserNID'];
                                                                        $Username = $buff['Username'];
                                                                        $Nama_Lengkap = $buff['Nama_Lengkap'];
                                                                        
                                                                        if($Current_UserNID==$Filter_UserNID)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_UserNID?>" selected><?php echo $Nama_Lengkap ?></option>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_UserNID?>"><?php echo $Nama_Lengkap ?></option>
                                                                            <?php
                                                                        }
                                                                        
                                                                    }
                                                                    
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputMeasurement" class="col-sm-3 ">Measurement</label>
                                                                
                                                                <div class="col-sm-9 input-group date" >
                                                                    <select name="Measurement" id="inputMeasurement" onchange="CekCabang()" class="form-control">
                                                                        <?php
                                                                        
                                                                        if($Measurement==1)
                                                                        {
                                                                            ?>
                                                                            <option value="1"  selected>Tanggal</option>
                                                                            <option value="2"  >Jumlah</option>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="1"  >Tanggal</option>
                                                                            <option value="2"  selected>Jumlah</option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputBobot" class="col-sm-3 ">Bobot</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                
                                                                <input type="number" class="form-control pull-right" id="inputBobot" placeholder="0 s/d 100" name="Bobot" min="1" max="100" value="<?php echo $Bobot ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputTarget" class="col-sm-3 ">Target Penilaian</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                
                                                                <input type="number" class="form-control pull-right" id="inputTarget" placeholder="Target penilaian" name="Target" min="0" value="<?php echo $Target ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="InputIndikator" class="col-sm-3 ">Indikator</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                
                                                                <input type="text" class="form-control pull-right" id="InputIndikator" placeholder="Indikator penilaian" name="Indikator" value="<?php echo $Indikator ?>">
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
            
            $Indikator_UserNID = $_GET['Indikator_UserNID'];
            $Indikator_UserNID = str_replace('&#39;',"'",$Indikator_UserNID);
            $Indikator_UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Indikator_UserNID));

            $sql = "DELETE FROM indikator_user
                        WHERE Indikator_UserNID = '".$Indikator_UserNID."'
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

                $UserNID  = $_POST['UserNID'];
                $UserNID  = str_replace('&#39;',"'",$UserNID );
                $UserNID  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$UserNID ));
                
                $Jenis_Penilaian  = $_POST['Measurement'];
                $Jenis_Penilaian  = str_replace('&#39;',"'",$Jenis_Penilaian );
                $Jenis_Penilaian  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Jenis_Penilaian ));

                $Bobot  = $_POST['Bobot'];
                $Bobot  = str_replace('&#39;',"'",$Bobot );
                $Bobot  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Bobot ));

                $Nilai_Target  = $_POST['Target'];
                $Nilai_Target  = str_replace('&#39;',"'",$Nilai_Target );
                $Nilai_Target  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Nilai_Target ));

                $Indikator  = $_POST['Indikator'];
                $Indikator  = str_replace('&#39;',"'",$Indikator );
                $Indikator  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Indikator ));


                $Waktu_Upload = date("Ymdghis");
                if($_POST['Action']=='Dokumen_Siswa_Update')
                {
                    $Indikator_UserNID = $_POST['Indikator_UserNID'];
                    $Indikator_UserNID = str_replace('&#39;',"'",$Indikator_UserNID);
                    $Indikator_UserNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Indikator_UserNID));

                    $sql = "UPDATE laporan_harian sp SET
                                    sp.Bobot = '".$Bobot."', 
                                    sp.Nilai_Target = '".$Nilai_Target."', 
                                    sp.Jenis_Penilaian = '".$Jenis_Penilaian."', 
                                    sp.Indikator = '".$Indikator."', 
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.Indikator_UserNID = '".$Indikator_UserNID."' ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    
                }
                elseif($_POST['Action']=='Dokumen_Siswa_Tambah')
                {
                    //Simpan data ke database
                    $Image_Before = "";
                    $Image_After = "";
                    $sql = "INSERT INTO indikator_user(UserNID, Bobot, Nilai_Target, Jenis_Penilaian, Indikator, Creator, Create_Date, Last_User) VALUES 
                                ('$UserNID', '$Bobot', '$Nilai_Target',  '$Jenis_Penilaian', '$Indikator', '$Last_UserNID', now(), '$Last_UserNID') ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $Indikator_UserNID = mysqli_insert_id($Connection);
                }
            }
            
            ?>
                <script>
                    window.location.href="indikator_kpi_ho.php?Action=Daftar";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Dokumen_Detail_Update' || $_POST['Action']=='Dokumen_Detail_Tambah')
        {
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

