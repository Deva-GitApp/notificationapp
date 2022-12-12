<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of roletype_model
 *
 * @author rckumar
 */
class Department_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add_department($department_name, $department_code, $department_week, $id) {
        $data = array(
            'department_name' => $department_name,
            'department_code' => $department_code,
            'department_week' => $department_week,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $id
        );
        $this->db->insert('department', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function edit_department($department_id, $department_name, $department_code, $department_week, $id) {
        $data = array(
            'department_name' => $department_name,
            'department_code' => $department_code,
            'department_week' => $department_week,
            'modified_by' => $id
        );
        $this->db->where(array(
            'department_id' => $department_id
        ));
        $this->db->update('department', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_department_by_id($department_id, $uid) {
        $data = array(
            'status' => '0',
            'archive_status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'department_id' => $department_id
        ));
        $this->db->update('department', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function change_status_department_by_id($department_id, $uid) {
        $data = array(
            'status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'department_id' => $department_id
        ));
        $this->db->update('department', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function check_department_unique($department_id, $department_name) {
        $this->db->select('department_id');
        $this->db->from('department');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'department_name' => $department_name,
            'department_id !=' => $department_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_department_by_id($department_id) {
        $slt_ary = array(
            'department_id',
            'department_name',
            'department_code',
            'department_week',
            'status',
            'archive_status',
            'created_by',
            'created_date',
            'modified_date',
        );
        $this->db->select($slt_ary);
        $this->db->from('department');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'department_id=' => $department_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function allposts_count() {
        $slt_ary = array(
            'department_id'
        );
        $where_ary = array(
//            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('department ');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function allposts($limit, $start, $order, $dir) {
        $slt_ary = array(
            'department_id',
            'department_name',
            'department_code',
            'department_week',
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
        $this->db->from('department');
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

    public function posts_search($limit, $start, $search, $order, $dir) {
        $slt_ary = array(
            'department_id',
            'department_name',
            'department_code',
            'department_week',
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
        $this->db->from('department');

        $this->db->group_start();
        $this->db->where($where_ary);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->like('department_name', $search, 'after');
        $this->db->or_like('department_code', $search, 'after');
        $this->db->or_like('department_week', $search, 'after');
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

    public function posts_search_count($search) {
        $slt_ary = array(
            'department_id',
        );
        $where_ary = array(
//            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('department');
        $this->db->group_start();
        $this->db->where($where_ary);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->like('department_name', $search, 'after');
        $this->db->or_like('department_code', $search, 'after');
        $this->db->or_like('department_week', $search, 'after');
        $this->db->group_end();
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    /* chart querys */
}
