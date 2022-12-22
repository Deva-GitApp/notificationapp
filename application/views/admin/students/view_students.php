<?php
$page_name = $this->router->fetch_class();
$per_res = permission_view_check($page_name, $ss_data);
$hashids = new Hashids\Hashids('the srh-ola studentdata error');
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
                if ($this->session->flashdata('db_error') != '') {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('db_error'); ?>
                    </div>
                <?php
                }
                if ($this->session->flashdata('db_sucess') != '') {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('db_sucess'); ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>Student Name</th>
                            <th>Student Barcode</th>
                            <th>Student Course Name</th>
                            <th>DOB</th>
                            <th>Batch</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>

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
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/students/ajax_with_datatable') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                var info = $(this).DataTable().page.info();
                $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                return nRow;
            },
            "columns": [{
                    "data": "student_id"
                },
                {
                    "data": "student_name"
                },
                {
                    "data": "student_barcode"
                },
                {
                    "data": "course_name"
                },
                {
                    "data": "student_dob"
                },
                {
                    "data": "batch"
                },
                {
                    "data": "created_date"
                }
            ],
            "initComplete": function(settings, json) {
                var info = this.api().page.info();
                $('select[name=example_length]').append('<option value="' + info.recordsTotal + '">All</option>');
            },

            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
        });
    });
</script>