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
    $Dokumen_Target_Dir = "../files/siswa/dokumen/";
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
                                            <li>
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                                <a href="siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title">Daftar Prestasi</h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div>
                                            <!--<a href="#demo" class="" data-toggle="collapse">Filter</a>
                                            <div id="demo" class="collapse">
                                                <div class="row">
                                                    <form class="form-horizontal" name="form_tambah" action="prestasi_siswa.php" method="post" enctype="multipart/form-data">
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
                                                
                                            </div>-->
                                        </div>
                                        <div class="panel">
                                            <div class="panel-body">
                                                <div class="col-sm-10">
                                                    <!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://sdkmaterdeipml.sincos.online/file/tugas/2018070000001/2020-2021/4318/PPDB Online.pptx' width='80%' height='565px' frameborder='0'> </iframe>
                                                    <iframe src="https://docs.google.com/gview?url=http://sdkmaterdeipml.sincos.online/file/tugas/2018070000001/2020-2021/4318/Menuliskan kegiatan hari ini.docx&embedded=true" width='80%' height='400px'></iframe>
                                                    <iframe src="https://docs.google.com/gview?url=http://sdkmaterdeipml.sincos.online/file/tugas/2018070000001/2020-2021/4318/Kelas 1 ( TP. 2021-2022 ) (3).xls&embedded=true" width='80%' height='400px'></iframe>

                                                    <iframe src="http://sdkmaterdeipml.sincos.online/file/tugas/2018070000001/2020-2021/4318/hasil/4318_27_192001115_Bahasa indonesia-sheryl-27-2D.jpg" style="max-width: 90%;max-height: 90%;" width='100%' height='400px'></iframe>
                                                    <img src="http://sdkmaterdeipml.sincos.online/file/tugas/2018070000001/2020-2021/4318/hasil/4318_18_192001088_16233300456856512398100819464807.jpg" style="max-width: 90%;max-height: 90%;" alt="">-->
                                                </div>
                                                
                                                <?php 
                                                if($Hak_Akses==1 || $Hak_Akses==9)
                                                {
                                                    ?>
                                                    <p><a href="prestasi_siswa.php?Action=Prestasi_Tambah" class="btn btn-info" title="Klik untuk menambah data"><i class="fa fa-plus"></i> Data Prestasi</a></p>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <p><p class="btn btn-info" title="User tidak memiliki akses untuk melakukan penambahan data"><i class="fa fa-plus"></i> Data Prestasi</p></p>
                                                    <?php
                                                }
                                                ?>
                                                <!--<h4 class="m-b-30 m-t-0">Fixed Header Example</h4>-->
                                                <table id="data-kehadiran" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width=5% rowspan=1 style="text-align:center;vertical-align:middle">No</th>
                                                            <th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Periode/<br>Semester</th>
                                                            <th width=35% colspan=1 style="text-align:left;vertical-align:middle">Nama/<br>NIS</th>
                                                            <th width=10% colspan=1 style="text-align:center;vertical-align:middle">Kategori</th>
                                                            <th width=35% colspan=1 style="text-align:center;vertical-align:middle">Keterangan</th>
                                                            <th width=5% colspan=1 style="text-align:center;vertical-align:middle">Action</th>
                                                            <!--<th width=10% rowspan=1 style="text-align:center;vertical-align:middle">Action</th>-->
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                        $Nomor_Urut = 1;
                                                        $sql = "SELECT sp.*, ds.NIS, ds.Nama_Lengkap, p.PeriodeID, s.SemesterID, s.SemesterStr1 FROM siswa_prestasi sp  
                                                                    INNER JOIN data_siswa ds ON ds.SiswaNID = sp.SiswaNID
                                                                    INNER JOIN periode p ON p.PeriodeNID = sp.PeriodeNID
                                                                    INNER JOIN semester s ON s.SemesterNID = sp.SemesterNID
                                                                    WHERE sp.Deleted = 0
                                                                    ORDER BY sp.PeriodeNID, sp.SemesterNID, ds.Nama_Lengkap
                                                                    ";
                                                        //echo $sql.";<br>";
                                                        $qry_Data_Siswa = mysqli_query($Connection, $sql);
                                                        while($buff_Data_Siswa = mysqli_fetch_array($qry_Data_Siswa))
                                                        {
                                                            $SiswaNID = $buff_Data_Siswa['SiswaNID'];
                                                            $PeriodeID = $buff_Data_Siswa['PeriodeID'];
                                                            $SemesterStr1 = $buff_Data_Siswa['SemesterStr1'];
                                                            $Kategori = $buff_Data_Siswa['Kategori'];
                                                            $Keterangan = $buff_Data_Siswa['Keterangan'];
                                                            $PrestasiNID = $buff_Data_Siswa['PrestasiNID'];


                                                            $NIS = $buff_Data_Siswa['NIS'];
                                                            $Nama_Lengkap = $buff_Data_Siswa['Nama_Lengkap'];
                                                            

                                                            ?>
                                                            <tr>
                                                                <td style="text-align:right"><?php echo $Nomor_Urut ?></td>
                                                                <td style="text-align:center"><?php echo $PeriodeID."<br>".$SemesterStr1 ?></td>
                                                                <td style="text-align:left"><?php echo $Nama_Lengkap."<br>".$NIS ?></td>
                                                                <td style="text-align:center"><?php echo $Kategori ?></td>
                                                                <td style="text-align:left"><?php echo nl2br($Keterangan)  ?></td>
                                                                <td style="text-align:center">
                                                                <?php
                                                                    if($Hak_Akses==1 || $Hak_Akses==9)
                                                                    {
                                                                        ?>
                                                                        <span style="padding-right:10px"><a href="prestasi_siswa.php?Action=Prestasi_Update&PrestasiNID=<?php echo $PrestasiNID ?>" title="Update prestasi siswa"><span ><i class="fa fa-pencil"></i></span></a></span>
                                                                        <span><a href="prestasi_siswa.php?Action=Prestasi_Hapus&PrestasiNID=<?php echo $PrestasiNID ?>" title="Hapus data prestasi siswa"><span ><i class="fa fa-trash-o"></i></span></a></span>
                                                                        <?php
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <span style="padding-right:10px"><span title="User tidak memiliki akses untuk melakukan update data"><i class="fa fa-pencil"></i></span></span>
                                                                        <span><span title="User tidak memiliki akses untuk melakukan menghapus data"><i class="fa fa-trash-o"></i></span></span>
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
        elseif($_GET['Action']=='Prestasi_Update' || $_GET['Action']=='Prestasi_Tambah')
        {
            

            $Action = $_GET['Action'];
            $Action = str_replace('&#39;',"'",$Action);
            $Action = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$Action));

            if($Action=="Prestasi_Tambah")
            {
                $SiswaNID = "";
                $Nama_Lengkap_Siswa = "";

                $PeriodeNID = $_SESSION['PeriodeNID_Aktif'];
                $SemesterNID = $_SESSION['SemesterNID_Aktif'];
                $Kategori = "";
                $Keterangan = "";

                $Creator = "";
                $Last_User = "";
                $Create_Date = "";
                $Last_Update = "";
            }
            else
            {
                $PrestasiNID = $_GET['PrestasiNID'];
                $PrestasiNID = str_replace('&#39;',"'",$PrestasiNID);
                $PrestasiNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$PrestasiNID));

                //Ambil data prestasi siswa
                $sql = "SELECT sp.*, ds.Nama_Lengkap FROM siswa_prestasi sp
                            INNER JOIN data_siswa ds ON ds.SiswaNID = sp.SiswaNID
                            WHERE sp.PrestasiNID = '".$PrestasiNID."'
                            ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);
                $buff = mysqli_fetch_array($qry);
                $Nama_Lengkap_Siswa = $buff['Nama_Lengkap'];
                $SiswaNID = $buff['SiswaNID'];
                $PeriodeNID = $buff['PeriodeNID'];
                $SemesterNID = $buff['SemesterNID'];
                $Kategori = $buff['Kategori'];
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
            $_SESSION['Parrent_Page'] = 'prestasi_siswa.php?Action=Daftar';
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
                                            <a href="prestasi_siswa.php?Action=Daftar" class="waves-effect"><i class="ti-back-left"></i><span> Kembali </span></a>
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
                                        <h4 class="page-title"><?php echo (($_GET['Action']=='Prestasi_Update')?"Update":"Tambah") ?> Data Prestasi <?php echo $Nama_Lengkap_Siswa ?></h4>
                                    </div>
                                </div>

                                <div class="page-content-wrapper ">

                                    <div class="container">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <form class="form-horizontal" name="form_tambah" action="prestasi_siswa.php" method="post" enctype="multipart/form-data">
                                                    <?php 
                                                    if($Action=="Prestasi_Tambah")
                                                    {
                                                        ?>
                                                        <input id='Prestasi_Siswa_Tambah' type="hidden" name="Action" value="Prestasi_Siswa_Tambah">
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <input id='Prestasi_Siswa_Update' type="hidden" name="Action" value="Prestasi_Siswa_Update">
                                                        <input id='PrestasiNID' type="hidden" name="PrestasiNID" value="<?php echo $PrestasiNID ?>">
                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="inputPeriodeID" class="col-sm-3 ">NIS</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT * FROM data_siswa ds
                                                                            WHERE ds.Tanggal_Keluar IS Null";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="SiswaNID" id="SiswaNID">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Current_SiswaNID = $buff['SiswaNID'];
                                                                        $NIS = $buff['NIS'];
                                                                        $Nama_Lengkap_Siswa = $buff['Nama_Lengkap'];
                                                                        if($Action=='Prestasi_Tambah')
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_SiswaNID ?>" ><?php echo $NIS."-".$Nama_Lengkap_Siswa ?></option>
                                                                            <?php    
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_SiswaNID ?>" <?php echo ($Current_SiswaNID==$SiswaNID)?"selected":"" ?>><?php echo $NIS."-".$Nama_Lengkap_Siswa ?></option>
                                                                            <?php    
                                                                        }
                                                                        
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPeriodeID" class="col-sm-3 ">Tahun Pelajaran</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT * FROM periode p";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                ?>
                                                                <select name="PeriodeNID" id="PeriodeNID">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Current_PeriodeNID = $buff['PeriodeNID'];
                                                                        $PeriodeID = $buff['PeriodeID'];
                                                                        if($Action=='Prestasi_Tambah')
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_PeriodeNID ?>" <?php echo ($_SESSION['PeriodeNID_Aktif']==$Current_PeriodeNID)?"selected":"" ?>><?php echo $PeriodeID ?></option>
                                                                            <?php    
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_PeriodeNID ?>" <?php echo ($Current_PeriodeNID==$PeriodeNID)?"selected":"" ?>><?php echo $PeriodeID ?></option>
                                                                            <?php    
                                                                        }
                                                                        
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputSemester" class="col-sm-3 ">Semester</label>
                                                            
                                                            <div class="col-sm-3 input-group date" >
                                                                <?php 
                                                                $sql = "SELECT * FROM semester s";
                                                                //echo $sql.";<br>";
                                                                $qry = mysqli_query($Connection, $sql);
                                                                
                                                                ?>
                                                                <select name="SemesterNID" id="SemesterNID">
                                                                    <?php
                                                                    while($buff = mysqli_fetch_array($qry))
                                                                    {
                                                                        $Current_SemesterNID = $buff['SemesterNID'];
                                                                        $SemesterID = $buff['SemesterStr2'];
                                                                        if($Action=='Prestasi_Tambah')
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_SemesterNID ?>" <?php echo ($_SESSION['SemesterNID_Aktif']==$Current_SemesterNID)?"selected":"" ?>><?php echo $SemesterID ?></option>
                                                                            <?php    
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $Current_SemesterNID ?>" <?php echo ($Current_SemesterNID==$SemesterNID)?"selected":"" ?>><?php echo $SemesterID ?></option>
                                                                            <?php    
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputkategori" class="col-sm-3 ">Kategori</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <input type="text" class="form-control pull-right" id="inputkategori" name="Kategori" value="<?php echo $Kategori ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputKeterangan" class="col-sm-3 ">Keterangan</label>
                                                            
                                                            <div class="col-sm-8 input-group date" >
                                                                <textarea class="form-control pull-right" id="inputKeterangan" name="Keterangan"><?php echo nl2br($Keterangan) ?></textarea>
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
        elseif($_GET['Action']=='Prestasi_Hapus')
        {
            
            $PrestasiNID = $_GET['PrestasiNID'];
            $PrestasiNID = str_replace('&#39;',"'",$PrestasiNID);
            $PrestasiNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$PrestasiNID));

            $sql = "SELECT sp.SiswaNID FROM siswa_prestasi sp
                        WHERE sp.PrestasiNID = '".$PrestasiNID."'
                        ";
            //echo $sql.";<br>";
            $qry = mysqli_query($Connection, $sql);
            $buff = mysqli_fetch_array($qry);
            $SiswaNID = $buff['SiswaNID'];
            
            //Ambil data prestasi siswa
            $sql = "UPDATE siswa_prestasi sp SET
                        sp.Deleted = 1,
                        sp.Last_User =  '".$Last_UserNID."'
                        WHERE sp.PrestasiNID = '".$PrestasiNID."'
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
        if($_POST['Action']=='Prestasi_Siswa_Update' || $_POST['Action']=='Prestasi_Siswa_Tambah')
        {
            $SiswaNID = $_POST['SiswaNID'];
            $SiswaNID = str_replace('&#39;',"'",$SiswaNID);
            $SiswaNID = mysqli_real_escape_string($Connection, str_replace('&#34;','"',$SiswaNID));

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
                            sp.SiswaNID = '".$SiswaNID."', 
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
                $sql = "INSERT INTO siswa_prestasi(SiswaNID, PeriodeNID, SemesterNID, Kategori, Keterangan, Creator, Create_Date, Last_User) VALUES 
                            ('$SiswaNID', '$PeriodeNID', '$SemesterNID', '$Kategori', '$Keterangan', '$Last_UserNID', now(), '$Last_UserNID') ";
                //echo $sql.";<br>";
                $qry = mysqli_query($Connection, $sql);

            }
            
            ?>
                <script>
                    window.location.href="prestasi_siswa.php?Action=Daftar";
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
                    window.location.href="prestasi_siswa.php?Action=Daftar";
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

