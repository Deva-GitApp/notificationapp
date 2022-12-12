<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Notification extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/notification_model',
        );


        $lib_ary = array(
            'imageupload',
            'usersupport',
        );

        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher notification error');
    }

    public function index() {
        redirect('admin/employee/view', 'refresh');
    }

    public function view() {
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

            $data['notification_list'] = $this->notification_model->get_all_student_datas();
//            $data['role_type_list'] = $this->employee_model->get_all_role_type();
//            $data['department_list'] = $this->employee_model->get_all_departments();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/notification/view_notification', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function create() {
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
                'bower_components/select2/dist/css/select2.min.css',
                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
            );

            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Document', 'trim');
            if (empty($_FILES['notification_file']['name'])) {
                $this->form_validation->set_rules('notification_file', 'Notification File', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/notification/addnotification', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $student_file = $_FILES['notification_file'];
                $res = $this->imageupload->csvupload($student_file);
                if ($res != FALSE) {
                    $this->notification_model->add_excel_details($res);
                    $path = './admin_assets/upload/notification/' . $res['file_name'];
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== FALSE) {
                        $student_data_ary = array();
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if ($row != 0) {
                                $student_data_ary_item['student_name'] = $data[0];
                                $student_data_ary_item['student_course'] = $data[1];
                                $student_data_ary_item['student_batch'] = $data[2];
                                $student_data_ary_item['student_session'] = $data[3];
                                $student_data_ary_item['student_barcode'] = $data[4];
                                $student_data_ary_item['student_file'] = $data[5];
                                $student_data_ary_item['student_file_upload_data'] = $data[6];
                                $student_data_ary_item['student_file_upload_by'] = $data[7];
                                $student_data_ary_item['student_file_approved_date'] = $data[8];
                                $student_data_ary_item['student_file_approved_by'] = $data[10];
                                array_push($student_data_ary, $student_data_ary_item);
                            }
                            $row++;
                        }
                        fclose($handle);
                    }

                    if (!empty($student_data_ary)) {
                        $i = 0;
                        foreach ($student_data_ary as $key => $value) {
                            /* STUDENT DETAILS */
                            $student_barcode = $value['student_barcode'];
                            $student_course = $value['student_course'];
                            $student_name = $value['student_name'];
                            $student_batch = $value['student_batch'];
                            $student_newdes = NULL;
                            /* STUDENT DETAILS */

                            /* NOTIFICATION DETAILS */
                            $student_session = $value['student_session'];
                            $student_file = $value['student_file'];
                            $student_file_upload_data = $value['student_file_upload_data'];
                            $student_file_upload_by = $value['student_file_upload_by'];
                            $student_file_approved_date = $value['student_file_approved_date'];
                            $student_file_approved_by = $value['student_file_approved_by'];
                            /* NOTIFICATION DETAILS */


                            if ($student_barcode != 'NULL') {
                                $student_data = $this->notification_model->check_fr_student($student_barcode);
                                if ($student_data == FALSE) {
                                    $student_id = $this->notification_model->add_student_data($student_name, $student_barcode, $student_course, $student_batch, $student_newdes, $session_data['id']);
                                } else {
                                    $student_id = $student_data['student_id'];
                                }
                                if ($student_id != FALSE) {
                                    $receipt_id = $this->notification_model->add_student_session($student_id, $student_barcode, $student_session, $student_file, $student_file_upload_data, $student_file_upload_by, $student_file_approved_date, $student_file_approved_by, $session_data['id']);
                                    // $receipt_data = $this->notification_model->check_session_duplicate($receipt_number, $student_barcode);
                                    // if ($receipt_data == FALSE) {
                                    // } else {
                                    //    $receipt_id = $receipt_data['receipt_id'];
                                    // }
                                }
                            }
                            $i++;
                        }
                    }
                    $this->session->set_flashdata('db_sucess', 'Student Session data uploaded successfully');
                    redirect('admin/notification/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'File Upload Error Please try Again');
                    redirect('admin/notification/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

//   
//
//    public function ajax_send_receipt() {
//        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
//            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
//            $uid = $session_data['id'];
//            if (isset($_POST) && !empty($_POST)) {
//                $student_id = $this->input->post('student_id');
//                $main_receipt_details = $this->notification_model->get_receipt_details($student_id);
//                if ($main_receipt_details != FALSE) {
//                    $receipt_id = array_column($main_receipt_details, 'receipt_id');
//                }
//
//
//                echo '<pre>';
//                print_r($receipt_details);
//                echo '</pre>';
//            }
//        }
//    }
}
