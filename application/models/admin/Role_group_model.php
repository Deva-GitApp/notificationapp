<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of role_group_model
 *
 * @author rckumar
 */
class Role_group_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add_role_group($role_group_name, $role_group_code, $id) {
        $data = array(
            'role_group_name' => $role_group_name,
            'role_group_code' => $role_group_code,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('role_group', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

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

    public function get_role_group_by_id($role_group_id) {
        $this->db->select('*');
        $this->db->from('role_group');
        $this->db->where(array(
            'role_group_id' => $role_group_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function edit_role_group($role_group_id, $role_group_name, $role_group_code, $id) {
        $data = array(
            'role_group_name' => $role_group_name,
            'role_group_code' => $role_group_code,
            'modified_by' => $id
        );
        $this->db->where(array(
            'role_group_id' => $role_group_id
        ));
        $this->db->update('role_group', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_role_group_unique($role_group_id, $role_group_name) {
        $this->db->select('*');
        $this->db->from('role_group');
        $this->db->where(array(
            'role_group_id !=' => $role_group_id,
            'role_group_name' => $role_group_name,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_role_group_by_id($role_group_id, $uid) {
        $data = array(
            'status' => '0',
            //'archive_status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'role_group_id' => $role_group_id
        ));
        $this->db->update('role_group', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function change_status_role_group_by_id($role_group_id, $uid, $status) {
        $data = array(
            'status' => $status,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'role_group_id' => $role_group_id
        ));
        $this->db->update('role_group', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
