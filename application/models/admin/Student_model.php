<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model
{

    public function get_all_student_datas()
    {
        $slt_ary = array(
            'a.receipt_id',
            'a.receipt_no',
            'a.receipt_date',
            'a.receipt_des',
            'a.fk_student_id',
            'COUNT(a.fk_student_id) as student_count',
            'b.student_id',
            'b.student_name',
            'b.student_barcode',
            'b.course_name',
            'b.batch',
            'b.receipt_email_status',
            'b.receipt_preview_status',
            'b.student_newdes',
            'b.status',
            'b.archive_status',
            'b.created_date'

        );
        $this->db->select($slt_ary);
        $this->db->from('receipt as a');
        $this->db->join('students as b', 'b.student_id=a.fk_student_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
        ));
        $this->db->group_by('a.fk_student_id');
        $this->db->order_by('a.fk_student_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_all_studenthallticket()
    {
        $slt_ary = array(
            'a.studenthallticket_id',
            'a.student_barcode',
            'a.dob',
            'a.dob',
            'a.halltcketcourse_name',
            'a.examdate',
            'COUNT(a.fk_student_id) as student_count',
            'a.examtime',
            'a.course_code',
            'a.yearsemhead',
            'a.status',
            'a.archive_status',
            'a.created_date',
            'b.student_name',
            'b.student_dob',
            'b.student_id',
            'b.hall_ticket_preview_status',
            'b.batch',

        );
        $this->db->select($slt_ary);
        $this->db->from('studenthallticket as a');
        $this->db->join('students as b', 'b.student_id=a.fk_student_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
        ));
        $this->db->group_by('a.fk_student_id');
        $this->db->order_by('a.fk_student_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_studentsfr_student()
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'course_name',
            'student_dob',
            'batch',
            'status',
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
    public function update_hall_preview_status($student_ary)
    {
        $data = array(
            'hall_ticket_preview_status' => '1'
        );

        $this->db->where_in('student_id', $student_ary);
        $this->db->update('students', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }
    public function update_receipt_preview_status($student_ary)
    {
        $data = array(
            'receipt_preview_status' => '1'
        );

        $this->db->where_in('student_id', $student_ary);
        $this->db->update('students', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }
    public function update_receipt_preview_status_remove($student_list_toremove)
    {
        $data = array(
            'receipt_preview_status' => '0'
        );
        $this->db->where_in('student_id', $student_list_toremove);
        $this->db->update('students', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return false;
        }
    }
    public function update_hall_preview_status_remove($student_list_toremove)
    {
        $data = array(
            'hall_ticket_preview_status' => '0'
        );
        $this->db->where_in('student_id', $student_list_toremove);
        $this->db->update('students', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return false;
        }
    }


    public function get_all_students($student_ida_ary)
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'course_name',
            'batch',
            'status',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'receipt_email_status' => '0',
            'archive_status' => '1',
        ));
        $this->db->where_in('student_id', $student_ida_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_all_students_hall_ticket($student_ida_ary)
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'course_name',
            'batch',
            'status',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where(array(
            'status' => '1',
            'hallticket_email_status' => '0',
            'archive_status' => '1',
        ));
        $this->db->where_in('student_id', $student_ida_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_students_id($excelid)
    {
        $slt_ary = array(
            'fk_student_id',
            'COUNT(fk_student_id) as student_count',
        );
        $this->db->select($slt_ary);
        $this->db->from('receipt');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_excel_id' => $excelid,
        ));
        $this->db->group_by('fk_student_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_students_hall_ticket_id($excelid)
    {
        $slt_ary = array(
            'fk_student_id',
            'COUNT(fk_student_id) as student_count',
        );
        $this->db->select($slt_ary);
        $this->db->from('studenthallticket');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'hallticket_excel_id' => $excelid,
        ));
        $this->db->group_by('fk_student_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_all_students_frpreview($excelid)
    {
        $slt_ary = array(
            'a.fk_student_id',
            'COUNT(a.fk_student_id) as student_count',
            'b.student_id ',
            'b.student_name',
            'b.student_barcode',
            'b.student_dob',
            'b.course_name',
            'b.hallticket_email_status',
        );
        $this->db->select($slt_ary);
        $this->db->from('studenthallticket as a');
        $this->db->join('students  as b', 'b.student_barcode=a.student_barcode', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.hallticket_excel_id' => $excelid,
            /* 'b.hallticket_email_status' => '0', */
        ));
        $this->db->group_by('a.fk_student_id');
        $query = $this->db->get();
        /* echo $this->db->last_query(); */
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_all_studentsreceipts_frpreview($excelid)
    {
        $slt_ary = array(
            'a.fk_student_id',
            'a.receipt_no',
            'a.receipt_date',
            'a.receipt_des',
            'a.receipt_mode',
            'b.student_id ',
            'b.student_name',
            'b.student_barcode',
            'b.student_dob',
            'b.course_name',
            'b.receipt_email_status',
        );
        $this->db->select($slt_ary);
        $this->db->from('receipt as a');
        $this->db->join('students as b', 'b.student_barcode=a.student_barcode', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.fk_excel_id' => $excelid,
            /* 'b.hallticket_email_status' => '0', */
        ));
        $query = $this->db->get();
        /* echo $this->db->last_query(); */
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_uploaded_excel_data()
    {
        $slt_ary = array(
            'excel_details_id',
            'orig_name',
            'file_name',
            'file_size',
            'sent_count',
            'created_date as uploaded_date',
        );
        $this->db->select($slt_ary);
        $this->db->from('excel_details');
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

    public function get_all_uploaded_hallticketexcel_data()
    {
        $slt_ary = array(
            'excel_details_id',
            'orig_name',
            'file_name',
            'file_size',
            'sent_count',
            'created_date as uploaded_date',
        );
        $this->db->select($slt_ary);
        $this->db->from('hallticketexcel_details');
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
    public function get_totalhallticket_count($hallticketexcel_id)
    {
        $slt_ary = array(
            'fk_student_id',
            'COUNT(fk_student_id) as student_count',
            'studenthallticket_id',
        );
        $this->db->select($slt_ary);
        $this->db->from('studenthallticket');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'hallticket_excel_id' => $hallticketexcel_id,
        ));
        $this->db->group_by('fk_student_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function get_total_receipt_count($excel_details_id)
    {
        $slt_ary = array(
            'receipt_id',
            'fk_student_id',
            'COUNT(fk_student_id) as student_count',
        );
        $this->db->select($slt_ary);
        $this->db->from('receipt');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_excel_id' => $excel_details_id,
        ));
        $this->db->group_by('fk_student_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function check_receipt_fr_student($student_barcode)
    {
        $this->db->select('*');
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

    public function check_hallticket_fr_student($student_barcode)
    {
        $this->db->select('*');
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

    public function check_receipt_datadet($receipt_number, $student_barcode)
    {
        $this->db->select('*');
        $this->db->from('receipt');
        $this->db->where(array(
            'student_barcode' => $student_barcode,
            'receipt_no' => $receipt_number,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_hallticket_datadet($student_id, $student_barcode, $course_code)
    {
        $this->db->select('*');
        $this->db->from('studenthallticket');
        $this->db->where(array(
            'fk_student_id' => $student_id,
            'student_barcode' => $student_barcode,
            'course_code' => $course_code,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function get_receipt_details($student_id)
    {
        $slt_ary = array(
            'receipt_id',
            'fk_student_id',
            'student_barcode',
            'receipt_no',
            'receipt_date',
            'receipt_date',
            'receipt_mode',
            'receipt_des',
            'status',
        );
        $this->db->select($slt_ary);
        $this->db->from('receipt');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_student_id' => $student_id,
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

    public function check_receipt_subdatadet($receipt_id, $student_rec_detno)
    {
        $this->db->select('*');
        $this->db->from('receipt_details');
        $this->db->where(array(
            'fk_receipt_id' => $receipt_id,
            'receipt_detail_no' => $student_rec_detno,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
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
        $this->db->insert('students ', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return FALSE;
        }
    }
    public function add_bulk_students($studentdatas)
    {

        $this->db->insert_batch('students', $studentdatas);
    }

    public function add_student_hallticket($student_id, $student_barcode, $progcode, $dob, $course_code, $hall_tck_course_name, $examdate, $examtime, $fullmonthyear, $yearsempart, $yearsemhead, $sylyear, $mysession, $hallticketexcel_id, $id)
    {
        $data = array(
            'fk_student_id' => $student_id,
            'student_barcode' => $student_barcode,
            'hallticket_excel_id' => $hallticketexcel_id,
            'progcode' => $progcode,
            'dob' => $dob,
            'course_code' => $course_code,
            'halltcketcourse_name' => $hall_tck_course_name,
            'examdate' => $examdate,
            'examtime' => $examtime,
            'fullmonthyear' => $fullmonthyear,
            'yearsempart' => $yearsempart,
            'yearsemhead' => $yearsemhead,
            'sylyear' => $sylyear,
            'mysession' => $mysession,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('studenthallticket', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return FALSE;
        }
    }

    public function add_student_receipt($student_id, $student_barcode, $receipt_number, $receipt_date, $receipt_cdno, $receipt_paymode, $receipt_des, $excel_id, $id)
    {
        $data = array(
            'fk_student_id' => $student_id,
            'receipt_no' => $receipt_number,
            'student_barcode' => $student_barcode,
            'receipt_date' => date('Y-m-d', strtotime($receipt_date)),
            'receipt_cdno' => $receipt_cdno,
            'receipt_mode' => $receipt_paymode,
            'receipt_des' => $receipt_des,
            'fk_excel_id' => $excel_id,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('receipt', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
        } else {
            return FALSE;
        }
    }

    public function add_student_receipt_details($student_id, $receipt_id, $student_rec_detno, $student_rec_dethead, $receipt_amount, $id)
    {
        $data = array(
            'fk_receipt_id' => $receipt_id,
            'fk_student_id' => $student_id,
            'receipt_detail_no' => $student_rec_detno,
            'receipt_detail_head' => $student_rec_dethead,
            'receipt_detail_amount' => $receipt_amount,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('receipt_details', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_excel_details($res)
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
        $this->db->insert('excel_details', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }


    public function add_hallticketexcel_details($res)
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
        $this->db->insert('hallticketexcel_details', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function get_user_by_id($admin_id)
    {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where(array(
            'admin_id' => $admin_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_role_type()
    {
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_role_group_id !=' => '1',
        ));
        $this->db->order_by('role_type_id', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_departments()
    {
        $this->db->select('*');
        $this->db->from('department');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        $this->db->order_by('department_name', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_roletype_by_id($role_type_id)
    {
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where(array(
            'role_type_id' => $role_type_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_user_profile_by_id($employee_id, $user_profile_hid)
    {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where(array(
            'admin_id' => $employee_id,
            'photo' => $user_profile_hid,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_doctor_unique($employee_id, $employee_email, $employee_mobile)
    {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where(array(
            'admin_id !=' => $employee_id,
            'email' => $employee_email,
            'mobile' => $employee_mobile,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_receipt_mailstatus($id, $excelid)
    {
        $data = array(
            'receipt_email_status' => '1',
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
            $this->db->update('excel_details');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function update_hallticket_mailstatus($id, $excelid)
    {
        $data = array(
            'hallticket_email_status' => '1',
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
            $this->db->update('hallticketexcel_details');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /* datatable */
    public function allposts_count()
    {
        $slt_ary = array(
            'student_id'
        );
        $where_ary = array(
            //            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function allposts($limit, $start, $order, $dir)
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'student_dob',
            'course_name',
            'batch',
            'student_dob',
            'status',
            'archive_status',
            'created_by',
            'created_date',
            'modified_date',
        );
        $where_ary = array(
            //            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->where($where_ary);
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function posts_search($limit, $start, $search, $order, $dir)
    {
        $slt_ary = array(
            'student_id',
            'student_name',
            'student_barcode',
            'student_dob',
            'course_name',
            'batch',
            'student_dob',
            'status',
            'archive_status',
            'created_by',
            'created_date',
            'modified_date',
        );

        $where_ary = array(
            //            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->group_start();
        $this->db->where($where_ary);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->like('student_name', $search, 'after');
        $this->db->or_like('student_barcode', $search, 'after');
        $this->db->or_like('course_name', $search, 'after');
        $this->db->or_like('batch', $search, 'after');
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function posts_search_count($search)
    {
        $slt_ary = array(
            'student_id',
        );
        $where_ary = array(
            //            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('students');
        $this->db->group_start();
        $this->db->where($where_ary);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->like('student_name', $search, 'after');
        $this->db->or_like('student_barcode', $search, 'after');
        $this->db->or_like('course_name', $search, 'after');
        $this->db->or_like('batch', $search, 'after');
        $this->db->group_end();
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
}
