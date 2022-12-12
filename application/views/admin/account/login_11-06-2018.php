<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SRH-OLA</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('admin_assets'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('admin_assets'); ?>/bower_components/font-awesome.min.css" rel="stylesheet">        
        <link href="<?php echo base_url('admin_assets'); ?>/dist/css/login.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="lib/html5shiv.min.js"></script>
          <script src="lib/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="admin_body">        
        <!-- content start -->
        <div class="content_area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">
                        <div class="form-header">
                            <h1>Admin Login</h1>
                        </div>
                        <div class="form-main">                            
                            <?php                            
                            $attributes = array('class' => 'loginform', 'id' => 'login', 'name' => 'login');
                            if (empty($inputs)) {
                                echo form_open('admin/verifylogin', $attributes);
                            } else {
                                echo form_open('admin/verifypin', $attributes);
                            }
                            ?>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-lg-12"><input type="text" class="form-control txt_box" id="txtEmail" name="txtEmail" placeholder="Email" <?php if (!empty($inputs)) { ?>value="<?= $inputs['email'] ?>"readonly="readonly"<?php } ?>></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-lg-12"><input type="password" class="form-control txt_box" id="txtPassword" name="txtPassword" placeholder="Password" <?php if (!empty($inputs)) { ?>value="<?= $inputs['password'] ?>"readonly="readonly"<?php } ?>></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-lg-12">                                                
                                        <input type="submit" name="submit" id="submit" value="Login" class="signin btn btn-block" onClick="return validateLogin(document.login)" <?php if (!empty($inputs)) { ?>disabled="disabled"<?php } ?> />                                        
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($inputs)) { ?>
                                <div class="form-group">
                                    <div class="row">                                        
                                        <div class="col-lg-12"><input autofocus  type="password" name="txtSecurePin" placeholder="Secure Pin" onKeyPress="return runScript(event)" id="txtSecurePin" class="txtbox form-control" maxlength="6" /></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">                                        
                                        <div class="col-lg-12"><input type="submit"  id="submitpin" name="submitpin" value="Proceed"  class="signin btn btn-block" onClick="return validatePin(document.login)" /></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if (validation_errors() != '') {
                                ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4">&nbsp;</div>
                                        <div class="col-lg-8">
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
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </div>
        <!-- content end -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script type="text/javascript">
            var base = "<?php echo base_url(''); ?>";
        </script>
        <script src="<?php echo base_url('admin_assets'); ?>/bower_components/jquery/dist/lib/jquery.min.js"></script>        
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <link href="<?php echo base_url('admin_assets'); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js" rel="stylesheet">
        <script src="<?php echo base_url('admin_assets'); ?>/js/admin/loginvalidation.js"></script>        
    </body>
</html>