<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Permission extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/permission_model'
        );

        $this->load->model($data, '', true);
        $this->hashids = new Hashids\Hashids('the srh-ola employee error');
        $this->hashidsrole = new Hashids\Hashids('the srh-ola role_type error');
    }

    public function index() {
        redirect('admin/permission/view', 'refresh');
    }

    public function employee_permission($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee Permission';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'plugins/iCheck/all.css',
            );
            $data['loadjs'] = array(
                // 'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'plugins/iCheck/icheck.min.js'
            );
            /* decode url */
            $numbers = $this->hashids->decode($id);            
            
            
            $pages_list = $this->permission_model->get_all_pages_list();
            $data['pages_list'] = $pages_list;
            $permission = $this->permission_model->get_existing_permission($numbers[0]);
            if (!empty($permission)) {
                $batch_ary = array();
                foreach ($permission as $value) {
                    $item['fk_page_code'] = $value['fk_page_code'];
                    $item['permission_id'] = $value['permission_id'];
                    $item['fk_action_code'] = $value['fk_action_code'];
                    $batch_ary[$value['fk_page_code']] = $item;
                }
                $data['user_permission'] = $batch_ary;
            } else {
                $user_details = $this->permission_model->get_user_details_by_id($numbers[0]);
                $roletype_id = $user_details['fk_roletype_id'];

                $permission = $this->permission_model->get_role_type_permission($roletype_id);
                if (!empty($permission)) {
                    $batch_ary = array();
                    foreach ($permission as $value) {
                        $item['fk_page_code'] = $value['fk_page_code'];
                        $item['permission_id'] = $value['role_type_permission_id'];
                        $item['fk_action_code'] = $value['fk_action_code'];
                        $batch_ary[$value['fk_page_code']] = $item;
                    }
                    $data['user_permission'] = $batch_ary;
                } else {
                    $data['user_permission'] = '';
                }
            }
            $data['employee_data'] = $this->permission_model->get_employee_by_id($numbers[0]);
            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Employee Name', 'trim');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/permission/edit_employee_permission', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';
