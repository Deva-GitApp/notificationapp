<?php
$hashids = new Hashids\Hashids('the srh-ola user error');
$this->load->library('usersupport');
$employee_password = $this->usersupport->encrypt_decrypt('decrypt', $employee_data['password']);
?>
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/doctor'); ?>/view">Doctor</a></li>
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
                    $doctor_id = $hashids->encode($ss_data['id'], dateintval('d'), dateintval('m'), dateintval('y'));
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open_multipart('admin/user_profile/profile/' . $doctor_id, $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-6">                        
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="employee_name" class="col-lg-4 control-label">Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="employee_name" placeholder="Name" name="employee_name" value="<?php echo $employee_data['name']; ?>">
                                    </div>
                                </div>
                                <?php
                                if (!empty($department_list)) {
                                    ?>
                                    <div class="form-group">
                                        <label for="slt_department" class="col-lg-4 control-label">Select Department</label>
                                        <div class="col-lg-8 department">
                                            <select class="form-control select2" name="slt_department" id="slt_department">
                                                <option value="0">Select Department</option>
                                                <?php
                                                foreach ($department_list as $value) {
                                                    ?>
                                                    <option  value="<?php echo $value['department_id']; ?>" <?php echo set_select('slt_role', $value['department_id'], ($employee_data['fk_department_id'] == $value['department_id']) ? TRUE : ''); ?>><?php echo $value['department_name']; ?></option>
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
                                    <label for="employee_id" class="col-lg-4 control-label">Id</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="employee_id" placeholder="Id" name="employee_id" value="<?php echo $employee_data['employee_id']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_email" class="col-lg-4 control-label">Email</label>
                                    <div class="col-lg-8">
                                        <input type="email" class="form-control" id="employee_email" placeholder="Email" name="employee_email" value="<?php echo $employee_data['email']; ?>">
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label for="employee_sec_pin" class="col-lg-4 control-label">Secure Pin</label>
                                    <div class="col-lg-8">
                                        <input type="password" class="form-control" id="employee_sec_pin" placeholder="Secure Pin" name="employee_sec_pin" value="<?php echo $employee_data['user_pin']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_mobile" class="col-lg-4 control-label">Mobile</label>
                                    <div class="col-lg-8">
                                        <input type="tel" class="form-control" id="employee_mobile" placeholder="Mobile" name="employee_mobile" value="<?php echo $employee_data['mobile']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_password" class="col-lg-4 control-label">Password</label>
                                    <div class="col-lg-8">
                                        <input type="tel" class="form-control" id="employee_mobile" placeholder="Password" name="employee_password" value="<?php echo $employee_password; ?>">
                                    </div>
                                </div>
                                <div class="form-group ui-widget">
                                    <label for="employee_piconde" class="col-lg-4 control-label">Pincode</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="employee_piconde" placeholder="Pincode" name="employee_piconde" value="<?php echo $employee_data['pincode']; ?>">
                                        <input type="hidden" name="emp_pincode" id="emp_pincode" value="<?php echo $employee_data['pincode']; ?>">
                                        <input type="hidden" name="country" id="country" value="<?php echo $employee_data['country']; ?>">
                                        <input type="hidden" name="state" id="state" value="<?php echo $employee_data['state']; ?>">
                                        <input type="hidden" name="district" id="district" value="<?php echo $employee_data['city']; ?>">
                                        <input type="hidden" name="geolocationid" id="geolocationid" value="<?php echo $employee_data['geolocation_id']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employee_address" class="col-lg-4 control-label">Address</label>
                                    <div class="col-lg-8">
                                        <textarea class="form-control" id="employee_address" placeholder="Address" name="employee_address"><?php echo $employee_data['address']; ?></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="roletype_name" class="col-lg-4 control-label">Profile</label>
                                            <div class="col-lg-8">
                                                <div class="file-loading">
                                                    <label>Preview File Icon</label>
                                                    <?php
                                                    if ($role_name['role_type_name'] == 'Doctor') {
                                                        ?>
                                                        <input id="user_profile" type="file" multiple name="user_profile[]" value="<?php echo base_url('admin_assets/upload') . '/doctor/' . $employee_data['photo']; ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <input id="user_profile" type="file" multiple name="user_profile[]" value="<?php echo base_url('admin_assets/upload') . '/employee_profile/' . $employee_data['photo']; ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($role_name['role_type_name'] == 'Doctor') {
                            ?>
                            <div class="col-md-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="doctor_designation" class="col-lg-4 control-label">Designation</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="doctor_designation" placeholder="Designation" name="doctor_designation" value="<?php echo $employee_data['doctor_designation']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="doctor_qualification" class="col-lg-4 control-label">Qualification</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="doctor_qualification" placeholder="Qualification" name="doctor_qualification" value="<?php echo $employee_data['doctor_qualification']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="doctor_experience" class="col-lg-4 control-label">Experience</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="doctor_experience" placeholder="Experience" name="doctor_experience" value="<?php echo $employee_data['doctor_experience']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="doc_description" class="col-lg-4 control-label">Description</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" id="doc_description" placeholder="Description" name="doc_description"><?php echo $employee_data['doctor_desc']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="doctor_experience" class="col-lg-4 control-label">Gender</label>
                                        <div class="col-lg-8 error-validate">
                                            <label>
                                                <input type="radio" name="doc_gender" id="doc_gender_ma" value="M" class="minimal" <?php echo set_radio('doc_gender', 'F', ($employee_data['doctor_gender'] == 'M') ? TRUE : ''); ?>> Male
                                            </label>
                                            &nbsp;&nbsp;
                                            <label>
                                                <input type="radio" name="doc_gender" id="doc_gender_fe" value="F" class="minimal" <?php echo set_radio('doc_gender', 'M', ($employee_data['doctor_gender'] == 'F') ? TRUE : ''); ?>> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                    </div>
                    <div class="row">
                        <div class="col-lg-offset-4 col-md-6">
                            <div class="form-group">                                    
                                <div class=" col-lg-4">
                                    <input type="hidden" name="slt_role" id="slt_role" value="<?= $employee_data['fk_roletype_id'] ?>">
                                    <input id="user_profile_hid" type="hidden" name="user_profile_hid" value="<?php echo $employee_data['photo']; ?>">
                                    <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary hvr-bounce-out" value="Update" >
                                    <input type="reset" name="btn_reset" id="btn_reset" class="btn btn-default hvr-bounce-out" value="Reset">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
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
        $('input[type="radio"].minimal').iCheck({
            radioClass: 'iradio_minimal-blue'
        })
        //$('.select2').select2();
        var img_url;
<?php
if (!empty($employee_data['photo'])) {
    if ($role_name['role_type_name'] == 'Doctor') {
        ?>

                img_url = "<?php echo base_url('admin_assets/upload'); ?>/doctor/<?php echo $employee_data['photo']; ?>";
        <?php
    } else {
        ?>
                        img_url = "<?php echo base_url('admin_assets/upload'); ?>/employee_profile/<?php echo $employee_data['photo']; ?>";
        <?php
    }
} else {
    ?>
                            img_url = "<?php echo base_url('admin_assets/doctor'); ?>/no-image.jpg";
    <?php
}
?>
                        //$('.select2').select2();
                        $("#user_profile").fileinput({
                            initialPreview: [img_url],
                            initialPreviewAsData: true,
                            showUpload: false,
                            showCaption: false,
                            allowedFileExtensions: ['jpg', 'png', 'gif'],
                            overwriteInitial: true,
                            maxFileSize: 1000,
                            slugCallback: function (filename) {
                                return filename.replace('(', '_').replace(']', '_');
                            }
                        });
                        $("#user_profile").change(function () {
                            $('#user_profile_hid').val('').val($(this).val())
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
