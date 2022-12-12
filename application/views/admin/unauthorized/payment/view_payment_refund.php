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
            <li class="active"><a href="<?php echo base_url('admin/payment/view_payment_refunds'); ?>">Payment Refund</a></li>
        </ol>
        <div class="radio-check-sec">
            <label>
                <input type="radio" name="flt_key" class="flat-red" value="1" checked="">
                Refund incomplete
            </label>
            <label>
                <input type="radio" name="flt_key" class="flat-red" value="2">
                Refund Initiated
            </label>
        </div>
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

                    <table id="example" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sn.</th>
                                <th>Patient Name</th>
                                <th>Patient Email</th>
                                <th>Patient Mobile</th>
                                <th>Appointment ID</th>
                                <th>Amount Paid</th>
                                <th>Order ID</th>
                                <th>Payment ID</th>
                                <th>To Deduct</th>
                                <th>To Refund</th>
                                <th>Request On</th>
                                <th>Request By</th>
                                <th>Amount Refunded</th>
                                <th>Refund Status</th>
                                <th>Refund ID</th>
                                <th>Refund On</th>
                                <th>Action</th>
                                <th>User Refund</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="ajax_res_refund_data"></div>
        <?php
        /*
          <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Refund Request Data</h4>
          </div>
          <?php
          $attributes = array('class' => 'form-horizontal', 'id' => 'frm_registration', 'name' => 'frm_registration');
          echo form_open_multipart('admin/doctor_schedule/create', $attributes);
          ?>
          <div class="modal-body">
          <div class="row">
          <div class="col-md-12">
          <div class="box-body">
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">User name</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">Rudra Deva</label>

          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">User Mobile</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">7708903373</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">Appointment ID</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">HASJMJ</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">Amount Paid</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">1000</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">Payment ID</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">pay_DPW2Daw3ZDpdd6</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">User Type</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">Admin</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">Requested Date</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">16 JAN 2015</label>
          </div>
          </div>
          <div class="form-group">
          <label for="schedule_title" class="col-lg-3 control-label">Requested By</label>
          <div class="col-lg-6">
          <label class=" control-label" style="font-weight: normal;">Admin</label>
          </div>
          </div>

          <div class="form-group">
          <label for="amount_to_refund" class="col-lg-3 control-label">Amount to Refund</label>
          <div class="col-lg-6">
          <input type="text" class="form-control" id="amount_to_refund" placeholder="Amount to Refund" name="amount_to_refund" onkeypress="return isNumberKey(event)">
          </div>
          </div>
          <div class="form-group">
          <label for="refund_notes" class="col-lg-3 control-label">Refund Notes</label>
          <div class="col-lg-6">
          <textarea class="form-control" id="refund_notes" name="refund_notes" placeholder="Refund Notes"></textarea>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          <div class="modal-footer">
          <input type="hidden" name="refund_request_id" id="refund_request_id">
          <input type="hidden" name="payment_id" id="payment_id">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Refund</button>
          </div>
          <?php
          echo form_close();
          ?>
          </div>
          </div>
          </div>
         * 
         */
        ?>
    </section>    
</div>

