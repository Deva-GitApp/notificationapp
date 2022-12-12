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
                            <th>Reg No</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Exam Date & Time</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($studenthallticket_list)) {
                            foreach ($studenthallticket_list as $list) {
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['student_name']; ?></td>
                                    <td><?php echo $list['student_barcode']; ?></td>
                                    <td><?php echo $list['halltcketcourse_name']; ?></td>
                                    <td><?php echo $list['course_code']; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($list['examdate'])) . ' - ' . $list['examtime']; ?></td>
                                    <td><?php echo date('d-M-Y H:i', strtotime($list['created_date'])); ?></td>

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
    });
</script>