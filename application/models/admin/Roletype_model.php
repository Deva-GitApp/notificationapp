<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of roletype_model
 *
 * @author rckumar
 */
class Roletype_model extends CI_Model {

    function __construct() {
        parent::__construct();
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

    public function add_roletype($role_grp_id, $role_type_name, $role_type_code, $id) {
        $data = array(
            'fk_role_group_id' => $role_grp_id,
            'role_type_name' => $role_type_name,
            'role_type_code' => $role_type_code,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('roletype', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all_roletype() {
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where(array(
            // 'status' => '1'
            'archive_status' => '1'
        ));
        $this->db->order_by('role_type_id', 'DESC');
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

    public function edit_roletype($role_type_id, $slt_role_grp, $roletype_name, $roletype_code, $id) {
        $data = array(
            'fk_role_group_id' => $slt_role_grp,
            'role_type_name' => $roletype_name,
            'role_type_code' => $roletype_code,            
            'modified_by' => $id
        );
        $this->db->where(array(
            'role_type_id' => $role_type_id
        ));
        $this->db->update('roletype', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_roletype_unique($role_type_id, $role_type_name) {
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where(array(
            'role_type_id !=' => $role_type_id,
            'role_type_name' => $role_type_name,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_roletype_by_id($role_type_id, $uid) {
        $data = array(
            'status' => '0',
            'archive_status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'role_type_id' => $role_type_id
        ));
        $this->db->update('roletype', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function change_status_roletype_by_id($role_type_id, $uid, $status) {
        $data = array(
            'status' => $status,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'role_type_id' => $role_type_id
        ));
        $this->db->update('roletype', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
