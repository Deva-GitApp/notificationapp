<?php
$page_name = $this->router->fetch_class();
$CI = & get_instance();
$CI->load->model('dashboard_model');

$app_per_create_res = checkuserpermission($ss_data['id'], $ss_data['role'], 'appointment', 'create');
$app_per_view_res = checkuserpermission($ss_data['id'], $ss_data['role'], 'appointment', 'view');
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
      
            
            
    </section>    
</div>