<!-- content end -->
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
//        $('#modal-default').modal('hide');
        get_ajax_datatable('1');
        $('input[name="flt_key"]').on('ifClicked', function (event) {
            get_ajax_datatable(this.value);
        });
    });





    $('body').on('click', '.partial_refund', function () {
        var elem = $(this);
        var refund_request_id = $(this).attr('data-refundrequestid');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('admin/payment'); ?>/get_refund_request_data",
            data: {data: refund_request_id},
            success: function (msg) {
                if (msg != false) {
                    $(elem).addClass('partial_refund').html('Click to Refund');
                    $('.ajax_res_refund_data').html('').html(msg);
                    $('#modal-default').modal('show');
                }

            }, beforeSend: function () {
                $(elem).removeClass('partial_refund').html('Please wait');
            }
        });
    });
    $('body').on('click', '.full_refund', function () {
        var elem = $(this);
        var refund_request_id = $(this).attr('data-refundrequestid');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('admin/payment'); ?>/refund_amount_user_cancelled",
            data: {data: refund_request_id},
            dataType: 'json',
            success: function (msg) {
                $(elem).addClass('full_refund').html('Click to Refund');
                if (msg.res != false) {
                    $.confirm({
                        content: msg.msg,
                        icon: 'fa fa-smile-o',
                        theme: 'modern',
                        closeIcon: false,
                        animation: 'scale',
                        type: 'blue',
                        boxWidth: '30%',
                        useBootstrap: false,
                        buttons: {
                            Ok: function () {

                            }
                        }
                    });
                } else {
                    $.confirm({
                        content: msg.msg,
                        icon: 'fa fa-warning',
                        theme: 'modern',
                        closeIcon: false,
                        animation: 'scale',
                        type: 'blue',
                        boxWidth: '30%',
                        useBootstrap: false,
                        buttons: {
                            Ok: function () {

                            }
                        }
                    });
                }

            }, beforeSend: function () {
                $(elem).removeClass('full_refund').html('Please wait');
            }
        });
    });



    $('body').on('click', '.refund_amount_to_user', function () {
        $('.error').html('');
        var elem = $(this);
        var amount_to_refund = $('#amount_to_refund').val();
        var refund_notes = $('#refund_notes').val();
        var refund_request_id = $('#refund_request_id').val();
        var payment_id = $('#payment_id').val();
        if (amount_to_refund != '' && amount_to_refund != '0') {
            $.ajax({
                method: "POST",
                dataType: 'json',
                url: "<?php echo base_url('admin/payment'); ?>/refund_amount_to_user",
                data: {refund_request_id: refund_request_id, payment_id: payment_id, amount_to_refund: amount_to_refund, refund_notes: refund_notes},
                success: function (msg) {
                    if (msg.res != false) {
                        $('#modal-default').modal('hide');
                        $('.ajax_res_refund_data').html('');
                        $.confirm({
                            content: msg.msg,
                            icon: 'fa fa-smile-o',
                            theme: 'modern',
                            closeIcon: false,
                            animation: 'scale',
                            type: 'blue',
                            boxWidth: '30%',
                            useBootstrap: false,
                            buttons: {
                                Ok: function () {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        $(elem).addClass('refund_amount_to_user').html('Refund');
                        $('.error').html(msg.msg);
                    }

                }, beforeSend: function () {
                    $(elem).removeClass('refund_amount_to_user').html('Please wait');

                }
            });
        } else {
            alert('Amount field is required');
            $('#amount_to_refund').focus();
        }
    });


    function get_ajax_datatable(flt_key) {
        if (flt_key == '1') {
            url = 'ajax_get_refund_data_incomplete';
//            $('#example thead th').eq(5).html('Date & Time');
//            $('#example thead th').eq(6).html('Mobile Number');
//            $('#example thead th').eq(7).html('Confirmed By');
//            $('#example thead th').eq(8).html('Actions');
        } else if (flt_key == '2') {
            url = 'ajax_get_refund_data_datatable';
//            $('#example thead th').eq(5).html('Date & Time');
//            $('#example thead th').eq(6).html('Cancelled By');
//            $('#example thead th').eq(7).html('Confirmed By');
//            $('#example thead th').eq(8).html('Actions');
        }

        $('#example').DataTable({
            "order": [[0, "desc"]],
//        "columnDefs": [{orderable: false, targets: [4, 7, 10, 8]}],
            "scrollY": true,
            "scrollX": true,
            "scrollCollapse": true,
            "processing": true,
            "serverSide": true,
            destroy: true,
            sDom: '<"row"<"col-lg-4"l><"col-lg-5"T><"col-lg-3"f>>rt<"row"<"col-lg-6"i><"col-lg-6"p>>',
            tableTools: {
                "sSwfPath": "<?php echo base_url('admin_assets'); ?>/bower_components/datatables.net/swf/copy_csv_xls_pdf.swf"
            },
            "ajax": {
                "url": "<?php echo base_url('admin/payment/') ?>" + url,
                "dataType": "json",
                "type": "POST",
                "data": {'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>', 'fltr_key': flt_key, }
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var info = $(this).DataTable().page.info();
                $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                return nRow;
            },
            "columns": [
                {"data": "appointment_request_refund_id"},
                {"data": "patient_name"},
                {"data": "patient_email"},
                {"data": "patient_mobile"},
                {"data": "appointment_key"},
                {"data": "amount_paid"},
                {"data": "order_id"},
                {"data": "payment_id"},
                {"data": "deduct"},
                {"data": "refund"},
                {"data": "requested_on"},
                {"data": "requested_by"},
                {"data": "amount_refund"},
                {"data": "refund_status"},
                {"data": "refund_id"},
                {"data": "refund_time"},
                {"data": "action"},
                {"data": "user_refund"},
            ],
            "initComplete": function (settings, json) {
                var info = this.api().page.info();
                $('select[name=example_length]').append('<option value="' + info.recordsTotal + '">All</option>');
                var api = new $.fn.dataTable.Api(settings);
                var showColumn = (<?php echo $ss_data['role'] ?> == '11' || <?php echo $ss_data['role'] ?> == '1') ? true : false;

                api.columns([16]).visible(showColumn);
            }
        });
    }



</script>
