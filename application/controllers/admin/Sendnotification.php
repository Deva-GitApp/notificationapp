<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Sendnotification extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/sendnotification_model',
        );


        $lib_ary = array(
            'imageupload',
            //'usersupport',
        );

        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher sendnotification error');
    }

    public function index()
    {
        redirect('admin/sendnotification/view', 'refresh');
    }

    public function view()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Student Data';
            $data['sub_title'] = 'View';
            /*
              $data['loadcss'] = array(
              'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
              );
              $data['loadjs'] = array(
              'bower_components/datatables.net/js/jquery.dataTables.min.js',
              'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',


              );
             */
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
                //                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                //                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
                //                'bower_components/datatable.net.btns/css/jquery.dataTables.min.css',
                //                'bower_components/datatable.net.btns/css/buttons.dataTables.min.css',
            );
            $data['loadjs'] = array(
                'bower_components/datatables.net/js/jquery.dataTables.min.js',
                'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'bower_components/datatable.net.btns/js/dataTables.buttons.min.js',
                'bower_components/datatable.net.btns/js/jszip.min.js',
                'bower_components/datatable.net.btns/js/pdfmake.min.js',
                'bower_components/datatable.net.btns/js/vfs_fonts.js',
                'bower_components/datatable.net.btns/js/buttons.html5.min.js',
            );

            //            $data['role_type_list'] = $this->employee_model->get_all_role_type();
            //            $data['department_list'] = $this->employee_model->get_all_departments();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/studentdata/view_studentdata', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function create()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            //  $employee_id = $session_data['employee'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Student Data';
            $data['sub_title'] = 'Create';

            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
                'bower_components/select2/dist/css/select2.min.css',
                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'bower_components/datatables.net/js/jquery.dataTables.min.js',
                'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'bower_components/datatable.net.btns/js/dataTables.buttons.min.js',
                'bower_components/datatable.net.btns/js/jszip.min.js',
                'bower_components/datatable.net.btns/js/pdfmake.min.js',
                'bower_components/datatable.net.btns/js/vfs_fonts.js',
                'bower_components/datatable.net.btns/js/buttons.html5.min.js',
            );

            $data['studentdata_list'] = $this->sendnotification_model->get_all_student_datas();

            $this->load->library('form_validation');

            $this->form_validation->set_rules('btn_submit', "Duration", "trim");

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/sendnotification/create', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                if (!empty($_POST['student_id'])) {
                    $student_id_ary = $this->input->post('student_id');
                    foreach ($student_id_ary as $value) {
                        $mail_data = $this->sendnotification_model->get_student_data($value);
                        //                        echo '<pre>';
                        //                        print_r($mail_data);
                        //                        echo '</pre>';
                        //                        exit;
                        //$res = $this->usersupport->sent_notification_mail($mail_data);
                        $res = TRUE;
                        if ($res != FALSE) {
                            $this->sendnotification_model->update_mail_status($value);
                        }
                    }
                } else {
                    $this->session->set_flashdata('db_error', 'No Data selected');
                    redirect('admin/sendnotification/create', 'refresh');
                }



                if ($res != FALSE) {
                    $this->session->set_flashdata('db_sucess', 'Notification Sent Successfully.');
                    redirect('admin/sendnotification/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Notification Sent Failed.');
                    redirect('admin/sendnotification/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }



    /* public function ajax_send_receipt()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            if (isset($_POST) && !empty($_POST)) {
                $student_id = $this->input->post('student_id');
                $main_receipt_details = $this->student_model->get_all_nofication_details($student_id);
                if ($main_receipt_details != FALSE) {
                    $receipt_id = array_column($main_receipt_details, 'receipt_id');
                    if (!empty($student_ids_ary)) {
                    $student_ids_ary = array_unique(array_column($student_ids_ary, 'fk_student_id'));
                    $student_data = $this->student_model->get_all_students($student_ids_ary);
                    $success_count = 0;
                    $failure_count = 0;
                    foreach ($student_data as $key => $student) {
                        $student_id = $student['student_id'];
                        $student_name = $student['student_name'];
                        $student_barcode = $student['student_barcode'];
                        $course_name = $student['course_name'];
                        $batch = $student['batch'];
                        $enc_stud_id = $this->usersupport->encrypt_decrypt('encrypt', $student_id);

                        $url = base_url() . '/userenclogin/receipt/' . $enc_stud_id;
                        $mail_data['url'] = $url;
                        $mail_data['student_id'] = $student_id;
                        $mail_data['student_name'] = $student_name;
                        $mail_data['student_barcode'] = $student_barcode;
                        $mail_data['course_name'] = $course_name;
                        $mail_data['batch'] = $batch;
                        $mail_data['user_mail'] = $student_barcode . '@sriramachandra.edu.in';
                        $res = true; //$this->usersupport->sent_notification_mail($mail_data);
                        if ($res) {
                            $this->student_model->update_receipt_mailstatus($student_id, $excelid);
                            $success_count++;
                        } else {
                            $failure_count++;
                        }
                    }

                    echo json_encode(
                        array(
                            'success' => $success_count,
                            'failure' => $success_count,
                        )
                    );
                }
                }
            }
        }
    } */
}
