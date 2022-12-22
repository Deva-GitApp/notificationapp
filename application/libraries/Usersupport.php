<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of User
 *
 * @author rckumar
 */
class Usersupport {

    /**
     * Copies an instance of CI
     */
    public function __construct() {
        $this->ci = & get_instance();
        $this->from_local = "kumar@clasticon.com";
        $this->local_to = "kumar@clasticon.com";
        $this->online_to = "";
        $this->from = 'noreply@sriramachandra.edu.in'; // pfb@onetwo
        $this->to = 'ipcs@sriramachandra.edu.in';
        $this->bcc_list = array('mailsendclasticon@gmail.com');
    }

    public function get_email_config() {
        $email_config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.ramkaytvs.com',
            'smtp_port' => '587',
            'smtp_crypto' => 'tls',
            'smtp_user' => 'info@ramkaytvs.com',
            'smtp_pass' => 'rktvs@20',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
        $email_config_1 = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => '465',
            //'smtp_crypto' => 'ssl',
            'smtp_user' => 'noreply@sriramachandra.edu.in',
            'smtp_pass' => 'SRIHER@noreply',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'wordwrap' => TRUE
        );
        return $email_config_1;
    }

    // To generate random password
    public function random_password($num = NULL) {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789$@!#";
        if (empty($num)) {
            return substr(str_shuffle($alphabet), 0, 8);
        } else {
            return substr(str_shuffle($alphabet), 0, $num);
        }
    }

    // To generate random secure pin
    public function random_secure_pin($num = NULL) {

        $alphabet = "0123456789";
        if (empty($num)) {
            return substr(str_shuffle($alphabet), 0, 8);
        } else {
            return substr(str_shuffle($alphabet), 0, $num);
        }
    }

    // To generate random email confirmation code
    public function random_otp($limit) {

        $alphabet = "0123456789";

        return substr(str_shuffle($alphabet), 0, $limit);
    }

    // To generate random email confirmation code
    public function random_email_confirmation_code() {

        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

        return substr(str_shuffle($alphabet), 0, 8);
    }

    //your_user_login based unique ecode
    public function unique_random_email_confirmation_code($your_user_login) {
        return md5(uniqid($your_user_login, true));
    }

    // To generate random mobile confirmation code
    public function random_mobile_confirmation_code($type = NULL) {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
        $number = "0123456789";
        $rand_alpha = substr(str_shuffle($alphabet), 0, 3);
        $rand_num = substr(str_shuffle($number), 0, 5);
        if (!empty($type)) {
            $alpha_num = $rand_alpha . $rand_num;
        } else {
            $alpha_num = $rand_num;
        }
        return $alpha_num;
    }

    public function autologin_encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'gUkXp2s5v8y/B?E(H+MbPeShVmYq3t6w';
        $secret_iv = '18158e89d55c4f7ca3c87997d5a694b0';

        // hash
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function encrypt_decrypt($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'sriher secret key';
        $secret_iv = 'sriher secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public function sent_notification_mail($mail_data) {
        $usr_mail = $mail_data['user_mail'];
        $subject_name = 'SRIHER RECEIPT NOTIFICATION - ' . $mail_data['student_barcode'];
        $this->ci->load->library('email', $this->get_email_config());
        $this->ci->email->set_mailtype("html");
        $this->ci->email->from($this->from, 'SRMC');
//        $this->ci->email->to($usr_mail);
        $this->ci->email->to('deva33.rd5@gmail.com');
        $this->ci->email->cc('suresh.j@sriramachandra.edu.in');
//        $this->ci->email->bcc($this->bcc_list);
//        $this->ci->email->reply_to($email, $name);
        $this->ci->email->subject($subject_name);
//        $data = array('name' => $name, 'gender' => $gender, 'email' => $email, 'mobile' => $mobile, 'country' => $country, 'ip' => $ip, 'department_name' => $department_name, 'passport_number' => $passport_number, 'preferred_lang' => $preferred_lang);
//        $email_message = 'Test Message';
        $email_message = $this->ci->load->view('mailtemplate/receiptmailer', $mail_data, TRUE);
//        $email_message = "Test Mail test ur " . $mail_data['url'] . " ";
        $this->ci->email->message($email_message);
        $return_val = $this->ci->email->send();
        return $return_val;
    }

