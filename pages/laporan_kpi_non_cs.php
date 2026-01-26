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
    $Default_Dokumen_Dir = "../files/laporan_harian_non_cs/";
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
                                    elseif($Hak_Akses==4) //Guru
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
                                    elseif($Hak_Akses==5) //Guru
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
                                        <h4 class="page-title">Laporan KPI Non CS </h4>
                                    </div>
                                </div>
                                <?php
                                // Filter Tahun
                                if(isset($_GET['Tahun']))
                                {
                                    $Filter_Tahun = $_GET['Tahun'];
                                    $_SESSION['Filter_Tahun'] = $Filter_Tahun;
                                }
                                else
                                {   
                                    if(!isset($_SESSION['Filter_Tahun']))
                                    {
                                        $_SESSION['Filter_Tahun'] = date('Y');
                                        $Filter_Tahun = $_SESSION['Filter_Tahun'];
                                    }
                                    else
                                    {
                                        $Filter_Tahun = $_SESSION['Filter_Tahun'];
                                    }
                                }

                                // Filter Bulan
                                if(isset($_GET['Bulan']))
                                {
                                    $Filter_Bulan = $_GET['Bulan'];
                                    $_SESSION['Filter_Bulan'] = $Filter_Bulan;
                                }
                                else
                                {   
                                    if(!isset($_SESSION['Filter_Bulan']))
                                    {
                                        $_SESSION['Filter_Bulan'] = date('m');
                                        $Filter_Bulan = $_SESSION['Filter_Bulan'];
                                    }
                                    else
                                    {
                                        $Filter_Bulan = $_SESSION['Filter_Bulan'];
                                    }
                                }

                                // Periode Laporan dari Tahun dan Bulan
                                $Periode_Laporan = $Filter_Tahun . '-' . str_pad($Filter_Bulan, 2, '0', STR_PAD_LEFT);

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
                                            
                                        </div>
                                        <div id="demo" class="collapse" style="margin-bottom: 15px; margin-top: 10px;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Tahun:</label>
                                                    <select id="inputTahun" class="form-control" onchange="ApplyFilter()">
                                                        <?php
                                                        // Get distinct years from Tanggal_Laporan
                                                        $sql_tahun = "SELECT DISTINCT YEAR(Tanggal_Laporan) AS Tahun FROM laporan_non_cs ORDER BY Tahun DESC";
                                                        $qry_tahun = mysqli_query($Connection, $sql_tahun);
                                                        
                                                        $tahun_list = array();
                                                        while($buff_tahun = mysqli_fetch_array($qry_tahun))
                                                        {
                                                            $tahun_list[] = $buff_tahun['Tahun'];
                                                        }
                                                        
                                                        // Add current year if not in list
                                                        $current_year = date('Y');
                                                        if(!in_array($current_year, $tahun_list))
                                                        {
                                                            $tahun_list[] = $current_year;
                                                            rsort($tahun_list);
                                                        }
                                                        
                                                        foreach($tahun_list as $tahun)
                                                        {
                                                            $selected = ($tahun == $Filter_Tahun) ? 'selected' : '';
                                                            echo '<option value="'.$tahun.'" '.$selected.'>'.$tahun.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Bulan:</label>
                                                    <select id="inputBulan" class="form-control" onchange="ApplyFilter()">
                                                        <?php
                                                        for($i = 1; $i <= 12; $i++)
                                                        {
                                                            $bulan_val = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                            $selected = ($bulan_val == $Filter_Bulan) ? 'selected' : '';
                                                            echo '<option value="'.$bulan_val.'" '.$selected.'>'.$Daftar_Bulan[$i].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>&nbsp;</label><br>
                                                    <button type="button" class="btn btn-primary" onclick="ApplyFilter()"><i class="fa fa-filter"></i> Terapkan Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body table-responsive">
                                                <?php 
                                                if($Hak_Akses==4)
                                                {
                                                    ?>
                                                    <p><a href="laporan_kpi_non_cs.php?Action=Dokumen_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data</a></p>
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
                                                            <?php
                                                            if($Hak_Akses==2)
                                                            {
                                                                ?>
                                                                <th width=15% rowspan=1 style="text-align:left;vertical-align:middle">User</th>
                                                                <th width=30% rowspan=1 style="text-align:left;vertical-align:middle">Indikator</th>
                                                                <th width=5% rowspan=1 style="text-align:left;vertical-align:middle">Periode</th>
                                                                <th width=10% rowspan=1 style="text-align:left;vertical-align:middle">Lokasi</th>
                                                                <th width=15% rowspan=1 style="text-align:left;vertical-align:middle">Tanggal</th>
                                                                <th width=15% rowspan=1 style="text-align:center;vertical-align:middle">File</th>
                                                                <th width=5% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <th width=25% rowspan=1 style="text-align:left;vertical-align:middle">Indikator</th>
                                                                <th width=5% rowspan=1 style="text-align:left;vertical-align:middle">Periode</th>
                                                                <th width=10% rowspan=1 style="text-align:left;vertical-align:middle">Lokasi</th>
                                                                <th width=15% rowspan=1 style="text-align:left;vertical-align:middle">Tanggal</th>
                                                                <th width=15% rowspan=1 style="text-align:center;vertical-align:middle">File</th>
                                                                <th width=5% colspan=1 style="text-align:left;vertical-align:middle">Action</th>
                                                                <?php
                                                            }
                                                            ?>
                                                            
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        if($Hak_Akses==2)
                                                        {
                                                            $sql = "SELECT ln.*, dk.Nama_Lengkap, ik.Indikator FROM laporan_non_cs ln 
                                                                        INNER JOIN indikator_kpi_user iu ON iu.Indikator_UserNID = ln.Indikator_UserNID
                                                                        INNER JOIN indikator_kpi ik ON ik.IndikatorNID = iu.IndikatorNID
                                                                        INNER JOIN data_karyawan dk ON dk.KaryawanNID = iu.KaryawanNID
                                                                        INNER JOIN user_list ul ON ul.Username = dk.NIM
                                                                        WHERE YEAR(ln.Tanggal_Laporan) = '".$Filter_Tahun."' 
                                                                        AND MONTH(ln.Tanggal_Laporan) = '".$Filter_Bulan."' 
                                                                        ORDER BY ln.Tanggal_Laporan DESC";
                                                        }
                                                        else
                                                        {
                                                            $sql = "SELECT ln.*, dk.Nama_Lengkap, ik.Indikator FROM laporan_non_cs ln 
                                                                        INNER JOIN indikator_kpi_user iu ON iu.Indikator_UserNID = ln.Indikator_UserNID
                                                                        INNER JOIN indikator_kpi ik ON ik.IndikatorNID = iu.IndikatorNID
                                                                        INNER JOIN data_karyawan dk ON dk.KaryawanNID = iu.KaryawanNID
                                                                        INNER JOIN user_list ul ON ul.Username = dk.NIM
                                                                        WHERE YEAR(ln.Tanggal_Laporan) = '".$Filter_Tahun."' 
                                                                        AND MONTH(ln.Tanggal_Laporan) = '".$Filter_Bulan."' 
                                                                        AND ul.UserNID = '".$Last_UserNID."'
                                                                        ORDER BY ln.Tanggal_Laporan DESC";
                                                        }
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $LaporanNID = $buff_Data_Siswa['LaporanNID'];
                                                            $Tanggal_Laporan = $buff_Data_Siswa['Tanggal_Laporan'];
                                                            $Lokasi = $buff_Data_Siswa['Lokasi'];
                                                            $Periode = $buff_Data_Siswa['Periode'];
                                                            $Nama_Lengkap_User = $buff_Data_Siswa['Nama_Lengkap'];
                                                            $Indikator = $buff_Data_Siswa['Indikator'];
                                                            $Checked = $buff_Data_Siswa['Checked'];
                                                            $Tanggal_Report_Tampilan = strtotime($Tanggal_Laporan);
                                                            $Hari = date("w", $Tanggal_Report_Tampilan );

                                                            // Get files for this report
                                                            $sql_files = "SELECT * FROM laporan_kpi_files WHERE LaporanNID = '".$LaporanNID."'";
                                                            $qry_files = mysqli_query($Connection, $sql_files);
                                                            $files_html = '';
                                                            while($buff_files = mysqli_fetch_array($qry_files))
                                                            {
                                                                $File_Name = $buff_files['File_Name'];
                                                                $File_Periode = $Periode;
                                                                $File_Folder = str_replace('-', '', $File_Periode);
                                                                $File_Path = "../files/laporan_kpi/".$File_Folder."/".$File_Name;
                                                                
                                                                // Get file extension
                                                                $file_ext = strtolower(pathinfo($File_Name, PATHINFO_EXTENSION));
                                                                
                                                                // Set icon based on file type
                                                                $icon_class = '';
                                                                $icon_color = '';
                                                                if(in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                                {
                                                                    $icon_class = 'fa fa-file-image-o';
                                                                    $icon_color = 'color: #4CAF50;';
                                                                }
                                                                elseif($file_ext == 'pdf')
                                                                {
                                                                    $icon_class = 'fa fa-file-pdf-o';
                                                                    $icon_color = 'color: #F44336;';
                                                                }
                                                                elseif(in_array($file_ext, ['doc', 'docx']))
                                                                {
                                                                    $icon_class = 'fa fa-file-word-o';
                                                                    $icon_color = 'color: #2196F3;';
                                                                }
                                                                elseif(in_array($file_ext, ['xls', 'xlsx']))
                                                                {
                                                                    $icon_class = 'fa fa-file-excel-o';
                                                                    $icon_color = 'color: #4CAF50;';
                                                                }
                                                                elseif(in_array($file_ext, ['ppt', 'pptx']))
                                                                {
                                                                    $icon_class = 'fa fa-file-powerpoint-o';
                                                                    $icon_color = 'color: #FF9800;';
                                                                }
                                                                else
                                                                {
                                                                    $icon_class = 'fa fa-file-o';
                                                                    $icon_color = 'color: #757575;';
                                                                }
                                                                
                                                                $files_html .= '<a href="'.$File_Path.'" target="_blank" title="'.$File_Name.'" style="margin-right: 8px;"><i class="'.$icon_class.'" style="font-size: 20px; '.$icon_color.'"></i></a>';
                                                            }

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right;font-size:12px"><?php echo $Nomor_Urut ?></td>
                                                                <?php
                                                                if($Hak_Akses==2)
                                                                {
                                                                    ?>
                                                                    <td style="text-align:left;font-size:12px"><?php echo $Nama_Lengkap_User ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <td style="text-align:left;font-size:12px"><?php echo $Indikator ?></td>
                                                                <td style="text-align:left;font-size:12px"><?php echo $Periode ?></td>
                                                                <td style="text-align:left;font-size:12px"><?php echo $Lokasi ?></td>
                                                                <td style="text-align:left;font-size:12px"><?php echo $Daftar_Hari[$Hari].", ".date("d-m-Y", $Tanggal_Report_Tampilan) ?></td>
                                                                <td style="text-align:center;font-size:12px"><?php echo $files_html ?></td>
                                                                
                                                                <td style="text-align:center">
                                                                    <?php
                                                                    if($Hak_Akses==2)
                                                                    {
                                                                        ?>
                                                                        <input type="checkbox" class="check-toggle" data-laporan-id="<?php echo $LaporanNID ?>" <?php echo ($Checked == 1) ? 'checked' : ''; ?> onchange="toggleCheck(this, '<?php echo $LaporanNID ?>')">
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <a href="laporan_kpi_non_cs.php?Action=Dokumen_Update&LaporanNID=<?php echo $LaporanNID ?>"><i class="ti-pencil" title="Update data"></i></a>
                                                                        <a href="laporan_kpi_non_cs.php?Action=Dokumen_Hapus&LaporanNID=<?php echo $LaporanNID ?>" style="color:red;padding-left:10px" title="Hapus data"><i class="ti-trash"></i></a>
                                                                        <?php
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
                    <script>
                        function ApplyFilter() 
                        {
                            var Tahun = document.getElementById("inputTahun").value;
                            var Bulan = document.getElementById("inputBulan").value;
                            
                            window.location.href="laporan_kpi_non_cs.php?Action=Daftar&Tahun="+Tahun+"&Bulan="+Bulan;
                        }
                        function CekCabang() 
                        {
                            var Cabang = document.getElementById("inputCabang").value;
                            
                            window.location.href="laporan_kpi_non_cs.php?Action=Daftar&Cabang="+Cabang;
                        }
                        
                        function toggleCheck(checkbox, laporanId) 
                        {
                            var isChecked = checkbox.checked ? 1 : 0;
                            
                            // Send AJAX request to update database
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "laporan_kpi_non_cs.php?Action=Toggle_Check", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    // Optional: show success message
                                    console.log("Check status updated");
                                }
                            };
                            
                            xhr.send("LaporanNID=" + laporanId + "&Checked=" + isChecked);
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
        elseif($_GET['Action']=='Toggle_Check')
        {
            $LaporanNID = $_POST['LaporanNID'];
            $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
            $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));
            
            $Checked = $_POST['Checked'];
            $Checked = mysqli_real_escape_string($Connection, $Checked);
            
            $sql = "UPDATE laporan_non_cs SET Checked = '".$Checked."' WHERE LaporanNID = '".$LaporanNID."'";
            $qry = mysqli_query($Connection, $sql);
            
            if($qry)
            {
                echo "success";
            }
            else
            {
                echo "error";
            }
            exit;
        }
        elseif($_GET['Action']=='Dokumen_Valid')
        {
            $LaporanNID = $_GET['LaporanNID'];
            $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
            $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));

            $sql = "SELECT * FROM laporan_harian sp
                        WHERE sp.LaporanNID = '".$LaporanNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $IsValid = $buff['IsValid'];
            if($IsValid==0)
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 1
                            WHERE sp.LaporanNID = '".$LaporanNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
            }
            else
            {
                $sql = "UPDATE laporan_harian sp SET
                            sp.IsValid = 0
                            WHERE sp.LaporanNID = '".$LaporanNID."'
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
        }
        elseif($_GET['Action']=='Dokumen_Update' || $_GET['Action']=='Dokumen_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Dokumen_Tambah")
            {

                $Periode = "";
                $Indikator_UserNID = "";
                $Lokasi = "";
                $inputFileBefore = "";
                
                $Tanggal_Pembelian = date("d-m-Y");

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
                $Tanggal_Laporan = "";
            }
            else
            {
                $LaporanNID = $_GET['LaporanNID'];
                $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
                $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));

                //Ambil data prestasi siswa
                $sql = "SELECT * FROM laporan_non_cs sp
                            WHERE sp.LaporanNID = '".$LaporanNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Periode = $buff['Periode'];
                $Tanggal_Laporan = $buff['Tanggal_Laporan'];
                $Lokasi = $buff['Lokasi'];
                $Image_Before = $buff['Image_Before'];
                
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
            $_SESSION['Parrent_Page'] = 'laporan_kpi_non_cs.php?Action=Daftar';
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
                                            <a href="laporan_kpi_non_cs.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Dokumen_Update')?"Update":"Tambah") ?> Laporan KPI</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="laporan_kpi_non_cs.php" method="POST" enctype="multipart/form-data">
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
                                                        <input id='LaporanNID' type="hidden" name="LaporanNID" value="<?php echo $LaporanNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputPeriode" class="col-sm-3 ">Periode</label>
                                                            
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
                                                                $sql = "SELECT * FROM laporan_non_cs lh 
                                                                            WHERE lh.Periode <> '".$Tahun_Berjalan."-".date("m")."'
                                                                            GROUP BY lh.Periode
                                                                            ";
                                                                //echo $sql.";<br>";
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
                                                                //echo "Tahun_Sebelumnya : ".$Tahun_Sebelumnya."<br>";
                                                                //echo "Bulan_Sebelumnya : ".$Bulan_Sebelumnya."<br>";
                                                                $Bulan_Text_Sebelumnya = $Daftar_Bulan[$Bulan_Sebelumnya];
                                                                $Text_Item_Sebelumnya = $Bulan_Text_Sebelumnya." ".$Tahun_Sebelumnya;
                                                                $Waktu_Sebelumnya = $Tahun_Sebelumnya."-".substr("0".$Bulan_Sebelumnya,-2);
                                                                $Bulan_Text = $Daftar_Bulan[intval(substr($Tanggal,5,2))];
                                                                $Tahun_Text = substr($Tanggal,0,4);
                                                                $Text_Item = $Bulan_Text." ".$Tahun_Text;
                                                                $Waktu = $Tahun_Text."-".substr($Tanggal,5,2);
                                                                //echo "Bulan_Text_Sebelumnya : ".$Bulan_Text_Sebelumnya."<br>";
                                                                //echo "Text_Item_Sebelumnya : ".$Text_Item_Sebelumnya."<br>";
                                                                //echo "Waktu_Sebelumnya : ".$Waktu_Sebelumnya."<br>";
                                                                //echo "Waktu : ".$Waktu."<br>";
                                                                //echo "Bulan_Text : ".$Bulan_Text."<br>";
                                                                //echo "Tahun_Text : ".$Tahun_Text."<br>";
                                                                //echo "Text_Item : ".$Text_Item."<br>";
                                                                
                                                                // Set default periode untuk tambah data baru
                                                                if($Action == "Dokumen_Tambah")
                                                                {
                                                                    $Periode_Default = $Waktu; // Bulan dan tahun berjalan
                                                                }
                                                                else
                                                                {
                                                                    $Periode_Default = $Periode; // Dari database untuk update
                                                                }
                                                                ?>
                                                               <select name="Periode" id="inputWaktu" onchange="CekWaktu()" class="form-control">
                                                                    
                                                                    <option value="<?php echo $Waktu_Sebelumnya?>" <?php echo ($Periode_Default == $Waktu_Sebelumnya) ? 'selected' : ''; ?>><?php echo $Text_Item_Sebelumnya ?></option>
                                                                    <option value="<?php echo $Waktu?>" <?php echo ($Periode_Default == $Waktu) ? 'selected' : ''; ?>><?php echo $Text_Item ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputIndikatorNID" class="col-sm-3 ">Indikator</label>
                                                                
                                                                <div class="col-sm-9 input-group date" >
                                                                    <?php
                                                                    

                                                                    $sql = "SELECT ik.Indikator, iku.Indikator_UserNID FROM indikator_kpi ik 
                                                                                INNER JOIN indikator_kpi_user iku ON iku.IndikatorNID = ik.IndikatorNID 
                                                                                INNER JOIN data_karyawan dk ON dk.KaryawanNID = iku.KaryawanNID
                                                                                INNER JOIN user_list ul ON ul.Username = dk.NIM
                                                                                WHERE ul.UserNID = '".$Last_UserNID."'
                                                                                ORDER BY ik.Indikator;";
                                                                    //echo $sql.";<br>";
                                                                    //echo "Cabang : ".$Filter_Cabang."<br>";
                                                                    $qry = mysqli_query($Connection, $sql);
                                                                    $num = mysqli_num_rows($qry);
                                                                    //echo "Filter tanggal ".$Filter_Tanggal."<br>";
                                                                    ?>
                                                                    <select name="Indikator_UserNID" id="inputIndikatorNID" onchange="" class="form-control">
                                                                        <?php
                                                                        while ($buff = mysqli_fetch_array($qry)) 
                                                                        {
                                                                            $Current_Indikator_UserNID  = $buff['Indikator_UserNID'];
                                                                            $Indikator = $buff['Indikator'];
                                                                            
                                                                            ?>
                                                                            <option value="<?php echo $Current_Indikator_UserNID ?>"  ><?php echo $Indikator ?></option>
                                                                            <?php
                                                                        }
                                                                        
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputLokasi" class="col-sm-3 " title="Lokasi kunjungan jika ada">Lokasi*</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputLokasi" name="Lokasi" placehoder="Lokasi kunjungan (jika ada)" value="<?php echo $Lokasi ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputFile" class="col-sm-3 ">File Pendukung</label>
                                                            
                                                            <div class="col-sm-9">
                                                                <div id="file-upload-container">
                                                                    <div class="file-upload-row" style="margin-bottom: 10px;">
                                                                        <input type="file" name="uploaded_files[]" class="form-control file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif" style="display: inline-block; width: 85%;">
                                                                        <button type="button" class="btn btn-danger btn-sm remove-file-btn" style="display: none; margin-left: 5px;"><i class="fa fa-times"></i></button>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success btn-sm" id="add-more-files" style="margin-top: 10px;"><i class="fa fa-plus"></i> Tambah File</button>
                                                                <p class="help-block">File yang diperbolehkan: PDF, Word, Excel, PowerPoint, dan Gambar (JPG, PNG, GIF). Max 5MB per file.</p>
                                                                <?php
                                                                if($Action=="Dokumen_Update")
                                                                {
                                                                    // Display existing files
                                                                    $sql_files = "SELECT lkf.*, lnc.Periode FROM laporan_kpi_files lkf 
                                                                                  INNER JOIN laporan_non_cs lnc ON lnc.LaporanNID = lkf.LaporanNID
                                                                                  WHERE lkf.LaporanNID = '".$LaporanNID."' ORDER BY lkf.Upload_Date DESC";
                                                                    $qry_files = mysqli_query($Connection, $sql_files);
                                                                    if(mysqli_num_rows($qry_files) > 0)
                                                                    {
                                                                        ?>
                                                                        <div style="margin-top: 15px;">
                                                                            <strong>File yang sudah di-upload:</strong>
                                                                            <ul class="list-group" style="margin-top: 10px;">
                                                                            <?php
                                                                            while($buff_file = mysqli_fetch_array($qry_files))
                                                                            {
                                                                                $FileNID = $buff_file['FileNID'];
                                                                                $File_Original_Name = $buff_file['File_Original_Name'];
                                                                                $File_Name = $buff_file['File_Name'];
                                                                                $File_Size = round($buff_file['File_Size'] / 1024, 2); // Convert to KB
                                                                                $File_Periode = $buff_file['Periode'];
                                                                                $File_Folder = str_replace('-', '', $File_Periode); // Convert YYYY-MM to YYYYMM
                                                                                ?>
                                                                                <li class="list-group-item" style="padding: 8px;">
                                                                                    <a href="../files/laporan_kpi/<?php echo $File_Folder ?>/<?php echo $File_Name ?>" target="_blank"><?php echo $File_Original_Name ?></a>
                                                                                    <span class="badge"><?php echo $File_Size ?> KB</span>
                                                                                    <a href="laporan_kpi_non_cs.php?Action=Delete_File&FileNID=<?php echo $FileNID ?>&LaporanNID=<?php echo $LaporanNID ?>" class="btn btn-danger btn-xs pull-right" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?');"><i class="fa fa-trash"></i></a>
                                                                                </li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                            </ul>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
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
                            
                            // File upload management
                            var maxFiles = 10;
                            var maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
                            var allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif'];
                            
                            // Add more file inputs
                            $('#add-more-files').click(function() {
                                var fileCount = $('.file-upload-row').length;
                                if(fileCount < maxFiles) {
                                    var newRow = $('<div class="file-upload-row" style="margin-bottom: 10px;">' +
                                        '<input type="file" name="uploaded_files[]" class="form-control file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif" style="display: inline-block; width: 85%;">' +
                                        '<button type="button" class="btn btn-danger btn-sm remove-file-btn" style="margin-left: 5px;"><i class="fa fa-times"></i></button>' +
                                        '</div>');
                                    $('#file-upload-container').append(newRow);
                                } else {
                                    alert('Maksimal ' + maxFiles + ' file yang dapat di-upload.');
                                }
                            });
                            
                            // Remove file input
                            $(document).on('click', '.remove-file-btn', function() {
                                if($('.file-upload-row').length > 1) {
                                    $(this).closest('.file-upload-row').remove();
                                }
                            });
                            
                            // Show/hide remove button
                            $(document).on('change', '.file-input', function() {
                                var $row = $(this).closest('.file-upload-row');
                                if($(this).val()) {
                                    $row.find('.remove-file-btn').show();
                                } else {
                                    $row.find('.remove-file-btn').hide();
                                }
                            });
                            
                            // Validate files before submit
                            $('form[name="form_tambah"]').submit(function(e) {
                                var hasError = false;
                                var errorMessages = [];
                                
                                $('.file-input').each(function() {
                                    if(this.files.length > 0) {
                                        var file = this.files[0];
                                        var fileName = file.name;
                                        var fileSize = file.size;
                                        var fileExt = fileName.split('.').pop().toLowerCase();
                                        
                                        // Check file extension
                                        if($.inArray(fileExt, allowedExtensions) === -1) {
                                            hasError = true;
                                            errorMessages.push('File "' + fileName + '" memiliki ekstensi yang tidak diperbolehkan.');
                                        }
                                        
                                        // Check file size
                                        if(fileSize > maxFileSize) {
                                            hasError = true;
                                            errorMessages.push('File "' + fileName + '" melebihi ukuran maksimal 5MB.');
                                        }
                                        
                                        // Check for dangerous patterns in filename
                                        var dangerousPatterns = /\.php|\.exe|\.sh|\.bat|\.cmd|\.com|\.pif|\.scr|\.vbs|\.js$/i;
                                        if(dangerousPatterns.test(fileName)) {
                                            hasError = true;
                                            errorMessages.push('File "' + fileName + '" tidak diperbolehkan karena alasan keamanan.');
                                        }
                                    }
                                });
                                
                                if(hasError) {
                                    e.preventDefault();
                                    alert('Error:\n\n' + errorMessages.join('\n'));
                                    return false;
                                }
                            });
                        } );

                    </script>
                </body>
            </html>
            <?php
        }
        elseif($_GET['Action']=='Dokumen_View')
        {
        }
        elseif($_GET['Action']=='Dokumen_Hapus')
        {
            
            $LaporanNID = $_GET['LaporanNID'];
            $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
            $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));

            $sql = "DELETE FROM laporan_non_cs
                        WHERE LaporanNID = '".$LaporanNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            ?>
            <script>
                  window.history.back();
            </script>
            <?php
            
        }
        elseif($_GET['Action']=='Delete_File')
        {
            // Delete specific file
            $FileNID = $_GET['FileNID'];
            $FileNID = str_replace('&#39;',"'",$FileNID);
            $FileNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$FileNID));
            
            $LaporanNID = $_GET['LaporanNID'];
            $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
            $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));
            
            // Get file name and period before deleting
            $sql = "SELECT lkf.File_Name, lnc.Periode FROM laporan_kpi_files lkf
                    INNER JOIN laporan_non_cs lnc ON lnc.LaporanNID = lkf.LaporanNID
                    WHERE lkf.FileNID = '".$FileNID."'";
            $qry = mysqli_query($Connection, $sql);
            if($buff = mysqli_fetch_array($qry))
            {
                $File_Name = $buff['File_Name'];
                $File_Periode = $buff['Periode'];
                $File_Folder = str_replace('-', '', $File_Periode); // Convert YYYY-MM to YYYYMM
                
                // Delete physical file
                $file_path = "../files/laporan_kpi/".$File_Folder."/".$File_Name;
                if(file_exists($file_path))
                {
                    unlink($file_path);
                }
                
                // Delete from database
                $sql = "DELETE FROM laporan_kpi_files WHERE FileNID = '".$FileNID."'";
                mysqli_query($Connection, $sql);
            }
            
            ?>
            <script>
                window.location.href="laporan_kpi_non_cs.php?Action=Dokumen_Update&LaporanNID=<?php echo $LaporanNID ?>";
            </script>
            <?php
        }
    }
    elseif(isset($_POST['Action']))
    {
        if($_POST['Action']=='Dokumen_Siswa_Update' || $_POST['Action']=='Dokumen_Siswa_Tambah')
        {
            // Function to sanitize filename
            function sanitize_filename($filename) {
                // Remove any path components
                $filename = basename($filename);
                
                // Remove any non-alphanumeric characters except dots, dashes, and underscores
                $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
                
                // Remove multiple dots (potential directory traversal)
                $filename = preg_replace('/\.+/', '.', $filename);
                
                // Limit filename length
                if(strlen($filename) > 200) {
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $name = substr(pathinfo($filename, PATHINFO_FILENAME), 0, 190);
                    $filename = $name . '.' . $ext;
                }
                
                return $filename;
            }
            
            // Function to validate file type
            function validate_file_type($filename, $tmp_name) {
                $allowed_extensions = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif');
                $dangerous_extensions = array('php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'sh', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js', 'jar', 'app');
                
                // Get file extension
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                // Check if extension is dangerous
                if(in_array($ext, $dangerous_extensions)) {
                    return false;
                }
                
                // Check if extension is allowed
                if(!in_array($ext, $allowed_extensions)) {
                    return false;
                }
                
                // Verify MIME type for images
                if(in_array($ext, array('jpg', 'jpeg', 'png', 'gif'))) {
                    $mime = mime_content_type($tmp_name);
                    $allowed_mimes = array('image/jpeg', 'image/png', 'image/gif');
                    if(!in_array($mime, $allowed_mimes)) {
                        return false;
                    }
                }
                
                // Check for double extensions (like file.php.jpg)
                $filename_parts = explode('.', $filename);
                if(count($filename_parts) > 2) {
                    foreach($filename_parts as $part) {
                        if(in_array(strtolower($part), $dangerous_extensions)) {
                            return false;
                        }
                    }
                }
                
                return true;
            }
            
            if(isset($_POST['submit']))
            {
                
                $Periode  = $_POST['Periode'];
                $Periode  = str_replace('&#39;',"'",$Periode );
                $Periode  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Periode ));
                $Bulan_Periode = substr($Periode,5,2);
                $Tahun_Periode = substr($Periode,0,4);
                //echo "Periode: ".$Periode."<br>";
                //echo "Bulan Periode: ".$Bulan_Periode."<br>";
                //echo "Tahun Periode: ".$Tahun_Periode."<br>";
                
                $Indikator_UserNID  = $_POST['Indikator_UserNID'];
                $Indikator_UserNID  = str_replace('&#39;',"'",$Indikator_UserNID );
                $Indikator_UserNID  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Indikator_UserNID ));
                $Tanggal_Laporan = date("Y-m-d");

                $Lokasi  = $_POST['Lokasi'];
                $Lokasi  = str_replace('&#39;',"'",$Lokasi );
                $Lokasi  = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Lokasi ));

                $Keterangan = "";

                //$Jenis_LaporanNID = 6; //Pembayaran Invoice
                $Waktu_Upload = date("Ymdghis");
                if($_POST['Action']=='Dokumen_Siswa_Update')
                {
                    $LaporanNID = $_POST['LaporanNID'];
                    $LaporanNID = str_replace('&#39;',"'",$LaporanNID);
                    $LaporanNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$LaporanNID));

                    // Update laporan data
                    $sql = "UPDATE laporan_non_cs SET
                            Indikator_UserNID = '".$Indikator_UserNID."',
                            Periode = '".$Periode."',
                            Lokasi = '".$Lokasi."',
                            Last_User = '".$Last_UserNID."',
                            Last_Update = NOW()
                            WHERE LaporanNID = '".$LaporanNID."'";
                    //echo $sql.";<br>";
                    mysqli_query($Connection, $sql);
                    
                    // Process new file uploads
                    if(isset($_FILES['uploaded_files']) && !empty($_FILES['uploaded_files']['name'][0]))
                    {
                        // Create directory with YYYYMM format if not exists
                        $periode_folder = $Tahun_Periode.str_pad($Bulan_Periode, 2, '0', STR_PAD_LEFT); // Format: YYYYMM
                        $upload_dir = "../files/laporan_kpi/".$periode_folder."/";
                        if(!is_dir($upload_dir))
                        {
                            mkdir($upload_dir, 0755, true);
                        }
                        
                        $file_count = count($_FILES['uploaded_files']['name']);
                        $upload_errors = array();
                        $upload_success = 0;
                        
                        for($i = 0; $i < $file_count; $i++)
                        {
                            if($_FILES['uploaded_files']['error'][$i] == 0)
                            {
                                $original_filename = $_FILES['uploaded_files']['name'][$i];
                                $tmp_name = $_FILES['uploaded_files']['tmp_name'][$i];
                                $file_size = $_FILES['uploaded_files']['size'][$i];
                                
                                // Validate file type
                                if(!validate_file_type($original_filename, $tmp_name))
                                {
                                    $upload_errors[] = "File '".$original_filename."' tidak diperbolehkan.";
                                    continue;
                                }
                                
                                // Check file size (max 5MB)
                                if($file_size > 5242880)
                                {
                                    $upload_errors[] = "File '".$original_filename."' melebihi ukuran maksimal 5MB.";
                                    continue;
                                }
                                
                                // Sanitize filename
                                $sanitized_filename = sanitize_filename($original_filename);
                                
                                // Create unique filename
                                $file_ext = pathinfo($sanitized_filename, PATHINFO_EXTENSION);
                                $file_basename = pathinfo($sanitized_filename, PATHINFO_FILENAME);
                                $unique_filename = $file_basename.'_'.time().'_'.rand(1000,9999).'.'.$file_ext;
                                
                                $destination = $upload_dir.$unique_filename;
                                
                                // Move uploaded file
                                if(move_uploaded_file($tmp_name, $destination))
                                {
                                    // Save file info to database
                                    $sql_file = "INSERT INTO laporan_kpi_files 
                                                (LaporanNID, File_Name, File_Original_Name, File_Type, File_Size, Upload_Date, Uploaded_By) 
                                                VALUES 
                                                ('".$LaporanNID."', '".$unique_filename."', '".$original_filename."', '".$file_ext."', '".$file_size."', NOW(), '".$Last_UserNID."')";
                                    mysqli_query($Connection, $sql_file);
                                    $upload_success++;
                                }
                                else
                                {
                                    $upload_errors[] = "Gagal meng-upload file '".$original_filename."'.";
                                }
                            }
                        }
                    }
                    
                    ?>
                    <script>
                        alert('Data berhasil diupdate.');
                        window.location.href="laporan_kpi_non_cs.php?Action=Daftar";
                    </script>
                    <?php
                   
                    
                }
                elseif($_POST['Action']=='Dokumen_Siswa_Tambah')
                {
                    $Simpan = False;
                    //Cari Indikator dari data yang dipilih, ini untuk validasi, jika user 
                    $sql="SELECT iku.Indikator_UserNID, ik.Jenis_Penilaian, ik.Bobot, ik.Target FROM indikator_kpi_user iku
                            INNER JOIN indikator_kpi ik ON ik.IndikatorNID = iku.IndikatorNID
                            WHERE iku.Indikator_UserNID = '".$Indikator_UserNID."';";
                    //echo $sql.";<br>";
                    $qry = mysqli_query($Connection, $sql);
                    $buff = mysqli_fetch_array($qry);
                    $Jenis_Penilaian = $buff['Jenis_Penilaian'];
                    $Bobot = $buff['Bobot'];
                    $Target = $buff['Target'];
                    //echo "Jenis Penilaian: ".$Jenis_Penilaian."<br>";
                    //echo "Bobot: ".$Bobot."<br>";   
                    //echo "Target: ".$Target."<br>";
                    // Validasi tanggal
                    $Simpan = True;
                    if($Jenis_Penilaian==1)
                    {
                        //Tanggal
                        $Tanggal_Saat_Ini = date("Y-m-d");
                        
                        // Ambil tanggal, bulan, dan tahun saat ini
                        $Hari_Ini = date("d"); // Tanggal hari ini
                        $Bulan_Ini = date("m");
                        $Tahun_Ini = date("Y");
                        
                        // Buat tanggal target di bulan/tahun yang sama
                        $Tanggal_Target = $Tahun_Ini."-".$Bulan_Ini."-".str_pad($Target, 2, "0", STR_PAD_LEFT);
                        
                        // Hitung selisih hari antara tanggal saat ini dan tanggal target
                        $Date_Sekarang = new DateTime($Tanggal_Saat_Ini);
                        $Date_Target = new DateTime($Tanggal_Target);
                        $Selisih = $Date_Sekarang->diff($Date_Target);
                        $Selisih_Hari = $Selisih->days;
                        
                        // Cek apakah tanggal sekarang lebih dari tanggal target
                        if($Date_Sekarang > $Date_Target)
                        {
                            // Jika selisih lebih dari 4 hari, maka tidak boleh simpan
                            if($Selisih_Hari > 4)
                            {
                                $Simpan = False;
                            }
                        }
                    }
                    elseif($Jenis_Penilaian==2)
                    {
                        //Kuantitas
                        // Cara 1: Menggunakan cal_days_in_month untuk mendapatkan jumlah hari dalam bulan
                        $Akhir_Bulan_Periode = cal_days_in_month(CAL_GREGORIAN, intval($Bulan_Periode), intval($Tahun_Periode));
                        $Tanggal_Akhir_Bulan = $Tahun_Periode."-".$Bulan_Periode."-".$Akhir_Bulan_Periode;
                        
                        // Cara 2: Menggunakan date dengan 't' untuk mendapatkan tanggal terakhir bulan
                        // $Tanggal_Akhir_Bulan = date("Y-m-t", strtotime($Tahun_Periode."-".$Bulan_Periode."-01"));
                        
                        //echo "Tanggal Akhir Bulan: ".$Tanggal_Akhir_Bulan."<br>";
                        //echo "Jumlah Hari: ".$Akhir_Bulan_Periode."<br>";
                        
                        // Validasi: Cek apakah tanggal submit lebih besar dari tanggal akhir bulan periode
                        $Tanggal_Submit = date("Y-m-d");
                        //echo "Tanggal Submit: ".$Tanggal_Submit."<br>";
                        if($Tanggal_Submit > $Tanggal_Akhir_Bulan)
                        {
                            $Simpan = False;
                            echo "Validasi Gagal: Tanggal submit melebihi akhir bulan periode!<br>";
                        }
                    }

                    //Simpan data ke database
                    if($Simpan)
                    {
                        //Jika lolos validasi tanggal atau validasi kuantitas
                        // Insert laporan data
                        $sql = "INSERT INTO laporan_non_cs 
                                (Indikator_UserNID, Periode, Tanggal_Laporan, Lokasi, Creator, Create_Date, Last_User, Last_Update) 
                                VALUES 
                                ('".$Indikator_UserNID."', '".$Periode."', '".$Tanggal_Laporan."', '".$Lokasi."', '".$Last_UserNID."', NOW(), '".$Last_UserNID."', NOW())";
                        //echo $sql.";<br>";
                        if(mysqli_query($Connection, $sql))
                        {
                            $LaporanNID = mysqli_insert_id($Connection);
                            
                            // Process file uploads
                            if(isset($_FILES['uploaded_files']) && !empty($_FILES['uploaded_files']['name'][0]))
                            {
                                // Create directory with YYYYMM format if not exists
                                $periode_folder = $Tahun_Periode.str_pad($Bulan_Periode, 2, '0', STR_PAD_LEFT); // Format: YYYYMM
                                $upload_dir = "../files/laporan_kpi/".$periode_folder."/";
                                if(!is_dir($upload_dir))
                                {
                                    mkdir($upload_dir, 0755, true);
                                }
                                
                                $file_count = count($_FILES['uploaded_files']['name']);
                                $upload_errors = array();
                                $upload_success = 0;
                                
                                for($i = 0; $i < $file_count; $i++)
                                {
                                    if($_FILES['uploaded_files']['error'][$i] == 0)
                                    {
                                        $original_filename = $_FILES['uploaded_files']['name'][$i];
                                        $tmp_name = $_FILES['uploaded_files']['tmp_name'][$i];
                                        $file_size = $_FILES['uploaded_files']['size'][$i];
                                        
                                        // Validate file type
                                        if(!validate_file_type($original_filename, $tmp_name))
                                        {
                                            $upload_errors[] = "File '".$original_filename."' tidak diperbolehkan.";
                                            continue;
                                        }
                                        
                                        // Check file size (max 5MB)
                                        if($file_size > 5242880)
                                        {
                                            $upload_errors[] = "File '".$original_filename."' melebihi ukuran maksimal 5MB.";
                                            continue;
                                        }
                                        
                                        // Sanitize filename
                                        $sanitized_filename = sanitize_filename($original_filename);
                                        
                                        // Create unique filename
                                        $file_ext = pathinfo($sanitized_filename, PATHINFO_EXTENSION);
                                        $file_basename = pathinfo($sanitized_filename, PATHINFO_FILENAME);
                                        $unique_filename = $file_basename.'_'.time().'_'.rand(1000,9999).'.'.$file_ext;
                                        
                                        $destination = $upload_dir.$unique_filename;
                                        
                                        // Move uploaded file
                                        if(move_uploaded_file($tmp_name, $destination))
                                        {
                                            // Save file info to database
                                            $sql_file = "INSERT INTO laporan_kpi_files 
                                                        (LaporanNID, File_Name, File_Original_Name, File_Type, File_Size, Upload_Date, Uploaded_By) 
                                                        VALUES 
                                                        ('".$LaporanNID."', '".$unique_filename."', '".$original_filename."', '".$file_ext."', '".$file_size."', NOW(), '".$Last_UserNID."')";
                                            mysqli_query($Connection, $sql_file);
                                            $upload_success++;
                                        }
                                        else
                                        {
                                            $upload_errors[] = "Gagal meng-upload file '".$original_filename."'.";
                                        }
                                    }
                                }
                                
                                // Show upload status
                                if($upload_success > 0)
                                {
                                    ?>
                                    <script>
                                        alert('Data berhasil disimpan dengan <?php echo $upload_success ?> file ter-upload.');
                                        window.location.href="laporan_kpi_non_cs.php?Action=Daftar";
                                    </script>
                                    <?php
                                }
                                if(!empty($upload_errors))
                                {
                                    ?>
                                    <script>
                                        alert('Data tersimpan, tetapi ada error pada file:\\n<?php echo implode("\\n", $upload_errors) ?>');
                                        window.location.href="laporan_kpi_non_cs.php?Action=Daftar";
                                    </script>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <script>
                                    alert('Data berhasil disimpan.');
                                    window.location.href="laporan_kpi_non_cs.php?Action=Daftar";
                                </script>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <script>
                                alert('Gagal menyimpan data: <?php echo mysqli_error($Connection) ?>');
                                window.history.back();
                            </script>
                            <?php
                        }
                    }
                   
                }
                else
                {
                    // Jika validasi tanggal gagal (lebih dari 4 hari terlambat)
                    ?>
                    <script>
                        alert('Gagal menyimpan! Anda terlambat lebih dari 4 hari dari tanggal target (<?php echo $Target ?>).');
                        window.history.back();
                    </script>
                    <?php
                }
            }
            
            ?>
                <script>
                    //window.location.href="laporan_kpi_non_cs.php?Action=Daftar";
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

