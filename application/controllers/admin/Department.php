<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of Department
 *
 * @author rckumar
 */
class Department extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/department_model'
        );
        $lib_ary = array(
            'imageupload',
            'usersupport',
        );
        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher department error');
    }

    public function index()
    {
        redirect('admin/department/create', 'refresh');
    }

    public function view()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Department';
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

            //            $data['department_list'] = $this->department_model->get_all_department();
            //            $data['role_type_list'] = $this->department_model->get_all_role_type();
            //            $data['department_list'] = $this->department_model->get_all_departments();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/department/view_department', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function create()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            //  $department_id = $session_data['department'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Department';
            $data['sub_title'] = 'Add';

            /* dynamic js */
            $data['loadcss'] = array(
                //                'bower_components/select2/dist/css/select2.min.css',
                //                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                /*  'lib/imagere-size/css/imgareaselect-animated.css' */);
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                // 'dist/js/form_validation/department.js',
            );


            $this->load->library('form_validation');
            $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required|is_unique[department.department_name]');
            $this->form_validation->set_rules('department_code', 'Department Code', 'trim|required');
            $this->form_validation->set_rules('department_week', 'Department Week', 'trim|required|numeric');
            $this->form_validation->set_rules('department_desc', 'Department Description', 'trim');
            $this->form_validation->set_message('is_unique', 'This %s already exists.');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/department/add_department', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $department_name = $this->input->post('department_name');
                $department_code = $this->input->post('department_code');
                $department_week = $this->input->post('department_week');
                $department_desc = $this->input->post('department_desc');
                $result = $this->department_model->add_department($department_name, $department_code, $department_desc, $department_week, $session_data['id']);

                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'New Department Name is Created Successfully.');
                    redirect('admin/department/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Creation Failed. Please try again...');
                    redirect('admin/department/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function edit($id)
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Department';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                //                'bower_components/select2/dist/css/select2.min.css',
                //                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                /*  'lib/imagere-size/css/imgareaselect-animated.css' */);
            $data['loadjs'] = array(
                //                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                //                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
                //                'bower_components/autocomplete/typeahead.js',
                //'dist/js/form_validation/department.js',
            );
            /* decode url */
            $numbers = $this->hashids->decode($id);
            //            print_r($numbers);
            $data['department_data'] = $this->department_model->get_department_by_id($numbers[0]);
            //            var_dump($data['department_data']);
            //$this->output->enable_profiler(TRUE);
            //callback_slt_check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
            $this->form_validation->set_rules('department_code', 'Department Code', 'trim|required');
            $this->form_validation->set_rules('department_week', 'Department Week', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/department/edit_department', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $department_name = $this->input->post('department_name');
                $department_code = $this->input->post('department_code');
                $department_week = $this->input->post('department_week');
                $check_unq = $this->department_model->check_department_unique($numbers[0], $department_name);
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->department_model->edit_department($numbers[0], $department_name, $department_code, $department_week, $session_data['id']);
                } else {
                    $this->session->set_flashdata('db_error', 'This Department Name already exists. Please try again..');
                    redirect('admin/department/edit/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/department/view/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/department/edit/' . $id, 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function delete($id)
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            // $department_id = $session_data['department'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Department';
            $data['sub_title'] = 'Delete';
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->department_model->delete_department_by_id($numbers[0], $session_data['id']);
            if ($result) {
                $this->session->set_flashdata('db_sucess', 'Department Name is Deleted Successfully.');
                redirect('admin/department/view/', 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Can not Delete. Please try again...');
                redirect('admin/department/view/', 'refresh');
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function status($id)
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Department';
            $data['sub_title'] = 'Status';
            $status = $_POST['data'];
            if ($status == '0') {
                $status = '1';
            } elseif ($status == '1') {
                $status = '0';
            }
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->department_model->change_status_department_by_id($numbers[0], $uid, $status);

            if ($result) {
                echo $status;
            } else {
                echo '2';
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function slt_check($str)
    {
        if ($str == '0') {
            $this->form_validation->set_message('slt_check', 'Select the {field} ');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function ajax_with_datatable()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $page_name = $this->router->fetch_class();
            $per_res = permission_view_check($page_name, $session_data);
            $uid = $session_data['id'];


            $columns = array(
                0 => 'department_id',
                1 => 'department_name',
                2 => 'department_code',
                3 => 'department_week',
                4 => 'created_date',
                5 => 'modified_date',
                6 => 'department_id',
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalData = $this->department_model->allposts_count();

            $totalFiltered = $totalData;

            if (empty($this->input->post('search')['value'])) {
                $posts = $this->department_model->allposts($limit, $start, $order, $dir);
            } else {
                $search = $this->input->post('search')['value'];
                $posts = $this->department_model->posts_search($limit, $start, $search, $order, $dir);
                $totalFiltered = $this->department_model->posts_search_count($search);
            }
            $data = array();
            if (!empty($posts)) {
                $permission = '';
                foreach ($posts as $post) {
                    $department_id = $post->department_id;
                    $action_html = '';
                    //    if ($per_res['status']) {
                    if ($post->status == '1') {
                        $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $department_id . '" data-href="' . base_url('admin') . '/department/status/' . $this->hashids->encode($department_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    } else if ($post->status == '0') {
                        $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $department_id . '" data-href="' . base_url('admin') . '/department/status/' . $this->hashids->encode($department_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-close"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    }
                    //    }
                    //  if ($per_res['edit']) {
                    $action_html .= '<a class="action_edit" id="action_edit_' . $department_id . '" href="' . base_url('admin') . '/department/edit/' . $this->hashids->encode($department_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    // }
                    // if ($per_res['delete']) {

                    $action_html .= '<a href="javascript:;" class="action_del" id="action_del_' . $department_id . '" data-href="' . base_url('admin') . '/department/delete/' . $this->hashids->encode($department_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-remove"></span></a>';
                    //  }



                    $nestedData['department_id'] = $post->department_id;
                    $nestedData['department_name'] = $post->department_name;
                    $nestedData['department_code'] = $post->department_code;
                    $nestedData['department_week'] = $post->department_week;
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
}
