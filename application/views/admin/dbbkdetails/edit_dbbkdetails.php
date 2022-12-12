<?php
$hashids = new Hashids\Hashids('the sriher dbbkdetails error');
?>
<div class="content-wrapper">
    <section class="content-header">        
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/dbbkdetails'); ?>/view">Data Base Back Up</a></li>
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
                    $dbbkdetails_id = $hashids->encode($dbbkdetails_data['dbbkdetails_id'], dateintval('d'), dateintval('m'), dateintval('y'));
                    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
                    echo form_open('admin/dbbkdetails/edit/' . $dbbkdetails_id, $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <?php
                                if (!empty($project_list)) {
                                    ?>
                                    <div class="form-group">
                                        <label for="fk_project_id" class="col-lg-2 control-label">Select Project</label>
                                        <div class="col-lg-4 department">
                                            <select class="form-control select2" name="fk_project_id" id="fk_project_id">
                                                <option value="">Select Project</option>
                                                <?php
                                                foreach ($project_list as $value) {
                                                    ?>
                                                    <option value="<?php echo $value['project_id']; ?>" <?php echo set_select('project_id', $value['project_id'], ($value['project_id'] == $dbbkdetails_data['fk_project_id']) ? true : false); ?>><?php echo $value['project_name']; ?></option>
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
                                    <label for="db_name" class="col-lg-2 control-label">DataBase Name</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="db_name" placeholder="DataBase Name" name="db_name" value="<?php echo $dbbkdetails_data['db_name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="db_path" class="col-lg-2 control-label">DataBase Path</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="db_path" placeholder="DataBase Path" name="db_path" value="<?php echo $dbbkdetails_data['db_path']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">                                    
                                    <div class="col-lg-offset-2 col-lg-4">
                                        <button type="submit" id="btn_submit" class="btn btn-primary hvr-bounce-out">Edit</button>
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
