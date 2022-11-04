<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security Guard Tour</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/assets/dist/img/logo.jpeg">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- jQuery -->
    <script src="<?= base_url('assets') ?>/dist/js/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets') ?>/dist/js/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <!-- pagination freeze -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item mr-2">
                    <span class="font-italic font-bold">Welcome <?= $this->session->userdata('name') ?></span>
                </li>
                <li class="nav-item">
                    <a class=" btn btn-sm btn-info" href="<?= base_url('Logout') ?>">
                        <i class="fas fa-user"></i> LOGOUT
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- <aside class="main-sidebar sidebar-dark-primary elevation-4"> -->
        <aside class="main-sidebar sidebar-dark-info elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('assets') ?>/index3.html" class="brand-link">
                <img src="<?= base_url('assets') ?>/dist/img/logo.jpeg" alt="AdminLTE Logo" style='margin-left:2px' class="brand-image img-square elevation-5" style="opacity: .8">

                <label style="margin-left:-5px" class="brand-text font-bold font-weight-light"><b>Astra Daihatsu Motor</b></label>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('assets') ?>/dist/img/security.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">GUARD PATROL</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item ">
                            <a href="<?= base_url('Dashboard') ?>" class="nav-link
                            <?php if ($link == 'Dashboard' || $link == '') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-tachometer-alt "></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Mst_Company') ?>" class="nav-link
                            <?php if ($link == 'Mst_Company') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Master Company
                                </p>
                            </a>
                        </li>
                        <li class="nav-item 
                        <?php if (
                            $link == 'Mst_Role' || $link == 'Mst_Site' || $link == 'Mst_Plant' || $link == 'Mst_Zona' || $link == 'Mst_Checkpoint' || $link == 'Mst_objek'
                            || $link == 'Mst_Kategori_Object' || $link == 'Mst_Event' || $link == 'Mst_user' || $link == 'FormMenu' || $link == 'Mst_Periode' || $link == 'Mst_Shift' || $link == 'Mst_Periode' || $link == 'Mst_Produksi'
                        ) {
                            echo 'menu-open';
                        } ?> ">
                            <a href="#" class="nav-link
                            <?php if ($link == 'Mst_Site' || $link == 'Mst_Plant' || $link == 'Mst_Zona' || $link == 'Mst_objek' || $link == 'Mst_Kategori_Object' || $link == 'Event' || $link == 'Mst_Role' || $link == 'FormMenu' || $link == 'Mst_Periode' || $link == 'Mst_Shift' || $link == 'Mst_Periode' ||  $link == 'Mst_Produksi' || $link == 'Mst_Produksi') {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Site') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Site') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Wilayah</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" <?= base_url('Mst_Plant') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Plant') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Plant</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" <?= base_url('Mst_Zona') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Zona') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Zona</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" <?= base_url('Mst_Checkpoint') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Checkpoint') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Check Point</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href=" <?= base_url('Mst_objek') ?>" class="nav-link
                                    <?php if ($link == 'Mst_objek') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Objek</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href=" <?= base_url('Mst_Kategori_Object') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Kategori_Object') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Kategori Objek</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Event') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Event') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Event</p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Periode') ?>" class="nav-link 
                                    <?php if ($link == 'Mst_Periode') {
                                        echo 'active';
                                    } ?>">
                                        <i class=" far fa-circle nav-icon"></i>
                                        <p>Master Periode Patroli</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Shift') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Shift') {
                                        echo 'active';
                                    } ?>">
                                        <i class=" far fa-circle nav-icon"></i>
                                        <p>Master Shift</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Produksi') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Produksi') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Produksi</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_user') ?>" class="nav-link
                                    <?php if ($link == 'Mst_user') {
                                        echo ' active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Role') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Role') {
                                        echo ' active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Role User</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item
                        <?php if (
                            $link == 'Upload_Jadwal' || $link == 'Mst_Jadwal' || $link == 'Mst_Jadwal_Produksi'
                        ) {
                            echo 'menu-open';
                        } ?>">
                            <a href="#" class="nav-link
                            <?php if (
                                $link == 'Upload_Jadwal' || $link == 'Mst_Jadwal' || $link == 'Mst_Jadwal_Produksi'
                            ) {
                                echo 'active';
                            } ?>">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>
                                    Jadwal
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Jadwal') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Jadwal') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jadwal Patroli</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Mst_Jadwal_Produksi') ?>" class="nav-link
                                    <?php if ($link == 'Mst_Jadwal_Produksi') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jadwal Produksi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('Upload_Jadwal') ?>" class="nav-link
                                    <?php if ($link == 'Upload_Jadwal') {
                                        echo 'active';
                                    } ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Upload Jadwal</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Patroli</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Temuan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
