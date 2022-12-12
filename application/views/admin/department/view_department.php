<?php
$page_name = $this->router->fetch_class();
$per_res = permission_view_check($page_name, $ss_data);
$hashids = new Hashids\Hashids('the sriher department error');
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
            <li class="active"><a href="<?php echo base_url('admin/department/create'); ?>">Department</a></li>
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
                            <th>Department Name</th>
                            <th>Department Code</th>
                            <th>Department Week</th>
                            <th>Created Date</th>
                            <th>Modified Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (!empty($department_list)) {
                            foreach ($department_list as $list) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['page_name']; ?></td>
                                    <td><?php echo $list['menu_icon_class']; ?></td>   
                                    <td><?php echo $list['menu_priority']; ?></td>   
                                    <td><?php echo $list['short_code']; ?></td>                                                                                                             
                                    <td><?php echo date('d-M-Y H:i', strtotime($list['created_date'])); ?></td>
                                    <td><?php echo date('d-M-Y H:i', strtotime($list['modified_date'])); ?></td>
                                    <td>
                                        <?php
                                        if ($per_res['status']) {
                                            if ($list['status'] == '1') {
                                                ?>
                                                <a href="javascript:;" class="action_status" data-value="<?php echo $list['status']; ?>" id="action_status_<?php echo $list['page_id']; ?>" data-href="<?php echo base_url('admin'); ?>/department/status/<?php echo $hashids->encode($list['page_id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;
                                                <?php
                                            } else if ($list['status'] == '0') {
                                                ?>
                                                <a href="javascript:;" class="action_status" data-value="<?php echo $list['status']; ?>" id="action_status_<?php echo $list['page_id']; ?>" data-href="<?php echo base_url('admin'); ?>/department/status/<?php echo $hashids->encode($list['page_id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>"><span class="glyphicon glyphicon-eye-close"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php
                                        if ($per_res['edit']) {
                                            ?>
                                            <a class="action_edit" id="action_edit_<?php echo $list['page_id']; ?>" href="<?php echo base_url('admin'); ?>/department/edit/<?php echo $hashids->encode($list['page_id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            /*
                                              if ($per_res['delete']) {
                                              ?>
                                              <a href="javascript:;" class="action_del" id="action_del_<?php echo $list['page_id']; ?>" data-href="<?php echo base_url('admin'); ?>/department/delete/<?php echo $hashids->encode($list['page_id'], dateintval('d'), dateintval('m'), dateintval('y')); ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                              <?php
                                              }

                                             */
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
            </div>

        </div>
    </section>
    <!-- section end-->                                
</div>

<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/department/ajax_with_datatable') ?>",
                "dataType": "json",
                "type": "POST",
                "data": {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var info = $(this).DataTable().page.info();
                $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                return nRow;
            },
            "columns": [
                {"data": "department_id"},
                {"data": "department_name"},
                {"data": "department_code"},
                {"data": "department_week"},
                {"data": "created_date"},
                {"data": "modified_date"},
                {"data": "action"}
            ],
            "initComplete": function (settings, json) {
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
        $('body').on('click', '.action_del', function () {
            var url = $(this).attr('data-href');
            //var confirmText = "Are you sure you want to delete this record?";
            var confirmText = false;
            $.confirm({
                content: 'Are you sure you want to delete?',
                icon: 'fa fa-warning',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Yes: function () {
                        window.location.href = url;
                    },
                    No: function () {
                        //$.alert('Canceled!');
                    },
                }
            });
            return false;
        });
        $('body').on('click', '.action_status', function () {
            var url = $(this).attr('data-href');
            var data = $(this).attr('data-value');
            var id = $(this).attr('id');
            $.ajax({
                method: "POST",
                url: url,
                data: {data: data},
                success: function (msg) {
                    if (msg != '2') {
                        if (msg == '1') {
                            var ht_data = '<span class="glyphicon glyphicon-eye-open"></span>';
                        } else if (msg == '0') {
                            var ht_data = '<span class="glyphicon glyphicon-eye-close"></span>';
                        }
                        $('#' + id).attr('data-value', msg);
                        $('#' + id).html(ht_data);
                    } else {
                        $('#' + id).text('Please try again');
                    }
                }, beforeSend: function (msg) {
                    $('#' + id).text('wait');
                }
            });
        });
    });
</script>