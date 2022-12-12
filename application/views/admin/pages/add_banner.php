
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/banner'); ?>/view">Banner</a></li>
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
                    echo form_open_multipart('admin/banner/create', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="banner_name" class="col-lg-2 control-label">Banner Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="banner_name" placeholder="Banner Name" name="banner_name" value="<?php echo set_value('banner_name'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="banner_heading" class="col-lg-2 control-label">Banner Title Text</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="banner_heading" placeholder="Banner Title Text" name="banner_heading" value="<?php echo set_value('banner_heading'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="banner_desc" class="col-lg-2 control-label">Banner Description</label>
                                    <div class="col-lg-4">
                                        <textarea class="form-control" name="banner_desc" id="banner_desc" placeholder="Banner Description"><?php echo set_value('banner_desc'); ?></textarea>                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="banner_link" class="col-lg-2 control-label">Banner Link</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="banner_link" placeholder="Banner Link" name="banner_link" value="<?php echo set_value('banner_link'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="banner_desc_link" class="col-lg-2 control-label">Banner Desc Link</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="banner_desc_link" placeholder="Banner Desc Link" name="banner_desc_link" value="<?php echo set_value('banner_desc_link'); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="slider_range_date" class="col-lg-2 control-label">Slider Date Range</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="slider_range_date" placeholder="Slider Date Range" name="slider_range_date" value="<?php echo set_value('slider_range_date'); ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="slider_image" class="col-lg-4 control-label">Slider Image</label>
                                            <div class="col-lg-8">
                                                <div class="file-loading">
                                                    <label>Preview File Icon</label>
                                                    <input id="slider_image" type="file" multiple name="slider_image[]">
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
        //$('.select2').select2();
        $(function () {
            $('input[name="slider_range_date"]').daterangepicker();
        });
        $("#slider_image").fileinput({
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
</script>