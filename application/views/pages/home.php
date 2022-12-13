<?php
$CI = & get_instance();
$CI->load->model('receipt_model');
?>
<div class="container">
    <h3 class="pt-2 pb-3"><u>Login</u></h3>
    <div class="row">
        <div class="col-4">
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
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
            echo form_open('home', $attributes);
            ?>
            <div class="mb-3">
                <label for="student_reg_no" class="form-label">Registration Number </label>
                <input type="text" class="form-control" id="student_reg_no" name="student_reg_no" required="" placeholder="Registration No">
            </div>
            <div class="mb-3">
                <label for="receipt_no" class="form-label">Receipt No / DOB</label>
                <input type="text" class="form-control" id="receipt_no" name="receipt_no" placeholder="Receipt No / DOB">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <?php
            echo form_close();
            ?>
        </div>

    </div>

</div>
