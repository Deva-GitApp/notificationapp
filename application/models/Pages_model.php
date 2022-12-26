<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of base_model
 *
 * @author rckumar
 */
class Pages_model extends CI_Model
{

    public function get_notification_details($student_barcode)
    {
        $slt_ary = array(
            'a.session_name',
            'a.student_barcode',
            'a.appfees',
            'a.msfees',
            'a.pcfees',
            'a.disfees',
            'a.cmfees',
            'a.covfees',
            'b.notify_session_name',
            'b.monthyr',
            'b.fullmnthyear',
            'b.prog_code',
            'b.prog_name',
            'b.sylb_year',
            'b.paper_fees',
            'b.yersemhead',
            'b.yersempart',
            'b.course_code',
            'b.elective_code',
            'b.course_name',
        );
        $this->db->select($slt_ary);
        $this->db->from('students_notification as a');
        $this->db->join('students_notification_details as b', 'b.student_barcode=a.student_barcode', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.student_barcode' => $student_barcode,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_receiptsub_details($receipt_id)
    {
        $slt_ary = array(
            'receipt_detail_id',
            'fk_receipt_id',
            'receipt_detail_no',
            'receipt_detail_head',
            'receipt_detail_amount',
        );
        $this->db->select($slt_ary);
        $this->db->from('receipt_details');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_receipt_id' => $receipt_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_studentdata_by_id($student_id)
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'student_dob',
            'course_name',
            'batch',
        );
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'student_id' => $student_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_hallticket_details($student_id, $session_name)
    {
        $slt_ary = array(
            'a.student_id',
            'a.student_name',
            'a.student_barcode',
            'a.course_name',
            'a.student_dob as dob',
            'a.batch',
            'a.hall_ticket_preview_status',
            'a.status',
            'a.archive_status',
            'b.studenthallticket_id',
            //'b.dob',
            'b.course_code',
            'b.halltcketcourse_name',
            'b.examdate',
            'b.examtime',
            'b.fullmonthyear',
            'b.yearsempart',
            'b.progcode',
            'b.sylyear',
            'b.mysession',
            'b.yearsemhead',
            'b.status',
            'b.archive_status',
        );
        $this->db->select($slt_ary);
        $this->db->from('students as a');
        $this->db->join('studenthallticket as b', 'b.fk_student_id=a.student_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.student_id' => $student_id,
            'b.mysession' => $session_name,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_session_details($student_id)
    {
        $slt_ary = array(
            'mysession',
        );
        $this->db->select($slt_ary);
        $this->db->from('studenthallticket');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_student_id' => $student_id,
        ));
        $this->db->group_by('mysession');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_student_data_by_id($student_id)
    {
        $slt_ary = array(
            '*',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'student_id' => $student_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
