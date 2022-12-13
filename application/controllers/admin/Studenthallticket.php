<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Studenthallticket extends CI_Controller
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
        $this->hashids = new Hashids\Hashids('the sriher studenthallticket error');
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

            $data['studenthallticket_list'] = $this->student_model->get_all_studenthallticket();

            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/studenthallticket/view_studenthallticket', $data);
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
            $data['title'] = 'Student Hall Ticket Data';
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

            $data['excel_data'] = $this->student_model->get_all_uploaded_hallticketexcel_data();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Document', 'trim');
            if (empty($_FILES['studenthallticket_file']['name'])) {
                $this->form_validation->set_rules('studenthallticket_file', 'Document', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/studenthallticket/addstudenthallticket', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $student_file = $_FILES['studenthallticket_file'];
                $uplpath = 'studenthallticket';
                $res = $this->imageupload->csvupload($student_file, $inp_name = 'studenthallticket_file', $uplpath);
                if ($res != FALSE) {
                    $hallticketexcel_id = $this->student_model->add_hallticketexcel_details($res);
                    $path = './admin_assets/upload/studenthallticket/' . $res['file_name'];
                    $row = 0;
                    if (($handle = fopen($path, "r")) !== FALSE) {
                        $student_data_ary = array();
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if ($row != 0) {
                                $student_data_ary_item['progcode'] = $data[0];
                                $student_data_ary_item['student_barcode'] = $data[1];
                                $student_data_ary_item['student_name'] = $data[2];
                                $student_data_ary_item['dob'] = $data[3];
                                $student_data_ary_item['student_batch'] = $data[4];
                                $student_data_ary_item['course_code'] = $data[5];
                                $student_data_ary_item['hall_tck_course_name'] = $data[6];
                                $student_data_ary_item['examdate'] = $data[7];
                                $student_data_ary_item['examtime'] = $data[8];
                                $student_data_ary_item['student_course'] = $data[9];
                                $student_data_ary_item['fullmonthyear'] = $data[10];
                                $student_data_ary_item['yearsempart'] = $data[11];
                                $student_data_ary_item['yearsemhead'] = $data[12];
                                $student_data_ary_item['sylyear'] = $data[13];
                                $student_data_ary_item['mysession'] = $data[14];
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
                            $student_dob = date('Y-m-d', strtotime($value['dob']));
                            $student_course = $value['student_course'];
                            $student_name = $value['student_name'];
                            $student_batch = $value['student_batch'];
                            /* STUDENT DETAILS */

                            /* HALL TICKET DETAILS */

                            $progcode = $value['progcode'];
                            $dob = date('Y-m-d', strtotime($value['dob']));
                            $course_code = $value['course_code'];
                            $hall_tck_course_name = $value['hall_tck_course_name'];
                            $examdate = date('Y-m-d', strtotime($value['examdate']));
                            $examtime = $value['examtime'];
                            $fullmonthyear = $value['fullmonthyear'];
                            $yearsempart = $value['yearsempart'];
                            $yearsemhead = $value['yearsemhead'];
                            $sylyear = $value['sylyear'];
                            $mysession = $value['mysession'];
                            /* HALL TICKET DETAILS */



                            if ($student_barcode != 'NULL') {
                                $student_data = $this->student_model->check_hallticket_fr_student($student_barcode);
                                if ($student_data == FALSE) {
                                    $student_id = $this->student_model->add_student_data($student_name, $student_barcode, $student_course, $student_batch, $student_newdes = null, $student_dob, $session_data['id']);
                                } else {
                                    $student_id = $student_data['student_id'];
                                }
                                if ($student_id != FALSE) {
                                    $receipt_data = $this->student_model->check_hallticket_datadet($student_id, $student_barcode, $course_code);
                                    if ($receipt_data == FALSE) {
                                        $res = $this->student_model->add_student_hallticket($student_id, $student_barcode, $progcode, $dob, $course_code, $hall_tck_course_name, $examdate, $examtime, $fullmonthyear, $yearsempart, $yearsemhead, $sylyear, $mysession, $hallticketexcel_id, $session_data['id']);
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                    $this->session->set_flashdata('db_sucess', 'Student receipt data uploaded successfully');
                    redirect('admin/studenthallticket/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'File Upload Error Please try Again');
                    redirect('admin/studenthallticket/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }



    public function ajax_send_hallticket()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            if (isset($_POST) && !empty($_POST)) {
                $excelid = $this->input->post('excelid');
                $student_ids_ary = $this->student_model->get_all_students_hall_ticket_id($excelid);
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
                        $url = base_url() . 'userenclogin/hallticket/' . $enc_stud_id;
                        $mail_data['url'] = $url;
                        $mail_data['student_id'] = $student_id;
                        $mail_data['student_name'] = $student_name;
                        $mail_data['student_barcode'] = $student_barcode;
                        $mail_data['course_name'] = $course_name;
                        $mail_data['batch'] = $batch;
                        $mail_data['user_mail'] = $student_barcode . '@sriramachandra.edu.in';
                        $res = true; //$this->usersupport->sent_notification_mail($mail_data);

                        if ($res) {
                            $this->student_model->update_hallticket_mailstatus($student_id, $excelid);
                            $success_count++;
                        } else {
                            $failure_count++;
                        }

                        //exit;
                    }
                    $msg['msg'] = array(
                        'success' => $success_count,
                        'failure' => $failure_count,
                    );
                    echo json_encode($msg['msg']);
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }
}
