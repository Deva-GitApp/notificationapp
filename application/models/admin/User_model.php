<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_doctor_by_id($doctor_id) {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where(array(
            'fk_admin_id' => $doctor_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
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
