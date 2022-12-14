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
            'pages_model',
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
            $data['title'] = 'Student Hall Ticket Data';
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

            $this->load->library('form_validation');
            $this->form_validation->set_rules('btn_submit', 'Document', 'trim');
            $this->form_validation->set_rules('student_id[]', 'Student', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/studenthallticket/view_studenthallticket', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $student_id_ary = $this->input->post('student_id[]');
                $total_student_ary = array_column($data['studenthallticket_list'], 'student_id');
                $student_list_toremove = array_diff($total_student_ary, $student_id_ary);
                $resremove = false;
                if (!empty($student_list_toremove)) {
                    $resremove =  $this->student_model->update_hall_preview_status_remove($student_list_toremove);
                }

                $res = $this->student_model->update_hall_preview_status($student_id_ary, $student_list_toremove);
                if ($res || $resremove) {
                    $this->session->set_flashdata('db_sucess', 'Student Permission Updated');
                    redirect('admin/studenthallticket/view', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'No Updation Done');
                    redirect('admin/studenthallticket/view', 'refresh');
                }
            }
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
                $form_data = $this->input->post('form_data');
                parse_str($form_data, $searcharray);
                if (!empty($searcharray['student_id'])) {
                    $excelid =  $searcharray['student_excel_id'];
                    $student_ids_ary = $searcharray['student_id'];
                    $student_data = $this->student_model->get_all_students_hall_ticket($student_ids_ary);

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


    public function preview_students_list()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            if (isset($_POST) && !empty($_POST)) {
                $excelid = $this->input->post('excelid');
                $student_data_ary = $this->student_model->get_all_students_frpreview($excelid);
                if (!empty($student_data_ary)) {
                    $html = '';
                    foreach ($student_data_ary as $studentdata) {
                        $student_dob =  ($studentdata['student_dob'] != NULL) ? date('d M Y', strtotime($studentdata['student_dob'])) : ' - ';
                        $mail_status =  ($studentdata['hallticket_email_status'] != 0) ? 'Sent Successfully' : 'Not Yet Sent';
                        $student_id =  ($studentdata['hallticket_email_status'] == 0) ? $studentdata['student_id'] : '';
                        $cls = ($studentdata['hallticket_email_status'] != 0) ? 'succ' : 'fail';
                        $html .= '<tr class="' . $cls . '">
                        <td>' . $student_id . '</td>
                        <td>' . $studentdata['student_name'] . '</td>
                        <td>' . $studentdata['student_barcode'] . '</td>
                        <td>' . $studentdata['course_name'] . '</td>
                        <td>' . $student_dob . '</td>                      
                        <td>' . $mail_status . '</td>                      
                    </tr>';
                    }
                    echo $html;
                } else {
                    echo false;
                }
            } else {
                echo false;
            }
        }
    }
    public function studenthallticketdetails($id)
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Hall Ticket Details';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array();

            $data['loadjs'] = array(
                'bower_components/jquery-validation/dist/jquery.validate.min.js',

            );
            $numbers = $this->hashids->decode($id);
            $student_id = $numbers[0];
            $user_session_details = $data['user_session_details'] = $this->pages_model->get_session_details($student_id);
            if (!empty($user_session_details)) {
                $user_session_details = array_column($user_session_details, 'mysession');
                $hallticket_ary = array();
                foreach ($user_session_details as $session_details) {
                    $hallticket_details = $this->pages_model->get_hallticket_details($student_id, $session_details);
                    if (!empty($hallticket_details)) {
                        array_push($hallticket_ary, $hallticket_details);
                    }
                }
            }

            $data['hallticket_details_ary']  = !empty($hallticket_ary) ? $hallticket_ary : '';
            $data['user_session_details'] = !empty($user_session_details) ? $user_session_details : '';


            $this->load->view('includes/header', $data);
            /* $this->load->view('admin/includes/admin_menu', $data); */
            $this->load->view('admin/studenthallticket/hallticketdetails', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }
}
