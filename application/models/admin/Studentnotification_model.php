<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentnotification_model extends CI_Model
{


    public function check_hallticket_fr_student($student_barcode)
    {
        $this->db->select('student_id');
        $this->db->from('students');
        $this->db->where(array(
            'student_barcode' => $student_barcode,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    public function check_student_notification_dup($student_barcode)
    {
        $this->db->select('student_notification_id');
        $this->db->from('students_notification');
        $this->db->where(array(
            'student_barcode' => $student_barcode,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    public function check_student_notificationdetail_dup($RegNo, $CourseCode)
    {
        $this->db->select('student_notification_detail_id');
        $this->db->from('students_notification_details');
        $this->db->where(array(
            'student_barcode' => $RegNo,
            'course_code' => $CourseCode,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    public function get_student_notification_by_reg_no($RegNo)
    {
        $this->db->select('*');
        $this->db->from('students_notification');
        $this->db->where(array(
            'student_barcode' => $RegNo,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
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

    public function update_notifiction_mailstatus($id, $excelid)
    {
        $data = array(
            'notifiction_mailstatus' => '1',
            'modified_by' => $id
        );
        $whr_ary = array(
            'student_id' => $id
        );
        $this->db->where($whr_ary);
        $this->db->update('students ', $data);
        if ($this->db->affected_rows() > 0) {
            $whr_ary = array(
                'excel_details_id' => $excelid
            );
            $this->db->set('sent_count', 'sent_count+1', false);
            $this->db->where($whr_ary);
            $this->db->update('excel_notification_details');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }


    public function update_student_details($RegNo, $Programme)
    {
        $data = array(
            'course_name' => $Programme,
        );
        $this->db->where('student_barcode', $RegNo);
        $this->db->update('students', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function add_student_data($student_name, $student_barcode, $student_course, $student_batch, $student_newdes, $id)
    {
        $data = array(
            'student_name' => $student_name,
            'student_barcode' => $student_barcode,
            'course_name' => $student_course,
            'batch' => $student_batch,
            'student_newdes' => $student_newdes,
            'student_dob' => null,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('students', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return FALSE;
        }
    }
    public function add_student_notification_details($MySession, $MonYr, $FullMonYr, $ProgCode, $Programme, $SyllabusYear, $YrSemPart, $YrSemHead, $CourseCode, $ElecCode, $Course, $RegNo, $Fees, $UploadDate, $UploadBy, $ApprovedDate, $ApprovedBy, $id)
    {
        $data = array(
            'notify_session_name' => $MySession,
            'monthyr' => $MonYr,
            'fullmnthyear' => $FullMonYr,
            'prog_code' => $ProgCode,
            'prog_name' => $Programme,
            'sylb_year' => $SyllabusYear,
            'yersempart' => $YrSemPart,
            'yersemhead' => $YrSemHead,
            'course_code' => $CourseCode,
            'elective_code' => $ElecCode,
            'course_name' => $Course,
            'student_barcode' => $RegNo,
            'paper_fees' => $Fees,
            'uploaded_date' => $UploadDate,
            'uploaded_by' => $UploadBy,
            'approved_date' => $ApprovedDate,
            'approved_by' => $ApprovedBy,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('students_notification_details', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return FALSE;
        }
    }
    public function add_student_notification($MySession, $RegNo, $ApplFees, $MSFees, $PCFees, $DissFees, $CMFees, $ConvFees, $UploadDate, $UploadBy, $ApprovedDate, $ApprovedBy, $notificationexcel_id, $id)
    {
        $data = array(
            'session_name' => $MySession,
            'student_barcode' => $RegNo,
            'appfees' => $ApplFees,
            'msfees' => $MSFees,
            'pcfees' => $PCFees,
            'disfees' => $DissFees,
            'cmfees' => $CMFees,
            'covfees' => $ConvFees,
            'uploaded_date' => $UploadDate,
            'uploaded_by' => $UploadBy,
            'approved_date' => $ApprovedDate,
            'approved_by' => $ApprovedBy,
            'notificationexcel_id' => $notificationexcel_id,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('students_notification', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }


    public function add_notificationdetails_excel_details($res)
    {
        $data = array(
            'file_name' => $res['file_name'],
            'file_type' => $res['file_type'],
            'file_path' => $res['file_path'],
            'full_path' => $res['full_path'],
            'raw_name' => $res['raw_name'],
            'orig_name' => $res['orig_name'],
            'client_name' => $res['client_name'],
            'file_ext' => $res['file_ext'],
            'file_size' => $res['file_size'],
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('excel_notification_details', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function get_all_uploaded_excel_data()
    {
        $slt_ary = array(
            'a.excel_details_id',
            'a.orig_name',
            'a.file_name',
            'a.file_size',
            'a.sent_count',
            'a.created_date as uploaded_date',
            'COUNT(b.student_notification_id) as student_notification_count',
        );
        $this->db->select($slt_ary);
        $this->db->from('excel_notification_details  as a');
        $this->db->join('students_notification  as b', 'b.notificationexcel_id=a.excel_details_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
        ));
        $this->db->group_by('a.excel_details_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
}
