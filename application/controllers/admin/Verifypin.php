<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VerifyPin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data = array(
            'admin/user',
        );
        $this->load->model($data, '', true);
        $this->load->library(array('usersupport'));
    }

    // Default form controller
    public function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtSecurePin', 'Secure PIN', 'trim|required|callback_check_database_pin');

        $data['loadjs'] = array(
            'admin/loginvalidation.js'
        );

        if ($this->form_validation->run() == false) {
            $data['inputs'] = array('email' => $this->input->post('txtEmail'), 'password' => $this->input->post('txtPassword'));
            //$this->load->view('admin/account/login', $data);
            $this->load->view('includes/header', $data);
            $this->load->view('admin/account/login', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect('admin/dashboard', 'refresh');
        }
    }

    // Controller for password pin verification
    public function check_database_pin($pin) {

        $email = $this->input->post('txtEmail');
        $password = $this->input->post('txtPassword');
        $pwd = $this->usersupport->encrypt_decrypt('encrypt', $password);
        $result = $this->user->login_pin($email, $pwd, $pin);
        $role_group_id = $this->user->get_role_group_id($result['fk_roletype_id']);

        if (is_array($result)) {
            $last_login = $this->user->get_last_login_date($result['admin_id']);
            $insert_id = $this->user->user_log($result['admin_id'], $this->input->ip_address());
            $sess_array = array(
                'id' => $result['admin_id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'role' => $result['fk_roletype_id'],
                'role_group' => $role_group_id['fk_role_group_id'],
                'role_type_name' => $role_group_id['role_type_name'],
                'photo' => $result['photo'],
                'log_id' => $insert_id,
                'last_login' => $last_login,
                'landing_url' => $result['landing_url'],
            );
            $this->session->set_userdata('srihertemp_admin_logged_in', $sess_array);
            return true;
        } else {
            $this->form_validation->set_message('check_database_pin', 'Invalid Secure PIN');
            return false;
        }
    }

}
