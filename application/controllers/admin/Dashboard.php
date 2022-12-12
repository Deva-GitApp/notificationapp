<?php

defined('BASEPATH') or exit('No direct script access allowed');
//use Hashids\Hashids;
/**
 * Description of dashboard
 *
 * @author rckumar
 */
class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $model_ary = array(
            //  'base_model',
            'admin/user',
            'admin/dashboard_model',
        );
        $this->load->model($model_ary, '', true);
        $this->load->library(array('usersupport'));
        $this->hashids_error = new Hashids\Hashids('the srihertemp error');
        $this->controller_name = 'dashboard';
    }

    public function index()
    {
        redirect('admin/dashboard', 'refresh');
    }

    public function dashboard()
    {

        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_type_id = $session_data['role'];

            //$this->dashboard_model->check_das_permission($role_type_id);
            $dashboad_res = checkuserpermission($uid, $role_type_id, 'dashboard', 'dashboard');




            $data['ss_data'] = $session_data;
            $data['loadcss'] = array(
                //  'bower_components/jquery-ui/themes/base/jquery-ui.css',

            );

            $data['loadjs'] = array(
                //'bower_components/jquery-ui/jquery-ui.js'             
            );

            /*
             * page model
             */


            $data['title'] = 'Dashboard';
            $data['sub_title'] = 'Control panel';
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/account/dashboard', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }


    public function change_password()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            $role_group_id = $session_data['role_group'];
            /*
             * check user permissions
             */
            $permissions_result = '1';
            $permission_mnu_result = '';
            if ($role_group_id != '1') {
                $permissions_result = $this->base_model->check_user_permissions($uid, $this->controller_name, 'change_password');
                $permission_mnu_result = $this->base_model->get_user_permission_for_menu($uid);
            }
            if ($permissions_result == '0') {
                $id = $this->hashids_error->encode(401, dateintval('d'), dateintval('m'), dateintval('y'));
                $url = base_url('admin') . '/show_error/' . $id;
                redirect($url, 'refresh');
            }
            /* $ip = $this->user->user_login_ip($uid);
              $date = $this->user->last_login_date($uid);
              if ($ip != false) {
              $data['loginip'] = $ip->login_ip;
              }

              if ($date != false) {
              $data['lastlogin'] = $date->logout;
              } else {
              $data['lastlogin'] = date('d M Y H:i:s');
              } */
            $data['ss_data'] = $session_data;
            /*
             * page model
             */
            //$category_count = $this->dashboard_model->get_category_count();
            //$videos_count = $this->dashboard_model->get_videos_count();
            //$subscription_count = $this->dashboard_model->get_subscription_count();
            /*
             * load js
             */
            $data['loadjs'] = array(
                'js/admin/common.js',
                'js/admin/jquery.validate.min.js'
            );

            $data['title'] = 'Dashboard';
            $data['sub_title'] = 'Change Password';
            $data['enquiry_notifi'] = $this->base_model->get_customer_enquiry();
            $data['role_type_name'] = $role['role_type_name'];
            $data['role_type_code'] = $role['role_type_code'];
            $data['permission_menu'] = $permission_mnu_result;

            $this->load->library('form_validation');
            $this->form_validation->set_rules('old_pwd', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('cnew_pwd', 'Confirmation New Password', 'trim|required|matches[new_pwd]');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/change_password', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $old_pwd = $this->input->post('old_pwd');
                $new_pwd = $this->input->post('new_pwd');
                $pwd = $this->usersupport->encrypt_decrypt('encrypt', $old_pwd);
                $check_valid_user = $this->dashboard_model->check_valid_user($uid, $pwd);
                if ($check_valid_user) {
                    $pwd = $this->usersupport->encrypt_decrypt('encrypt', $new_pwd);
                    $result = $this->dashboard_model->update_password($uid, $pwd);
                } else {
                    $result = FALSE;
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Password Updated Successfully.');
                    redirect('admin/dashboard/change_password', 'refresh');
                } else {
                    redirect('admin/dashboard/logout', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function logout()
    {
        if ($this->session->has_userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $this->user->update_user_log($session_data['log_id']);
            $unset_items = array('srihertemp_admin_logged_in', 'admin_insertid');
            $this->session->unset_userdata($unset_items);
            redirect('admin', 'refresh');
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }
}
