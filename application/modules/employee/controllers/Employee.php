<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('employee_model');
        $this->load->model('home/home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['employees'] = $this->employee_model->getEmployeeByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('employee', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function employeeByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['employees'] = $this->employee_model->getEmployeeByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('employee', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchEmployee() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['employees'] = $this->employee_model->getEmployeeByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('employee', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $designation = $this->input->post('designation');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $salary = $this->input->post('salary');
        $incentive = $this->input->post('incentive');
        $status = $this->input->post('status');
        $feedback = $this->input->post('feedback');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Designation Field
        $this->form_validation->set_rules('designation', 'Designation', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[1]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("employee/editEmployee?id=$id");
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $data['nextPayments'] = $this->home_model->getUnpaidStudents();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {
            $file_name = $_FILES['img_url']['name'];
            $file_name_pieces = explode('_', $file_name);
            $new_file_name = '';
            $count = 1;
            foreach ($file_name_pieces as $piece) {
                if ($count !== 1) {
                    $piece = ucfirst($piece);
                }

                $new_file_name .= $piece;
                $count++;
            }
            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();
                $img_url = "uploads/" . $path['file_name'];
                $data = array();
                $data = array(
                    'img_url' => $img_url,
                    'name' => $name,
                    'designation' => $designation,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'salary' => $salary,
                    'incentive' => $incentive,
                    'status' => $status,
                    'feedback' => $feedback
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'designation' => $designation,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'salary' => $salary,
                    'incentive' => $incentive,
                    'status' => $status,
                    'feedback' => $feedback
                );
            }

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Employee
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', 'This Email Address Is Already Registered');
                    redirect('employee/addNewView');
                } else {
                    $dfg = 3;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $user_id = $this->db->insert_id();
                    $ion_user_id = $this->db->get_where('users_groups', array('id' => $user_id))->row()->user_id;
                    $this->employee_model->insertEmployee($data);
                    $employee_user_id = $this->db->insert_id();
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->employee_model->updateEmployee($employee_user_id, $id_info);

                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('employee');
                    $message = $autosms->message;
                    $to = $phone;
                    $name1 = explode(' ', $name);
                    if (!isset($name1[1])) {
                        $name1[1] = null;
                    }
                    $data1 = array(
                        'firstname' => $name1[0],
                        'lastname' => $name1[1],
                        'name' => $name,
                        'designation' => $designation,
                        'institution' => $set['settings']->system_vendor
                    );

                    if ($autosms->status == 'Active') {
                        $messageprint = $this->parser->parse_string($message, $data1);
                        $data2[] = array($to => $messageprint);
                        $this->sms->sendSms($to, $message, $data2);
                    }
                    //end
                    //email

                    $autoemail = $this->email_model->getAutoEmailByType('employee');
                    if ($autoemail->status == 'Active') {
                        $emailSettings = $this->email_model->getEmailSettings();
                        $message1 = $autoemail->message;
                        $messageprint1 = $this->parser->parse_string($message1, $data1);
                        $this->email->from($emailSettings->admin_email);
                        $this->email->to($email);
                        $this->email->subject('Appointment confirmation');
                        $this->email->message($messageprint1);
                        $this->email->send();
                    }

                    //end

                    $this->session->set_flashdata('feedback', 'Added');
                }
            } else { // Updating Employee
                $ion_user_id = $this->db->get_where('employee', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->employee_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->employee_model->updateEmployee($id, $data);
                $incentiveData['employee'] = $id;
                $incentiveData['incentive'] = $incentive;
                $incentiveData['date'] = date("Y-m-d");
                $this->employee_model->storeIncentive($incentiveData);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('employee');
        }
    }

    function getEmployee() {
        $data['employees'] = $this->employee_model->getEmployee();
        $this->load->view('employee', $data);
    }

    function editEmployee() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['employee'] = $this->employee_model->getEmployeeById($id);
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editEmployeeByJason() {
        $id = $this->input->get('id');
        $data['employee'] = $this->employee_model->getEmployeeById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('employee', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->employee_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('employee');
    }

    function getEmployeeList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->employee_model->getEmployeeBySearch($search);
            } else {
                $data['cases'] = $this->employee_model->getEmployee();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->employee_model->getEmployeeByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->employee_model->getEmployeeByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="employee/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $imgoption = '<img style="width:95%;"src="' . $case->img_url . '">';

            $info[] = array(
                "<input type='checkbox' name='employee_box' class='employee_check' value='".$case->email."'>",$imgoption,
                "<a href='#?' id='".$case->id."' class='employee'>".$case->name."</a>",
                $case->designation,
                $case->email,
                $case->address,
                $case->phone,
                $case->salary,
                $case->incentive,
                ($case->status==1?"Active":"In Active"),
                $case->feedback,
                $option2 . ' ' . $option3
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('employee')->num_rows(),
                "recordsFiltered" => $this->db->get('employee')->num_rows(),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

    public function getLeads() {
        $employee = $this->input->post("employee");
        $leads = $this->employee_model->getStudents($employee);
        echo json_encode($leads);
    }

    public function incentives(){
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        // $data['incentives'] = $this->employee_model->getIncentiveByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('incentives', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function getIncentives() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->employee_model->getIncentiveBySearch($search);
            } else {
                $data['cases'] = $this->employee_model->getIncentives();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->employee_model->getIncentiveBySearch(null,$limit, $start, $search);
            } else {
                $data['cases'] = $this->employee_model->getIncentiveBySearch(null,$limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            
            $info[] = array(
                
                $case->name,
                $case->incentive,
                
                $case->date,
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => count($this->employee_model->getIncentiveBySearch()),
                "recordsFiltered" => count($this->employee_model->getIncentiveBySearch()),
                "data" => $info
            );
        } else {
            $output = array(
                // "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            );
        }

        echo json_encode($output);
    }

}

/* End of file employee.php */
/* Location: ./application/modules/employee/controllers/employee.php */
