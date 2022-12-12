<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    public function check_fr_student($student_barcode) {
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

    public function add_student_data($student_name, $student_barcode, $student_course, $student_batch, $student_newdes, $id) {
        $data = array(
            'student_name' => $student_name,
            'student_barcode' => $student_barcode,
            'course_name' => $student_course,
            'batch' => $student_batch,
            'student_newdes' => $student_newdes,
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

    public function add_student_session($student_id, $student_barcode, $student_session, $student_file, $student_file_upload_data, $student_file_upload_by, $student_file_approved_date, $student_file_approved_by, $id) {
        $data = array(
            'fk_student_id' => $student_id,
            'fk_student_barcode' => $student_barcode,
            'session_name' => $student_session,
            'file_name' => $student_file,
            'uploaded_date' => date('Y-m-d', strtotime($student_file_upload_data)),
            'uploaded_by' => $student_file_upload_by,
            'approved_date' => date('Y-m-d', strtotime($student_file_approved_date)),
            'approved_by' => $student_file_approved_by,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('student_session ', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            return $insert_id;
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

    public function check_receipt_datadet($receipt_number, $student_barcode) {
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

    public function get_receipt_details($student_id) {
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

    public function get_receiptsub_details($receipt_id) {
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

    public function check_receipt_subdatadet($receipt_id, $student_rec_detno) {
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

    public function add_student_receipt_details($student_id, $receipt_id, $student_rec_detno, $student_rec_dethead, $receipt_amount, $id) {
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

    public function add_excel_details($res) {
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
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_user_by_id($admin_id) {
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

    public function get_all_role_type() {
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

    public function get_all_departments() {
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

    public function get_roletype_by_id($role_type_id) {
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

    public function check_user_profile_by_id($employee_id, $user_profile_hid) {
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

    public function check_doctor_unique($employee_id, $employee_email, $employee_mobile) {
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

    public function edit_doctor($admin_id, $employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $doctor_designation, $doctor_qualification, $doctor_experience, $doctor_gender, $available_days_str, $doc_description, $department, $id) {
        $data = array(
            'name' => $employee_name,
            'employee_id' => $employee_id,
            'photo' => $user_profile,
            'email' => $employee_email,
            'password' => $employee_password,
            'user_pin' => $employee_sec_pin,
            'mobile' => $employee_mobile,
            'address' => $employee_address,
            'country' => $employee_country,
            'state' => $employee_state,
            'city' => $employee_district,
            'pincode' => $employee_piconde,
            'geolocation_id' => $geolocationid,
            'fk_roletype_id' => $role,
            'fk_department_id' => $department,
            'modified_by' => $id
        );
        $this->db->where(array(
            'admin_id' => $admin_id
        ));
        $this->db->update('admin_user', $data);

        if ($role_type_name == 'Doctor') {
            $data['doctor_designation'] = $doctor_designation;
            $data['doctor_qualification'] = $doctor_qualification;
            $data['doctor_experience'] = $doctor_experience;
            $data['available_days'] = $available_days_str;
            $data['doctor_gender'] = $doctor_gender;
            $data['doctor_gender'] = $doctor_gender;
            $data['doctor_desc'] = $doc_description;
            $data['fk_department_id'] = $department;
            $this->db->where(array(
                'fk_admin_id' => $admin_id
            ));
            $this->db->update('doctors', $data);
        }
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
