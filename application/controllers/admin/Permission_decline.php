<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Permission_decline extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data = array(
            'base_model',            
        );        
        $this->load->model($data, '', true);                
        $this->hashids = new Hashids\Hashids('the srh-ola user error');
    }

    public function index() {
        $session_data = $this->session->userdata('srihertemp_admin_logged_in');
        $uid = $session_data['id'];
        $email = $session_data['email'];
        $role_id = $session_data['role'];

        $data['ss_data'] = $session_data;
        //  $this->output->set_status_header('404');
        // Make sure you actually have some view file named 404.php

        $this->load->view('admin/includes/header', $data);
        $this->load->view('admin/includes/admin_menu', $data);

        $this->load->view('admin/unauthorized/unauthorized');
        $this->load->view('admin/includes/footer', $data);
    }

}