//    public function pdf_test_mail($content) {
//        $subject_name = 'International Enquiry';
//        $this->ci->load->library('email');
//        $this->ci->email->set_mailtype("html");
//        $this->ci->email->from($this->from, 'SRMC');
//        $this->ci->email->to('deva33.rd5@gmail.com');
//        $this->ci->email->subject($subject_name);
//        $this->ci->email->attach($content, 'attachment', 'test.pdf', 'application/pdf');
//        ////$data = array('name' => $name, 'gender' => $gender, 'email' => $email, 'mobile' => $mobile, 'country' => $country, 'ip' => $ip, 'department_name' => $department_name, 'passport_number' => $passport_number, 'preferred_lang' => $preferred_lang);
////        $email_message = 'Test Message';
//        // $email_message = $this->ci->load->view('mailer/international_enquiry', $data, TRUE);
//        //$this->ci->email->message($email_message);
//        $return_val = $this->ci->email->send();
//        return $return_val;
//    }
//
//    public function pdf_test_mail_test($content) {
//        $subject_name = 'International Enquiry';
//        $this->ci->load->library('email');
//        $this->ci->email->set_mailtype("html");
//        $this->ci->email->from($this->from, 'SRMC');
//        $this->ci->email->to('deva33.rd5@gmail.com');
//        $this->ci->email->cc('deva@clasticon.com');
//        $this->ci->email->subject($subject_name);
//        $this->ci->email->attach($content, 'attachment', 'test.pdf', 'application/pdf');
////        $data = array('name' => $name, 'gender' => $gender, 'email' => $email, 'mobile' => $mobile, 'country' => $country, 'ip' => $ip, 'department_name' => $department_name, 'passport_number' => $passport_number, 'preferred_lang' => $preferred_lang);
//        $email_message = 'Test Message';
////         $email_message = $this->ci->load->view('mailer/international_enquiry', $data, TRUE);
//        $this->ci->email->message($email_message);
//
//        $return_val = $this->ci->email->send();
//        echo $this->ci->email->print_debugger();
//        return $return_val;
//    }
//
//    public function feedback_enquiry($name, $email, $mobile, $query, $ip) {
//        $subject_name = 'Feedback Enquiry';
//        $this->ci->load->library('email');
//        $this->ci->email->set_mailtype("html");
//        $this->ci->email->from($this->from, 'SRMC');
//        $this->ci->email->to($this->to);
//        $this->ci->email->bcc($this->bcc_list);
//        $this->ci->email->subject($subject_name);
//        $this->ci->email->reply_to($email, $name);
//        $data = array('name' => $name, 'query' => $query, 'email' => $email, 'mobile' => $mobile, 'ip' => $ip);
//        //$email_message = 'Test Message';
//        $email_message = $this->ci->load->view('mailer/feedback', $data, TRUE);
//        $this->ci->email->message($email_message);
//        $return_val = $this->ci->email->send();
//        return $return_val;
//    }
//
//    public function visited_feedback_enquiry($batch_ary, $sub_ques_ary) {
//        $subject_name = 'Visit Feedback - ' . $batch_ary[0]['user_name'];
//        $this->ci->load->library('email');
//        $this->ci->email->set_mailtype("html");
//        $this->ci->email->from($this->from, 'SRMC');
//        $this->ci->email->to('patientfeedback@sriramachandramedicalcentre.com');
//        $this->ci->email->bcc($this->bcc_list);
//        $this->ci->email->subject($subject_name);
////        $this->ci->email->reply_to($email, $name);
//        $data = array('batch_ary' => $batch_ary, 'sub_ques_ary' => $sub_ques_ary);
//        $email_message = $this->ci->load->view('mailer/visited_feedback', $data, TRUE);
//        $this->ci->email->message($email_message);
//        $return_val = $this->ci->email->send();
//        return $return_val;
//    }
//
////    public function test_mail($email_to, $mail_subject, $message) {
////
////        $subject_name = $mail_subject;
////        $this->ci->load->library('email');
////        $this->ci->email->set_mailtype("html");
////        $this->ci->email->from($this->from, 'SRMC');
////        $this->ci->email->to($email_to);
////        //$this->ci->email->bcc($this->bcc_list);
////        $this->ci->email->subject($subject_name);
////        //        $this->ci->email->reply_to($email, $name);
////        //        $data = array('batch_ary' => $batch_ary, 'sub_ques_ary' => $sub_ques_ary);
////        $email_message = $message;
////        $this->ci->email->message($email_message);
////        $return_val = $this->ci->email->send();
////        //echo $this->ci->email->print_debugger();
////        return $return_val;
////    }
}
