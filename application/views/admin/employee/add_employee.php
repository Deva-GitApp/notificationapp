
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/employee'); ?>/view">Employee</a></li>
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
                    echo form_open_multipart('admin/employee/create', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="employee_name" placeholder="Employee Name" name="employee_name" value="<?php echo set_value('employee_name'); ?>">
                                    </div>
                                </div>
                                <?php
                                if (!empty($department_list)) {
                                    ?>
                                    <div class="form-group">
                                        <label for="slt_department" class="col-lg-2 control-label">Select Department</label>
                                        <div class="col-lg-4 department">
                                            <select class="form-control select2" name="slt_department" id="slt_department">
                                                <option value="0">Select Department</option>
                                                <?php
                                                foreach ($department_list as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['department_id']; ?>" <?php echo set_select('slt_role', $value['department_id']); ?>><?php echo $value['department_name']; ?></option>
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
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Id</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="employee_id" placeholder="Employee Id" name="employee_id" value="<?php echo set_value('employee_id'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Email</label>
                                    <div class="col-lg-4">
                                        <input type="email" class="form-control" id="employee_email" placeholder="Employee Email" name="employee_email" value="<?php echo set_value('employee_email'); ?>">
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Secure Pin</label>
                                    <div class="col-lg-4">
                                        <input type="password" class="form-control" id="employee_sec_pin" placeholder="Employee Secure Pin" name="employee_sec_pin" value="<?php echo set_value('employee_sec_pin'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Mobile</label>
                                    <div class="col-lg-4">
                                        <input type="tel" class="form-control" id="employee_mobile" placeholder="Employee Mobile" name="employee_mobile" value="<?php echo set_value('employee_mobile'); ?>">
                                    </div>
                                </div>
                                <div class="form-group ui-widget">
                                    <label for="roletype_name" class="col-lg-2 control-label">Employee Pincode</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="employee_piconde" placeholder="Employee Pincode" name="employee_piconde" value="<?php echo set_value('employee_piconde'); ?>">
                                        <input type="hidden" name="emp_pincode" id="emp_pincode">
                                        <input type="hidden" name="country" id="country">
                                        <input type="hidden" name="state" id="state">
                                        <input type="hidden" name="district" id="district">
                                        <input type="hidden" name="geolocationid" id="geolocationid">
                                        <input type="hidden"  id="employee_password" name="employee_password" value="srhola">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_address" class="col-lg-2 control-label">Employee Address</label>
                                    <div class="col-lg-4">
                                        <textarea class="form-control" id="employee_address" placeholder="Employee Mobile" name="employee_address"><?php echo set_value('employee_address'); ?></textarea>
                                    </div>
                                </div>
                                <?php
                                if (!empty($role_type_list)) {
                                    ?>
                                    <div class="form-group">
                                        <label for="roletype_name" class="col-lg-2 control-label">Select Role</label>
                                        <div class="col-lg-4 role_slt">
                                            <select class="form-control select2" name="slt_role" id="slt_role">
                                                <option value="0">Select Role</option>
                                                <?php
                                                foreach ($role_type_list as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['role_type_id']; ?>" <?php echo set_select('slt_role', $value['role_type_id']); ?>><?php echo $value['role_type_name']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="roletype_name" class="col-lg-4 control-label">Employee Profile</label>
                                            <div class="col-lg-8">
                                                <div class="file-loading">
                                                    <label>Preview File Icon</label>
                                                    <input id="user_profile" type="file" multiple name="user_profile[]">
                                                </div>
                                            </div>
                                        </div>
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
        $("#user_profile").fileinput({
            // theme: 'fa',
            showUpload: false,
            showCaption: false,
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize: 1000,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });
    });
    $('#employee_piconde').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?php echo base_url('admin/autocomplete/get_picode_details') ?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        return item;
                    }));
                }
            });
        },
        minLength: 3,
        select: function (event, ui) {
            $('#emp_pincode').val('').val(ui.item.pincode);
            $('#country').val('').val(ui.item.country);
            $('#state').val('').val(ui.item.state);
            $('#district').val('').val(ui.item.district);
            $('#geolocationid').val('').val(ui.item.geo_location_id);
        }
    });
</script>
