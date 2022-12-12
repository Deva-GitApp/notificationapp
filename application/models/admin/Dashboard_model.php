<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of roletype_model
 *
 * @author rckumar
 */
class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_total_order_amount() {
        $this->db->select('sum(amount) as total_order_amount');
        $this->db->from('payment_order_details');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['total_order_amount'];
        } else {
            return 0;
        }
    }

    public function get_total_order_amount_paid_successfully() {
        $this->db->select('sum(b.amount) as total_order_successfully_paid');
        $this->db->from('payment_response as a');
        $this->db->join('payment_order_details as b', 'b.order_id=a.order_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.payment_status' => 'captured',
        ));
        $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['total_order_successfully_paid'];
        } else {
            return 0;
        }
    }

    public function get_active_doctors_count($doctor_id = FALSE) {
        $this->db->select('count(doctor_id) as doctor_count');
        $this->db->from('doctors');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'doctor_id' => $doctor_id
            ));
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['doctor_count'];
        } else {
            return 0;
        }
    }

    public function get_active_patient_count() {
        $this->db->select('count(patient_id) as patient_count');
        $this->db->from('patient');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['patient_count'];
        } else {
            return 0;
        }
    }

    public function get_appointment_count($doctor_id = FALSE) {
        $this->db->select('count(appointment_id) as appointment_count');
        $this->db->from('appointment');
        $this->db->where(array(
            'status' => '1',
            'reschedule_status' => '0',
            'archive_status' => '1',
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_curmonthappointments($doctor_id = FALSE) {
        $this->db->select('count(appointment_id) as cur_month_appointment_count');
        $this->db->from('appointment');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            /* devaupd */
//            'reschedule_status' => '0',
            'MONTH(appointment_date)' => date('m'),
            'YEAR(appointment_date)' => date('Y'),
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cur_month_appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_curmonthreschedule($doctor_id = FALSE) {
        $this->db->select('count(appointment_id) as cur_month_reschedule');
        $this->db->from('appointment as a');
        $this->db->join('appointment_reschedule_history as b', 'b.fk_reschedule_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.reschedule_status' => '1',
            'b.user_type' => '1',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'a.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cur_month_reschedule'];
        } else {
            return 0;
        }
    }

    public function get_reschedule_count($doctor_id = FALSE) {
        $this->db->select('count(appointment_id) as reschedule_count');
        $this->db->from('appointment as a');
        $this->db->join('appointment_reschedule_history as b', 'b.fk_reschedule_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.reschedule_status' => '1',
//            'b.user_type' => '1',
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'a.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['reschedule_count'];
        } else {
            return 0;
        }
    }

    public function get_patient_widthdrawn_count($doctor_id = FALSE) {
        $this->db->select('count(b.appointment_id) as patient_withdrawn_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.cancel_type' => '2',
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['patient_withdrawn_count'];
        } else {
            return 0;
        }
    }

    public function get_patient_cancelled_count($doctor_id = FALSE, $from_date = FALSE, $to_date = FALSE) {
        $this->db->select('count(b.appointment_id) as patient_cancelled_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '0',
            'a.cancel_type' => '0',
        ));
        if ($from_date != FALSE && $to_date != FALSE) {
            $this->db->where(array(
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        }

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
//        echo $this->db->last_query();


        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['patient_cancelled_count'];
        } else {
            return 0;
        }
    }

    public function get_admin_cancelled_count($doctor_id = FALSE, $from_date = FALSE, $to_date = FALSE) {
        $this->db->select('count(b.appointment_id) as admin_cancelled_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.appointment_cancel_status' => '1',
            'b.status' => '1',
            'b.archive_status' => '1',
            'a.user_type' => '1',
            'a.cancel_type' => '0',
            'a.status' => '1',
            'a.archive_status' => '1',
        ));

        if ($from_date != FALSE && $to_date != FALSE) {
            $this->db->where(array(
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        }
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['admin_cancelled_count'];
        } else {
            return 0;
        }
    }

    public function get_admin_reshedule_count($doctor_id = FALSE, $from_date = FALSE, $to_date = FALSE) {
        $this->db->select('count(b.appointment_id) as admin_reshedule_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '0',
            'a.archive_status' => '0',
            'a.user_type' => '1',
            'a.cancel_type' => '3',
        ));
        if ($from_date != FALSE && $to_date != FALSE) {
            $this->db->where(array(
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        }
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['admin_reshedule_count'];
        } else {
            return 0;
        }
    }

    public function get_cancelled_appointment_count($doctor_id = FALSE) {
        $this->db->select('count(b.appointment_id) as cancelled_appointment_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.cancel_type !=' => '2',
//            'a.user_type' => '0',
//            'a.cancel_type' => '3',
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cancelled_appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_cancelled_appointment_count_management($from_date, $to_date) {
        $this->db->select('count(b.appointment_id) as cancelled_appointment_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
//            'a.status' => '1',
//            'a.archive_status' => '1',
            'a.cancel_type !=' => '1',
            'a.user_type !=' => '2',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));


        $query = $this->db->get();
//        echo $this->db->last_query();


        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cancelled_appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_user_widhrawn_count($doctor_id, $from_date, $to_date) {
        $this->db->select('count(a.appointment_cancel_id) as declined_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as d', 'd.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'd.appointment_date >=' => $from_date,
            'd.appointment_date <=' => $to_date,
            'd.confirm_status' => '1',
            'd.status' => '1',
            'd.appointment_cancel_status' => '1',
            'd.archive_status' => '1',
            'a.user_type' => '0',
            'a.cancel_type' => '2',
            'a.status' => '1',
            'a.archive_status' => '1'
        ));
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['declined_count'];
        } else {
            return 0;
        }
    }

    public function get_admin_decline_count($doctor_id, $from_date, $to_date) {
        $this->db->select('count(d.appointment_id) as declined_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as d', 'd.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
            'd.appointment_date >=' => $from_date,
            'd.appointment_date <=' => $to_date,
            'd.confirm_status' => '2',
            'd.status' => '1',
            'd.appointment_cancel_status' => '0',
            'd.archive_status' => '1',
            'a.user_type' => '1',
            'a.status' => '1',
            'a.archive_status' => '1'
        ));
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }


        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['declined_count'];
        } else {
            return 0;
        }
    }

    public function get_user_reshedule_count($doctor_id = FALSE, $from_date = FALSE, $to_date = FALSE) {
        $this->db->select('count(b.appointment_id) as user_reshedule_count');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->where(array(
//            'a.status' => '1',
//            'a.archive_status' => '1',
            'a.user_type' => '0',
            'a.cancel_type' => '3',
        ));

        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }

        if ($from_date != FALSE && $to_date != FALSE) {
            $this->db->where(array(
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['user_reshedule_count'];
        } else {
            return 0;
        }
    }

    public function get_visit_count($doctor_id = FALSE) {
        $this->db->select('count(visit_status_details_id) as visit_count');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.fk_visit_status_id' => '1',
        ));
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['visit_count'];
        } else {
            return 0;
        }
    }

    public function get_nonvisit_count($doctor_id = FALSE) {
        $this->db->select('count(visit_status_details_id) as visit_count');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.fk_visit_status_id' => '2',
        ));
        if ($doctor_id != FALSE) {
            $this->db->where(array(
                'b.fk_doctor_id' => $doctor_id
            ));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['visit_count'];
        } else {
            return 0;
        }
    }

    public function get_today_appointment_count($date) {
        $this->db->select('count(appointment_id) as appointment_count');
        $this->db->from('appointment');
        $this->db->where(array(
            'appointment_date' => $date,
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_doctor_details_by_admin_id($admin_id) {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'fk_admin_id' => $admin_id,
        ));


        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_today_doc_appointment_list($date, $doctor_id) {
        $this->db->select('*');
        $this->db->from('appointment as a');
        $this->db->join('patient as b', 'a.fk_patient_id=b.patient_id', 'left');
        $this->db->where(array(
            'a.appointment_date' => $date,
            'a.fk_doctor_id' => $doctor_id,
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_today_doc_slot_list($date, $doc_id) {
        $this->db->select('time_slot_interval');
        $this->db->from('doctor_schedule_days');
        $this->db->where(array(
            'shedule_date' => $date,
            'fk_doctor_id' => $doc_id,
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_today_appointment_count_by_docotor_id($doctor_id) {
        $this->db->select('count(appointment_id) as appointment_count');
        $this->db->from('appointment');
        $this->db->where(array(
            'fk_doctor_id' => $doctor_id,
            'appointment_date' => date('Y-m-d'),
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_latest_appointment($limit) {
        $this->db->select('*');
        $this->db->from('appointment as a');
        $this->db->join('doctors as b', 'b.doctor_id=a.fk_doctor_id', 'left');
        $this->db->join('department as c', 'c.department_id=b.fk_department_id', 'left');
        $this->db->join('patient as d', 'd.patient_id=a.fk_patient_id', 'left');
        //$this->db->join('visit_status_details as e', 'e.fk_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
        ));
        $this->db->limit($limit);
        $this->db->group_by('a.appointment_date');
        $this->db->order_by('a.created_date', 'DESC');
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_latest_appointment_chart($limit) {
        $this->db->select('count(appointment_id) as total, appointment_date');
        $this->db->from('appointment');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
        ));
        // $this->db->group_by('appointment_date');
        $this->db->group_by('appointment_date');
        $this->db->order_by('created_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_latest_dates($limit) {
        $this->db->select('DATE(created_date) as created_date');
        $this->db->from('appointment');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
        ));
        // $this->db->group_by('appointment_date');
        $this->db->group_by('DATE(created_date)');
        $this->db->order_by('created_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_latest_datatable_details($date_details, $ch_val) {
        $slt_ary = array(
            'a.*',
            'a.created_date as booking_date',
            'b.patient_id',
            'b.patient_name',
            'c.doctor_id',
            'c.name',
            'e.department_id',
            'e.department_name',
        );

        $this->db->select($slt_ary);
        $this->db->from('appointment as a');
        $this->db->join('patient as b', 'a.fk_patient_id=b.patient_id', 'left');
        $this->db->join('doctors as c', 'a.fk_doctor_id=c.doctor_id', 'left');
        $this->db->join('time_slot as d', 'd.time_slot_id=a.fk_time_slot_id', 'left');
        $this->db->join('department as e', 'e.department_id=c.fk_department_id', 'left');

        if (!empty($ch_val)) {
            $where_ary_1 = array(
                'a.appointment_date' => $ch_val,
            );
            $this->db->where($where_ary_1);
        }
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
        ));
        $this->db->where_in('DATE(a.created_date)', $date_details);
        // $this->db->group_by('a.appointment_date');
        $this->db->order_by('a.created_date', 'DESC');

        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_today_appointment_list($date) {
        $this->db->select('count(a.appointment_id) as total_appointment, a.fk_doctor_id,b.name');
        $this->db->from('appointment as a');
        $this->db->join('doctors as b', 'b.doctor_id=a.fk_doctor_id', 'left');
        $this->db->group_by('a.fk_doctor_id');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_date' => $date,
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_user_cancelled_appointment() {
        $this->db->select('count(a.appointment_id) as usercancelledappointment');
        $this->db->from('appointment as a');
        $this->db->join('appointment_cancel_history as b', 'b.fk_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.user_type' => '0',
            'a.appointment_cancel_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['usercancelledappointment'];
        } else {
            return 0;
        }
    }

    public function get_cuemonthusercancelledcount() {
        $this->db->select('count(a.appointment_id) as cuemonthusercancelledcount');
        $this->db->from('appointment as a');
        $this->db->join('appointment_cancel_history as b', 'b.fk_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            /* devaupd */
            //            'b.archive_status' => '1',
//            'b.status' => '1',
            'b.user_type' => '0',
            'a.appointment_cancel_status' => '1',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cuemonthusercancelledcount'];
        } else {
            return 0;
        }
    }

    /*
      public function get_admin_cancelled_appointment() {
      $this->db->select('count(a.appointment_id) as admincancelledappointment');
      $this->db->from('appointment as a');
      $this->db->join('appointment_cancel_history as b', 'b.fk_appointment_id=a.appointment_id', 'left');

      $this->db->where(array(
      'a.status' => '1',
      'a.archive_status' => '1',
      devaupd
      //            'b.archive_status' => '1',
      //            'b.status' => '1',
      'b.user_type !=' => '0',
      //            'a.appointment_cancel_status' => '1',
      ));

      $query = $this->db->get();
      if ($query->num_rows() > 0) {
      $res = $query->row_array();
      return $res['admincancelledappointment'];
      } else {
      return 0;
      }
      }
     * 
     */

    public function get_admin_cancelled_appointment() {
        $this->db->select('count(b.appointment_id) as admincancelledappointment');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');

        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '1',
            'a.cancel_type' => '0',
//             devaupd 
//            'b.archive_status' => '1',
//            'b.status' => '1',
//            'b.user_type !=' => '0',
//            'a.appointment_cancel_status' => '1',
        ));

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['admincancelledappointment'];
        } else {
            return 0;
        }
    }

    public function get_cuemonthadmincancelledcount() {
        $this->db->select('count(a.appointment_id) as admincancelledappointment');
        $this->db->from('appointment as a');
        $this->db->join('appointment_cancel_history as b', 'b.fk_appointment_id=a.appointment_id', 'left');

        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.archive_status' => '1',
            'b.status' => '1',
            'b.user_type !=' => '0',
//            'a.appointment_cancel_status' => '1',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        ));

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['admincancelledappointment'];
        } else {
            return 0;
        }
    }

    public function get_currentmonth_visits() {
        $this->db->select('count(a.appointment_id) as currentmonthvisits');
        $this->db->from('appointment as a');
        $this->db->join('visit_status_details as b', 'b.fk_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.visited_status !=' => '0',
            'a.confirm_status' => '1',
            'b.fk_visit_status_id' => '1',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['currentmonthvisits'];
        } else {
            return 0;
        }
    }

    public function get_currentmonth_nonvisits() {
        $this->db->select('count(a.appointment_id) as currentmonthnonvisits');
        $this->db->from('appointment as a');
        $this->db->join('visit_status_details as b', 'b.fk_appointment_id=a.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.visited_status !=' => '0',
            'a.confirm_status' => '1',
            'b.fk_visit_status_id' => '2',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['currentmonthnonvisits'];
        } else {
            return 0;
        }
    }

    public function get_doctor_details_by_id($doctor_id) {
        $this->db->select('*');
        $this->db->from('doctors');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
            'doctor_id' => $doctor_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_latest_registration($limit) {
        $this->db->select('*');
        $this->db->from('patient');
        $this->db->where(array(
            'status' => '1',
            'archive_status' => '1',
        ));
        $this->db->order_by('created_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_patient_details_by_search($srch_val, $srch_type) {
        if ($srch_type == '1') {
            $col_name = 'a.patient_uhid';
        } else if ($srch_type == '2') {
            $col_name = 'a.patient_mobile';
        } else {
            $col_name = 'b.appointment_key';
        }
//        echo $col_name;
//        echo $srch_val;
        $where_ary = array(
            'a.status' => '1',
            'a.archive_status' => '1',
            //'a.fk_patient_id' => '0',
            $col_name => $srch_val,
        );
        $this->db->select('*');
        $this->db->from('patient as a');
        $this->db->join('appointment as b', 'a.patient_id=b.fk_patient_id', 'left');
        $this->db->where($where_ary);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_count_fr_patient($patient_id) {
        $this->db->select('count(appointment_id) as appointment_count');
        $this->db->from('appointment');
        $this->db->where(array(
            'fk_patient_id' => $patient_id,
            //'appointment_cancel_status' => '0',
            'confirm_status' => '1',
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['appointment_count'];
        } else {
            return 0;
        }
    }

    public function get_no_of_visits($patient_id) {
        $this->db->select('count(visit_status_details_id) as visit_count');
        $this->db->from('visit_status_details');
        $this->db->where(array(
            'fk_patient_id' => $patient_id,
            'fk_visit_status_id' => '1',
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['visit_count'];
        } else {
            return 0;
        }
    }

    public function get_no_of_novisits($patient_id) {
        $this->db->select('count(visit_status_details_id) as novisit_count');
        $this->db->from('visit_status_details');
        $this->db->where(array(
            'fk_patient_id' => $patient_id,
            'fk_visit_status_id' => '2',
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['novisit_count'];
        } else {
            return 0;
        }
    }

    public function get_appointment_list_fr_patient($patient_id) {
        $this->db->select('*');
        $this->db->from('appointment');
        $this->db->where(array(
            'fk_patient_id' => $patient_id,
            //'appointment_cancel_status' => '0',
            'confirm_status' => '1',
            'appointment_date >=' => date('Y-m-d'),
            'status' => '1',
            'archive_status' => '1',
        ));
        $this->db->order_by('appointment_date', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_today_doc_slot_booked_list($cur_date, $doctor_id) {
        $this->db->select('count(appointment_id) as booked_slots');
        $this->db->from('appointment');
        $this->db->where(array(
            'fk_doctor_id' => $doctor_id,
            'appointment_date' => $cur_date,
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['booked_slots'];
        } else {
            return 0;
        }
    }

    public function get_today_doc_slot_cancelled_list($cur_date, $doctor_id) {
        $this->db->select('count(appointment_id) as cancelled_slots');
        $this->db->from('appointment');
        $this->db->where(array(
            'fk_doctor_id' => $doctor_id,
            'appointment_date' => $cur_date,
            'appointment_cancel_status' => '1',
            //'confirm_status' => '1',
            'status' => '1',
            'archive_status' => '1',
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['cancelled_slots'];
        } else {
            return 0;
        }
    }

    public function get_future_shedules_by_doctor($cur_date, $doctor_id, $limit) {
        $this->db->select('*');
        $this->db->from('doctor_schedule_days');
        $this->db->where(array(
            'fk_doctor_id' => $doctor_id,
            'shedule_date >' => $cur_date,
            'status' => '1',
            'archive_status' => '1',
        ));
        $this->db->limit($limit);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_cancel_details($appointment_id) {
        $where_ary = array(
            'fk_appointment_id' => $appointment_id,
            'status' => '1',
            'archive_status' => '1',
        );
        $this->db->select('*');
        $this->db->from('appointment_cancel_history');
        $this->db->where($where_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /* chart querys */

    public function get_appointment_details_by_day_cherts($cur_date) {
        $where_ary = array(
            'appointment_date' => $cur_date,
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
        );
        $this->db->select('count(appointment_id) as total, fk_time_slot_id, appointment_date');
        $this->db->from('appointment');
        $this->db->where($where_ary);
        $this->db->group_by('fk_time_slot_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_appointment_details_by_month_charts() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
            'YEAR(appointment_date)' => date('Y'),
        );
        $this->db->select('count(appointment_id) as total, appointment_date');
        $this->db->from('appointment');
        $this->db->where($where_ary);
        $this->db->group_by("MONTH(appointment_date), YEAR(appointment_date)");
        //$this->db->order_by("YEAR(appointment_date)", 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_appointment_details_by_cur_month_charts() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
            'MONTH(appointment_date)' => date('m'),
            'YEAR(appointment_date)' => date('Y'),
        );
        $this->db->select('count(appointment_id) as total, appointment_date');
        $this->db->from('appointment');
        $this->db->where($where_ary);
        $this->db->group_by("DATE(appointment_date)");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_appointment_details_by_yearwise_charts() {
        $where_ary = array(
            'status' => '1',
            'archive_status' => '1',
            'appointment_cancel_status' => '0',
            'confirm_status' => '1',
                // 'YEAR(appointment_date)' => date('Y'),
        );
        $this->db->select('count(appointment_id) as total, appointment_date');
        $this->db->from('appointment');
        $this->db->where($where_ary);
        $this->db->group_by("YEAR(appointment_date)");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /* Chart datatable */

    public function get_appointment_details_for_details($cur_date, $ch_val) {
        $slt_ary = array(
            'a.*',
            'a.created_date as booking_date',
            'b.patient_id',
            'b.patient_name',
            'c.doctor_id',
            'c.name',
            'e.department_id',
            'e.department_name',
        );
        $where_ary = array(
            'a.appointment_date' => $cur_date,
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
        );



        $this->db->select($slt_ary);
        $this->db->from('appointment as a');
        $this->db->join('patient as b', 'a.fk_patient_id=b.patient_id', 'left');
        $this->db->join('doctors as c', 'a.fk_doctor_id=c.doctor_id', 'left');
        $this->db->join('time_slot as d', 'd.time_slot_id=a.fk_time_slot_id', 'left');
        $this->db->join('department as e', 'e.department_id=c.fk_department_id', 'left');
        if (!empty($ch_val)) {
            $where_ary_1 = array(
                'a.fk_time_slot_id' => $ch_val,
            );
            $this->db->where($where_ary_1);
        }
        $this->db->where($where_ary);

        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_appointment_details_for_mnth_details($cur_m, $converted_date) {
        $slt_ary = array(
            'a.*',
            'a.created_date as booking_date',
            'b.patient_id',
            'b.patient_name',
            'c.doctor_id',
            'c.name',
            'e.department_id',
            'e.department_name',
        );
        $where_ary = array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
            'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        );



        $this->db->select($slt_ary);
        $this->db->from('appointment as a');
        $this->db->join('patient as b', 'a.fk_patient_id=b.patient_id', 'left');
        $this->db->join('doctors as c', 'a.fk_doctor_id=c.doctor_id', 'left');
        $this->db->join('time_slot as d', 'd.time_slot_id=a.fk_time_slot_id', 'left');
        $this->db->join('department as e', 'e.department_id=c.fk_department_id', 'left');
        if (!empty($converted_date)) {
            $where_ary_1 = array(
                'a.appointment_date' => $converted_date,
            );
            $this->db->where($where_ary_1);
        }
        $this->db->where($where_ary);

        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_appointment_details_for_monthw_details($cur_m, $converted_date) {
        $slt_ary = array(
            'a.*',
            'a.created_date as booking_date',
            'b.patient_id',
            'b.patient_name',
            'c.doctor_id',
            'c.name',
            'e.department_id',
            'e.department_name',
        );
        $where_ary = array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.appointment_cancel_status' => '0',
            'a.confirm_status' => '1',
            //'MONTH(a.appointment_date)' => date('m'),
            'YEAR(a.appointment_date)' => date('Y'),
        );



        $this->db->select($slt_ary);
        $this->db->from('appointment as a');
        $this->db->join('patient as b', 'a.fk_patient_id=b.patient_id', 'left');
        $this->db->join('doctors as c', 'a.fk_doctor_id=c.doctor_id', 'left');
        $this->db->join('time_slot as d', 'd.time_slot_id=a.fk_time_slot_id', 'left');
        $this->db->join('department as e', 'e.department_id=c.fk_department_id', 'left');
        if (!empty($converted_date)) {
            $where_ary_1 = array(
                'MONTH(a.appointment_date)' => $converted_date,
            );
            $this->db->where($where_ary_1);
        }
        $this->db->where($where_ary);

        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /* MANAGEMENT DASHBOARD */

    public function get_appointment_count_by_date($from_date, $to_date) {
        $whr_ary = array(
//            'reschedule_status' => '0',
            'status' => '1',
            'archive_status' => '1',
            'appointment_date >=' => $from_date,
            'appointment_date <=' => $to_date,
        );

        $this->db->select('count(appointment_id) as total_appointment');
        $this->db->from('appointment');
        $this->db->where($whr_ary);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['total_appointment'];
        } else {
            return FALSE;
        }
    }

    public function get_appointment_visit_non_visit_count($from_date, $to_date, $app_type) {
        $this->db->select('count(visit_status_details_id) as count');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
            'a.fk_visit_status_id' => $app_type,
        ));

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
            return $res['count'];
        } else {
            return 0;
        }
    }

    public function get_appointment_count_by_month($flt_type, $from_date, $to_date) {
        $this->db->select('COUNT(b.appointment_id) as total_count, MONTHNAME(b.appointment_date) as mnth, YEAR(b.appointment_date) as year');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->group_by('MONTH(b.appointment_date), YEAR(b.appointment_date)');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
            'a.fk_visit_status_id' => $flt_type,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointwise_doctor_wise($flt_type, $month, $year) {
        $this->db->select('c.name as doctor_name, COUNT(appointment_id) as count, c.doctor_id');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->group_by('c.name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'MONTH(b.appointment_date)' => $month,
            'YEAR(b.appointment_date)' => $year,
            'a.fk_visit_status_id' => $flt_type,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_details_by_doctor_wise($flt_type, $month, $year, $doctor_id) {
        $slt_ary = array(
            'b.appointment_date',
            'b.appointment_time',
            'b.appointment_key',
            'e.patient_name',
            'c.name as doctor_name',
            'd.department_name',
        );


        $this->db->select($slt_ary);
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
//        $this->db->group_by('c.name');

        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'MONTH(b.appointment_date)' => $month,
            'YEAR(b.appointment_date)' => $year,
            'a.fk_visit_status_id' => $flt_type,
            'b.fk_doctor_id' => $doctor_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_department_wise($flt_type, $month, $year) {
        $this->db->select('d.department_name as department_name, COUNT(b.appointment_id) as count,d.department_id');
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->group_by('d.department_name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'MONTH(b.appointment_date)' => $month,
            'YEAR(b.appointment_date)' => $year,
            'a.fk_visit_status_id' => $flt_type,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_appointment_details_by_department_wise($flt_type, $month, $year, $department_id) {
        $slt_ary = array(
            'b.appointment_date',
            'b.appointment_time',
            'b.appointment_key',
            'e.patient_name',
            'c.name as doctor_name',
            'd.department_name',
        );


        $this->db->select($slt_ary);
        $this->db->from('visit_status_details as a');
        $this->db->join('appointment as b', 'a.fk_appointment_id=b.appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
//        $this->db->group_by('c.name');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'MONTH(b.appointment_date)' => $month,
            'YEAR(b.appointment_date)' => $year,
            'a.fk_visit_status_id' => $flt_type,
            'd.department_id' => $department_id,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_doctor_wise_patient_cancelled_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('c.name as doctor_name, COUNT(appointment_id) as count, c.doctor_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
//        $this->db->group_by('c.name');
        $this->db->group_by('c.name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '0',
            'a.cancel_type' => '0',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_dep_wise_patient_cancelled_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('d.department_name as department_name, COUNT(b.appointment_id) as count,d.department_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('d.department_name');
        $this->db->order_by('count', 'DESC');
//        $this->db->group_by('c.name');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '0',
            'a.cancel_type' => '0',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /* DOCTOR CANCELLED */

    public function get_doctor_wise_dcotor_cancelled_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('c.name as doctor_name, COUNT(appointment_id) as count, c.doctor_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('c.name');
        $this->db->order_by('count', 'DESC');
//        $this->db->group_by('c.name');
        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '1',
            'a.cancel_type' => '0',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_dep_wise_doctor_cancelled_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('d.department_name as department_name, COUNT(b.appointment_id) as count,d.department_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('d.department_name');
        $this->db->order_by('count', 'DESC');

        $this->db->where(array(
            'a.status' => '1',
            'a.archive_status' => '1',
            'a.user_type' => '1',
            'a.cancel_type' => '0',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /* Reshedule */

    public function get_dep_wise_doctor_reshedule_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('d.department_name as department_name, COUNT(b.appointment_id) as count,d.department_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('d.department_name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.status' => '0',
            'a.archive_status' => '0',
            'a.user_type' => '1',
            'a.cancel_type' => '3',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_dep_wise_patient_reshedule_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('d.department_name as department_name, COUNT(b.appointment_id) as count,d.department_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('d.department_name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.user_type' => '0',
            'a.cancel_type' => '3',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_doctor_wise_doctor_reshedule_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('c.name as doctor_name, COUNT(appointment_id) as count, c.doctor_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('c.name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.status' => '0',
            'a.archive_status' => '0',
            'a.user_type' => '1',
            'a.cancel_type' => '3',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    public function get_doctor_wise_patient_reshedule_counts($from_date = FALSE, $to_date = FALSE) {
        $this->db->select('c.name as doctor_name, COUNT(appointment_id) as count, c.doctor_id');
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
        $this->db->group_by('c.name');
        $this->db->order_by('count', 'DESC');
        $this->db->where(array(
            'a.user_type' => '0',
            'a.cancel_type' => '3',
            'b.appointment_date >=' => $from_date,
            'b.appointment_date <=' => $to_date,
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /* Doctor Wise Cancelled */

    public function get_appointment_details_by_doctor_wise_cancelled($flt_type, $from_date, $to_date, $flt_id, $grp_by_type) {
        $slt_ary = array(
            'b.appointment_date',
            'b.appointment_time',
            'b.appointment_key',
            'e.patient_name',
            'c.name as doctor_name',
            'd.department_name',
        );

        $this->db->select($slt_ary);
        $this->db->from('appointment_cancel_history as a');
        $this->db->join('appointment as b', 'b.appointment_id=a.fk_appointment_id', 'left');
        $this->db->join('doctors as c', 'c.doctor_id=b.fk_doctor_id', 'left');
        $this->db->join('department as d', 'd.department_id=c.fk_department_id', 'left');
        $this->db->join('patient as e', 'e.patient_id=b.fk_patient_id', 'left');
//        $this->db->group_by('c.name');
        if ($grp_by_type == 'doctor_wise') {
//            $this->db->group_by('c.name');
            $this->db->where(array(
                'b.fk_doctor_id' => $flt_id,
            ));
        } else {
            $this->db->where(array(
                'd.department_id' => $flt_id,
            ));
        }

        if ($flt_type == '1') {
            $this->db->where(array(
                'a.status' => '1',
                'a.archive_status' => '1',
                'a.user_type' => '0',
                'a.cancel_type' => '0',
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        } else if ($flt_type == "2") {
            $this->db->where(array(
                'a.status' => '1',
                'a.archive_status' => '1',
                'a.user_type' => '1',
                'a.cancel_type' => '0',
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        } else if ($flt_type == "3") {
            $this->db->where(array(
                'a.status' => '0',
                'a.archive_status' => '0',
                'a.user_type' => '1',
                'a.cancel_type' => '3',
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        } else if ($flt_type == "4") {
            $this->db->where(array(
                'a.user_type' => '0',
                'a.cancel_type' => '3',
                'b.appointment_date >=' => $from_date,
                'b.appointment_date <=' => $to_date,
            ));
        }

        $query = $this->db->get();
//        echo $this->db->last_query();



        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
