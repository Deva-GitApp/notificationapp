<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('clean_str_alpha_numeric')) {

    function clean_str_alpha_numeric($str)
    {
        //        $clstr = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
        $clstr = str_replace("'", " ", $str);
        return $clstr;
    }
}

if (!function_exists('moneyFormatIndia')) {
    function moneyFormatIndia($num)
    {
        $explrestunits = "";
        if (strlen($num) > 3) {
            $lastthree = substr($num, strlen($num) - 3, strlen($num));
            $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
            $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for ($i = 0; $i < sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if ($i == 0) {
                    $explrestunits .= (int)$expunit[$i] . ","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i] . ",";
                }
            }
            $thecash = $explrestunits . $lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }
}

if (!function_exists('custom_function')) {

    function get_extension($file)
    {
        $extension = explode(".", $file);
        return $extension ? end($extension) : false;
    }
}

if (!function_exists('bg_colors')) {


    function bg_colors()
    {
        $bg_colors = array(
            'bg-light-blue',
            'bg-green',
            'bg-yellow',
            'bg-red',
            'bg-purple',
            'bg-blue',
            //            'bg-navy',
            'bg-teal',
            'bg-maroon',
            //            'bg-black',
            //            'bg-gray',
            'bg-olive',
            //            'bg-lime',
            'bg-orange',
            //            'bg-fuchsia',
        );
        return $bg_colors;
    }
}

if (!function_exists('agecalbydob')) {

    function agecalbydob($dateofbirth)
    {
        $diff = (date('Y') - date('Y', strtotime($dateofbirth)));
        return $diff;
    }
}
if (!function_exists('agecalbydob_sec')) {

    function agecalbydob_sec($dateofbirth)
    {
        $interval = date_diff(date_create(), date_create($dateofbirth));
        $res['year'] = $interval->format("%Y");
        $res['month'] = $interval->format("%M");
        $res['days'] = $interval->format("%d");
        return $res;
        //        $diff = (date('Y') - date('Y', strtotime($dateofbirth)));
        //        return $diff;
    }
}



if (!function_exists('welcome')) {

    function welcome()
    {
        if (date("H") < 12) {
            return "good morning";
        } elseif (date("H") > 11 && date("H") < 18) {
            return "good afternoon";
        } elseif (date("H") > 17) {
            return "good evening";
        }
    }
}

if (!function_exists('permission_view_check')) {

    // $CI = get_instance();
    //  $page_name = $CI->router->fetch_class();
    // $action_name = $CI->router->fetch_method();

    function permission_view_check($page_name, $ss_data)
    {
        //$CI = get_instance();
        $role_id = $ss_data['role'];
        $uid = $ss_data['id'];
        if ($role_id != 1) {
            $permission_edit = checkuserpermission($uid, $role_id, $page_name, 'edit');
            $permission_status = checkuserpermission($uid, $role_id, $page_name, 'status');
            $permission_delete = checkuserpermission($uid, $role_id, $page_name, 'delete');
            $item['edit'] = $permission_edit;
            $item['status'] = $permission_status;
            $item['delete'] = $permission_delete;
        } else {
            $item['edit'] = TRUE;
            $item['status'] = TRUE;
            $item['delete'] = TRUE;
        }

        return $item;
    }
}

if (!function_exists('checkuserpermission')) {

    function checkuserpermission($uid, $role_id, $page_name, $action_name)
    {
        $CI = get_instance();
        $CI->load->model('helper_model');

        $check_user_permission = $CI->helper_model->check_user_haspermission($uid);
        if ($check_user_permission) {
            $result = $CI->helper_model->check_user_permission($uid, $page_name, $action_name);
        } else {
            /* check roletype */
            $result = $CI->helper_model->check_permission($role_id, $page_name, $action_name);
        }
        return $result;
    }
}

if (!function_exists('get_permission_menu')) {

    function get_permission_menu($employee_id, $role_type_id)
    {
        //load library
        $CI = get_instance();
        $CI->load->model('helper_model');
        $res_per = $CI->helper_model->check_employee_permission($employee_id);
        if ($res_per != FALSE) {
            $permission_menu = $CI->helper_model->get_employee_permission($employee_id);
        } else {
            $permission_menu = $CI->helper_model->get_role_type_permission($role_type_id);
        }
        return $permission_menu;
    }
}
if (!function_exists('generate_pdf')) {

    function generate_pdf($message, $file_name)
    {
        require 'application/third_party/mpdf/vendor/autoload.php';
        $mpdf = new mPDF();
        $path_to_file = 'admin_assets/pdf/' . $file_name;
        $stylesheet_2 = file_get_contents('admin_assets/dist/css/adminstyle.css'); // external css        
        $mpdf->WriteHTML($stylesheet_2, 1);
        $mpdf->WriteHTML($message, 2);
        $mpdf->Output($path_to_file, "F");
        return $path_to_file;
    }
}


if (!function_exists('set_barcode')) {

    function set_barcode($code)
    {
        //load library
        $CI = get_instance();
        $CI->load->library('zend');
        //load in folder Zend
        $CI->zend->load('Zend/Barcode');
        //        //generate barcode
        //        Zend_Barcode::render('code128', 'image', array('text' => $code), array());
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
        $code = time() . $code;
        $store_image = imagepng($file, "admin_assets/upload/barcode/{$code}.png");
        return $code . '.png';
    }
}


if (!function_exists('getlistofdaysformont')) {

    function getlistofdaysformont($month, $year)
    {
        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);

        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $list[] = date('Y-m-d', $i);
        }
        return $list;
    }
}

