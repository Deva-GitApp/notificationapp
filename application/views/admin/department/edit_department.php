<?php
$hashids = new Hashids\Hashids('the sriher department error');
?>
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/department'); ?>/view">Department</a></li>
        </ol>
    </section>              
    <!-- section start -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header with-border">

                        <?php
                        if (validation_errors() != '' || $this->session->flashdata('db_error') != '') {
                            ?> 
                            <div class="form-group has-error">
                                <label for="inputError" class="control-label">                                    
                                    <?php echo $this->session->flashdata('db_error'); ?>
                                    <?php echo validation_errors('<i class="fa fa-times-circle-o"></i> '); ?>
                                </label>                            
                            </div>
                            <?php
                        }
                        if ($this->session->flashdata('db_sucess') != '') {
                            ?>
                            <div class="form-group has-success">
                                <label for="inputSuccess" class="control-label">
                                    <i class="fa fa-check"></i> 
                                    <?php echo $this->session->flashdata('db_sucess'); ?>
                                </label>                                
                            </div>
                            <?php
                        }
                        ?>     
                    </div>
                    <?php
                    $department_id = $hashids->encode($department_data['department_id'], dateintval('d'), dateintval('m'), dateintval('y'));
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open_multipart('admin/department/edit/' . $department_id, $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="department_name" class="col-lg-2 control-label">Department Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="department_name" placeholder="Department Name" name="department_name" value="<?php echo $department_data['department_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="department_code" class="col-lg-2 control-label">Department Code</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="department_code" placeholder="Department Code" name="department_code" value="<?php echo $department_data['department_code']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="department_week" class="col-lg-2 control-label">Department Week</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="department_week" placeholder="Department Week" name="department_week" value="<?php echo $department_data['department_week']; ?>">

                                    </div>
                                </div>

                                <div class="form-group">                                    
                                    <div class="col-lg-offset-2 col-lg-4">                                        
                                        <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary hvr-bounce-out" value="Update" >
                                        <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-default hvr-bounce-out" value="Reset">
                                    </div>
                                </div>
                                <?php
                                echo form_close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end-->                                
</div>      
<!-- content end -->
