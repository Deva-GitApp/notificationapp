<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of User
 *
 * @author rckumar
 */
class Ftpsettings {

    /**
     * Copies an instance of CI
     */
    public function __construct() {
        $this->ci = & get_instance();
    }

    public function get_projectfiles($cnf) {

        $ftp_username = 'idelivery@wisualit.com';
        $ftp_userpass = '4U#89!6fcC$23sPiK';
        $ftp_server = "id.wisualit.com";
        $this->ci->load->library('ftp');
        $config['hostname'] = "id.wisualit.com"; //"172.16.1.161"; // "172.16.1.235"; // 'ftp.example.com'
        $config['username'] = "idelivery@wisualit.com"; //"root@172.16.1.161"; // 'your-username';
        $config['password'] = '4U#89!6fcC$23sPiK'; //"R@$@t^)); //'your-password';
//        $config['port'] = 21;
//        $config['passive'] = true;
        $config['debug'] = true;

        $res = $this->ci->ftp->connect($config);
        $this->ci->ftp->close();
        return $res;

//        if ($res) {
////            $list = $this->ci->ftp->list_files('/home/');
//            return $list;
//        } else {
//            return false;
//        }
    }

}
