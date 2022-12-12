<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of User
 *
 * @author rckumar
 */
class Imageupload
{

    /**
     * Copies an instance of CI
     */
    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function do_multiple_upload($type, $files, $file_name = FALSE)
    {



        if ($type == 'user_profile') {
            $config['upload_path'] = 'admin_assets/upload/employee_profile/';
            $config['allowed_types'] = 'gif|jpg|png';

            //$config['max_height'] = '300';
            $config['max_size'] = '2048';
        } else if ($type == 'doctor') {
            $config['upload_path'] = 'admin_assets/upload/doctor/';
            $config['allowed_types'] = 'gif|jpg|png';

            //$config['max_height'] = '300';
            $config['max_size'] = '2048';
        } else if ($type == 'banner') {
            $config['upload_path'] = 'admin_assets/upload/banner/';
            $config['allowed_types'] = 'gif|jpg|png';

            //$config['max_height'] = '300';
            $config['max_size'] = '2048';
        } else if ($type == 'prescription') {
            $config['upload_path'] = 'admin_assets/upload/prescription/';
            $config['allowed_types'] = 'gif|jpg|png|pdf|PDF';

            //$config['max_height'] = '300';
            $config['max_size'] = '2048';
        } else if ($type == 'patient') {
            $config['upload_path'] = 'admin_assets/upload/patient/';
            $config['allowed_types'] = 'gif|jpg|png';

            //$config['max_width'] = '77';
            // $config['max_height'] = '77';
            // $config['min_width'] = '77';
            //  $config['min_height'] = '77';
            $config['max_size'] = '2048';
        } else if ($type == 'dep_icon') {
            $config['upload_path'] = 'admin_assets/upload/department/icon';
            $config['allowed_types'] = 'gif|jpg|png';

            //$config['max_width'] = '77';
            // $config['max_height'] = '77';
            // $config['min_width'] = '77';
            //  $config['min_height'] = '77';
            $config['max_size'] = '2048';
        }
        //        $config = array(
        //            'upload_path' => $path,
        //            'allowed_types' => 'jpg|gif|png',
        //            'overwrite' => 1,
        //        );

        $this->ci->load->library('upload', $config);

        $images = array();
        $i = 1;
        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name'] = $files['name'][$key];
            $_FILES['images[]']['type'] = $files['type'][$key];
            $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
            $_FILES['images[]']['error'] = $files['error'][$key];
            $_FILES['images[]']['size'] = $files['size'][$key];

            $fileName = $image;

            if ($file_name) {
                $images[] = $file_name;
                $config['file_name'] = $file_name;
            } else {
                $images[] = $fileName;
                $config['file_name'] = $fileName;
            }

            //            echo '<pre>';
            //            print_r($_FILES);
            //            echo '</pre>';
            //            exit;

            $this->ci->upload->initialize($config);

            if (!$this->ci->upload->do_upload('images[]')) {
                $error = array('error' => $this->ci->upload->display_errors());
                return $error;
            } else {
                $upload_data = $this->ci->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                $file_name = $upload_data['file_name'];

                //. return false;
            }
            $i++;
        }
        return $images;
    }

    public function csvupload($fileName, $inp_name, $uplpath)
    {

        $uploadPath = "./admin_assets/upload/$uplpath/";
        //        echo $uploadPath;
        //        exit;

        // Config the upload
        $config['upload_path'] = $uploadPath; // some directory on the server with write permission        
        $config['allowed_types'] = 'csv|xls|xlsx';
        //        $config['max_size'] = '51200'; //50 MB
        $config['encrypt_name'] = TRUE;
        $config['file_ext_tolower'] = true;
        // Set file name
        $config['file_name'] = $fileName['name'];
        // Load the library with config
        $this->ci->load->library('upload', $config);

        // Do the upload
        if (!$this->ci->upload->do_upload($inp_name)) {
            die($this->ci->upload->display_errors());
        } else {
            $upload_data = $this->ci->upload->data();
            return $upload_data;
        }
    }
}