//                exit;
                $result = FALSE;
                $result_ary = array();
                $result_ary1 = array();
                foreach ($pages_list as $value) {
                    if (isset($_POST[$value['short_code']])) {
                        //echo 'asd';
                        $check_permission = $this->permission_model->check_employee_permission($numbers[0], $value['short_code']);
                        if ($check_permission) {
                            $page_action_ary = $this->input->post($value['short_code']);
                            $priority = $this->input->post($value['short_code'] . '_priority');
                            $page_action_str = implode(',', $page_action_ary);
                            $res = $this->permission_model->update_employee_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                            if ($res) {
                                array_push($result_ary, $res);
                            }
                        } else {
                            $page_action_ary = $this->input->post($value['short_code']);
                            $priority = $this->input->post($value['short_code'] . '_priority');
                            $page_action_str = implode(',', $page_action_ary);
                            $res = $this->permission_model->add_employee_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                            if ($res) {
                                array_push($result_ary, $res);
                            }
                        }
                    } else {
                        $page_action_str = '';
                        $priority = '';
                        $result = $this->permission_model->update_employee_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                        if ($result) {
                            array_push($result_ary1, $result);
                        }
                    }
                }
                if (!empty($result_ary) || $result_ary1) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/permission/employee_permission/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'No Changes made.');
                    redirect('admin/permission/employee_permission/' . $id, 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function roletype_permission($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Role Type Permission';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'plugins/iCheck/all.css',
            );
            $data['loadjs'] = array(
                // 'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'plugins/iCheck/icheck.min.js'
            );
            /* decode url */
            $numbers = $this->hashidsrole->decode($id);
            $pages_list = $this->permission_model->get_all_pages_list();
            $data['pages_list'] = $pages_list;
            $permission = $this->permission_model->get_role_type_permission($numbers[0]);
            if (!empty($permission)) {
                $batch_ary = array();
                foreach ($permission as $value) {
                    $item['fk_page_code'] = $value['fk_page_code'];
                    $item['permission_id'] = $value['role_type_permission_id'];
                    $item['fk_action_code'] = $value['fk_action_code'];
                    $batch_ary[$value['fk_page_code']] = $item;
                }
                $data['user_permission'] = $batch_ary;
            } else {
                $data['user_permission'] = '';
            }



            $data['roletype_data'] = $this->permission_model->get_role_type_by_id($numbers[0]);
            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Employee Name', 'trim');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/permission/edit_roletype_permission', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $post_ary = $_POST;

                $result = FALSE;
                $result_ary = array();
                $result_ary1 = array();
                foreach ($pages_list as $value) {
                    if (isset($_POST[$value['short_code']])) {
                        //echo 'asd';
                        $check_permission = $this->permission_model->check_roletype_permission($numbers[0], $value['short_code']);
                        if ($check_permission) {
                            $page_action_ary = $this->input->post($value['short_code']);
                            $priority = $this->input->post($value['short_code'] . '_priority');
                            $page_action_str = implode(',', $page_action_ary);
                            $res = $this->permission_model->update_roletype_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                            if ($res) {
                                array_push($result_ary, $res);
                            }
                        } else {
                            $page_action_ary = $this->input->post($value['short_code']);
                            $priority = $this->input->post($value['short_code'] . '_priority');
                            $page_action_str = implode(',', $page_action_ary);
                            $res = $this->permission_model->add_roletype_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                            if ($res) {
                                array_push($result_ary, $res);
                            }
                        }
                    } else {
                        $page_action_str = '';
                        $priority = '';
                        $result = $this->permission_model->update_roletype_permission($numbers[0], $value['short_code'], $page_action_str, $priority, $uid);
                        if ($result) {
                            array_push($result_ary1, $result);
                        }
                    }
                }
                if (!empty($result_ary) || !empty($result_ary1)) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/permission/roletype_permission/' . $id, 'refresh');
                    $user_id_ary = $this->permission_model->get_user_by_role($numbers[0]);
                    if ($user_id_ary) {
                        $user_res_batch = array();
                        foreach ($user_id_ary as $value) {
                            $emp_id = $value['admin_id'];
                            $user_res = $this->update_user_permission($pages_list, $post_ary, $emp_id, $uid);
                            array_push($user_res_batch, $user_res);
                        }
                    }
                    if ($user_res_batch) {
                        
                    } else {
                        $this->session->set_flashdata('db_error', 'No Changes made.');
                        redirect('admin/permission/roletype_permission/' . $id, 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('db_error', 'No Changes made.');
                    redirect('admin/permission/roletype_permission/' . $id, 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function update_user_permission($pages_list, $postary, $emp_id, $uid) {
        $result = FALSE;
        $result_ary = array();
        $result_ary1 = array();
        foreach ($pages_list as $value) {
            if (isset($postary[$value['short_code']])) {
                //echo 'asd';
                $check_permission = $this->permission_model->check_employee_permission($emp_id, $value['short_code']);
                if ($check_permission) {
                    $page_action_ary = $this->input->post($value['short_code']);
                    $page_action_str = implode(',', $page_action_ary);
                    $res = $this->permission_model->update_employee_permission($emp_id, $value['short_code'], $page_action_str, $uid);
                    if ($res) {
                        array_push($result_ary, $res);
                    }
                } else {
                    $page_action_ary = $this->input->post($value['short_code']);
                    $page_action_str = implode(',', $page_action_ary);
                    $res = $this->permission_model->add_employee_permission($emp_id, $value['short_code'], $page_action_str, $uid);
                    if ($res) {
                        array_push($result_ary, $res);
                    }
                }
            } else {
                $page_action_str = '';
                $result = $this->permission_model->update_employee_permission($emp_id, $value['short_code'], $page_action_str, $uid);
                if ($result) {
                    array_push($result_ary1, $result);
                }
            }
        }
        if (!empty($result_ary) || !empty($result_ary1)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
