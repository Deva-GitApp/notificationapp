
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SRIHER</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?= base_url('admin_assets') ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('admin_assets') ?>/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= base_url('admin_assets') ?>/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('admin_assets') ?>/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('admin_assets') ?>/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                Admin
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>


                <?php
                $attributes = array('class' => 'loginform', 'id' => 'login', 'name' => 'login');
                if (empty($inputs)) {
                    echo form_open('admin/verifylogin', $attributes);
                } else {
                    echo form_open('admin/verifypin', $attributes);
                }
                ?>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email ID" <?php if (!empty($inputs)) { ?>value="<?= $inputs['email'] ?>"readonly="readonly"<?php } ?>>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password" <?php if (!empty($inputs)) { ?>value="<?= $inputs['password'] ?>"readonly="readonly"<?php } ?>>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <?php if (empty($inputs)) { ?>
                    <div class="btn-hid">
                        <input type="submit" name="submit" id="submit" value="Login" class="submit-btn admn-dis btn btn-primary btn-flat" onClick="return validateLogin(document.login)" <?php if (!empty($inputs)) { ?>disabled="disabled"<?php } ?> />                                        
    <!--                            <span class="submit-btn admn-dis">Log in</span>-->
                    </div>
                <?php } ?>
                <?php if (!empty($inputs)) { ?>
                    <div class="btn-shw" style="padding-top: 15px; display: block">
                        <span class="frm-titile">Security PIN</span>                                
                        <input autofocus class="form-control"  type="password" name="txtSecurePin" placeholder="Security Pin" onKeyPress="return runScript(event)" id="txtSecurePin" class="frm-inpt" maxlength="6" />
                        <br>
                        <input type="submit" id="submitpin" name="submitpin" value="Proceed" class="submit-btn btn btn-primary btn-block btn-flat" onClick="return validatePin(document.login)">
                    </div>
                <?php } ?>
                <?php
                if (validation_errors() != '') {
                    ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <br>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                    echo validation_errors();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?= base_url('admin_assets') ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url('admin_assets') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url('admin_assets') ?>/plugins/iCheck/icheck.min.js"></script>

</body>
</html>