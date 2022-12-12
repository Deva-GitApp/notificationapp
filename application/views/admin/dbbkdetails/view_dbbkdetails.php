<?php
$page_name = $this->router->fetch_class();
$per_res = permission_view_check($page_name, $ss_data);
$hashids = new Hashids\Hashids('the sriher dbbkdetails error');

$ftp_username = 'idelivery@wisualit.com';
$ftp_userpass = '4U#89!6fcC$23sPiK';
$ftp_server = "id.wisualit.com";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
print_r($login);
exit;
echo $login;
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
            <li class="active"><a href="<?php echo base_url('admin/dbbkdetails/create'); ?>">Data Base Back Up</a></li>
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
                            <th>Project Name</th>
                            <th>Database Name</th>
                            <th>Database Path</th>
                            <th>Created Date</th>
                            <th>Modified Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </section>
    <section class="content-header">
        <h1>
            SRMC UNIVERSITY
            <small>https://www.sriramachandra.edu.in/</small>
        </h1>

    </section>   
    <section class="content">
        <div class="box">
            <div class="box-body">                
                <table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SI.No</th>
                            <th>Backup Date</th>
                            <th>Backup File name</th>
                            <th>File Size</th>
                            <th>Backup Date</th>
                            <th>Notes</th>
                            <th>Action</th>                            
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
    $(document).ready(function () {
        $('#example2').DataTable();
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('admin/dbbkdetails/ajax_with_datatable') ?>",
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
                {"data": "dbbkdetails_id"},
                {"data": "project_name"},
                {"data": "db_name"},
                {"data": "db_path"},
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
        $('body').on('click', '.action_getdatabase_backupdetails', function () {
            var url = $(this).attr('data-href');
            var id = $(this).attr('id');
            $.ajax({
                method: "POST",
                url: url,
//                data: {data: data},
                success: function (msg) {
                    if (msg) {
//                        alert('sucess');
                    } else {
//                        alert('failed');

                    }
                }, beforeSend: function (msg) {
                    //$('#' + id).text('wait');
                }
            });
        });
    });
</script>