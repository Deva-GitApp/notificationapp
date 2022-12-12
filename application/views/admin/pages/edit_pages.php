<?php
$hashids = new Hashids\Hashids('the srh-ola pages error');
?>
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/pages'); ?>/view">Pages</a></li>
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
                    $pages_id = $hashids->encode($pages_data['page_id'], dateintval('d'), dateintval('m'), dateintval('y'));
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open_multipart('admin/pages/edit/' . $pages_id, $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="page_name" class="col-lg-2 control-label">Page Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="page_name" placeholder="Pages Name" name="page_name" value="<?php echo $pages_data['page_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="page_icon_class" class="col-lg-2 control-label">Menu Icons Class</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="page_icon_class" placeholder="Menu Icons Class" name="page_icon_class" value="<?php echo $pages_data['menu_icon_class']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="page_priority" class="col-lg-2 control-label">Menu Priority</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="page_priority" placeholder="Menu Priority" name="page_priority" value="<?php echo $pages_data['menu_priority']; ?>">
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
