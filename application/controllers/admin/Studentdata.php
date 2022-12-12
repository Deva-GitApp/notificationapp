<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class studentdata extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/student_model',
        );

        $lib_ary = array(
            'imageupload',
            'usersupport',
        );

        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher studentdata error');
    }

    public function index()
    {
        redirect('admin/employee/view', 'refresh');
    }

    public function view()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Student Receipt Data';
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

            $data['students_list'] = $this->student_model->get_all_student_datas();

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
            $data['title'] = 'Student Receipt Data';
            $data['sub_title'] = 'Create';

            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
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

            $data['excel_data'] = $this->student_model->get_all_uploaded_excel_data();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Document', 'trim');
            if (empty($_FILES['studentdata_file']['name'])) {
                $this->form_validation->set_rules('studentdata_file', 'Document', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/studentdata/addstudentdata', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $student_file = $_FILES['studentdata_file'];
                $uplpath = 'studentdata';
                $res = $this->imageupload->csvupload($student_file, $inp_name = 'studentdata_file', $uplpath);
                //                $res = $this->imageupload->csvupload($student_file);
                if ($res != FALSE) {
                    $excel_id = $this->student_model->add_excel_details($res);
                    $path = './admin_assets/upload/studentdata/' . $res['file_name'];
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== FALSE) {
                        $student_data_ary = array();
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if ($row != 0) {
                                $student_data_ary_item['receipt_number'] = $data[0];
                                $student_data_ary_item['receipt_date'] = $data[1];
                                $student_data_ary_item['receipt_amount'] = $data[2];
                                $student_data_ary_item['receipt_paytype'] = $data[3];
                                $student_data_ary_item['receipt_paymode'] = $data[4];
                                $student_data_ary_item['receipt_des'] = $data[5];
                                $student_data_ary_item['receipt_vdes'] = $data[6];
                                $student_data_ary_item['student_barcode'] = $data[7];
                                $student_data_ary_item['student_newdes'] = $data[8];
                                $student_data_ary_item['student_course'] = $data[9];
                                $student_data_ary_item['student_rec_detno'] = $data[10];
                                $student_data_ary_item['student_batch'] = $data[11];
                                $student_data_ary_item['student_rec_dethead'] = $data[12];
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
                            $receipt_des = explode('/', $value['receipt_des']);
                            $student_name = $receipt_des[0];
                            $student_batch = $value['student_batch'];
                            $student_newdes = $value['student_newdes'];
                            /* STUDENT DETAILS */

                            /* RECEIPT DETAILS */
                            $receipt_number = $value['receipt_number'];
                            $receipt_date = $value['receipt_date'];
                            $receipt_cdno = $value['receipt_paytype'];
                            $receipt_paymode = $value['receipt_paymode'];
                            $receipt_des = $value['receipt_vdes'];
                            /* RECEIPT DETAILS */


                            /* RECEIPT SUB DETAILS */
                            $student_rec_detno = $value['student_rec_detno'];
                            $student_rec_dethead = $value['student_rec_dethead'];
                            $receipt_amount = $value['receipt_amount'];

                            /* RECEIPT SUB DETAILS */

                            if ($student_barcode != 'NULL') {
                                $student_data = $this->student_model->check_receipt_fr_student($student_barcode);
                                if ($student_data == FALSE) {
                                    $student_id = $this->student_model->add_student_data($student_name, $student_barcode, $student_course, $student_batch, $student_newdes, $session_data['id']);
                                } else {
                                    $student_id = $student_data['student_id'];
                                }
                                if ($student_id != FALSE) {
                                    $receipt_data = $this->student_model->check_receipt_datadet($receipt_number, $student_barcode);
                                    if ($receipt_data == FALSE) {
                                        $receipt_id = $this->student_model->add_student_receipt($student_id, $student_barcode, $receipt_number, $receipt_date, $receipt_cdno, $receipt_paymode, $receipt_des, $excel_id, $session_data['id']);
                                    } else {
                                        $receipt_id = $receipt_data['receipt_id'];
                                    }
                                    if ($receipt_id != FALSE) {
                                        $receiptsubdet_data = $this->student_model->check_receipt_subdatadet($receipt_id, $student_rec_detno);
                                        if ($receiptsubdet_data == FALSE) {
                                            $receipt_id = $this->student_model->add_student_receipt_details($student_id, $receipt_id, $student_rec_detno, $student_rec_dethead, $receipt_amount, $session_data['id']);
                                        }
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                    $this->session->set_flashdata('db_sucess', 'Student receipt data uploaded successfully');
                    redirect('admin/studentdata/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'File Upload Error Please try Again');
                    redirect('admin/studentdata/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }



    public function ajax_send_receipt()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            if (isset($_POST) && !empty($_POST)) {
                $excelid = $this->input->post('excelid');
                $student_ids_ary = $this->student_model->get_all_students_id($excelid);
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
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }
}