if (!function_exists('get_color')) {

    function get_color($booked_slot_count)
    {
        $color = '';
        if ($booked_slot_count == '0') {
            $color = "#f56954";
        } else if ($booked_slot_count > 0 && $booked_slot_count <= 10) {
            $color = "#3c8dbc";
        } else if ($booked_slot_count > 10 && $booked_slot_count <= 50) {
            $color = "#00c0ef";
        } else {
            $color = "#00a65a";
        }
        return $color;
    }
}
if (!function_exists('get_day_name')) {

    function get_day_name($date)
    {

        $date = date('Y-m-d', strtotime($date));

        if ($date == date('Y-m-d')) {
            $date = 'Today';
        } else if ($date == date('Y-m-d', time() - (24 * 60 * 60))) {
            $date = 'Yesterday';
        } else {
            $date = date('d-m-Y', strtotime($date));
        }
        return $date;
    }
}
if (!function_exists('action_ary')) {

    function action_ary()
    {

        $action_ary = array(
            'create',
            'createnew',
            'edit',
            'delete',
            'status',
            'dep_edit',
            'dashboard',
            'bulk_cancel',
            'view',
            'employee_permission',
            'month_wise',
            'department_wise',
            'doctor_wise',
            'date_wise',
            'doc_dashboard',
            'profile',
            'visitedfeedback',
            'management_dashboard',
            'employee_wise',
            'view_payment_refunds',
            'view_order_details',
            'view_payment_details',
            'view_delayed_payment',
            'add_slot',
            'view_slot',
            'edit_slot',
        );
        return $action_ary;
    }
}

if (!function_exists('slotmerge')) {

    function slotmerge($slot_id_str, $slot_time_interval_str)
    {
        $slot_id_ary = explode(',', $slot_id_str);
        $slot_time_interval_ary = explode('$', $slot_time_interval_str);

        foreach ($slot_id_ary as $key => $value) {
            $slot_interval_str = $slot_time_interval_ary[$key];
            if ($value == '1') {
                $item['morning'] = $slot_interval_str;
            } else if ($value == '2') {
                $item['afternoon'] = $slot_interval_str;
            } else if ($value == '3') {
                $item['evening'] = $slot_interval_str;
            }
        }
        return $item;
    }
}
if (!function_exists('getimagesizefromstring')) {

    function getimagesizefromstring($data)
    {
        $uri = 'data://application/octet-stream;base64,' . base64_encode($data);
        return getimagesize($uri);
    }
}


if (!function_exists('time_diff')) {

    function time_diff($cur_date_time, $app_created_date)
    {
        $datetime1 = new DateTime($cur_date_time);
        $datetime2 = new DateTime($app_created_date);
        $interval = $datetime1->diff($datetime2);
        //return $interval->format('%d') . " Hours " . $interval->format('%h') . " Hours " . $interval->format('%i') . " Minutes";
        $res = array(
            'days' => $interval->format('%d'),
            'hours' => $interval->format('%h'),
        );
        return $res;
    }
}
if (!function_exists('date_difference')) {

    function date_difference($date1, $date2)
    {
        //        $date1 = "2007-03-24";
        //        $date2 = "2009-06-26";

        $diff = abs(strtotime($date2) - strtotime($date1));
        $diff_fr_days = strtotime($date2) - strtotime($date1);
        $total_days = abs(round($diff_fr_days / 86400));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $res['days'] = $days;
        $res['months'] = $months;
        $res['years'] = $years;
        $res['total_days'] = $total_days;

        return $res;
    }
}

if (!function_exists('firstthreschar')) {

    function firstthreschar($str, $length)
    {
        $result = substr($str, 0, $length);
        return $result;
    }
}

if (!function_exists('array_asc')) {

    function array_asc($ary)
    {
        sort($ary);
        $res_ary = array();
        foreach ($ary as $key => $value) {
            array_push($res_ary, $value);
        }

        return $res_ary;
    }
}

if (!function_exists('date_sort')) {

    function date_sort($a, $b)
    {
        return strtotime($a) - strtotime($b);
    }
}


if (!function_exists('array_desc')) {

    function array_desc($ary)
    {





        rsort($ary);
        $res_ary = array();
        foreach ($ary as $key => $value) {
            date('d', strtotime($value));



            array_push($res_ary, $value);
        }

        return $res_ary;
    }
}
if (!function_exists('arrayfirstlastvalue')) {

    function arrayfirstlastvalue($ary)
    {
        $first_val = reset($ary);
        $last_value = end($ary);
        $res_ary['first_val'] = $first_val;
        $res_ary['last_value'] = $last_value;
        return $res_ary;
    }
}
if (!function_exists('doNewColor')) {

    function doNewColor()
    {
        $color = dechex(rand(0x000000, 0xFFFFFF));
        return $color;
    }
}
if (!function_exists('randomcolor')) {

    function randomcolor()
    {
        $rand_color = array(
            "#f56954",
            "#d2d6de",
            "#3c8dbc",
            "#00c0ef",
            "#00a65a",
            "#f39c12",
            "#932ab6",
            "#39cccc",
        );
        $k = array_rand($rand_color);
        $v = $rand_color[$k];
        return $v;
    }
}
if (!function_exists('dateintval')) {

    function dateintval($str)
    {

        if ($str == 'd') {
            $res = intval(date('d'));
        } else if ($str == 'm') {
            $res = intval(date('m'));
        } else if ($str == 'y') {
            $res = intval(date('y'));
        }





        //        $date_ary = array(
        //            'd' => $d,
        //            'm' => $m,
        //            'y' => $y,
        //        );
        return $res;
    }
}

if (!function_exists('validate_phone_number')) {

    function validate_phone_number($phone)
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
            return false;
        } else {
            return $phone_to_check;
        }
    }
}

if (!function_exists('IsRemoteFile')) {

    function IsRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result !== FALSE) {
            return 'image exists';
        } else {
            return 'image does not exist';
        }
    }
}
