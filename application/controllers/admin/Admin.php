<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of admin
 *
 * @author rckumar
 */
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            redirect(base_url('admin/dashboard'), 'refresh');
        } else {
            $data['title'] = '';
            $this->load->view('admin/account/login', $data);
        }
    }

}
