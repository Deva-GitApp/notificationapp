<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author rckumar
 */
class Employee extends CI_Controller {

    function __construct() {
        parent::__construct();
        $data = array(
            'base_model',
            'admin/user',
            'admin/employee_model'
        );
        $lib_ary = array(
            'imageupload',
            'usersupport',
        );
        $this->load->model($data, '', true);
        $this->load->library($lib_ary, '', true);
        $this->hashids = new Hashids\Hashids('the srh-ola employee error');
    }

    public function index() {
        redirect('admin/employee/view', 'refresh');
    }

    public function view() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee';
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

//            $data['employee_list'] = $this->employee_model->get_all_employee();
//            $data['role_type_list'] = $this->employee_model->get_all_role_type();
//            $data['department_list'] = $this->employee_model->get_all_departments();
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/includes/admin_menu', $data);
            $this->load->view('admin/employee/view_employee', $data);
            $this->load->view('admin/includes/footer', $data);
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function create() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);
            //  $employee_id = $session_data['employee'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee';
            $data['sub_title'] = 'Add';

            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
                'bower_components/autocomplete/typeahead.js',
                'dist/js/form_validation/employee.js',
            );
            $data['employee_list'] = $this->employee_model->get_all_employee();
            $data['department_list'] = $this->employee_model->get_all_departments();
            $data['role_type_list'] = $this->employee_model->get_all_role_type();

            $this->load->library('form_validation');
            $this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
            $this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required|is_unique[admin_user.employee_id]');
            $this->form_validation->set_rules('employee_email', 'Employee Email', 'trim|required|is_unique[admin_user.email]');
            $this->form_validation->set_rules('employee_password', 'Employee Password', 'trim|required');
            $this->form_validation->set_rules('employee_address', 'Employee Address', 'trim|required');
            $this->form_validation->set_rules('employee_sec_pin', 'Employee Secure Pin', 'trim|required');
            $this->form_validation->set_rules('employee_mobile', 'Employee Mobile', 'trim|required|is_unique[admin_user.mobile]');
            $this->form_validation->set_rules('emp_pincode', 'Employee Pincode', 'trim|required');
            $this->form_validation->set_rules('geolocationid', 'Employee Pincode', 'trim|required');
            $this->form_validation->set_rules('slt_role', 'Role', 'trim|required|callback_slt_check');
            $this->form_validation->set_rules('slt_department', 'Department', 'trim|required|callback_slt_check');
            $this->form_validation->set_message('is_unique', 'This %s already exists.');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/employee/add_employee', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $role = $this->input->post('slt_role');
                $role_details = $this->employee_model->get_roletype_by_id($role);
                $role_type_name = $role_details['role_type_name'];
                if ($role_type_name == 'Doctor') {
                    $type = 'doctor';
                } else {
                    $type = 'user_profile';
                }
                $file_name = $_FILES['user_profile']['name'][0];
                $ext = get_extension($file_name);

                $employee_name = $this->input->post('employee_name');
                $upload_employee_name = strtolower(str_replace(".", "", preg_replace('/[^a-zA-Z0-9-_\.]/', '', $employee_name))) . 'profile' . date('His');
                $upload_res = $this->imageupload->do_multiple_upload($type, $_FILES['user_profile'], $upload_employee_name);
                $user_profile = (isset($upload_res[0])) ? $upload_res[0] . '.' . $ext : 'no-image.jpg';

                $employee_id = $this->input->post('employee_id');
                $employee_email = $this->input->post('employee_email');
                $employee_password_str = $this->input->post('employee_password');
                $employee_password = $this->usersupport->encrypt_decrypt('encrypt', $employee_password_str);
                $employee_address = $this->input->post('employee_address');
                $employee_sec_pin = $this->input->post('employee_sec_pin');
                $employee_mobile = $this->input->post('employee_mobile');
                $employee_piconde = $this->input->post('emp_pincode');
                $employee_country = $this->input->post('country');
                $employee_state = $this->input->post('state');
                $employee_district = $this->input->post('district');
                $geolocationid = $this->input->post('geolocationid');
                $department = $this->input->post('slt_department');



                $result = $this->employee_model->add_employee($employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $department, $session_data['id']);

                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'New Employee Name is Created Successfully.');
                    redirect('admin/employee/view', 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Creation Failed. Please try again...');
                    redirect('admin/employee/create', 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function edit($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);




            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee';
            $data['sub_title'] = 'Edit';
            /* dynamic js */
            $data['loadcss'] = array(
                'bower_components/select2/dist/css/select2.min.css',
                'bower_components/file-input/bootstrap-fileinput-master/css/fileinput.min.css',
                    /*  'lib/imagere-size/css/imgareaselect-animated.css' */
            );
            $data['loadjs'] = array(
                'bower_components/select2/dist/js/select2.full.min.js',
                'bower_components/jquery-validation/dist/jquery.validate.min.js',
                'bower_components/file-input/bootstrap-fileinput-master/js/fileinput.js',
                'bower_components/autocomplete/typeahead.js',
                'dist/js/form_validation/employee.js',
            );
            /* decode url */
            $numbers = $this->hashids->decode($id);
//            print_r($numbers);
            $data['employee_data'] = $this->employee_model->get_employee_by_id($numbers[0]);
            $data['role_type_list'] = $this->employee_model->get_all_role_type();
            $data['department_list'] = $this->employee_model->get_all_departments();

            //$this->output->enable_profiler(TRUE);
            //callback_slt_check
            $this->load->library('form_validation');
            $this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
            $this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required');
            $this->form_validation->set_rules('employee_email', 'Employee Email', 'trim|required');
            $this->form_validation->set_rules('employee_password', 'Employee Password', 'trim|required');
            $this->form_validation->set_rules('employee_address', 'Employee Address', 'trim|required');
            $this->form_validation->set_rules('employee_sec_pin', 'Employee Secure Pin', 'trim|required');
            $this->form_validation->set_rules('employee_mobile', 'Employee Mobile', 'trim|required');
            $this->form_validation->set_rules('emp_pincode', 'Employee Pincode', 'trim|required');
            $this->form_validation->set_rules('geolocationid', 'Employee Pincode', 'trim|required');
            $this->form_validation->set_rules('slt_role', 'Role', 'trim|required|callback_slt_check');
            $this->form_validation->set_rules('slt_department', 'Department', 'trim|required|callback_slt_check');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/includes/admin_menu', $data);
                $this->load->view('admin/employee/edit_employee', $data);
                $this->load->view('admin/includes/footer', $data);
            } else {
                $employee_name = $this->input->post('employee_name');
                $role = $this->input->post('slt_role');
                $user_profile_hid = $this->input->post('user_profile_hid');

                $check_user_img = $this->employee_model->check_user_profile_by_id($numbers[0], $user_profile_hid);
                $role_details = $this->employee_model->get_roletype_by_id($role);
                $role_type_name = $role_details['role_type_name'];
                if ($check_user_img == FALSE) {
                    $role_type_name = $role_details['role_type_name'];
                    if ($role_type_name == 'Doctor') {
                        $type = 'doctor';
                    } else {
                        $type = 'user_profile';
                    }
                    $file_name = $_FILES['user_profile']['name'][0];
                    $ext = get_extension($file_name);
                    $upload_employee_name = strtolower(str_replace(".", "", preg_replace('/[^a-zA-Z0-9-_\.]/', '', $employee_name))) . 'profile' . date('His');
                    $upload_res = $this->imageupload->do_multiple_upload($type, $_FILES['user_profile'], $upload_employee_name);
                    //$user_profile = $upload_res[0] . '.' . $ext;
                    $user_profile = (isset($upload_res[0])) ? $upload_res[0] . '.' . $ext : 'no-image.jpg';
                } else {
                    $user_profile = $data['employee_data']['photo'];
                }
                $employee_id = $this->input->post('employee_id');
                $employee_email = $this->input->post('employee_email');
                $employee_password_str = $this->input->post('employee_password');
                $employee_password = $this->usersupport->encrypt_decrypt('encrypt', $employee_password_str);
                $employee_address = $this->input->post('employee_address');
                $employee_sec_pin = $this->input->post('employee_sec_pin');
                $employee_mobile = $this->input->post('employee_mobile');
                $employee_piconde = $this->input->post('emp_pincode');
                $employee_country = $this->input->post('country');
                $employee_state = $this->input->post('state');
                $employee_district = $this->input->post('district');
                $geolocationid = $this->input->post('geolocationid');
                $department = $this->input->post('slt_department');


                $check_unq = $this->employee_model->check_employee_unique($numbers[0], $employee_email, $employee_mobile, $employee_id);
                $result = FALSE;
                if ($check_unq) {
                    $result = $this->employee_model->edit_employee($numbers[0], $employee_name, $role_type_name, $employee_id, $employee_email, $user_profile, $employee_password, $employee_address, $employee_sec_pin, $employee_mobile, $employee_piconde, $employee_country, $employee_state, $employee_district, $geolocationid, $role, $department, $session_data['id']);
                } else {
                    $this->session->set_flashdata('db_error', 'This Employee Name or Email or Employee ID already exists.Please try again..');
                    redirect('admin/employee/edit/' . $id, 'refresh');
                }
                if ($result) {
                    $this->session->set_flashdata('db_sucess', 'Updated Successfully.');
                    redirect('admin/employee/view/' . $id, 'refresh');
                } else {
                    $this->session->set_flashdata('db_error', 'Updation Failed. Please try again...');
                    redirect('admin/employee/edit/' . $id, 'refresh');
                }
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function delete($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            // $employee_id = $session_data['employee'];

            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee';
            $data['sub_title'] = 'Delete';
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $employee_data = $this->employee_model->get_employee_by_id($numbers[0]);
            $role_details = $this->employee_model->get_roletype_by_id($employee_data['fk_roletype_id']);
            $role_type_name = $role_details['role_type_name'];


            $result = $this->employee_model->delete_employee_by_id($numbers[0], $role_type_name, $session_data['id']);
            if ($result) {
                $this->session->set_flashdata('db_sucess', 'Employee Name is Deleted Successfully.');
                redirect('admin/employee/view/', 'refresh');
            } else {
                $this->session->set_flashdata('db_error', 'Can not Delete. Please try again...');
                redirect('admin/employee/view/', 'refresh');
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function status($id) {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $uid = $session_data['id'];
            $email = $session_data['email'];
            $role_id = $session_data['role'];
            $role = $this->base_model->get_role_name_by_id($role_id);

            $data['ss_data'] = $session_data;
            $data['title'] = 'Employee';
            $data['sub_title'] = 'Status';
            $status = $_POST['data'];
            if ($status == '0') {
                $status = '1';
            } elseif ($status == '1') {
                $status = '0';
            }
            /* decode url */
            $numbers = $this->hashids->decode($id);
            $employee_data = $this->employee_model->get_employee_by_id($numbers[0]);
            $role_details = $this->employee_model->get_roletype_by_id($employee_data['fk_roletype_id']);
            $role_type_name = $role_details['role_type_name'];
            $result = $this->employee_model->change_status_employee_by_id($numbers[0], $role_type_name, $uid, $status);

            if ($result) {
                echo $status;
            } else {
                echo '2';
            }
        } else {
            redirect(base_url('admin'), 'refresh');
        }
    }

    public function slt_check($str) {
        if ($str == '0') {
            $this->form_validation->set_message('slt_check', 'Select the {field} ');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function ajax_with_datatable() {
        if ($this->session->userdata('srihertemp_admin_logged_in') == true) {
            $session_data = $this->session->userdata('srihertemp_admin_logged_in');
            $page_name = $this->router->fetch_class();
            $per_res = permission_view_check($page_name, $session_data);
            $uid = $session_data['id'];
            if ($session_data['role_type_name'] == "Doctor") {
                $doctor_id = get_docotor_id($uid);
            } else {
                $doctor_id = FALSE;
            }


            $columns = array(
                0 => 'admin_id',
                1 => 'name',
                2 => 'employee_id',
                3 => 'department_name',
                4 => 'email',
                5 => 'role_type_name',
                6 => 'admin_id',
                7 => 'created_date',
                8 => 'modified_date',
                9 => 'admin_id',
            );


            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];

            $totalData = $this->employee_model->allposts_count($doctor_id);

            $totalFiltered = $totalData;

            if (empty($this->input->post('search')['value'])) {
                $posts = $this->employee_model->allposts($limit, $start, $order, $dir);
            } else {
                $search = $this->input->post('search')['value'];
                $posts = $this->employee_model->posts_search($limit, $start, $search, $order, $dir);
                $totalFiltered = $this->employee_model->posts_search_count($search);
            }

//           
//            echo '<pre>';
//            print_r($posts);
//            echo '</pre>';
            $data = array();
            if (!empty($posts)) {
                $permission = '';
                foreach ($posts as $post) {
                    $admin_id = $post->admin_id;
                    $action_html = '';
                    if ($per_res['status']) {
                        if ($post->status == '1') {
                            $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $admin_id . '" data-href="' . base_url('admin') . '/employee/status/' . $this->hashids->encode($admin_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                        } else if ($post->status == '0') {
                            $action_html .= '<a href="javascript:;" class="action_status" data-value="' . $post->status . '" id="action_status_' . $admin_id . '" data-href="' . base_url('admin') . '/employee/status/' . $this->hashids->encode($admin_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-eye-close"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                        }
                    }
                    if ($per_res['edit']) {

                        $action_html .='<a class="action_edit" id="action_edit_' . $admin_id . '" href="' . base_url('admin') . '/employee/edit/' . $this->hashids->encode($admin_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp; | &nbsp;&nbsp;';
                    }
                    if ($per_res['delete']) {

                        $action_html .='<a href="javascript:;" class="action_del" id="action_del_' . $admin_id . '" data-href="' . base_url('admin') . '/employee/delete/' . $this->hashids->encode($admin_id, dateintval('d'), dateintval('m'), dateintval('y')) . '"><span class="glyphicon glyphicon-remove"></span></a>';
                    }


                    $permission = '<a href="' . base_url("admin") . '/permission/employee_permission/' . $this->hashids->encode($admin_id, dateintval('d'), dateintval('m'), dateintval('y')) . '" class="btn btn-primary">Update Permission</a>';

                    $nestedData['admin_id'] = $post->admin_id;
                    $nestedData['name'] = $post->name;
                    $nestedData['employee_id'] = $post->employee_id;
                    $nestedData['department_name'] = $post->department_name;
                    $nestedData['email'] = $post->email;
                    $nestedData['role_type_name'] = $post->role_type_name;
                    $nestedData['permission'] = $permission;
                    $nestedData['created_date'] = date('d-M-Y H:i:s', strtotime($post->created_date));
                    $nestedData['modified_date'] = date('d-M-Y H:i:s', strtotime($post->modified_date));
                    $nestedData['action'] = $action_html;
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
