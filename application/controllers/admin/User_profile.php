<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class User_profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user_model',
        );
        $lib_ary = array(
            'imageupload',
        );
        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the srh-ola user error');
    }

    public function index() {
        redirect('admin/user/profile', 'refresh');
    }

    public function profile($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            $data['role_name'] = $role;




            $data['ss_data'] = $session_data;
            $data['title'] = 'Doctor';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                'plugins/iCheck/all.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
                'bower_components/autocomplete/typeahead.js',
                'plugins/iCheck/icheck.min.js',
                'dist/js/form_validation/doctor.js',
            );

            /* decode url */
            $numbers = $this->hashids->decode($id);
//            print_r($numbers);

            if ($role['role_type_name'] == 'Doctor') {
                $data['employee_data'] = $this->user_model->get_doctor_by_id($numbers[0]);
            } else {
                $data['employee_data'] = $this->user_model->get_user_by_id($numbers[0]);
            }
            $data['role_type_list'] = $this->user_model->get_all_role_type();
            $data['department_list'] = $this->user_model->get_all_departments();

            //$this->output->enable_profiler(TRUE);
            //callback_slt_check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
            $this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required');
            $this->form_validation->set_rules('employee_email', 'Employee Email', 'trim|required');
            $this->form_validation->set_rules('employee_password', 'Employee Password', 'trim|required');
            $this->form_validation->set_rules('employee_address', 'Employee Address', 'trim|required');
            $this->form_validation->set_rules('employee_sec_pin', 'Employee Secure Pin', 'trim|required');
            $this->form_validation->set_rules('employee_mobile', 'Employee Mobile', 'trim|required');
            $this->form_validation->set_rules('emp_pincode', 'Employee Pincode', 'trim|required');
            $this->form_validation->set_rules('geolocationid', 'Employee Pincode', 'trim|required');
            //$this->form_validation->set_rules('slt_role', 'Role', 'trim|required|callback_slt_check');
            $this->form_validation->set_rules('slt_department', 'Department', 'trim|required|callback_slt_check');

            if ($role['role_type_name'] == 'Doctor') {
                $this->form_validation->set_rules('doctor_designation', 'Designation', 'trim|required');
                $this->form_validation->set_rules('doctor_qualification', 'Qualification', 'trim|required');
                $this->form_validation->set_rules('doctor_experience', 'Experience', 'trim|required');
                //$this->form_validation->set_rules('available_days', 'Available Days', 'trim|required');
                $this->form_validation->set_rules('doc_gender', 'Gender', 'trim|required');
                $this->form_validation->set_rules('doc_description', 'Role', 'trim');
                //$this->form_validation->set_rules('slt_role', 'Role', 'trim|required|callback_slt_check');
                //$this->form_validation->set_message('is_unique', 'This %s already exists.');
            }


            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/user/edit_profile', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {

                $role_details = $this->user_model->get_roletype_by_id($role_id);
                $role_type_name = $role_details['role_type_name'];

                $employee_name = $this->input->post('employee_name');
                $user_profile_hid = $this->input->post('user_profile_hid');
                $check_user_img = $this->user_model->check_user_profile_by_id($numbers[0], $user_profile_hid);

                if ($check_user_img == FALSE) {
                    if ($role_type_name == 'Doctor') {
                        $type = 'doctor';
                    } else {
                        $type = 'user_profile';
                    }
                    $file_name = $_FILES['user_profile']['name'][0];
                    $ext = get_extension($file_name);

                    $upload_employee_name = strtolower(str_replace(".", "", preg_replace('/[^a-zA-Z0-9-_\.]/', '', $employee_name))) . 'profile' . date('His');
                    $upload_res = $this->imageupload->do_multiple_upload($type, $_FILES['user_profile'], $upload_employee_name);
                    $user_profile = (isset($upload_res[0])) ? $upload_res[0] . '.' . $ext : 'no-image.jpg';
                } else {
                    $user_profile = $data['employee_data']['photo'];
                }
                $employee_id = $this->input->post('employee_id');
                $employee_email = $this->input->post('employee_email');
                $employee_password_str = $this->input->post('employee_password');
                $employee_password = $this->usersupport->encrypt_decrypt('encrypt', $employee_password_str);
                $employee_address = $this->input->post('employee_address');
                $employee_sec_pin = $this->input->post('employee_sec_pin');
                $employee_mobile = $this->input->post('employee_mobile');
                $employee_piconde = $this->input->post('emp_pincode');
                $employee_country = $this->input->post('country');
                $employee_state = $this->input->post('state');
                $employee_district = $this->input->post('district');
                $geolocationid = $this->input->post('geolocationid');
                $role = $this->input->post('slt_role');
                $department = $this->input->post('slt_department');



                if ($role_type_name == 'Doctor') {
                    $doctor_designation = $this->input->post('doctor_designation');
                    $doctor_qualification = $this->input->post('doctor_qualification');
                    $doctor_experience = $this->input->post('doctor_experience');
                    $doctor_gender = $this->input->post('doc_gender');
                    $doc_description = $this->input->post('doc_description');
                    $available_days_str = '1,2,3,4,5,6,7';
                } else {
                    $doctor_designation = '';
                    $doctor_qualification = '';
                    $doctor_experience = '';
                    $doctor_gender = '';
                    $doc_description = '';
                    $available_days_str = '';
                }




                $check_unq = $this->user_model->check_doctor_unique($numbers[0], $employee_email, $employee_mobile);
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->user_model->edit_doctor($numbers[0], $employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $doctor_designation, $doctor_qualification, $doctor_experience, $doctor_gender, $available_days_str, $doc_description, $department, $session_data['id']);
                } else {
                    $this->session->set_flashdata('db_error', 'This Name already exists.Please enter a different name..');
                    redirect('admin/user_profile/profile/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/user_profile/profile/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/user_profile/profile/' . $id, 'refresh');
                }
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
