<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of roletype_model
 *
 * @author rckumar
 */
class Helper_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_doctor_settings_by_id($doctor_id) {
        $this->db->select('*');
        $this->db->from('doctor_setting');
        $this->db->where(array(
            'fk_doctor_id' => $doctor_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_appintment_send($appointment_id, $attr) {
        $this->db->select('*');
        $this->db->from('srmc_api_datas');
        $this->db->where(array(
            'fk_appointment_id' => $appointment_id,
            'key_attr' => $attr,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_appointment_cancelled($appointment_id) {
        $this->db->select('appointment_id');
        $this->db->from('appointment');
        $this->db->where(array(
            'appointment_id' => $appointment_id,
            'appointment_cancel_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_appointment_refunded($appointment_id) {
        $this->db->select('payment_refund_response_id');
        $this->db->from('payment_refund_response');
        $this->db->where(array(
            'fk_app_id' => $appointment_id,
//            'appointment_cancel_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_appointment_cancelled_details($appointment_id) {
        $slt_ary = array(
            'appointment_cancel_id',
            'created_date as cancelled_date'
        );
        $this->db->select($slt_ary);
        $this->db->from('appointment_cancel_history');
        $this->db->where(array(
            'fk_appointment_id' => $appointment_id,
            'cancel_type' => '0',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_cancelledappintment_send($appointment_id, $attr) {
        $this->db->select('*');
        $this->db->from('srmc_api_datas');
        $this->db->where(array(
            'fk_appointment_id' => $appointment_id,
            'key_attr' => $attr,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function time_slot_details() {
        $this->db->select('*');
        $this->db->from('time_slot');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_all_days() {
        $this->db->select('*');
        $this->db->from('days');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /* Cancel Appointment */

    public function get_appointment_details_by_app_id($appointment_id) {
        $this->db->select('*');
        $this->db->from('appointment');
        $this->db->where(array(
            'appointment_id' => $appointment_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function check_cancel_history($appointment_id) {
        $this->db->select('*');
        $this->db->from('appointment_cancel_history');
        $this->db->where(array(
            'fk_appointment_id' => $appointment_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_patient_details_by_id($patient_id) {
        $this->db->select('*');
        $this->db->from('patient');
        $this->db->where(array(
            'patient_id' => $patient_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_doctor_details_by_id($doctot_id) {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where(array(
            'doctor_id' => $doctot_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_order_details_by_app_id($appointment_id) {
        $slt_ary = array(
            'a.amount as order_amount',
            'a.new_reg_fees',
            'a.order_for',
            'a.re_reg_fees',
            'b.order_id',
            'b.payment_id',
            'b.delayed_payment',
            'b.amount',
            'b.created_date as payment_date',
        );
        $where_ary = array(
            'a.fk_appointment_id' => $appointment_id,
            'a.payment_status' => '2',
            'a.status' => '1',
            'a.archive_status' => '1',
        );
        $this->db->select($slt_ary);
        $this->db->from('payment_order_details as a');
        $this->db->join('payment_response as b', 'b.order_id=a.order_id', 'left');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_refund_details_by_app_id($appointment_id) {
        $slt_ary = array(
            'amount_refund',
            'refund_id',
            'created_date as refunded_date',
        );
        $where_ary = array(
            'fk_app_id' => $appointment_id,
        );

        $this->db->select($slt_ary);
        $this->db->from('payment_refund_response');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function update_cancel_status($appointment_id, $feed_val, $cancelled_by) {
        $data = array(
            'appointment_cancel_status' => '1',
            'fk_feedback_question_id' => $feed_val,
            'modified_by' => $cancelled_by
        );
        $this->db->where(array(
            'appointment_id' => $appointment_id
        ));
        $this->db->update('appointment', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_cancel_widrwn_status($appointment_id, $cancelled_by) {
        $data = array(
            'appointment_cancel_status' => '1',
            'confirm_status' => '1',
            //'fk_feedback_question_id' => $feed_val,
            'modified_by' => $cancelled_by
        );
        $this->db->where(array(
            'appointment_id' => $appointment_id
        ));
        $this->db->update('appointment', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_cancel_history($appointment_id, $smsres, $user_type, $ip, $cancelled_by, $cancel_type) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'user_type' => $user_type,
            'smsres' => $smsres,
            'cancellation_ip' => $ip,
            'cancelled_by' => $cancelled_by,
            'created_by' => $cancelled_by,
            'cancel_type' => $cancel_type,
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('appointment_cancel_history', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_data_response_by_srmc($res_type, $appointment_id, $rec_no, $app_key, $app_date) {
        $data = array(
            'data_res_type' => $res_type,
            'fk_appointment_id' => $appointment_id,
            'receipt_no' => $rec_no,
            'app_key' => $app_key,
            'date' => $app_date,
        );
        $this->db->insert('srmc_api_response_datas', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_api_send_res_data($appointment_id, $data_attr, $data_type, $data_send) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'key_attr' => $data_attr,
            'data_type' => $data_type,
            'data' => $data_send,
                // 'cancellation_ip' => date(''),
        );
        $this->db->insert('srmc_api_datas', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_reschedule_cancel_history($appointment_id, $user_type, $ip, $cancelled_by, $cancel_type) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'user_type' => $user_type,
            'cancellation_ip' => $ip,
            'cancelled_by' => $cancelled_by,
            'created_by' => $cancelled_by,
            'cancel_type' => $cancel_type,
            'created_date' => date('Y-m-d H:i:s'),
            'status' => '0',
            'archive_status' => '0',
        );
        $this->db->insert('appointment_cancel_history', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Visited feedback history */

    public function insert_visited_feed_back_history($appointment_id, $patient_id, $sms_res, $ip, $uid) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'fk_admin_user_id' => $uid,
            'fk_patient_id' => $patient_id,
            'sms_send' => $sms_res,
            'ip' => $ip,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $uid,
        );
        $this->db->insert('vistedfeedback_sms_history', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function tinyurlhis($patient_mobile, $data_array, $uid) {
        $data = array(
            'mobile_no' => $patient_mobile,
            'data' => $data_array,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $uid,
        );
        $this->db->insert('vistedfeedback_sms_tinyurlhistory', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* confirm appointment */

    public function update_confirm_status($appointment_id, $uid) {
        $data = array(
            'confirm_status' => '1',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'appointment_id' => $appointment_id
        ));
        $this->db->update('appointment', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_not_confirm_status($appointment_id, $uid) {
        $data = array(
            'confirm_status' => '2',
            'modified_by' => $uid
        );
        $this->db->where(array(
            'appointment_id' => $appointment_id
        ));
        $this->db->update('appointment', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_confirm_history($appointment_id, $smsres, $user_type, $confirm_type, $ip, $uid) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'user_type' => $user_type,
            'smsres' => $smsres,
            'confirm_ip' => $ip,
            'confirm_type' => $confirm_type,
            'confirmed_by' => $uid,
            'created_by' => $uid,
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('appointment_confirm_history', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Permission */

    public function check_user_haspermission($uid) {
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where(array(
            'fk_employee_id' => $uid,
            'status' => '1',
            'archive_status' => '1'
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_permission($role_id, $page_name, $action_name) {
        $this->db->select('*');
        $this->db->from('roletype_permission');
        $this->db->where(array(
            'fk_role_type_id' => $role_id,
            'fk_page_code' => $page_name,
            'status' => '1',
            'archive_status' => '1'
        ));
        $this->db->where("FIND_IN_SET('$action_name',`fk_action_code`)!=", 0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_user_permission($user_id, $page_name, $action_name) {
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where(array(
            'fk_employee_id' => $user_id,
            'fk_page_code' => $page_name,
            'status' => '1',
            'archive_status' => '1'
        ));
        $this->db->where("FIND_IN_SET('$action_name',`fk_action_code`)!=", 0);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* menu permission */

    public function check_employee_permission($employee_id) {
        $this->db->select('*');
        $this->db->from('employee_permission');
        $this->db->where(array(
            'fk_employee_id' => $employee_id,
            'status' => '1',
            'archive_status' => '1'
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_role_type_permission($role_type_id) {
        $this->db->select('*');
        $this->db->from('roletype_permission as a');
        $this->db->join('pages as b', 'a.fk_page_code=b.short_code', 'left');
        $this->db->where(array(
            'a.fk_role_type_id' => $role_type_id,
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.status' => '1',
            'b.archive_status' => '1',
        ));
        $this->db->order_by('a.priority', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_employee_permission($employee_id) {
        $this->db->select('*');
        $this->db->from('employee_permission as a');
        $this->db->join('pages as b', 'a.fk_page_code=b.short_code', 'left');
        $this->db->where(array(
            'a.fk_employee_id' => $employee_id,
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.status' => '1',
            'b.archive_status' => '1',
        ));
        $this->db->order_by('a.priority', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function checkvisitstatus($uid) {
        $whr_ary = array(
            'fk_patient_id' => $uid,
            'status' => '1',
            'archive_status' => '1',
            'fk_visit_status_id' => '1',
        );
        $this->db->select('*');
        $this->db->from('visit_status_details');
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkvisitstatuswithdep($user_ary) {
        $whr_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'fk_visit_status_id' => '1',
        );
        $this->db->select('*');
        $this->db->from('visit_status_details');
        $this->db->where_in('fk_patient_id', $user_ary);
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all_depentent($uid) {
        $whr_ary = array(
            'fk_patient_id' => $uid,
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('patient');
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_visit_details($appointment_id) {
        $whr_ary = array(
            'fk_appointment_id' => $appointment_id,
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('visit_status_details');
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_docotor_id($admin_id) {
        $this->db->select('doctor_id');
        $this->db->from('doctors');
        $this->db->where(array(
            'fk_admin_id' => $admin_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['doctor_id'];
        } else {
            return FALSE;
        }
    }

    /* Cancel by details */

    public function get_appointment_cancel_details($sppointment_id) {
        $this->db->select('cancelled_by, user_type, cancel_type');
        $this->db->from('appointment_cancel_history');
        $this->db->where(array(
            'fk_appointment_id' => $sppointment_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_admin_user($admin_id) {
        $this->db->select('name, employee_id');
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

    public function get_user($user_id) {
        $this->db->select('patient_name, patient_uhid');
        $this->db->from('patient');
        $this->db->where(array(
            'patient_id' => $user_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    /* Confirm By Details */

    public function get_appointment_confirm_details($sppointment_id) {
        $this->db->select('confirmed_by, user_type');
        $this->db->from('appointment_confirm_history');
        $this->db->where(array(
            'fk_appointment_id' => $sppointment_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    /* doctor sms log */

    public function add_doctor_sms($appointment_id, $doct_sms, $smsres, $sms_push_id, $user_type, $ip, $uid) {
        $data = array(
            'fk_appointment_id' => $appointment_id,
            'user_type' => $user_type,
            'smsres' => $smsres,
            'sms_push_id' => $sms_push_id,
            'ip' => $ip,
            'smstype' => $doct_sms,
            'created_by' => $uid,
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('doctorsms_log', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_alr_sms_log($sppointment_id) {
        $this->db->select('*');
        $this->db->from('doctorsms_log');
        $this->db->where(array(
            'fk_appointment_id' => $sppointment_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_doctor_sms($appointment_id, $doct_sms, $smsres, $sms_push_id, $uid) {
        $data = array(
            'smsres' => $smsres,
            'sms_push_id' => $sms_push_id,
            'smstype' => $doct_sms,
            'modified_by' => $uid
        );
        $this->db->where(array(
            'fk_appointment_id' => $appointment_id
        ));
        $this->db->update('doctorsms_log', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add_resend_sms_details($mobile, $text, $ip) {
        $data = array(
            'mobile_number' => $mobile,
            'text' => $text,
            'ip' => $ip,
            'created_date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('resendsmsdetails', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_appointment_cancel_ques_details($appointment_id) {
        $whr_ary = array(
            'appointment_id' => $appointment_id,
//            'status' => '1',
//            'archive_status' => '1',
        );
        $slt_ary = array(
            'a.fk_feedback_question_id',
            'b.question'
        );
        $this->db->select($slt_ary);
        $this->db->from('appointment as a');
        $this->db->join('cancel_feedback as b', 'b.feedback_question_id=a.fk_feedback_question_id', 'left');
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

}
