<?php
$class_name = $this->router->fetch_class(); // for controller
$method_name = $this->router->fetch_method(); // for method

?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url('admin_assets'); ?>/upload/employee_profile/<?php echo $ss_data['photo']; ?>" class="img-circle" alt="<?php echo $ss_data['name']; ?>">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($ss_data['name']); ?></p>
                <!--                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>
        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!--            <li class="header">MAIN NAVIGATION</li>-->

            <li class="treeview <?php echo ($class_name == 'dashboard') ? 'active menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($class_name == 'dashboard' && $method_name == 'dashboard') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-circle-o"></i>Main Dashboard</a></li>
                    <!--                        <li class="<?php echo ($class_name == 'dashboard' && $method_name == 'doc_dashboard') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/dashboard/doc_dashboard'); ?>"><i class="fa fa-circle-o"></i> Doctor Dashboard</a></li>                    -->
                </ul>
            </li>
            <li class="treeview <?php echo ($class_name == 'students') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-graduation-cap"></i>
                    <span>Students</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($class_name == 'students' && $method_name == 'view') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/students/view'); ?>"><i class="fa fa-circle-o"></i> View</a></li>
                </ul>
            </li>
            <li class="treeview <?php echo ($class_name == 'studentdata') ? 'active menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Receipt</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($class_name == 'studentdata' && $method_name == 'create') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studentdata/create'); ?>"><i class="fa fa-circle-o"></i> Create</a></li>
                    <li class="<?php echo ($class_name == 'studentdata' && $method_name == 'view') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studentdata/view'); ?>"><i class="fa fa-circle-o"></i> View</a></li>
                </ul>
            </li>
            <li class="treeview <?php echo ($class_name == 'studenthallticket') ? 'active menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-ticket"></i>
                    <span>Hall Ticket</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($class_name == 'studenthallticket' && $method_name == 'create') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studenthallticket/create'); ?>"><i class="fa fa-circle-o"></i> Create</a></li>
                    <li class="<?php echo ($class_name == 'studenthallticket' && $method_name == 'view') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studenthallticket/view'); ?>"><i class="fa fa-circle-o"></i> View</a></li>
                </ul>
            </li>
            <li class="treeview <?php echo ($class_name == 'studentnotification') ? 'active menu-open' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-bell"></i>
                    <span>Notification</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($class_name == 'studentnotification' && $method_name == 'create') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studentnotification/create'); ?>"><i class="fa fa-circle-o"></i> Create</a></li>
                    <li class="<?php echo ($class_name == 'studentnotification' && $method_name == 'view') ? 'active' : '' ?>"><a href="<?php echo base_url('admin/studentnotification/view'); ?>"><i class="fa fa-circle-o"></i> View</a></li>
                </ul>
            </li>            
        </ul>
    </section>
</aside>