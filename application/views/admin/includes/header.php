<?php
clearstatcache();
$page_name = $this->router->fetch_class();
$action_name = $this->router->fetch_method();


if ($page_name != 'permission_decline') {
    $hashids = new Hashids\Hashids('the srh-ola user error');
} else {
    $hashids = new Hashids\Hashids('the srh-ola user error');
}


$ss_loged_in = FALSE;
if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
    $session_data = $this->session->userdata('srihertemp_admin_logged_in');
    $ss_loged_in = TRUE;
}
if ($ss_loged_in) {
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="shortcut icon" href="<?php echo base_url('site_assets') ?>/images/favicon.ico">
        <title><?php
            if (isset($page_title) && !empty($page_title)) {
                echo $page_title;
            } else {
                echo 'SRMC';
            }
            ?></title>
        <!-- theme dynamic css start -->
        <?php
        if (isset($loadthemecss) && is_array($loadthemecss) && !empty($loadthemecss)) {
            foreach ($loadthemecss as $css) {
                ?>
                <link rel="stylesheet" href="<?= base_url("themes/default") ?>/<?= $css ?>" type="text/css" />
                <?php
            }
        }
        ?>
        <!-- dynamic css start -->
        <?php
        if (isset($loadcss) && is_array($loadcss) && !empty($loadcss)) {
            foreach ($loadcss as $css) {
                ?>
                <link rel="stylesheet" href="<?= base_url("admin_assets") ?>/<?= $css ?>" type="text/css" />
                <?php
            }
        }
        ?>
        <script>
            var version = '3.3.0';
        </script>
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/dist/css/adminstyle.css">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/dist/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-ui/themes/base/jquery-ui.css">
<!--        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/plugins/material_plugins/css/mdb.min.css">-->

        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-ui/themes/base/theme.css">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/hover-master/css/hover.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-confirm/jquery-confirm.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/dist/css/skins/_all-skins.min.css">   
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="<?php echo base_url('admin_assets'); ?>/dist/fonts/font-style.css">

        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/jquery/dist/jquery.min.js"></script>
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-confirm/jquery-confirm.min.js"></script>

        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-ui/jquery-ui.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
            function isNumberKey(evt)
            {
                var charCode = (evt.which) ? evt.which : event.keyCode
                if (charCode > 31 && (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--        <script src="<?php echo base_url('admin_assets'); ?>/plugins/material_plugins/js/mdb.min.js"></script>-->
        <!-- FastClick -->
        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('admin_assets'); ?>/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="<?php echo base_url('admin_assets'); ?>/dist/js/pages/dashboard.js"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url('admin_assets'); ?>/dist/js/demo.js"></script>
        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/jquery-loading-overlay-master/loadingoverlay.min.js"></script>

        <?php
        if ($this->config->item('ga')) {
            ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-43955061-8"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'UA-43955061-8');
            </script>
            <?php
        }
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->




        <?php
        if (isset($loadjs) && is_array($loadjs) && !empty($loadjs)) {
            foreach ($loadjs as $js) {
                ?>
                <script type="text/javascript" src="<?= base_url("admin_assets") ?>/<?= $js ?>"></script>
                <?php
            }
        }
        ?>
        <!-- theme dynamic js start -->
        <?php
        if (isset($loadthemejs) && is_array($loadthemejs) && !empty($loadthemejs)) {
            foreach ($loadthemejs as $js) {
                ?>
                <script type="text/javascript" src="<?= base_url("themes/default") ?>/<?= $js ?>"></script>
                <?php
            }
        }
        ?>
        <?php
        if (isset($loadjsdataTable) && is_array($loadjsdataTable) && !empty($loadjsdataTable)) {
            foreach ($loadjsdataTable as $js) {
                ?>
                <script type="text/javascript" src="<?= base_url("admin_assets") ?>/<?= $js ?>"></script>
                <?php
            }
        }
        ?>
    </head>
    <body class="skin-blue sidebar-mini <?= ($page_name == 'dashboard') ? 'loadoverlaypar' : '' ?>">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url('admin'); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>S</b>O</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>SRMC</b> Admin</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <!--                            <li class="dropdown messages-menu">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-envelope-o"></i>
                                                                <span class="label label-success">4</span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="header">You have 4 messages</li>
                                                                <li>
                                                                     inner menu: contains the actual data 
                                                                    <ul class="menu">
                                                                        <li> start message 
                                                                            <a href="#">
                                                                                <div class="pull-left">
                                                                                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                                                </div>
                                                                                <h4>
                                                                                    Support Team
                                                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                                </h4>
                                                                                <p>Why not buy a new awesome theme?</p>
                                                                            </a>
                                                                        </li>
                                                                         end message 
                                                                        <li>
                                                                            <a href="#">
                                                                                <div class="pull-left">
                                                                                    <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                                                </div>
                                                                                <h4>
                                                                                    AdminLTE Design Team
                                                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                                                </h4>
                                                                                <p>Why not buy a new awesome theme?</p>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <div class="pull-left">
                                                                                    <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                                                </div>
                                                                                <h4>
                                                                                    Developers
                                                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                                                </h4>
                                                                                <p>Why not buy a new awesome theme?</p>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <div class="pull-left">
                                                                                    <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                                                                </div>
                                                                                <h4>
                                                                                    Sales Department
                                                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                                                </h4>
                                                                                <p>Why not buy a new awesome theme?</p>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <div class="pull-left">
                                                                                    <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                                                                </div>
                                                                                <h4>
                                                                                    Reviewers
                                                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                                                </h4>
                                                                                <p>Why not buy a new awesome theme?</p>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="footer"><a href="#">See All Messages</a></li>
                                                            </ul>
                                                        </li>-->
                            <!-- Notifications: style can be found in dropdown.less -->
                            <!--                            <li class="dropdown notifications-menu">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-bell-o"></i>
                                                                <span class="label label-warning">10</span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="header">You have 10 notifications</li>
                                                                <li>
                                                                     inner menu: contains the actual data 
                                                                    <ul class="menu">
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                                                                page and may cause design problems
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-users text-red"></i> 5 new members joined
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <i class="fa fa-user text-red"></i> You changed your username
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="footer"><a href="#">View all</a></li>
                                                            </ul>
                                                        </li>-->
                            <!-- Tasks: style can be found in dropdown.less -->
                            <!--                            <li class="dropdown tasks-menu">
                                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                <i class="fa fa-flag-o"></i>
                                                                <span class="label label-danger">9</span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li class="header">You have 9 tasks</li>
                                                                <li>
                                                                     inner menu: contains the actual data 
                                                                    <ul class="menu">
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Design some buttons
                                                                                    <small class="pull-right">20%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">20% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                         end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Create a nice theme
                                                                                    <small class="pull-right">40%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">40% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                         end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Some task I need to do
                                                                                    <small class="pull-right">60%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">60% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                         end task item 
                                                                        <li> Task item 
                                                                            <a href="#">
                                                                                <h3>
                                                                                    Make beautiful transitions
                                                                                    <small class="pull-right">80%</small>
                                                                                </h3>
                                                                                <div class="progress xs">
                                                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                                                                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                                        <span class="sr-only">80% Complete</span>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </li>
                                                                         end task item 
                                                                    </ul>
                                                                </li>
                                                                <li class="footer">
                                                                    <a href="#">View all tasks</a>
                                                                </li>
                                                            </ul>
                                                        </li>-->
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php
//                                            echo '<pre>';
//                                            print_r($ss_data);
//                                            echo '</pre>';
                                    if ($ss_data['role_type_name'] == 'Doctor') {
                                        ?>
                                        <img src="<?php echo base_url('admin_assets'); ?>/upload/doctor/<?php echo $ss_data['photo']; ?>" class="img-circle img-responsive user-image" alt="<?php echo $ss_data['name']; ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo base_url('admin_assets'); ?>/upload/employee_profile/<?php echo $ss_data['photo']; ?>" class="img-circle img-responsive user-image" alt="<?php echo $ss_data['name']; ?>">
                                        <?php
                                    }
                                    ?>
                                    <span class="hidden-xs"><?php echo $ss_data['name']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <?php
                                        if ($ss_data['role_type_name'] == 'Doctor') {
                                            ?>
                                            <img src="<?php echo base_url('admin_assets'); ?>/upload/doctor/<?php echo $ss_data['photo']; ?>" class="img-circle" alt="<?php echo $ss_data['name']; ?>">
                                            <?php
                                        } else {
                                            ?>
                                            <img src="<?php echo base_url('admin_assets'); ?>/upload/employee_profile/<?php echo $ss_data['photo']; ?>" class="img-circle" alt="<?php echo $ss_data['name']; ?>">
                                            <?php
                                        }
                                        ?>
                                        <p>
                                            <?php echo $ss_data['name']; ?> - <?php echo $ss_data['role_type_name']; ?>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <?php
                                        if ($ss_data['role'] != '1') {
                                            if ($profile_check) {
                                                ?>
                                                <div class="pull-left">
                                                    <a href="<?php echo base_url('admin'); ?>/user_profile/profile/<?php echo $hashids->encode($ss_data['id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>" class="btn btn-default btn-flat">Profile</a>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="pull-left">
                                                <a href="<?php echo base_url('admin'); ?>/user_profile/profile/<?php echo $hashids->encode($ss_data['id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="pull-right">
                                            <a href="<?php echo base_url('admin/dashboard/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <?php
                            if ($ss_data['role'] == '1') {
                                ?>
                                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </nav>
            </header>