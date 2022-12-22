<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of base_model
 *
 * @author rckumar
 */
class Autologin_model extends CI_Model
{


    public function get_student_data($student_reg_no, $student_dob)
    {
        $slt_ary = array(
            '*',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'student_barcode' => $student_reg_no,
            'student_dob' => date('Y-m-d', strtotime($student_dob)),
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
