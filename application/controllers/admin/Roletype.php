<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Roletype extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/roletype_model'
        );
        $this->load->model($data, '', true);
        $this->hashids = new Hashids\Hashids('the srh-ola role_type error');
    }

    public function index() {
        redirect('admin/roletype/view', 'refresh');
    }

    public function view() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Type';
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
            $data['roletype_list'] = $this->roletype_model->get_all_roletype();
            $data['role_group_list'] = $this->roletype_model->get_all_role_group();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/roletype/view_roletype', $data);
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
            //  $roletype_id = $session_data['roletype'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Type';
            $data['sub_title'] = 'Add';

            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'dist/js/form_validation/roletype.js'
            );
            $data['roletype_list'] = $this->roletype_model->get_all_roletype();
            $data['role_group_list'] = $this->roletype_model->get_all_role_group();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('slt_role_grp', 'Role Group', 'trim|required|callback_slt_check');
            $this->form_validation->set_rules('roletype_name', 'Role Type Name', 'trim|required|is_unique[roletype.role_type_name]');
            $this->form_validation->set_message('is_unique', 'This %s already exists.');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/roletype/add_roletype', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $role_grp_id = $this->input->post('slt_role_grp');
                $roletype_name = $this->input->post('roletype_name');
                $roletype_code = preg_replace('/\s+/', '', $roletype_name);

                $result = $this->roletype_model->add_roletype($role_grp_id, $roletype_name, $roletype_code, $session_data['id']);
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'New Role Type Name is Created Successfully.');
                    redirect('admin/roletype/view', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Creation Failed. Please try again...');
                    redirect('admin/roletype/create', 'refresh');
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
            $data['title'] = 'Role Type';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'dist/js/form_validation/roletype.js'
            );

            /* decode url */
            $numbers = $this->hashids->decode($id);
//            print_r($numbers);
            $data['roletype_data'] = $this->roletype_model->get_roletype_by_id($numbers[0]);
            $data['role_group_list'] = $this->roletype_model->get_all_role_group();
            //$this->output->enable_profiler(TRUE);
            $this->load->library('form_validation');
            $this->form_validation->set_rules('slt_role_grp', 'Role Group', 'trim|required|callback_slt_check');
            $this->form_validation->set_rules('roletype_name', 'Role Type Name', 'trim|required');


            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/roletype/edit_roletype', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $slt_role_grp = $this->input->post('slt_role_grp');
                $roletype_name = $this->input->post('roletype_name');
                $roletype_code = preg_replace('/\s+/', '', $roletype_name);
//                echo $slt_role_grp.'<br>';
//                echo $roletype_name.'<br>';
//                echo $roletype_code.'<br>';
//                echo $numbers[0].'<br>';
//                exit;
                

                $check_unq = $this->roletype_model->check_roletype_unique($numbers[0], $roletype_name);
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->roletype_model->edit_roletype($numbers[0], $slt_role_grp, $roletype_name, $roletype_code, $session_data['id']);
                } else {
                    $this->session->set_flashdata('db_error', 'This Role Type Name already exists.Please enter a different name..');
                    redirect('admin/roletype/edit/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/roletype/view/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/roletype/edit/' . $id, 'refresh');
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
            // $roletype_id = $session_data['roletype'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Type';
            $data['sub_title'] = 'Delete';
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->roletype_model->delete_roletype_by_id($numbers[0], $session_data['id']);
            if ($result) {
                $this->session->set_flashdata('db_sucess', 'Role Type Name is Deleted Successfully.');
                redirect('admin/roletype/view/', 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Can not Delete. Please try again...');
                redirect('admin/roletype/view/', 'refresh');
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
            $data['title'] = 'Role Type';
            $data['sub_title'] = 'Status';
            $status = $_POST['data'];
            if ($status == '0') {
                $status = '1';
            } elseif ($status == '1') {
                $status = '0';
            }
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $result = $this->roletype_model->change_status_roletype_by_id($numbers[0], $uid, $status);
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

}
