<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Dbbkdetails extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/dbbkdetails_model'
        );
        $lib_ary = array(
            'imageupload',
            'ftpsettings',
        );
        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher dbbkdetails error');
    }

    public function index() {
        redirect('admin/dbbkdetails/view', 'refresh');
    }

    public function view() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Data Base Back Up';
            $data['sub_title'] = 'View';
            /*
              $data['loadcss'] = array(
              'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
              );
              $data['loadjs'] = array(
              'bower_components/datatables.net/js/jquery.dataTables.min.js',
              'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',


              );
             */
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
//                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
//                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
//                'bower_components/datatable.net.btns/css/jquery.dataTables.min.css',
//                'bower_components/datatable.net.btns/css/buttons.dataTables.min.css',
            );
            $data['loadjs'] = array(
                'bower_components/datatables.net/js/jquery.dataTables.min.js',
                'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'bower_components/datatable.net.btns/js/dataTables.buttons.min.js',
                'bower_components/datatable.net.btns/js/jszip.min.js',
                'bower_components/datatable.net.btns/js/pdfmake.min.js',
                'bower_components/datatable.net.btns/js/vfs_fonts.js',
                'bower_components/datatable.net.btns/js/buttons.html5.min.js',
            );

            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/dbbkdetails/view_dbbkdetails', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function create() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            //  $dbbkdetails_id = $session_data['dbbkdetails'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Data Base Back Up';
            $data['sub_title'] = 'Add';

            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
//                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
//                'bower_components/jquery-validation/dist/jquery.validate.min.js',
//                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
//                'bower_components/autocomplete/typeahead.js',
//                'dist/js/form_validation/dbbkdetails.js',
            );
            $data['project_list'] = $this->dbbkdetails_model->get_all_project_list();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('fk_project_id', 'Project Name', 'trim|required');
            $this->form_validation->set_rules('db_name', 'Database Name', 'trim|required');
            $this->form_validation->set_rules('db_path', 'Database path', 'trim|required');
//            $this->form_validation->set_message('is_unique', 'This %s already exists.');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/dbbkdetails/add_dbbkdetails', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $post_data = $this->input->post();
                $post_data['created_date'] = date('Y-m-d H:i:s');
                $post_data['created_by'] = $session_data['id'];
                $result = $this->dbbkdetails_model->add_dbbkdetails($post_data);

                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'New Data Base Back Up Details is Created Successfully.');
                    redirect('admin/dbbkdetails/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Creation Failed. Please try again...');
                    redirect('admin/dbbkdetails/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function edit($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Data Base Back Up';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
//                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
//                'bower_components/jquery-validation/dist/jquery.validate.min.js',
//                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
//                'bower_components/autocomplete/typeahead.js',
//                'dist/js/form_validation/dbbkdetails.js',
            );
            /* decode url */
            $numbers = $this->hashids->decode($id);
