<?php
$page_name = $this->router->fetch_class();
//$per_res = permission_view_check($page_name, $ss_data);
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
            <li class="active"><a href="<?php echo base_url('admin/payment/view_payment_details'); ?>">Payment Details</a></li>
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
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered table-hover dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>Patient Name</th>
                                <th>Patient Email</th>
                                <th>Patient Mobile</th>
                                <th>Appointment ID</th>
                                <th>Order Status</th>
                                <!--<th>Order ID</th>-->
                                <th>Amount Paid</th>
                                <th>Payment Status</th>
                                <th>Payment ID</th>
                                <th>Payment Method</th>
                                <th>Payment Bank</th>
                                <th>Currency</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>    
</div>



<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $('#example').DataTable({
        "order": [[0, "desc"]],
//        "columnDefs": [{orderable: false, targets: [4, 7, 10, 8]}],
        "processing": true,
        "scrollX": true,
        "serverSide": true,
        sDom: '<"row"<"col-lg-4"l><"col-lg-5"T><"col-lg-3"f>>rt<"row"<"col-lg-6"i><"col-lg-6"p>>',
        tableTools: {
            "sSwfPath": "<?php echo base_url('admin_assets'); ?>/bower_components/datatables.net/swf/copy_csv_xls_pdf.swf"
        },
        "ajax": {
            "url": "<?php echo base_url('admin/payment/ajax_payment_details_datatable') ?>",
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
            {"data": "s_no"},
            {"data": "patient_name"},
            {"data": "patient_email"},
            {"data": "patient_mobile"},
            {"data": "appointment_key"},
            {"data": "order_status"},
            //{"data": "order_id"},
            {"data": "amount_paid"},
            {"data": "payment_status"},
            {"data": "payment_id"},
            {"data": "payment_method"},
            {"data": "payment_bank"},
            {"data": "payment_currency"},
            {"data": "payment_date"}
        ],
        "initComplete": function (settings, json) {
            var info = this.api().page.info();
            $('select[name=example_length]').append('<option value="' + info.recordsTotal + '">All</option>');
        }
    });
</script>
