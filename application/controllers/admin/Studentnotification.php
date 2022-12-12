<?php

defined('BASEPATH') or exit('No direct script access allowed');
/* require 'vendor/autoload.php'; */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



/**
 * Description of category
 *
 * @author rckumar
 */
class Studentnotification extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/studentnotification_model',
        );

        $lib_ary = array(
            'imageupload',
            'usersupport',
            //'spreadsheetreader'
        );

        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher studentnotification error');
        $this->reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
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

            $data['studenthallticket_list'] = $this->student_model->get_all_student_datas();
            //            $data['role_type_list'] = $this->employee_model->get_all_role_type();
            //            $data['department_list'] = $this->employee_model->get_all_departments();
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
            $data['title'] = 'Student Notification';
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


            $data['notificationexcel_data'] = $this->studentnotification_model->get_all_uploaded_excel_data();


            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Document', 'trim');
            if (empty($_FILES['studentnotificationdetails_file']['name'])) {
                $this->form_validation->set_rules('studentnotificationdetails_file', 'Document', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/studentnotification/addstudentnotification', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $student_file = $_FILES['studentnotificationdetails_file'];
                $uplpath = 'studentnotificationdetails';
                $res = $this->imageupload->csvupload($student_file, $inp_name = 'studentnotificationdetails_file', $uplpath);
                if ($res != FALSE) {
                    $notificationexcel_id = $this->studentnotification_model->add_notificationdetails_excel_details($res);
                    $path = './admin_assets/upload/studentnotificationdetails/' . $res['file_name'];
                    $spreadsheet =  $this->reader->load($path);
                    $sheetCount = $spreadsheet->getSheetCount();
                    for ($i = 0; $i < $sheetCount; $i++) {
                        $sheet = $spreadsheet->getSheet($i);
                        $sheetData = $sheet->toArray(null, true, true, true);
                        if ($i == 0) {
                            foreach ($sheetData as $key => $sht1) {
                                if ($key != 1) {
                                    $session_name = $sht1['A'];
                                    $regno = $sht1['B'];
                                    $FileName = $sht1['C'];
                                    $UploadDate = $sht1['D'];
                                    $UploadBy = $sht1['E'];
                                    $ApprovedDate = $sht1['F'];
                                    $ApprovedBy = $sht1['G'];
                                    $student_data = $this->studentnotification_model->check_hallticket_fr_student($regno);
                                    if ($student_data == FALSE) {
                                        $this->studentnotification_model->add_student_data($student_name = null, $regno, $student_course = null, $student_batch = null, $student_newdes = null, $student_dob = null, $session_data['id']);
                                    }
                                }
                            }
                        }
                        if ($i == 2) {
                            foreach ($sheetData as $key => $sht1) {
                                if ($key != 1) {
                                    $MySession = $sht1['A'];
                                    $RegNo = $sht1['B'];
                                    $ApplFees = $sht1['C'];
                                    $MSFees = $sht1['D'];
                                    $PCFees = $sht1['E'];
                                    $DissFees = $sht1['F'];
                                    $CMFees = $sht1['G'];
                                    $ConvFees = $sht1['H'];
                                    $UploadDate =  date('Y-m-d H:i:s', strtotime($sht1['I']));
                                    $UploadBy = $sht1['J'];
                                    $ApprovedDate = date('Y-m-d H:i:s', strtotime($sht1['K']));
                                    $ApprovedBy = $sht1['L'];

                                    $student_data = $this->studentnotification_model->check_student_notification_dup($regno);
                                    if ($student_data == FALSE) {
                                        $this->studentnotification_model->add_student_notification($MySession, $RegNo, $ApplFees, $MSFees, $PCFees, $DissFees, $CMFees, $ConvFees, $UploadDate, $UploadBy, $ApprovedDate, $ApprovedBy, $notificationexcel_id, $session_data['id']);
                                    }
                                }
                            }
                        }
                    }
                    for ($j = 0; $j < $sheetCount; $j++) {
                        if ($j == 1) {
                            $sheet = $spreadsheet->getSheet($j);
                            $sheetData = $sheet->toArray(null, true, true, true);
                            foreach ($sheetData as $key => $sht1) {
                                if ($key != 1) {
                                    $MySession = $sht1['A'];
                                    $MonYr = $sht1['B'];
                                    $FullMonYr = $sht1['C'];
                                    $ProgCode = $sht1['D'];
                                    $Programme = $sht1['E'];
                                    $SyllabusYear = $sht1['F'];
                                    $YrSemPart = $sht1['G'];
                                    $YrSemHead = $sht1['H'];
                                    $CourseCode = $sht1['I'];
                                    $ElecCode = $sht1['J'];
                                    $Course = $sht1['K'];
                                    $RegNo = $sht1['L'];
                                    $Fees = $sht1['M'];
                                    $UploadDate =  date('Y-m-d H:i:s', strtotime($sht1['N']));
                                    $UploadBy = $sht1['O'];
                                    $ApprovedDate = date('Y-m-d H:i:s', strtotime($sht1['P']));
                                    $ApprovedBy = $sht1['Q'];
                                    $student_data = $this->studentnotification_model->check_student_notificationdetail_dup($RegNo, $CourseCode);
                                    if ($student_data == FALSE) {
                                        $notification_data =   $this->studentnotification_model->get_student_notification_by_reg_no($RegNo);
                                        if ($notification_data != FALSE) {
                                            $res =  $this->studentnotification_model->update_student_details($RegNo, $Programme);
                                            $res = true;
                                            if ($res != false) {
                                                $this->studentnotification_model->add_student_notification_details($MySession, $MonYr, $FullMonYr, $ProgCode, $Programme, $SyllabusYear, $YrSemPart, $YrSemHead, $CourseCode, $ElecCode, $Course, $RegNo, $Fees, $UploadDate, $UploadBy, $ApprovedDate, $ApprovedBy, $session_data['id']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $this->session->set_flashdata('db_sucess', 'Student Notification data uploaded successfully');
                    redirect('admin/studentnotification/create', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'File Upload Error Please try Again');
                    redirect('admin/studentnotification/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }


    public function ajax_send_notification()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            if (isset($_POST) && !empty($_POST)) {
                $excelid = $this->input->post('excelid');
                $student_data = $this->studentnotification_model->get_all_nofication_details($excelid);
                // var_dump($student_data);
                if (!empty($student_data)) {
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
                            $this->studentnotification_model->update_notifiction_mailstatus($student_id, $excelid);
                            $success_count++;
                        } else {
                            $failure_count++;
                        }
                    }
                    $ary = array(
                        'success' => $success_count,
                        'failure' => $failure_count,
                    );
                    echo json_encode($ary);
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }
}
