<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of role_group_model
 *
 * @author rckumar
 */
class Dbbkdetails_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function add_dbbkdetails($post_data) {
        $this->db->insert('dbbkdetails', $post_data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all_project_list() {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where(array(
            'status' => '1'
        ));
//        $this->db->order_by('project_id', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_dbbkdetails_by_id($dbbkdetails_id) {
        $this->db->select('*');
        $this->db->from('dbbkdetails');
        $this->db->where(array(
            'dbbkdetails_id' => $dbbkdetails_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_project_by_id($proj_id) {
        $this->db->select('*');
        $this->db->from('projects');
        $this->db->where(array(
            'project_id' => $proj_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function edit_dbbkdetails($dbbkdetails_id, $post_data) {
        $this->db->where(array(
            'dbbkdetails_id' => $dbbkdetails_id
        ));
        $this->db->update('dbbkdetails', $post_data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_dbbkdetails_unique($dbbkdetails_id, $fk_project_id, $db_name) {
        $this->db->select('*');
        $this->db->from('dbbkdetails');
        $this->db->where(array(
            'fk_project_id' => $fk_project_id,
            'db_name' => $db_name,
            'dbbkdetails_id !=' => $dbbkdetails_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_dbbkdetails_by_id($dbbkdetails_id, $uid) {
        $data = array(
            'status' => '0',
            'archive_status' => '0',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'dbbkdetails_id' => $dbbkdetails_id
        ));
        $this->db->update('dbbkdetails', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function change_status_dbbkdetails_by_id($dbbkdetails_id, $uid, $status) {
        $data = array(
            'status' => $status,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'dbbkdetails_id' => $dbbkdetails_id
        ));
        $this->db->update('dbbkdetails ', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allposts_count() {
        $slt_ary = array(
            'a.dbbkdetails_id',
//            'a.fk_project_id',
//            'a.db_name',
//            'a.db_path',
//            'a.created_date',
//            'a.created_by',
//            'b.project_name',
        );
        $where_ary = array(
//            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('dbbkdetails as a');
        $this->db->join('projects as b', 'b.project_id=a.fk_project_id', 'left');
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
            'a.dbbkdetails_id',
            'a.fk_project_id',
            'a.db_name',
            'a.db_path',
            'a.created_date',
            'a.modified_date',
            'a.status',
            'a.created_by',
            'b.project_name',
        );
        $where_ary = array(
//            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('dbbkdetails as a');
        $this->db->join('projects as b', 'b.project_id=a.fk_project_id', 'left');
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
            'a.dbbkdetails_id',
            'a.fk_project_id',
            'a.db_name',
            'a.db_path',
            'a.created_date',
            'a.modified_date',
            'a.status',
            'a.created_by',
            'b.project_name',
        );
        $where_ary = array(
//            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('dbbkdetails as a');
        $this->db->join('projects as b', 'b.project_id=a.fk_project_id', 'left');
        $this->db->where($where_ary);
        $this->db->group_start();
        $this->db->like('b.project_name', $search, 'after');
        $this->db->or_like('a.db_name', $search, 'after');
        $this->db->or_like('a.db_path', $search, 'after');
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
            'a.dbbkdetails_id',
        );
        $where_ary = array(
//            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('dbbkdetails as a');
        $this->db->join('projects as b', 'b.project_id=a.fk_project_id', 'left');
        $this->db->where($where_ary);
        $this->db->group_start();
        $this->db->like('b.project_name', $search, 'after');
        $this->db->or_like('a.db_name', $search, 'after');
        $this->db->or_like('a.db_path', $search, 'after');
        $this->db->group_end();
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

}
