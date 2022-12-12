<?php
$user_session_data = $this->session->userdata('srihertemp_user_logged_in');

$class_name = $this->router->fetch_class(); // for controller
$method_name = $this->router->fetch_method();
?>

<section class="menu" style="background-color: #eaecec;">
    <div class="container">
        <nav class="navbar navbar-expand-lg" style="width:100%;">
            <div class="container-fluid">
                <!--                        <a class="navbar-brand" href="javascript:void(0)">Menu</a>-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav navbar-expand-lg mb-2">
                        <li class="nav-item">
                            <a class="nav-link <?= ($class_name == 'home' && $method_name == 'dashboard') ? 'active' : '' ?>" aria-current="page" href="<?= base_url('dashboard') ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($class_name == 'pages' && $method_name == 'receipt') ? 'active' : '' ?>" href="<?= base_url('receipt') ?>">Receipt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($class_name == 'pages' && $method_name == 'notification') ? 'active' : '' ?>" href="<?= base_url('notification') ?>">Notification</a>
                        </li>                                
                        <li class="nav-item">
                            <a class="nav-link <?= ($class_name == 'pages' && $method_name == 'hallticket') ? 'active' : '' ?>" href="<?= base_url('hallticket') ?>">Hall Ticket</a>
                        </li>                                


                    </ul>



                </div>
                <a class="justify-content-end text-center" style="float:right" href="<?= base_url('home/logout') ?>"> <?= $user_session_data['student_name'] ?><br> <i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
            </div>
        </nav>
    </div>
</section>