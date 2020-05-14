<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('student_model');
        $this->load->model('batch/batch_model');
        $this->load->model('employee/employee_model');
        $this->load->model('finance/finance_model');
        $this->load->model('course/course_model');

        $this->load->model('instructor/instructor_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Student', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['students'] = $this->student_model->getStudentByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function studentByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['students'] = $this->student_model->getStudentByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchStudent() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['students'] = $this->student_model->getStudentByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $employee = $this->input->post('employee');
        $lead_from = $this->input->post('lead_from');        
        $bank_details = $this->input->post('bank_details');
        if (empty($id)) {
            $add_date = time();
        } else {
            $previous_add_date = $this->student_model->getStudentById($id)->add_date;
            if (!empty($previous_add_date)) {
                $add_date = $previous_add_date;
            } else {
                $add_date = time();
            }
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("student/editStudent?id=$id");
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new', $data);
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
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'add_date' => $add_date,
                    'employee' => $employee,
                    'lead_from' => $lead_from,
                    'bank_details' => $bank_details
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'add_date' => $add_date,
                    'employee' => $employee,
                    'lead_from' => $lead_from,
                    'bank_details' => $bank_details
                );
            }

            $username = $this->input->post('email');

            if (empty($id)) {     // Adding New Student
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', 'This Email Address Is Already Registered');
                    redirect('student/addNewView');
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $user_id = $this->db->insert_id();
                    $ion_user_id = $this->db->get_where('users_groups', array('id' => $user_id))->row()->user_id;
                    $this->student_model->insertStudent($data);
                    $student_user_id = $this->db->insert_id();
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->student_model->updateStudent($student_user_id, $id_info);
                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('student');
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
                        'institution' => $set['settings']->system_vendor
                    );
                    if ($autosms->status == 'Active') {
                        $messageprint = $this->parser->parse_string($message, $data1);
                        $data2[] = array($to => $messageprint);
                        $this->sms->sendSms($to, $message, $data2);
                    }
                    //end
                    //email
                    $autoemail = $this->email_model->getAutoEmailByType('student');
                    if ($autoemail->status == 'Active') {
                        $emailSettings = $this->email_model->getEmailSettings();
                        $message1 = $autoemail->message;
                        $messageprint1 = $this->parser->parse_string($message1, $data1);
                        $this->email->from($emailSettings->admin_email);
                        $this->email->to($email);
                        $this->email->subject('enrollment confirmation');
                        $this->email->message($messageprint1);
                        $this->email->send();
                    }

                    //end
                    $this->session->set_flashdata('feedback', 'Added');
                }
            } else { // Updating Student
                $ion_user_id = $this->db->get_where('student', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->student_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->student_model->updateStudent($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('student');
        }
    }

    function getStudent() {
        $data['students'] = $this->student_model->getStudent();
        $this->load->view('student', $data);
    }

    function details() {
        $student_id = $this->input->get('student_id');
        if ($this->ion_auth->in_group(array('Student'))) {
            $user = $this->ion_auth->get_user_id();
            $student_table_id = $this->db->get_where('student', array('ion_user_id' => $user))->row()->id;
            if ($student_id != $student_table_id) {
                redirect('home/permission');
            }
        }

        $data['batches'] = $this->student_model->getBatchByStudentId($student_id);
        $data['payments'] = $this->finance_model->getPaymentByStudentId($student_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        $data['student_details'] = $this->student_model->getStudentById($student_id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editStudent() {
        $data = array();
        $id = $this->input->get('id');
        $data['student'] = $this->student_model->getStudentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editStudentByJason() {
        $id = $this->input->get('id');
        $data['student'] = $this->student_model->getStudentById($id);
        $data['employees'] = $this->employee_model->getEmployeeById($data['student']->employee);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('student', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->student_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('student');
    }

    function getStudentList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->student_model->getStudentBySearch($search);
            } else {
                $data['cases'] = $this->student_model->getStudent();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->student_model->getStudentByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->student_model->getStudentByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $employee = $this->employee_model->getEmployeeById($case->employee);
            $i = $i + 1;

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="student/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $option4 = '<button type="button" class="btn btn-info btn-xs btn_width feedback_btn" data-toggle="modal" id="'.$case->id.'" data-id="' . $case->id . '"><i class="fa fa-edit"></i>Feedback</button>';
            $imgoption = '<img style="width:95%;"src="' . $case->img_url . '">';

            $info[] = array(
                "<input type='checkbox' name='employee_box' class='employee_check' value='".$case->email."'>",
                $imgoption,
                $case->name,
                $case->email,
                $case->address,
                $case->phone,
                $employee->name,
                $case->lead_from,
                $case->bank_details,
                $option1 . ' ' . $option2 . ' ' . $option3. ' ' . $option4
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('student')->num_rows(),
                "recordsFiltered" => $this->db->get('student')->num_rows(),
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

     public function addfeedback() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_feedback');
        $this->load->view('home/footer'); // just the header file
    }

    public function saveFeedback() {
        $data['feedback'] = $this->input->post('feedback');
        $data['status'] = $this->input->post('status');
        $data['student'] = $this->input->post('student');
        $this->db->insert('student_lead', $data);
        $this->session->set_flashdata('success', 'Student Feedback has been updated');
        redirect('student');
    }

    public function getFeedbackByStudent(){
        $student = $this->input->post('student');
        $response['leads'] = $this->student_model->getStudentFeedback($student);
        echo json_encode($response);
    }

    function getStudents() {
        $searchTerm = $this->input->post('searchTerm');
        
        $response = $this->student_model->getstudents($searchTerm);
        echo json_encode($response);
    }


}

/* End of file student.php */
/* Location: ./application/modules/student/controllers/student.php */
