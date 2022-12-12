<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sendnotification_model extends CI_Model {


    public function get_all_nofication_details($excelid)
    {
        $this->db->select('b.*');
        $this->db->from('students_notification as a');
        $this->db->join('students  as b', 'b.student_barcode=a.student_barcode', 'left');
        $this->db->where(array(
            'a.notificationexcel_id' => $excelid,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_all_student_datas() {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'course_name',
            'batch',
            'student_newdes',
            'status',
            'archive_status',
            'created_date',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function update_mail_status($student_id) {
        $data = array(
            'email_status' => '1',
        );
        $this->db->where(array(
            'student_id' => $student_id
        ));
        $this->db->update('students ', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_student_data($student_id) {
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
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

}
