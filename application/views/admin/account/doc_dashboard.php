<?php
$page_name = $this->router->fetch_class();
$action_name = $this->router->fetch_method();
$CI = & get_instance();
$CI->load->model('dashboard_model');
$uid = $ss_data['id'];
$role_id = $ss_data['role'];
//echo '<pre>';
//print_r($uid);
//print_r($ss_data);
//echo '</pre>';
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php /* <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
              <div class="inner">
              <h3><?= $doctor_count ?></h3>

              <p>Doctors</p>
              </div>
              <div class="icon">
              <!--                        <i class="ion ion-bag"></i>-->
              <i class="fa fa-user-md" aria-hidden="true"></i>

              </div>
              <a href="<?= base_url('admin/doctors') ?>" class="small-box-footer">View Doctors <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              </div>
             * 
             */
            ?>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $patient_count ?></h3>

                        <p>Patient</p>
                    </div>
                    <div class="icon">
                        <!--<i class="ion ion-stats-bars"></i>-->
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <a href="<?= base_url('admin/patient') ?>" class="small-box-footer">View Appointment <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $appointment_count ?></h3>

                        <p>Appointments </p>
                    </div>
                    <div class="icon">
                        <!--<i class="ion ion-person-add"></i>-->
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                    <a href="<?= base_url('admin/appointment') ?>" class="small-box-footer">View Appointments <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">                
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $visit_count ?></h3>

                        <p>Visits</p>
                    </div>
                    <div class="icon">
                        <!--<i class="ion ion-pie-graph"></i>-->
                        <i class="fa fa-eye" aria-hidden="true"></i>    
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- Left col -->
            <div class="col-md-6">                
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Today's Appointments</h3>

                        <div class="box-tools pull-right">
                            <span class="label label-info"><?= $time_slot_count ?> - Slots</span>
                            <span class="label label-success"><?= $today_doc_booked_list ?> - Booked</span>
                            <span class="label label-danger"><?= $today_doc_cancelled_list ?> - Cancelled</span>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Time</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($today_appointment_list)) {
                                        foreach ($today_appointment_list as $value) {
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $value['appointment_time'] ?></td>
                                                <td><?= $value['patient_name'] ?></td>
                                                <td><?= agecalbydob($value['patient_dob']) ?></td>
                                                <td><?= ($value['patient_gender'] == 'M') ? 'Male' : 'Female' ?></td>
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
                    <div class="box-footer clearfix">
                        <?php
                        $res = checkuserpermission($uid, $role_id, 'appointment', 'create');
                        if ($res) {
                            ?>
                            <a href = "<?= base_url('admin/appointment/create') ?>" class = "btn btn-sm btn-info btn-flat pull-left">Create Appointment</a>
                            <?php
                        }
                        ?>
                        <a href="<?= base_url('admin/appointment') ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Appointment</a>

                    </div>            
                </div>            
            </div>
            <div class="col-md-6">                
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Next Schedules</h3>

                        <div class="box-tools pull-right">                            
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Date</th>
                                        <th>Morning</th>
                                        <th>Afternoon</th>
                                        <th>Evening</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($doc_shedule_details)) {
                                        foreach ($doc_shedule_details as $value) {
                                            $res = slotmerge($value['fk_time_slot_ids'], $value['time_slot_interval']);
                                            $morning_count = (isset($res['morning'])) ? count(explode(',', $res['morning'])) : 0;
                                            $afternoon_count = (isset($res['afternoon'])) ? count(explode(',', $res['afternoon'])) : 0;
                                            $evening_count = (isset($res['evening'])) ? count(explode(',', $res['evening'])) : 0;
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= date('d-F-Y', strtotime($value['shedule_date'])) ?></td>
                                                <td><?= $morning_count ?></td>
                                                <td><?= $afternoon_count ?></td>
                                                <td><?= $evening_count ?></td>                                                
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
                    <div class="box-footer clearfix">                        
                        <a href="<?= base_url('admin/doctor_schedule') ?>" class="btn btn-sm btn-info btn-flat pull-right">View All Schedules</a>
                    </div>            
                </div>            
            </div>
        </div>



    </section>    
</div>
<style type="text/css">
    .list-group-item .print{ width: 100%; display: table; margin-bottom: 5px;}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="radio"].minimal-red').iCheck({
            radioClass: 'iradio_minimal-blue'
        });
    });

    $('#search').on('click', function (event) {
        var srch_type = $('input[type="radio"].minimal-red:checked').val();
        var srch_val = $('#srch_val').val();


        get_patient_details_search(srch_val, srch_type);
    });

    function get_patient_details_search(srch_val, srch_type) {
        $.ajax({
            method: "POST",
            url: '<?php echo base_url('admin/dashboard'); ?>/get_patient_details_search',
            data: {srch_val: srch_val, srch_type: srch_type},
            success: function (msg) {
                if (msg != false) {
                    $('.ajax_user_details').html('').html(msg);
                }
            }, beforeSend: function (msg) {

            }
        });
    }




</script>