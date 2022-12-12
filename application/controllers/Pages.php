<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Spipu\Html2Pdf\Html2Pdf;

//use Hashids\Hashids;
/**
 * Description of dashboard
 *
 * @author rckumar
 */
class Pages extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $model_ary = array(
            'receipt_model',
            'pages_model',
            // 'admin/user',
            // 'admin/dashboard_model',
        );
        $this->load->model($model_ary, '', true);
        $this->load->library(array('usersupport'));
        $this->hashids = new Hashids\Hashids('the pages error');
    }

    public function pass()
    {
        echo $this->usersupport->encrypt_decrypt('encrypt', 'admin');
    }

    public function receipt()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $user_session_data = $this->session->userdata('srihertemp_user_logged_in');
            $student_id = $user_session_data['student_id'];
            $data['receipt_details'] = $this->receipt_model->get_receipt_details($student_id);
            $this->load->view('includes/header', $data);
            $this->load->view('includes/menu', $data);
            $this->load->view('pages/studentreceipt', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function hallticket()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $user_session_data = $this->session->userdata('srihertemp_user_logged_in');
            $student_id = $user_session_data['student_id'];
            $data['hallticket_details'] = $this->pages_model->get_hallticket_details($student_id);
            $this->load->view('includes/header', $data);
            $this->load->view('includes/menu', $data);
            $this->load->view('pages/studenthallticket', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function hallticketpreview($id)
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $user_session_data = $this->session->userdata('srihertemp_user_logged_in');
            $student_id = $this->usersupport->encrypt_decrypt('decrypt', $id);
            $data['hallticket_details'] = $this->pages_model->get_hallticket_details($student_id);
            $this->load->view('includes/header', $data);
            //$this->load->view('includes/menu', $data);
            $this->load->view('pages/studenthallticketpreview', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function userenclogin($page, $encid)
    {
        if (!empty($page) && !empty($encid)) {
            $student_id = $this->usersupport->encrypt_decrypt('decrypt', $encid);
            $student_data = $this->pages_model->get_student_data_by_id($student_id);
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
                redirect(base_url($page), 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Data Not Available.');
                redirect(base_url(), 'refresh');
            }
        } else {
            $this->session->set_flashdata('db_error', 'Data Not Available.');
            redirect(base_url(), 'refresh');
        }
    }

    public function notification()
    {
        if ($this->session->has_userdata('srihertemp_user_logged_in') == true) {
            $user_session_data = $this->session->userdata('srihertemp_user_logged_in');
            $student_id = $user_session_data['student_id'];
            $student_data = $data['student_data'] = $this->pages_model->get_studentdata_by_id($student_id);
            $student_barcode = $student_data['student_barcode'];
            $data['notification_details'] = $this->pages_model->get_notification_details($student_barcode);
            $this->load->view('includes/header', $data);
            $this->load->view('includes/menu', $data);
            $this->load->view('pages/studentnotification', $data);
            $this->load->view('includes/footer', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function generatepdf($enc)
    {
        $enc_data = $this->usersupport->encrypt_decrypt('decrypt', $enc);
        $enc_data_ary = explode('-', $enc_data);
        $stud_id = $enc_data_ary[0];
        $rec_id = $enc_data_ary[1];
        $receipt_details = $this->receipt_model->get_receipt_details_by_id($stud_id, $rec_id);
        $receipt_no = $receipt_details['receipt_no'];
        $receipt_id = $receipt_details['receipt_id'];
        $course_name = $receipt_details['course_name'];
        $student_barcode = $receipt_details['student_barcode'];
        $batch = $receipt_details['batch'];
        $receipt_date = $receipt_details['receipt_date'];
        $receipt_des = $receipt_details['receipt_des'];
        $receipt_mode = $receipt_details['receipt_mode'];
        $pdf_name = $student_barcode . '-' . $receipt_no;
        $data['pdf_name'] = $pdf_name;
        $html = '';
        $html .= '<h4 class="text-center pt-1 pb-1"><u>Fee Receipt</u></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Programme :</th>
                                    <td>' . $course_name . '</td>
                                    <th>Receipt No :</th>
                                    <td>' . $receipt_no . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Batch :</th>
                                    <td>' . $batch . '</td>
                                    <th scope="row">Date :</th>
                                    <td>' . date('Y-m-d', strtotime($receipt_date)) . '</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <h4 class="text-center pt-3 pb-3">
                        Received with thanks from ' . $course_name . '/' . $batch . date('Y-m-d', strtotime($receipt_date)) . '
                    </h4>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Code</th>
                                <th>Towards</th>
                                <th>Amount ( in Rs )</th>
                            </tr>
                        </thead>
                        <tbody>';

        $subrec_details = $this->receipt_model->get_receiptsub_details($receipt_id);
        $receipt_total = array_sum(array_column($subrec_details, 'receipt_detail_amount'));
        $i = 1;
        foreach ($subrec_details as $key => $subrec) {
            $html .= '<tr>
                                    <td>' . $i . '</td>
                                    <td>' . $subrec['receipt_detail_no'] . '</td>
                                    <td>' . $subrec['receipt_detail_head'] . '</td>
                                    <td>' . $subrec['receipt_detail_amount'] . '</td>
                                </tr>';

            $i++;
        }

        $html .= '</tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <th class="text-end">Total</th>
                                <td>' . $receipt_total . '</td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <h6 class="pt-1 pb-3"><b>' . $receipt_des . '</b></h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4 pb-1 fs-6"><b>Mode</b></div>
                                <div class="col-4">' . $receipt_mode . '</div>
                            </div>
                            <div class="row">
                                <div class="col-4 pb-1 fs-6"><b>Date</b></div>
                                <div class="col-4">' . date('Y-m-d', strtotime($receipt_date)) . '</div>
                            </div>
                            <div class="row">
                                <div class="col-4 pb-1 fs-6"><b>Transaction no / DD no</b></div>
                                <div class="col-4">' . date('Y-m-d', strtotime($receipt_date)) . '</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="pt-1 pb-3 text-center"><b>SRI RAMACHANDRA<br> INSTITUTE OF HIGHER EDUCATION AND RESEARCH</b></h6>
                            <p class="fs-6 text-center"> ( Deemed to be University ) </p>
                            <p class="fs-6 text-center"><b>Authorized Signatory</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="pt-3 pb-2 text-center"><b>(Electronically generated. No Signature required)</b></h6>
                    </div>';
        $data['html'] = $html;
        $this->load->view('pages/studentreceiptpdf', $data);
        //        $data_receipt = $this->load->view('pages/studentreceiptpdf', $data, true);
        //        $html2pdf = new Html2Pdf();
        //        $html2pdf->writeHTML($data_receipt);
        //        $html2pdf->output('myPdf.pdf');
    }
}
