<?php
$page_name = $this->router->fetch_class();
$per_res = permission_view_check($page_name, $ss_data);
$hashids = new Hashids\Hashids('the sriher studenthallticket error');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title; ?>
            <small><?php echo $sub_title; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><a href="<?php echo base_url('admin/studentdata/create'); ?>">Student Data</a></li>
        </ol>
    </section>
    <!-- section start -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
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
        </div>
        <div class="box">
            <div class="box-body">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'update_student_fr_hallticketvisible', 'name' => 'update_student_fr_hallticketvisible');
                echo form_open('admin/studenthallticket/view', $attributes);
                ?>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                            <th>Student Name</th>
                            <th>Reg No</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Exam Date & Time</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($studenthallticket_list)) {
                            foreach ($studenthallticket_list as $list) {
                        ?>
                                <tr>
                                    <td><?php echo $list['hall_ticket_preview_status'] . '-' . $list['student_id']; ?></td>
                                    <td><?php echo $list['student_name']; ?></td>
                                    <td><?php echo $list['student_barcode']; ?></td>
                                    <td><?php echo $list['halltcketcourse_name']; ?></td>
                                    <td><?php echo $list['course_code']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($list['examdate'])) . ' - ' . $list['examtime']; ?></td>
                                    <td>
                                        <?php echo date('d-M-Y H:i', strtotime($list['created_date'])); ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-info" target="_blank" href="<?= base_url('admin/studenthallticket/studenthallticketdetails'); ?>/<?= $this->hashids->encode($list['student_id'], dateintval('d'), dateintval('m'), dateintval('y')) ?>">View Details</a>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="">
                    <button type="submit" id="update_student_hallticket_status" name="btn_submit" class="btn btn-primary">Update Student For Hall Ticket Visible</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>

        </div>
    </section>
    <!-- section end-->
</div>

<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        var table = $('#example').DataTable({
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    var st = $('<div/>').text(data).html().split('-')[0];
                    st = (st == '0') ? '' : 'checked';
                    return '<input type="checkbox" ' + st + '  name="student_id[]" value="' + $('<div/>').text(data).html().split('-')[1] + '">';
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
        $('#update_student_fr_hallticketvisible').on('submit', function(e) {
            var form = this;
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
        });
    });
</script>