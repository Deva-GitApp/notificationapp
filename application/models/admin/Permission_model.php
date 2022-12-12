<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of roletype_model
 *
 * @author rckumar
 */
class Permission_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_employee_by_id($employee_id) {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where(array(
            'admin_id' => $employee_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_role_type_by_id($roletype_id) {
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where(array(
            'role_type_id' => $roletype_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_pages_list() {
        $where_ary = array(
            'status' => '1'
        );
        $this->db->select('*');
        $this->db->from('pages');
        //$this->db->join('page_action as b', 'a.page_id=b.fk_page_id', 'left');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_page_action_by_page_id($page_id) {
        $where_ary = array(
            'fk_page_id' => $page_id,
        );
        $this->db->select('*');
        $this->db->from('page_action');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_existing_permission($employee_id) {
        $where_ary = array(
            'fk_employee_id' => $employee_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_role_type_permission($role_type_id) {
        $where_ary = array(
            'fk_role_type_id' => $role_type_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('roletype_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_user_details_by_id($employee_id) {
        $where_ary = array(
            'admin_id' => $employee_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_employee_permission($employee_id, $page_code) {
        $where_ary = array(
            'fk_employee_id' => $employee_id,
            'fk_page_code' => $page_code,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function update_employee_permission($employee_id, $page_code, $page_action_str, $priority, $uid) {
        $data = array(
            'fk_action_code' => $page_action_str,
            'priority' => $priority,
            'modified_by' => $uid,
        );
        $this->db->where(array(
            'fk_employee_id' => $employee_id,
            'fk_page_code' => $page_code,
        ));
        $this->db->update('employee_permission', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_employee_permission($employee_id, $page_code, $page_action_str, $priority, $uid) {
        $data = array(
            'fk_employee_id' => $employee_id,
            'fk_page_code' => $page_code,
            'priority' => $priority,
            'fk_action_code' => $page_action_str,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $uid
        );
        $this->db->insert('employee_permission', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* role type permission */

    public function check_roletype_permission($roletype_id, $page_code) {
        $where_ary = array(
            'fk_role_type_id' => $roletype_id,
            'fk_page_code' => $page_code,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('roletype_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function update_roletype_permission($roletype_id, $page_code, $page_action_str, $priority, $uid) {
        $data = array(
            'fk_action_code' => $page_action_str,
            'priority' => $priority,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'fk_role_type_id' => $roletype_id,
            'fk_page_code' => $page_code,
        ));
        $this->db->update('roletype_permission', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_roletype_permission($roletype_id, $page_code, $page_action_str, $priority, $uid) {
        $data = array(
            'fk_role_type_id' => $roletype_id,
            'fk_page_code' => $page_code,
            'priority' => $priority,
            'fk_action_code' => $page_action_str,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $uid
        );
        $this->db->insert('roletype_permission', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_user_by_role($roletype_id) {
        $where_ary = array(
            'fk_roletype_id' => $roletype_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('admin_id');
        $this->db->from('admin_user');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_page_details_by_page_code($page_code, $employee_id) {
        $where_ary = array(
            'fk_page_code' => $page_code,
            'fk_employee_id' => $employee_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    public function get_page_details_by_page_code_role_type($page_code, $fk_role_type_id) {
        $where_ary = array(
            'fk_page_code' => $page_code,
            'fk_role_type_id' => $fk_role_type_id,
            'status' => '1',
            'archive_status' => '1'
        );
        $this->db->select('*');
        $this->db->from('roletype_permission');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    /* old */

    public function get_all_role_group() {
        $this->db->select('*');
        $this->db->from('role_group');
        $this->db->where(array(
                // 'status' => '1'
        ));
        $this->db->order_by('role_group_id', 'DESC');
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

    public function add_employee($employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $department, $id) {
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
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('admin_user', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            if ($role_type_name == 'Doctor') {
                $data['fk_admin_id'] = $insert_id;
                $this->db->insert('doctors', $data);
                if ($this->db->affected_rows() > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_all_employee() {
        $this->db->select('*');
        $this->db->from('admin_user');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_roletype_id !=' => '1'
        ));
        $this->db->order_by('admin_id', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
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

    public function edit_employee($admin_id, $employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $department, $id) {
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
        if ($this->db->affected_rows() > 0) {
            if ($role_type_name == 'Doctor') {
                $this->db->where(array(
                    'fk_admin_id' => $admin_id
                ));
                $this->db->update('doctors', $data);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_employee_unique($employee_id, $employee_email, $employee_mobile) {
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

    public function delete_employee_by_id($employee_id, $role_type_name, $uid) {
        $data = array(
            'status' => '0',
            'archive_status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'admin_id' => $employee_id
        ));
        $this->db->update('admin_user', $data);
        if ($this->db->affected_rows() > 0) {
            if ($role_type_name == 'Doctor') {
                $this->db->where(array(
                    'fk_admin_id' => $employee_id
                ));
                $this->db->update('doctors', $data);
                if ($this->db->affected_rows() > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    public function change_status_employee_by_id($employee_id, $role_type_name, $uid, $status) {
        $data = array(
            'status' => $status,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'admin_id' => $employee_id
        ));
        $this->db->update('admin_user', $data);
        if ($this->db->affected_rows() > 0) {
            if ($role_type_name == 'Doctor') {
                $this->db->where(array(
                    'fk_admin_id' => $employee_id
                ));
                $this->db->update('doctors', $data);
                if ($this->db->affected_rows() > 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

}
