<?php
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
    $Default_Dokumen_Dir = "../files/siswa/dokumen/";
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
            $SiswaNID = $_GET['SiswaNID'];
            $SiswaNID = str_replace('&#39;',"'",$SiswaNID);
            $SiswaNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$SiswaNID));

            //Ambil data siswa
            $sql = "SELECT ds.Nama_Lengkap FROM data_siswa ds
                        WHERE ds.SiswaNID = '".$SiswaNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $Nama_Lengkap_Siswa = $buff['Nama_Lengkap'];

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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=View&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Daftar Dokumen <?php echo $Nama_Lengkap_Siswa ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <?php 
                                                if($Hak_Akses==1 || $Hak_Akses==4)
                                                {
                                                    ?>
                                                    <p><a href="dokumen_siswa.php?Action=Dokumen_Tambah&SiswaNID=<?php echo $SiswaNID ?>" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Dokumen</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Dokumen</p></p>
                                                    <?php
                                                }
                                                ?>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=30% rowspan=1 style="text-align:center;vertical-align:middle">Nama Dokumen</th>
                                                            <th width=55% colspan=1 style="text-align:left;vertical-align:middle">Keterangan</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT sd.DokumenNID, sd.Judul, sd.Keterangan, sd.Lampiran, sd.Creator, sd.Create_Date, sd.Last_Update, sd.Last_User  FROM siswa_dokumen sd 
                                                                    WHERE sd.SiswaNID = '".$SiswaNID."' AND sd.Deleted = 0
                                                                    ORDER BY sd.Judul ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $DokumenNID = $buff_Data_Siswa['DokumenNID'];
                                                            $Judul = $buff_Data_Siswa['Judul'];
                                                            $Keterangan = $buff_Data_Siswa['Keterangan'];
                                                            $Lampiran = $buff_Data_Siswa['Lampiran'];
                                                            $Creator = $buff_Data_Siswa['Creator'];
                                                            $Create_Date = $buff_Data_Siswa['Create_Date'];
                                                            $Last_Update = $buff_Data_Siswa['Last_Update'];
                                                            $Last_User = $buff_Data_Siswa['Last_User'];
                                                            $Link_Dokumen = $Default_Dokumen_Dir.$Lampiran;

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:left"><?php echo $Judul ?></td>
                                                                <td style="text-align:left"><?php echo nl2br($Keterangan)  ?></td>
                                                                <td style="text-align:center">
                                                                <?php
                                                                    if($Hak_Akses==1 || $Hak_Akses==4)
                                                                    {
                                                                        ?>
                                                                        <span style="padding-right:10px"><a href="dokumen_siswa.php?Action=Dokumen_Update&DokumenNID=<?php echo $DokumenNID ?>" title="Update prestasi siswa"><span ><i class="fa fa-pencil"></i></span></a></span>
                                                                        <span style="padding-right:10px"><a href="dokumen_siswa.php?Action=Dokumen_Hapus&DokumenNID=<?php echo $DokumenNID ?>" title="Hapus data prestasi siswa"><span ><i class="fa fa-trash-o"></i></span></a></span>
                                                                        <?php 
                                                                        if($Lampiran=="")
                                                                        {
                                                                            ?>
                                                                            <span><i class="fa fa-eye" title="Tidak ada dokumen"></i></span></span>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <span><a href="<?php echo $Link_Dokumen ?>" title="Lihat dokumen"><span ><i class="fa fa-eye"></i></span></a></span>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <span style="padding-right:10px"><span title="User tidak memiliki akses untuk melakukan update data"><i class="fa fa-pencil"></i></span></span>
                                                                        <span style="padding-right:10px"><span title="User tidak memiliki akses untuk melakukan menghapus data"><i class="fa fa-trash-o"></i></span></span>
                                                                        <?php 
                                                                        if($Lampiran=="")
                                                                        {
                                                                            ?>
                                                                            <span><i class="fa fa-eye" title="Tidak ada dokumen"></i></span></span>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <span><a href="<?php echo $Link_Dokumen ?>" title="Lihat dokumen"><span ><i class="fa fa-eye"></i></span></a></span>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
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
        elseif($_GET['Action']=='Dokumen_Update' || $_GET['Action']=='Dokumen_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Dokumen_Tambah")
            {
                $SiswaNID = $_GET['SiswaNID'];
                $SiswaNID = str_replace('&#39;',"'",$SiswaNID);
                $SiswaNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$SiswaNID));

                //Ambil nama siswa untuk nama file
                $sql = "SELECT * from data_siswa sd
                            WHERE sd.SiswaNID = '".$SiswaNID."'";
                //echo $sql.";<br>";
                $qry_Data_Siswa = mysqli_query($Connection, $sql);
                $buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa);
                $Nama_Lengkap_Siswa = $buff_Data_Siswa['Nama_Lengkap'];
                

                $Judul = "";
                $Keterangan = "";

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
            }
            else
            {
                $DokumenNID = $_GET['DokumenNID'];
                $DokumenNID = str_replace('&#39;',"'",$DokumenNID);
                $DokumenNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$DokumenNID));

                //Ambil data prestasi siswa
                $sql = "SELECT sp.*, ds.Nama_Lengkap FROM siswa_dokumen sp
                            INNER JOIN data_siswa ds ON ds.SiswaNID = sp.SiswaNID
                            WHERE sp.DokumenNID = '".$DokumenNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Nama_Lengkap_Siswa = $buff['Nama_Lengkap'];
                $SiswaNID = $buff['SiswaNID'];
                $Judul = $buff['Judul'];
                $Keterangan = $buff['Keterangan'];
                
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
                                WHERE dk.UserNID = '".$Creator."'
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
                                WHERE dk.UserNID = '".$Last_User."'
                                ";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $buff = mysqli_fetch_array($qry);
                    $Last_User = $buff['Last_User'];
                }
            }


            //$_SESSION['Parrent_Page'] = $_SESSION['Current_Page'];
            $_SESSION['Parrent_Page'] = 'dokumen_siswa.php?Action=Daftar';
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
                                            <a href="dokumen_siswa.php?Action=Daftar&SiswaNID=<?php echo $SiswaNID ?>" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Dokumen <?php echo $Nama_Lengkap_Siswa ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="dokumen_siswa.php" method="post" enctype="multipart/form-data">
                                                    <?php 
                                                    if($Action=="Dokumen_Tambah")
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Siswa_Tambah' type="hidden" name="Action" value="Dokumen_Siswa_Tambah">
                                                        <input id='SiswaNID' type="hidden" name="SiswaNID" value="<?php echo $SiswaNID ?>">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <input id='Dokumen_Siswa_Update' type="hidden" name="Action" value="Dokumen_Siswa_Update">
                                                        <input id='SiswaNID' type="hidden" name="SiswaNID" value="<?php echo $SiswaNID ?>">
                                                        <input id='DokumenNID' type="hidden" name="DokumenNID" value="<?php echo $DokumenNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputJudul" class="col-sm-3 ">Judul</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputJudul" name="Judul" value="<?php echo $Judul ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputKeterangan" class="col-sm-3 ">Keterangan</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <textarea class="form-control pull-right" id="inputKeterangan" name="Keterangan" ><?php echo nl2br($Keterangan) ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">File</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="file" name="file" id="inputFile" class="image-upload" required>
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
        elseif($_GET['Action']=='Dokumen_Hapus')
        {
            
            $DokumenNID = $_GET['DokumenNID'];
            $DokumenNID = str_replace('&#39;',"'",$DokumenNID);
            $DokumenNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$DokumenNID));

            $sql = "SELECT sp.SiswaNID, sp.Lampiran FROM siswa_dokumen sp
                        WHERE sp.DokumenNID = '".$DokumenNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $SiswaNID = $buff['SiswaNID'];
            $Lampiran = $buff['Lampiran'];
            echo dirname($Default_Dokumen_Dir)."<br>";
            echo $Default_Dokumen_Dir."<br>";
            echo $Default_Dokumen_Dir.$Lampiran."<br>";
            echo "Deleted-".$Default_Dokumen_Dir.$Lampiran."<br>";
            //Nama File diganti, awal file ditambahkan prefix Deleted
            if(file_exists($Default_Dokumen_Dir.$Lampiran))
            {
                rename($Default_Dokumen_Dir.$Lampiran, $Default_Dokumen_Dir."Deleted-".$Lampiran);
            }
            
            //Ambil data prestasi siswa
            $sql = "UPDATE siswa_dokumen sp SET
                        sp.Deleted = 1,
                        sp.Last_User =  '".$Last_UserNID."'
                        WHERE sp.DokumenNID = '".$DokumenNID."'
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
                $SiswaNID = $_POST['SiswaNID'];
                $SiswaNID = str_replace('&#39;',"'",$SiswaNID);
                $SiswaNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$SiswaNID));

                //Ambil NIS untuk nama file
                $sql = "SELECT * from data_siswa sd
                            WHERE sd.SiswaNID = '".$SiswaNID."'";
                //echo $sql.";<br>";
                $qry_Data_Siswa = mysqli_query($Connection, $sql);
                $buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa);
                $NIS = $buff_Data_Siswa['NIS'];

                $Judul = $_POST['Judul'];
                $Judul = str_replace('&#39;',"'",$Judul);
                $Judul = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Judul));

                $Keterangan = $_POST['Keterangan'];
                $Keterangan = str_replace('&#39;',"'",$Keterangan);
                $Keterangan = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Keterangan));

                if($_POST['Action']=='Dokumen_Siswa_Update')
                {
                    $DokumenNID = $_POST['DokumenNID'];
                    $DokumenNID = str_replace('&#39;',"'",$DokumenNID);
                    $DokumenNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$DokumenNID));

                    //Ambil data yang lama untuk membandingkan nama file
                    $sql = "SELECT * from siswa_dokumen sd
                                WHERE sd.DokumenNID = '".$DokumenNID."'";
                    //echo $sql.";<br>";
                    $qry_Data_Siswa = mysqli_query($Connection, $sql);
                    $buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa);
                    $Old_Judul = $buff_Data_Siswa['Judul'];
                    $Old_Lampiran = $buff_Data_Siswa['Lampiran'];

                    //cek apakah ada file baru yang diupload
                    if($_FILES['file']['name']<>"")
                    {
                        $filename = $_FILES['file']['name'];
                        $temp_Nama_File = $_FILES['file']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='pdf')
                        {
                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $NIS."-".$DokumenNID.".".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);
                            //$Jumlah_Sukses++;
                            //echo $filename." sukses.<br>";
                            $sql = "UPDATE siswa_dokumen sp SET
                                        sp.Judul = '".$Judul."', 
                                        sp.Keterangan = '".$Keterangan."',
                                        sp.Lampiran = '".$Lampiran."',
                                        sp.Last_User = '".$Last_UserNID."'
                                        WHERE sp.DokumenNID = '".$DokumenNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                        }
                        else
                        {
                            echo " Proses update gagal, silahkan cek ekstensi file. Ekstensi file yang bisa diterima jpg, jpeg, dan pdf.<br>";
                            ?>
                            <a href="dokumen_siswa.php?Action=Daftar&SiswaNID=<?php echo $SiswaNID ?>">Kembali</a>
                            <?php
                            //$Jumlah_Error++;
                        }
                    }
                    else
                    {
                        $sql = "UPDATE siswa_dokumen sp SET
                                    sp.Judul = '".$Judul."', 
                                    sp.Keterangan = '".$Keterangan."',
                                    sp.Last_User = '".$Last_UserNID."'
                                    WHERE sp.DokumenNID = '".$DokumenNID."' ";
                        //echo $sql.";<br>";
                        $qry = mysqli_query($Connection, $sql);
                    }
                   
                }
                elseif($_POST['Action']=='Dokumen_Siswa_Tambah')
                {
                    if($_FILES['file']['name']<>"")
                    {
                        $filename = $_FILES['file']['name'];
                        $temp_Nama_File = $_FILES['file']['tmp_name'];
                        $Ekstensi_File = pathinfo($filename, PATHINFO_EXTENSION);
                        //echo "Ekstensi file ".$Ekstensi_File."<br>";
                        if(strtolower($Ekstensi_File)=='jpg' || strtolower($Ekstensi_File)=='jpeg' || strtolower($Ekstensi_File)=='pdf')
                        {
                            $Lampiran = "";
                            $sql = "INSERT INTO siswa_dokumen(SiswaNID, Judul, Keterangan, Lampiran,  Creator, Create_Date, Last_User) VALUES 
                                        ('$SiswaNID', '$Judul', '$Keterangan', '$Lampiran', '$Last_UserNID', now(), '$Last_UserNID') ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            $DokumenNID = mysqli_insert_id($Connection);

                            //$Nama_File = pathinfo($filename, PATHINFO_FILENAME );
                            $Nama_File = $NIS."-".$DokumenNID.".".$Ekstensi_File;
                            $Lampiran = $Nama_File;
                            $Target_Lokasi_Penyimpanan = $Default_Dokumen_Dir.$Nama_File;
                            // Upload file
                            move_uploaded_file($temp_Nama_File, $Target_Lokasi_Penyimpanan);
                            //$Jumlah_Sukses++;
                            //echo $filename." sukses.<br>";
                            $sql = "UPDATE siswa_dokumen kk SET
                                        kk.Lampiran = '".$Lampiran."'
                                        WHERE kk.DokumenNID = '".$DokumenNID."' ";
                            //echo $sql.";<br>";
                            $qry = mysqli_query($Connection, $sql);
                            
                        }
                        else
                        {
                            echo " Proses upload gagal, silahkan cek ekstensi file. Ekstensi file yang bisa diterima jpg, jpeg, dan pdf.<br>";
                            ?>
                            <a href="dokumen_siswa.php?Action=Daftar&SiswaNID=<?php echo $SiswaNID ?>">Kembali</a>
                            <?php
                            //$Jumlah_Error++;
                        }
                    }
                    
                    

                }
            }
            
            ?>
                <script>
                    window.location.href="dokumen_siswa.php?Action=Daftar&SiswaNID=<?php echo $SiswaNID ?>";
                </script>
            <?php
        }
        elseif($_POST['Action']=='Filter_Siswa')
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

