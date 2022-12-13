<?php
$CI = &get_instance();
$CI->load->model('admin/student_model');
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/studentdata'); ?>/view">Student Data</a></li>
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
                    echo form_open_multipart('admin/studentdata/create', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="studentdata_name" class="col-lg-2 control-label">Student Receipt Data ( CSV )</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="form-control" id="studentdata_name" accept=".csv" placeholder="Role Type Name" name="studentdata_file">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-4">
                                        <input type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary hvr-bounce-out" value="Upload">
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
    <section class="content-header">
        <h1>
            Uploaded Receipt Data
        </h1>

    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Total Receipt</th>
                            <th>Receipt Sent Successfully</th>
                            <th>Uploaded Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($excel_data)) {
                            foreach ($excel_data as $list) {
                                $res =  $this->student_model->get_total_receipt_count($list['excel_details_id']);
                                $receipt_count = 0;
                                if (!empty($res)) {
                                    $receipt_count = count($res);
                                }
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['orig_name']; ?></td>
                                    <td><?php echo $list['file_size']; ?></td>
                                    <td><?= $receipt_count; ?></td>
                                    <td><?php echo $list['sent_count']; ?></td>
                                    <td><?php echo date('d-M-Y H:i', strtotime($list['uploaded_date'])); ?></td>
                                    <td>
                                        <?php
                                        if (intval($list['sent_count']) < $receipt_count) {
                                        ?>
                                            <a href="javascript:void(0);" data-excelid="<?= $list['excel_details_id'] ?>" class="btn btn-primary send_receipt_details">Send Receipt Details</a>
                                    </td>
                                <?php

                                        }
                                ?>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
    </section>
    <!-- section end-->
</div>
<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#example').dataTable();
        $('body').on('click', '.send_receipt_details', function() {
            var _this = $(this);
            var excelid = $(this).attr('data-excelid');
            $.ajax({
                method: "POST",
                url: "<?= base_url('admin/studentdata') ?>/ajax_send_receipt",
                data: {
                    excelid: excelid
                },
                dataType: 'json',
                success: function(msg) {
                    if (msg != false) {
                        _this.remove();
                        $.confirm({
                            title: 'Congratulations!!',
                            content: 'Successfully Sent to ' + msg.success + ' Users. <br>' + 'Total Failure Count ' + msg.failure,
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                                ok: function() {}
                            }
                        });
                    } else {
                        _this.html('').html('Send Receipt Details');
                        $.confirm({
                            title: 'Encountered an error!',
                            content: 'Something went wrong pleae try again',
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                ok: function() {}
                            }
                        });
                    }
                },
                beforeSend: function(msg) {
                    _this.html('').html('wait..');
                }
            });
        });
    });
</script>