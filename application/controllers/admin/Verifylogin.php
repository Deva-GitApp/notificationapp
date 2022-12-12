<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data = array(
            'admin/user',
        );
        $this->load->model($data, '', true);
        $this->load->library(array('usersupport'));
    }

    // Default login form controller
    public function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtEmail', 'Email', 'trim|required');
        $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|callback_check_database');

        $data['loadjs'] = array(
            'admin/loginvalidation.js'
        );

        if ($this->form_validation->run() == false) {
            $data['inputs'] = '';
            $this->load->view('admin/account/login', $data);
//            $this->load->view('includes/header', $data);
//            $this->load->view('admin/account/login', $data);
//            $this->load->view('includes/footer', $data);
        } else {
            $data['inputs'] = array('email' => $this->input->post('txtEmail'), 'password' => $this->input->post('txtPassword'));
            $this->load->view('admin/account/login', $data);
//            $this->load->view('includes/header', $data);
//            $this->load->view('admin/account/login', $data);
//            $this->load->view('includes/footer', $data);
        }
    }

    // Controller for password verification
    public function check_database($password) {

        $email = $this->input->post('txtEmail');
        $pwd = $this->usersupport->encrypt_decrypt('encrypt', $password);
        $result = $this->user->login($email, $pwd);        
        //exit;
        if ($result) {
            return true;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid Email or Password');
            return false;
        }
    }

}
