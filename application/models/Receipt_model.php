<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of base_model
 *
 * @author rckumar
 */
class Receipt_model extends CI_Model
{

    public function get_receipt_details($student_id)
    {
        $slt_ary = array(
            'b.receipt_id',
            'b.fk_student_id',
            'b.student_barcode',
            'b.receipt_no',
            'b.receipt_date',
            'b.receipt_date',
            'b.receipt_mode',
            'b.receipt_des',
            'b.status',
            'a.student_id',
            'a.receipt_preview_status',
            'a.student_name',
            'a.course_name',
            'a.batch',
        );
        $this->db->select($slt_ary);
        $this->db->from('students as a');
        $this->db->join('receipt as b', 'b.fk_student_id=a.student_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.student_id' => $student_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_receipt_details_by_id($student_id, $receipt_id)
    {
        $slt_ary = array(
            'b.receipt_id',
            'b.fk_student_id',
            'b.student_barcode',
            'b.receipt_no',
            'b.receipt_date',
            'b.receipt_date',
            'b.receipt_mode',
            'b.receipt_des',
            'b.status',
            'a.student_id',
            'a.student_name',
            'a.course_name',
            'a.batch',
        );
        $this->db->select($slt_ary);
        $this->db->from('students as a');
        $this->db->join('receipt as b', 'b.fk_student_id=a.student_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.student_id' => $student_id,
            'b.receipt_id' => $receipt_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
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
        $this->db->from('receipt_details ');
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
}
