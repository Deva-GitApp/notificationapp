<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Model {

    //Admin login using username & password
    function login($email, $password) {
        $this->db->select(array('admin_id', 'email', 'password'));
        $this->db->from('admin_user');
        $this->db->where(array('email' => $email, 'password' => $password, 'status' => '1'));
        //$this->db->limit(1);        
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            $this->db->select(array('admin_id', 'email', 'password'));
            $this->db->from('admin_user');
            $this->db->where(array('employee_id' => $email, 'password' => $password, 'status' => '1'));
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return true;
            } else {
                return FALSE;
            }
        }
    }

    //Admin login using secure pin 
    function login_pin($email, $password, $pin) {
        $this->db->select(array('admin_id', 'name', 'password', 'email', 'fk_roletype_id', 'photo', 'landing_url'));
        $this->db->from('admin_user');
        $this->db->where(array('email' => $email, 'password' => $password, 'user_pin' => $pin, 'status' => '1'));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            $this->db->select(array('admin_id', 'name', 'password', 'email', 'fk_roletype_id', 'photo', 'landing_url'));
            $this->db->from('admin_user');
            $this->db->where(array('employee_id' => $email, 'password' => $password, 'user_pin' => $pin, 'status' => '1'));
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() == 1) {
                return $query->row_array();
            } else {
                return FALSE;
            }
        }
    }

    //Login user insertion log
    function user_log($uid, $ip) {
        $data = array('fk_user_id' => $uid, 'login_ip' => $ip, 'login' => date('Y-m-d H:i:s'));
        $query = $this->db->insert('admin_log', $data);
        if ($query) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    //Login user updation log
    function update_user_log($rid) {
        $this->db->select('logout');
        $this->db->from('admin_log');
        $this->db->where('admin_log_id', $rid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $data = array('logout' => date('Y-m-d H:i:s'));
            $this->db->where('admin_log_id', $rid);
            $this->db->update('admin_log', $data);
        }
    }

    //Login user Ip
    function user_login_ip($uid) {
        $this->db->select('login_ip');
        $this->db->from('admin_log');
        $this->db->where('fk_user_id', $uid);
        $this->db->order_by('admin_log_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    //Get Last Login Date
    function get_last_login_date($uid) {
        $this->db->select('login');
        $this->db->from('admin_log');
        $this->db->where('fk_user_id', $uid);
        $this->db->order_by('admin_log_id', 'desc');
        $this->db->limit(1, 1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            return $result['login'];
        } else {
            return false;
        }
    }

    //Last Login Date
    function last_login_date($uid) {
        $this->db->select('logout');
        $this->db->from('admin_log');
        $this->db->where('fk_user_id', $uid);
        $this->db->order_by('admin_log_id', 'desc');
        $this->db->limit(1, 1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    //Change Password
    function updatePassword($id, $extpass, $newpass) {

        $data = array('user_pwd' => md5($newpass));
        $this->db->where(array('ID' => $id, 'user_pwd' => md5($extpass)));
        $this->db->update('admin_user', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * role group
     */

    public function get_role_group_id($role_id) {
        $where_ary = array(
            'role_type_id' => $role_id,
            'status' => '1',
        );
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where($where_ary);
        $this->db->order_by('role_type_name');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