//            print_r($numbers);
            $data['dbbkdetails_data'] = $this->dbbkdetails_model->get_dbbkdetails_by_id($numbers[0]);
            $data['project_list'] = $this->dbbkdetails_model->get_all_project_list();

            //$this->output->enable_profiler(TRUE);
            //callback_slt_check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fk_project_id', 'Project Name', 'trim|required');
            $this->form_validation->set_rules('db_name', 'Database Name', 'trim|required');
            $this->form_validation->set_rules('db_path', 'Database path', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/dbbkdetails/edit_dbbkdetails', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $post_data = $this->input->post();
                $post_data['created_by'] = $session_data['id'];
                $check_unq = $this->dbbkdetails_model->check_dbbkdetails_unique($numbers[0], $this->input->post('fk_project_id'), $this->input->post('db_name'));
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->dbbkdetails_model->edit_dbbkdetails($numbers[0], $post_data);
                } else {
                    $this->session->set_flashdata('db_error', 'This Data Base Back Up Name already exists.Please try again..');
                    redirect('admin/dbbkdetails/edit/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/dbbkdetails/view/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/dbbkdetails/edit/' . $id, 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function delete($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            // $dbbkdetails_id = $session_data['dbbkdetails'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Data Base Back Up';
            $data['sub_title'] = 'Delete';
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->dbbkdetails_model->delete_dbbkdetails_by_id($numbers[0], $session_data['id']);
            if ($result) {
                $this->session->set_flashdata('db_sucess', 'Data Base Back Up Name is Deleted Successfully.');
                redirect('admin/dbbkdetails/view/', 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Can not Delete. Please try again...');
                redirect('admin/dbbkdetails/view/', 'refresh');
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function get_database_backup_details($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            /* decode url */
            $numbers = $this->hashids->decode($id);
            $proj_id = $numbers[0];
            $dproject_details = $this->dbbkdetails_model->get_project_by_id($proj_id);
            if (!empty($dproject_details)) {
//                print_r($dproject_details);
//                exit;
                $res = $this->ftpsettings->get_projectfiles($dproject_details);
                print_r($res);
                exit;
                if (!$res) {
                    var_dump($res);
                } else {
                    echo false;
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function status($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Data Base Back Up';
            $data['sub_title'] = 'Status';
            $status = $_POST['data'];
            if ($status == '0') {
                $status = '1';
            } elseif ($status == '1') {
                $status = '0';
            }
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->dbbkdetails_model->change_status_dbbkdetails_by_id($numbers[0], $uid, $status);

            if ($result) {
                echo $status;
            } else {
                echo '2';
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function slt_check($str) {
        if ($str == '0') {
            $this->form_validation->set_message('slt_check', 'Select the {field} ');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function ajax_with_datatable() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $page_name = $this->router->fetch_class();
            $per_res = permission_view_check($page_name, $session_data);
            $uid = $session_data['id'];

            $columns = array(
                0 => 'dbbkdetails_id',
                1 => 'project_name',
                2 => 'db_name',
                3 => 'db_path',
                4 => 'created_date',
                5 => 'modified_date',
                6 => 'dbbkdetails_id',
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalData = $this->dbbkdetails_model->allposts_count();
            $totalFiltered = $totalData;

            if (empty($this->input->post('search')['value'])) {
                $posts = $this->dbbkdetails_model->allposts($limit, $start, $order, $dir);
            } else {
                $search = $this->input->post('search')['value'];
                $posts = $this->dbbkdetails_model->posts_search($limit, $start, $search, $order, $dir);
                $totalFiltered = $this->dbbkdetails_model->posts_search_count($search);
            }

            $data = array();
            if (!empty($posts)) {
                $permission = '';
                foreach ($posts as $post) {
                    $dbbkdetails_id = $post->dbbkdetails_id;
                    $action_html = '';
                    if ($post->status == '1') {
                        $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $dbbkdetails_id . '" data-href="' . base_url('admin') . '/dbbkdetails/status/' . $this->hashids->encode($dbbkdetails_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    } else if ($post->status == '0') {
                        $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $dbbkdetails_id . '" data-href="' . base_url('admin') . '/dbbkdetails/status/' . $this->hashids->encode($dbbkdetails_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-close"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    }
                    $action_html .= '<a class="action_edit" id="action_edit_' . $dbbkdetails_id . '" href="' . base_url('admin') . '/dbbkdetails/edit/' . $this->hashids->encode($dbbkdetails_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';

                    $action_html .= '<a href="javascript:;" class="action_del" id="action_del_' . $dbbkdetails_id . '" data-href="' . base_url('admin') . '/dbbkdetails/delete/' . $this->hashids->encode($dbbkdetails_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-remove"></span></a>';

                    $nestedData['dbbkdetails_id'] = $post->dbbkdetails_id;
                    $nestedData['project_name'] = '<a href="javascript:;" class="action_getdatabase_backupdetails" data-href="' . base_url('admin') . '/dbbkdetails/get_database_backup_details/' . $this->hashids->encode($post->fk_project_id, dateintval('d'), dateintval('m'), dateintval('y')) . '">' . $post->project_name . '</a>';
                    $nestedData['db_name'] = $post->db_name;
                    $nestedData['db_path'] = $post->db_path;
                    $nestedData['created_date'] = date('d-M-Y H:i:s', strtotime($post->created_date));
                    $nestedData['modified_date'] = date('d-M-Y H:i:s', strtotime($post->modified_date));
                    $nestedData['action'] = $action_html;
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );

            echo json_encode($json_data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function ftpcheck() {



// Connect to FTP server
// Use a correct ftp server
        $ftp_server = "id.wisualit.com";
        $ftp_username = "idelivery@wisualit.com";
        $ftp_userpass = "4U#89!6fcC$23sPiK";
        $ftp_connection = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

        if ($ftp_connection) {
            echo "successfully connected to the ftp server!";

            // Logging in to established connection
            // with ftp username password
            $login = ftp_login($ftp_connection, $ftp_username, $ftp_userpass);

            if ($login) {

                // Checking whether logged in successfully or not
                echo "<br>logged in successfully!";

                // Get file & directory list of current directory
                $file_list = ftp_nlist($ftp_connection, "/lib/");

                //output the array stored in $file_list using foreach loop
                foreach ($file_list as $key => $dat) {
                    echo $key . "=>" . $dat . "<br>";
                }
            } else {
                echo "<br>login failed!";
            }

            // echo ftp_get_option($ftp_connection, 1);
            // Closing connection
            if (ftp_close($ftp_connection)) {
                echo "<br>Connection closed Successfully!";
            }
        }
    }

}
