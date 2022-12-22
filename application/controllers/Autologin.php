<?php

defined('BASEPATH') or exit('No direct script access allowed');


//use Hashids\Hashids;
/**
 * Description of dashboard
 *
 * @author rckumar
 */
class Autologin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $model_ary = array(
            'autologin_model',
        );

        $this->load->model($model_ary, '', true);
        $this->load->library(array('usersupport'));
        $this->hashids = new Hashids\Hashids('the autologin error');
    }

    public function userlogin($enc_data)
    {
        if (!empty($enc_data)) {
            $student_data = $this->usersupport->autologin_encrypt_decrypt('decrypt', $enc_data);
            $tudent_dat_ary = explode('_', $student_data);
            if (is_array($tudent_dat_ary)) {
                $student_regno  = $tudent_dat_ary[0];
                $student_dob  =  date('Y-m-d', strtotime($tudent_dat_ary[1]));
                $student_data = $this->autologin_model->get_student_data($student_regno, $student_dob);
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
                    $this->session->set_flashdata('db_error', 'Data Not Available.');
                    redirect(base_url(), 'refresh');
                }
            } else {
                $this->session->set_flashdata('db_error', 'Data Not Available.');
                redirect(base_url(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('db_error', 'Data Not Available.');
            redirect(base_url(), 'refresh');
        }
    }
}
