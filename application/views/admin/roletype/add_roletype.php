
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/roletype'); ?>/view">Role Group</a></li>
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
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open('admin/roletype/create', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <?php
                                if (!empty($role_group_list)) {
                                    ?>
                                    <div class="form-group">
                                        <label for="roletype_name" class="col-lg-2 control-label">Role Group Name</label>
                                        <div class="col-lg-4">
                                            <select class="form-control select2" name="slt_role_grp" id="slt_role_grp">
                                                <option value="0">Select Role</option>
                                                <?php
                                                foreach ($role_group_list as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['role_group_id']; ?>" <?php echo set_select('slt_role_grp', $value['role_group_id']); ?>><?php echo $value['role_group_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="form-group">
                                    <label for="roletype_name" class="col-lg-2 control-label">Role Type Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="roletype_name" placeholder="Role Type Name" name="roletype_name" value="<?php echo set_value('roletype_name'); ?>">
                                    </div>
                                </div>                  
                                <div class="form-group">                                    
                                    <div class="col-lg-offset-2 col-lg-4">
                                        <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary hvr-bounce-out" value="Add" >
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
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>