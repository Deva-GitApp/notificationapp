<?php

//use Spipu\Html2Pdf\Tag\Html\Em;

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
            <li class="active"><a href="<?php echo base_url('admin/studenthallticket'); ?>/view">Student hall Ticket Data</a></li>
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
                    echo form_open_multipart('admin/studenthallticket/create', $attributes);
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="studenthallticket_name" class="col-lg-2 control-label">Student Hall Ticket Data ( CSV )</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="form-control" id="studenthallticket_name" accept=".csv" name="studenthallticket_file">
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
            Uploaded Hall Ticket Data
        </h1>

    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="student_preview" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>File Name</th>
                            <th>File Size</th>
                            <th>Total Halltickets</th>
                            <th>Halltickets Sent Successfully</th>
                            <th>Uploaded Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($excel_data)) {
                            foreach ($excel_data as $list) {
                                $hallticketdata = $CI->student_model->get_totalhallticket_count($list['excel_details_id']);
                                if (!empty($hallticketdata)) {
                                    $hallticketdata = $hallticketdata;
                                } else {
                                    $hallticketdata = array();
                                }
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['orig_name']; ?></td>
                                    <td><?php echo $list['file_size']; ?></td>
                                    <td><?php echo count($hallticketdata); ?></td>
                                    <td><?php echo $list['sent_count']; ?></td>
                                    <td><?php echo date('d-M-Y H:i', strtotime($list['uploaded_date'])); ?></td>
                                    <td>
                                        <?php
                                        if (intval($list['sent_count']) < count($hallticketdata)) {
                                        ?>
                                            <a href="javascript:void(0);" data-excelid="<?= $list['excel_details_id'] ?>" class="btn btn-primary send_hallticket_details">Send Hallticket Details</a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="modal fade bd-example-modal-lg" id="studende-preview">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Select Student to Send Hall Ticket</h4>
                            </div>
                            <?php
                            $attributes = array('class' => 'form-horizontal', 'id' => 'update_students', 'name' => 'update_students');
                            echo form_open('', $attributes);
                            ?>
                            <div class="modal-body">
                                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                            <th>Student Name</th>
                                            <th>Registration No</th>
                                            <th>Course Name</th>
                                            <th>Student DOB</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="previrestudents">

                                    </tbody>
                                </table>


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="student_excel_id" value="" id="student_excel_id" />
                                <button type="submit" id="update_student_hallticket_status" class="btn btn-primary">Update & Send</button>
                            </div>
                            <?php

                            echo form_close();
                            ?>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </section>
    <!-- section end-->
</div>

<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {

        $('#student_preview').dataTable();

        function init_datatablecheckbox() {
            var table = $('#example').DataTable({
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        if ($('<div/>').text(data).html() != '') {
                            return '<input type="checkbox" name="student_id[]" value="' + $('<div/>').text(data).html() + '">';
                        } else {
                            return '';
                        }
                    }
                }],
                'order': [
                    [1, 'asc']
                ]
            });

            $('#example-select-all').on('click', function() {
                // Get all rows with search applied
                var rows = table.rows({
                    'search': 'applied'
                }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });

            // Handle click on checkbox to set state of "Select all" control
            $('#example tbody').on('change', 'input[type="checkbox"]', function() {
                // If checkbox is not checked
                if (!this.checked) {
                    var el = $('#example-select-all').get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
            });
            $('#update_students').on('submit', function(e) {
                var form = this;
                e.preventDefault();

                // Iterate over all checkboxes in the table
                table.$('input[type="checkbox"]').each(function() {
                    // If checkbox doesn't exist in DOM
                    if (!$.contains(document, this)) {
                        // If checkbox is checked
                        if (this.checked) {
                            // Create a hidden element
                            $(form).append(
                                $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                            );
                        }
                    }
                });

                update_and_send_hallticket($(this), form);

            });

        }


        // Handle form submission event




        $('body').on('click', '.send_hallticket_details', function() {
            var _this = $(this);
            var excelid = $(this).attr('data-excelid');
            $('#student_excel_id').val(excelid);

            $.ajax({
                method: "POST",
                url: "<?= base_url('admin/studenthallticket') ?>/preview_students_list",
                data: {
                    excelid: excelid
                },
                /*  dataType: 'json', */
                success: function(msg) {
                    _this.html('').html('Send Receipt Details');
                    if (msg != false) {
                        $('.previrestudents').html('').html(msg);
                        init_datatablecheckbox();
                        $("#studende-preview").modal('show');


                    } else {
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


        function update_and_send_hallticket(elem, form) {
            var _this = $(elem).children().find('#update_student_hallticket_status');
            var form_data = $(form).serialize();
            if (form_data != '') {
                $.ajax({
                    method: "POST",
                    url: "<?= base_url('admin/studenthallticket') ?>/ajax_send_hallticket",
                    data: {
                        form_data: form_data
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
                                    ok: function() {
                                        window.location.reload();
                                    }
                                }
                            });
                            $("#studende-preview").modal('hide');
                        } else {
                            _this.html('').html('Update & Send');
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
            }




        }
        /* $('body').on('click', '#update_student_hallticket_status', function() {

            var excelid = $(this).attr('data-excelid');




        }); */
    });
</script>