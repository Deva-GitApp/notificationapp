<?php

defined('BASEPATH') or exit('No direct script access allowed');

//use Hashids\Hashids;
/**
 * Description of dashboard
 *
 * @author rckumar
 */
class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $model_ary = array(
            'home_model',
            // 'admin/user',
            // 'admin/dashboard_model',
        );
        $this->load->model($model_ary, '', true);
        //        $this->load->library(array('usersupport'));      
    }

    public function index()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            redirect(base_url('dashboard'), 'refresh');
        }
        $data = '';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('student_reg_no', 'Student Registration Number', 'trim|required');
        //$this->form_validation->set_rules('receipt_no', 'Receipt Number', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('includes/header', $data);
            //$this->load->view('includes/menu', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('includes/footer', $data);
        } else {
            $student_reg_no = $this->input->post('student_reg_no');
            $receipt_no = $this->input->post('receipt_no');
            $student_data = $this->home_model->get_student_data($student_reg_no, $receipt_no);
            if ($student_data != FALSE) {
                $sess_array = array(
                    'student_id' => $student_data['student_id'],
                    'student_name' => $student_data['student_name'],
                    'student_barcode' => $student_data['student_barcode'],
                    'course_name' => $student_data['course_name'],
                    'batch' => $student_data['batch'],
                    'status' => $student_data['status'],
                );
                $this->session->set_userdata('srihertemp_user_logged_in', $sess_array);
                redirect(base_url('dashboard'), 'refresh');
            } else {
                //                $this->session->set_flashdata('db_sucess', 'Password Updated Successfully.');
                $this->session->set_flashdata('db_error', 'Data Not Available.');
                redirect(base_url(), 'refresh');
            }
        }
    }

    public function dashboard()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $data['user_session_data'] = $this->session->has_userdata('srihertemp_user_logged_in');
            $this->load->view('includes/header', $data);
            $this->load->view('includes/menu', $data);
            $this->load->view('pages/dashboard', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function logout()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $unset_items = array('srihertemp_user_logged_in');
            $this->session->unset_userdata($unset_items);
            redirect(base_url(), 'refresh');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
