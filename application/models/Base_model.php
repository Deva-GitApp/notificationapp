<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of base_model
 *
 * @author rckumar
 */
class Base_model extends CI_Model {

    public function get_role_name_by_id($role_id) {
        $where_ary = array(
            'role_type_id' => $role_id,
            'status' => '1'
        );
        $this->db->select('role_type_name, role_type_code');
        $this->db->from('roletype');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    // Get perticular page meta details
    public function get_meta($pageuri) {
        $data = array(
            'page_title',
            'meta_key',
            'meta_desc',
            'canonical_title',
            'canonical_link',
            'next_title',
            'next_link',
            'prev_title',
            'prev_link',
            'author_name',
            'author_link'
        );

        $this->db->select($data);
        $this->db->from('tag_meta');
        $this->db->where(array('page_url' => $pageuri, 'status' => '1'));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_all_category_name() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('category_name, category_id');
        $this->db->from('category');
        $this->db->where($where_ary);
        $this->db->order_by('category_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_product_type() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('product_type_name, product_type_id');
        $this->db->from('product_type');
        $this->db->where($where_ary);
        $this->db->order_by('product_type_name', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_roletype() {
        $where_ary = array(
            'status' => '1'
        );
        $this->db->select('*');
        $this->db->from('roletype');
        $this->db->where($where_ary);
        $this->db->order_by('role_type_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_country() {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('country_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_states() {
        $this->db->select('*');
        $this->db->from('states');
        $this->db->order_by('state_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_country_by_id($country_id) {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('country_id', $country_id);
        $this->db->order_by('country_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_all_states_by_id($state_id) {
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where('state_id', $state_id);
        $this->db->order_by('state_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_all_city_by_id($city_id) {
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where('city_id', $city_id);
        $this->db->order_by('city_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function ajax_update_state_by_country_id($country_id) {
        $where_ary = array(
            'country_id' => $country_id,
        );
        $this->db->select('*');
        $this->db->from('states');
        $this->db->where($where_ary);
        $this->db->order_by('state_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function ajax_update_city_by_state_id($state_id) {
        $where_ary = array(
            'state_id' => $state_id,
        );
        $this->db->select('*');
        $this->db->from('cities');
        $this->db->where($where_ary);
        $this->db->order_by('city_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function ajax_update_location_by_city_id($city_id) {
        $where_ary = array(
            'fk_city_id' => $city_id,
        );
        $this->db->select('*');
        $this->db->from('location');
        $this->db->where($where_ary);
        $this->db->order_by('location_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function ajax_update_landmark_by_city_id($location_id) {
        $where_ary = array(
            'fk_location_id' => $location_id,
        );
        $this->db->select('*');
        $this->db->from('landmark');
        $this->db->where($where_ary);
        $this->db->order_by('landmark_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function ajax_portal_login($email, $pwd) {
        $where_ary = array(
            'customer_email' => $email,
            'password' => $pwd,
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_portal_user_last_login($user_id) {
        $this->db->select('login');
        $this->db->from('customer_log');
        $this->db->where('fk_customer_id', $user_id);
        $this->db->order_by('customer_log_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['login'];
        } else {
            return FALSE;
        }
    }

    public function portal_user_log($user_id, $ip, $device, $agent) {
        $data = array(
            'fk_customer_id' => $user_id,
            'login_ip' => $ip,
            'login' => date('Y-m-d H:i:s'),
            'device_type' => $device,
            'user_agent' => $agent,
        );
        $this->db->insert('customer_log', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function portal_user_page_track($log_id, $user_id, $purl) {
        $data = array(
            'fk_customer_log_id' => $log_id,
            'fk_customer_id' => $user_id,
            'page_url' => $purl,
            'login_time' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('customer_session_log', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_portal_user_log($log_id) {
        $this->db->select('logout');
        $this->db->from('customer_log');
        $this->db->where('customer_log_id', $log_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $data = array('logout' => date('Y-m-d H:i:s'));
            $this->db->where('customer_log_id', $log_id);
            $this->db->update('customer_log', $data);
            $tbl_name = 'tbl_customer_log';
            $query = "UPDATE $tbl_name SET duration = TIMEDIFF(logout, login) WHERE portal_log_id = '" . $log_id . "'";
            $this->db->query($query);
        }
    }

    public function update_portal_user_page_track($page_track_id) {
        $this->db->select('logout_time');
        $this->db->from('customer_session_log');
        $this->db->where('ss_id', $page_track_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            $data = array('logout_time' => date('Y-m-d H:i:s'));
            $this->db->where('ss_id', $page_track_id);
            $this->db->update('customer_session_log', $data);
            $tbl_name = 'tbl_customer_session_log';
            $query = "UPDATE $tbl_name SET duration = TIMEDIFF(logout_time, login_time) WHERE ss_id = '" . $page_track_id . "'";
            $this->db->query($query);
        }
    }

    public function check_user_permissions($uid, $controller, $method) {
        $this->db->select('*');
        $this->db->from('admin_permission');
        $this->db->where('FIND_IN_SET("' . $method . '",fk_action_code) AND fk_admin_id ="' . $uid . '" AND fk_page_code ="' . $controller . '"');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return '1';
        } else {
            return '0';
        }
    }

    public function ajax_enquiry_submit($name, $email, $mobile, $query_text, $ip) {
        $today = date("Y-m-d H:i:s");
        $data = array(
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'query' => $query_text,
            'created_date' => $today,
            'cus_ip' => $ip
        );

        $sucess = $this->db->insert('tbl_enquiry', $data);
        if ($sucess) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_user_permission_for_menu($uid) {
        $where_ary = array(
            'fk_admin_id' => $uid,
        );
        $this->db->select('*');
        $this->db->from('admin_permission as a');
        $this->db->join('pages as b', 'b.short_code=a.fk_page_code');
        $this->db->where($where_ary);
        $this->db->order_by('a.permission_id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_user_details_by_id($state_id) {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('customer_id', $state_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_all_product() {
        $where_ary = array(
            'a.sales_type' => '1',
            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('product as a');
        $this->db->join('product_type as b', 'b.product_type_id=a.fk_product_type_id', 'left');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_package_duration() {
        $where_ary = array(
            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('package as a');
        $this->db->join('frequency as b', 'b.frequency_id=a.fk_frequency_id', 'left');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_frequency() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('frequency');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_customer_enquiry() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'viewed' => '0'
        );
        $this->db->select('*');
        $this->db->from('enquiry');
        $this->db->where($where_ary);
        $this->db->order_by("enquiry_id", "desc");
        $query = $this->db->get();
        //return $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_completed_order_list() {
        $select_ary = array(
            'b.customer_name',
            'b.customer_email',
            'b.customer_mobile',
            'a.modified_date',
            'a.created_date',
            'a.total_amount',
            'a.order_code',
            'a.order_id',
            'a.fk_customer_id',
            'a.payment_type'
        );
        $where_ary = array(
            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $where_in = array(
            '1', '2'
        );
        $this->db->select($select_ary);
        $this->db->from('order as a');
        $this->db->join('customer as b', 'b.customer_id=a.fk_customer_id', 'left');
        // $this->db->join('delivery_activation as d', 'left');

        $this->db->where($where_ary);
        $this->db->where_in('a.payment_type', $where_in);

        $this->db->order_by('a.created_date', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_customer_by_date() {
        $today = date('Y-m-d');
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'date(created_date)' => $today
        );
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where($where_ary);
        $this->db->order_by('created_date','DESC');
        $this->db->last_query();
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_activated_order_by_id($order_id) {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'fk_order_id'=>$order_id
        );
        $this->db->select('*');
        $this->db->from('delivery_activation');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function get_frequency_from_package($val) {
        $where_ary = array(
            'package_id' => $val,
            'status' => '1',
            'archive_status' => '1',
        );

        $this->db->select('*');
        $this->db->from('package');
        $this->db->where($where_ary);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['fk_frequency_id'];
        } else {
            return FALSE;
        }
    }
     public function get_quantity_by_product_id($val) {
        $where_ary = array(
            'fk_product_id' => $val,
            'status' => '1',
            'archive_status' => '1',
        );

        $this->db->select('*');
        $this->db->from('product_quantity');
        $this->db->where($where_ary);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
