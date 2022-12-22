<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Students extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/student_model',
        );

        $lib_ary = array(
            'imageupload',
            'usersupport',
        );

        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the sriher students error');
    }



    public function view()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Students';
            $data['sub_title'] = 'View';
            /*
              $data['loadcss'] = array(
              'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
              );
              $data['loadjs'] = array(
              'bower_components/datatables.net/js/jquery.dataTables.min.js',
              'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',


              );
             */
            $data['loadcss'] = array(
                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
                //                'bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
                //                'bower_components/datatables.net/datatabletools/css/dataTables.tableTools.css',
                //                'bower_components/datatable.net.btns/css/jquery.dataTables.min.css',
                //                'bower_components/datatable.net.btns/css/buttons.dataTables.min.css',
            );
            $data['loadjs'] = array(
                'bower_components/datatables.net/js/jquery.dataTables.min.js',
                'bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
                'bower_components/datatable.net.btns/js/dataTables.buttons.min.js',
                'bower_components/datatable.net.btns/js/jszip.min.js',
                'bower_components/datatable.net.btns/js/pdfmake.min.js',
                'bower_components/datatable.net.btns/js/vfs_fonts.js',
                'bower_components/datatable.net.btns/js/buttons.html5.min.js',
            );

          //  $data['students_list'] = $this->student_model->get_all_studentsfr_student();

            //            $data['role_type_list'] = $this->employee_model->get_all_role_type();
            //            $data['department_list'] = $this->employee_model->get_all_departments();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/students/view_students', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }


    public function ajax_with_datatable()
    {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $page_name = $this->router->fetch_class();
            $per_res = permission_view_check($page_name, $session_data);
            $uid = $session_data['id'];


            $columns = array(
                0 => 'student_id',
                1 => 'student_name',
                2 => 'student_barcode',
                3 => 'course_name',
                4 => 'student_dob',
                5 => 'batch',
                6 => 'created_date',
            );

            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalData = $this->student_model->allposts_count();

            $totalFiltered = $totalData;

            if (empty($this->input->post('search')['value'])) {
                $posts = $this->student_model->allposts($limit, $start, $order, $dir);
            } else {
                $search = $this->input->post('search')['value'];
                $posts = $this->student_model->posts_search($limit, $start, $search, $order, $dir);
                $totalFiltered = $this->student_model->posts_search_count($search);
            }
            $data = array();
            if (!empty($posts)) {
                $permission = '';
                foreach ($posts as $post) {
                    $nestedData['student_id'] = $post->student_id;
                    $nestedData['student_name'] = $post->student_name;
                    $nestedData['student_barcode'] = $post->student_barcode;
                    $nestedData['course_name'] = $post->course_name;
                    $nestedData['student_dob'] = $post->student_dob;
                    $nestedData['batch'] = $post->batch;
                    $nestedData['created_date'] = date('d-M-Y H:i:s', strtotime($post->created_date));
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw" => intval($this->input->post('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );

            echo json_encode($json_data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }
}
