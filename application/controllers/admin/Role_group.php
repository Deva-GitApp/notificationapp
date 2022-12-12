<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Role_group extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/role_group_model'
        );
        $this->load->model($data, '', true);
        $this->hashids = new Hashids\Hashids('the srh-ola error');
    }

    public function index() {
        redirect('admin/role_group/view', 'refresh');
    }

    public function view() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Group';
            $data['sub_title'] = 'View';
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
            );
            $data['loadjs'] = array(
                'bower_components/datatables.net/js/jquery.dataTables.min.js',
                'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
//                'bower_components/datatables.net-bs/js/dataTables.bootstrap.js'
            );
            /* $id = $this->hashids->encode(date('d'),date('m'),date('y'),2);
              $numbers = $this->hashids->decode($id);
              echo $id;
              var_dump($numbers); */
            $data['role_group_list'] = $this->role_group_model->get_all_role_group();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/role_group/view_role_group', $data);
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
            $role_group_id = $session_data['role_group'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Group';
            $data['sub_title'] = 'Add';

            /* dynamic js */
            $data['loadcss'] = array(
                    /* 'lib/lightbox/css/lightbox.css',
                      'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'dist/js/form_validation/role_group.js'
            );
            $data['role_group_list'] = $this->role_group_model->get_all_role_group();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('role_group_name', 'Role Group Name', 'trim|required|is_unique[role_group.role_group_name]');
            $this->form_validation->set_message('is_unique', 'This %s already exists.');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/role_group/add_role_group', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $role_group_name = $this->input->post('role_group_name');
                $role_group_code = preg_replace('/\s+/', '', $role_group_name);

                $result = $this->role_group_model->add_role_group($role_group_name, $role_group_code, $session_data['id']);
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'New Role Group Name is Created Successfully.');
                    redirect('admin/role_group/view', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Creation Failed. Please try again...');
                    redirect('admin/role_group/create', 'refresh');
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
            $data['title'] = 'Role Group';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                    /* 'lib/lightbox/css/lightbox.css',
                      'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'dist/js/form_validation/role_group.js'
            );
            /* decode url */
            $numbers = $this->hashids->decode($id);
//            print_r($numbers);
            $data['role_group_data'] = $this->role_group_model->get_role_group_by_id($numbers[0]);
            $data['role_group_list'] = $this->role_group_model->get_all_role_group();
            //$this->output->enable_profiler(TRUE);
            $this->load->library('form_validation');
            $this->form_validation->set_rules('role_group_name', 'Role Group Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/role_group/edit_role_group', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $role_group_name = $this->input->post('role_group_name');
                $role_group_code = preg_replace('/\s+/', '', $role_group_name);

                $check_unq = $this->role_group_model->check_role_group_unique($numbers[0], $role_group_name);
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->role_group_model->edit_role_group($numbers[0], $role_group_name, $role_group_code, $session_data['id']);
                } else {
                    $this->session->set_flashdata('db_error', 'This Role Group Name already exists.Please enter a different name..');
                    redirect('admin/role_group/edit/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/role_group/view/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/role_group/edit/' . $id, 'refresh');
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
            $role_group_id = $session_data['role_group'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Group';
            $data['sub_title'] = 'Delete';
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->role_group_model->delete_role_group_by_id($numbers[0], $session_data['id']);
            if ($result) {
                $this->session->set_flashdata('db_sucess', 'Role Group Name is Deleted Successfully.');
                redirect('admin/role_group/view/', 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Can not Delete. Please try again...');
                redirect('admin/role_group/view/', 'refresh');
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
            $data['title'] = 'Role Group';
            $data['sub_title'] = 'Status';
            $status = $_POST['data'];
            if ($status == '0') {
                $status = '1';
            } elseif ($status == '1') {
                $status = '0';
            }
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->role_group_model->change_status_role_group_by_id($numbers[0], $uid, $status);
            if ($result) {
                echo $status;
            } else {
                echo '2';
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

}
