<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use Twilio\Rest\Client;

//include 'vendor/autoload.php';

class Sms extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('student/student_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('batch/batch_model');
        $this->load->model('course/course_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $data['settings'] = $this->settings_model->getSettings();
        $data['sgateways'] = $this->sms_model->getSmsSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('sgateway', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function sendView() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $type = 'sms';
        $data['templates'] = $this->sms_model->getTemplate($type);
        $data['shortcode'] = $this->sms_model->getTag();
        $data['settings'] = $this->settings_model->getSettings();

// $data['teams'] = $this->doctor_model->getDoctor();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('sendview', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function getStudentinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->sms_model->getstudents($searchTerm);

        echo json_encode($response);
    }

    public function getInstructorinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->sms_model->getinstructors($searchTerm);

        echo json_encode($response);
    }

    public function getBatchinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');

// Get users
        $response = $this->sms_model->getbatches($searchTerm);

        echo json_encode($response);
    }

    public function getTemplateinfo() {
// Search term
        $searchTerm = $this->input->post('searchTerm');
        $type = 'sms';
// Get users
        $response = $this->sms_model->gettemplates($searchTerm, $type);

        echo json_encode($response);
    }

    public function settings() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['settings1'] = $this->sms_model->getSmsSettingsById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('settings', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function addNewSettings() {

        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $api_id = $this->input->post('api_id');
        $auth_key = $this->input->post('authkey');
        $sender = $this->input->post('sender');
        $sid = $this->input->post('sid');
        $token = $this->input->post('token');
        $sendernumber = $this->input->post('sendernumber');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Name Field
        $this->form_validation->set_rules('username', 'Username', 'trim|min_length[5]|max_length[100]|xss_clean');
// Validating Password Field
        if (!empty($password)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]|max_length[100]|xss_clean');
        }
// Validating Email Field
        $this->form_validation->set_rules('api_id', 'Api Id', 'trim|min_length[5]|max_length[100]|xss_clean');

// Validating Email Field
        $this->form_validation->set_rules('authkey', 'Auth Key', 'trim|min_length[5]|max_length[100]|xss_clean');

// Validating Email Field
        $this->form_validation->set_rules('sender', 'Sender', 'trim|min_length[5]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('sid', 'Sid', 'trim|max_length[100]|xss_clean');

// Validating Email Field
        $this->form_validation->set_rules('token', 'Token', 'trim|max_length[100]|xss_clean');

// Validating Email Field
        $this->form_validation->set_rules('sendernumber', 'Sender Number', 'trim|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $id = $this->ion_auth->get_user_id();
            $data['settings'] = $this->settings_model->getSettings();
            $data['sms'] = $this->sms_model->getSmsSettingsById($id);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('settings', $data);
            $this->load->view('home/footer', $data); // just the footer file
        } else {
            $data = array();
            $data = array(
                'username' => $username,
                'password' => $password,
                'api_id' => $api_id,
                'authkey' => $auth_key,
                'sender' => $sender,
                'sid' => $sid,
                'token' => $token,
                'sendernumber' => $sendernumber,
                'user' => $this->ion_auth->get_user_id()
            );
            if (empty($id)) {
                $this->sms_model->addSmsSettings($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->sms_model->updateSmsSettings($data, $id);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('sms');
        }
    }

    function sendSms($to, $message, $data) {
        $sms_gateway = $this->settings_model->getSettings()->sms_gateway;
        if (!empty($sms_gateway)) {
            $smsSettings = $this->sms_model->getSmsSettingsByGatewayName($sms_gateway);
        } else {

            $this->session->set_flashdata('feedback', lang('gateway_not_selected'));
            redirect('sms/sendView');
        }
        $j = sizeof($data);
        foreach ($data as $key => $value) {
            foreach ($value as $key2 => $value2) {




                if ($smsSettings->name == 'Clickatell') {
                    $username = $smsSettings->username;
                    $password = $smsSettings->password;
                    $api_id = $smsSettings->api_id;

                    file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '&to=' . $key2 . '&content=' . $value2);           // file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey='.$api_id.'&to='.$to.'&content='.$message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
                }
                if ($smsSettings->name == 'Twilio') {
                    $sid = $smsSettings->sid;
                    $token = $smsSettings->token;
                    $sendername = $smsSettings->sendernumber;
                    if (!empty($sid) && !empty($token) && !empty($sendername)) {
                        $client = new Client($sid, $token);
                        $client->messages->create(
                                $key2, // Text this number
                                array(
                            'from' => $sendername, // From a valid Twilio number
                            'body' => $value2
                                )
                        );
                    }


//file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '&to=' . $to . '&content=' . $message);           // file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey='.$api_id.'&to='.$to.'&content='.$message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
                }
                if ($smsSettings->name == 'MSG91') {
                    $authkey = $smsSettings->authkey;
                    $sender = $smsSettings->sender;
                    file_get_contents('http://api.msg91.com/api/sendhttp.php?route=4&sender=' . $sender . '&mobiles=' . $key2 . '&authkey=' . $authkey . '&message=' . $value2 . '&country=0');           // file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey='.$api_id.'&to='.$to.'&content='.$message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
                }
            }
        }
    }

    function send() {
        $userId = $this->ion_auth->get_user_id();
        $is_v_v = $this->input->post('radio');

        if ($is_v_v == 'allstudent') {
            $students = $this->student_model->getStudent();
            foreach ($students as $student) {
                $to[] = $student->phone;
                $message = $this->input->post('message');
                $name = explode(' ', $student->name);
                if (!isset($name[1])) {
                    $name[1] = null;
                }
                $data1 = array(
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'name' => $student->name,
                    'phone' => $student->phone,
                    'email' => $student->email,
                    'address' => $student->address
                );
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($student->phone => $messageprint);
            }
            $recipient = 'All student';
        }


        if ($is_v_v == 'allinstructor') {
            $instructors = $this->instructor_model->getInstructor();
            foreach ($instructors as $instructor) {
                $to[] = $instructor->phone;
                $message = $this->input->post('message');
                $name = explode(' ', $instructor->name);
                if (!isset($name[1])) {
                    $name[1] = null;
                }
                $data1 = array(
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'name' => $instructor->name,
                    'phone' => $instructor->phone,
                    'email' => $instructor->email,
                    'address' => $instructor->address
                );
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($instructor->phone => $messageprint);
            }
            $recipient = 'All instructor';
        }


        if ($is_v_v == 'batch') {
            $batchwise = $this->input->post('batchwise');
            $batch = $this->batch_model->getBatchById($batchwise);
            $instructor = $this->instructor_model->getInstructorById($batch->instructor);
            $course = $this->course_model->getCourseById($batch->course);
            $studentfrombatch = $this->batch_model->getStudentsByBatchId($batchwise);

            foreach ($studentfrombatch as $studentfrombatch) {
                $studentname = $this->student_model->getStudentById($studentfrombatch);
                $to[] = $studentname->phone;
                $message = $this->input->post('message');
                $name = array();
                $name = explode(' ', $studentname->name);
                if (!isset($name[1])) {
                    $name[1] = null;
                }
                $data1 = array();
                $data1 = array(
                    'firstname' => $name[0],
                    'lastname' => $name[1],
                    'name' => $studentname->name,
                    'phone' => $studentname->phone,
                    'email' => $studentname->email,
                    'address' => $studentname->address,
                    'batch' => $batch->batch_id,
                    'course' => $course->name,
                    'instructor' => $instructor->name
                );
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($studentname->phone => $messageprint);
            }
            $recipient = 'All Students With batch id ' . $batchwise;
        }


        if ($is_v_v == 'single_student') {
            $student = $this->input->post('student');

            $student_detail = $this->student_model->getStudentById($student);
            $single_student_sms = $student_detail->phone;
            $message = $this->input->post('message');
            $name = array();
            $name = explode(' ', $student_detail->name);
            if (!isset($name[1])) {
                $name[1] = null;
            }
            $data1 = array();
            $data1 = array(
                'firstname' => $name[0],
                'lastname' => $name[1],
                'name' => $student_detail->name,
                'phone' => $student_detail->phone,
                'email' => $student_detail->email,
                'address' => $student_detail->address
            );
            $messageprint = $this->parser->parse_string($message, $data1);
            $data2[] = array($student_detail->phone => $messageprint);
            $recipient = 'Student Id: ' . $student_detail->id . '<br> Student Name: ' . $student_detail->name . '<br> Student Email: ' . $student_detail->email;
        }
        if ($is_v_v == 'single_instructor') {
            $instructor = $this->input->post('instructor');

            $instructor_detail = $this->instructor_model->getInstructorById($instructor);
            $single_instructor_phone = $instructor_detail->phone;
            $message = $this->input->post('message');
            $name = array();
            $name = explode(' ', $instructor_detail->name);
            if (!isset($name[1])) {
                $name[1] = null;
            }
            $data1 = array();
            $data1 = array(
                'firstname' => $name[0],
                'lastname' => $name[1],
                'name' => $instructor_detail->name,
                'phone' => $instructor_detail->phone,
                'email' => $instructor_detail->email,
                'address' => $instructor_detail->address
            );
            $messageprint = $this->parser->parse_string($message, $data1);
            $data2[] = array($instructor_detail->phone => $messageprint);
            $recipient = 'Instructor Id: ' . $instructor_detail->id . '<br> Instructor Name: ' . $instructor_detail->name . '<br> Instructor Phone: ' . $instructor_detail->phone;
        }
        if (!empty($single_instructor_phone)) {
            $to1 = $single_instructor_phone;
        } else {
            if (!empty($to)) {
                $to1 = implode(',', $to);
            }
        }
        if (!empty($single_student_sms)) {
            $to1 = $single_student_sms;
        } else {
            if (!empty($to)) {

                $to1 = implode(',', $to);
            }
        }

// $message = urlencode("Test Message");
        if (!empty($to1)) {

            $message = $this->input->post('message');
            $message1 = urlencode($message);
            $this->sendSms($to1, $message1, $data2);

            $data = array();
            $date = time();
            $dateinformat = date('h:i:s a m/d/y', $date);
            $data = array(
                'message' => $message,
                'date' => $date,
                'dateformat' => $dateinformat,
                'recipient' => $recipient,
                'user' => $this->ion_auth->get_user_id()
            );

            $this->sms_model->insertSms($data);
            $this->session->set_flashdata('feedback', 'Message Sent');
        } else {
            $this->session->set_flashdata('feedback', 'Not Sent');
        }
        redirect('sms/sendView');
    }

    function appointmentReminder() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Phone: ' . $patient_detail->phone;
        $to = $patient_detail->phone;

// $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Reminder: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            $this->sendSms($to, $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_p);
            $this->session->set_flashdata('feedback', 'Message Sent');
        }

        redirect('appointment/upcoming');
    }

    function sendSmsDuringAppointment($patient, $doctor, $date, $s_time, $e_time) {

        $patient_detail = $this->patient_model->getPatientById($patient);
        $doctor_detail = $this->doctor_model->getDoctorById($doctor);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Phone: ' . $patient_detail->phone;
        $recipient_d = 'Doctor Id: ' . $doctor_detail->id . '<br> Patient Name: ' . $doctor_detail->name . '<br> Doctor Phone: ' . $doctor_detail->phone;


// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $message = 'Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            $this->sendSms($patient_detail->phone, $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_p);
        }

        if (!empty($doctor)) {
            $message = 'Appointment is scheduled for you With Patient ' . $patient_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            $this->sendSms($doctor_detail->phone, $message1);
            $data_d = array();
            $date = time();
            $data_d = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_d,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_d);
        }
    }

    function appointmentApproved() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Phone: ' . $patient_detail->phone;
        $to = $patient_detail->phone;

// $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Approval: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            $this->sendSms($to, $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_p);
        }
    }

    function sendSmsDuringPayment($patient, $amount, $date) {

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Phone: ' . $patient_detail->phone;

// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->phone;
            $message = 'Bill For Patient ' . $patient_detail->name . 'Amount: ' . $amount . ' Date: ' . date('d-m-Y', $date);
            $message1 = urlencode($message);
            $this->sendSms($to, $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_p);
        }
    }

    function sendSmsDuringPatientRegistration($patient) {

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Phone: ' . $patient_detail->phone;

// $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->phone;
            $message = 'Patient Registration' . $patient_detail->name . 'is successfully registerred';
            $message1 = urlencode($message);
            $this->sendSms($to, $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->sms_model->insertSms($data_p);
        }
    }

    function sent() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $data['sents'] = $this->sms_model->getSms();
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $data['sents'] = $this->sms_model->getSmsByUser($current_user_id);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('sms', $data);
        $this->load->view('home/footer', $data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->sms_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('sms/sent');
    }

    function getSmsList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getSmsBySearch($search);
            } else {
                $data['cases'] = $this->sms_model->getSms();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getSmsByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->sms_model->getSmsByLimit($limit, $start);
            }
        }
//  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin'))) {
//   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';

                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="sms/delete?id=' . $case->id . '&redirect=sms" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
            }


            $info[] = array(
                $i,
                $case->dateformat,
                $case->message,
                $case->recipient,
                $options2
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('sms')->num_rows(),
                "recordsFiltered" => $this->db->get('sms')->num_rows(),
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

    public function smsTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->sms_model->getTag();
        $this->load->view('home/dashboard', $data);
        $this->load->view('smstemplate', $data);
        $this->load->view('home/footer', $data);
    }

    public function smsNewTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->sms_model->getTag();
        $this->load->view('home/dashboard', $data);
        $this->load->view('addtemplate', $data);
        $this->load->view('home/footer', $data);
    }

    public function addNewTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating 
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');

// Validating 
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                $data = array();
                $data['settings'] = $this->settings_model->getSettings();
                $data['templatename'] = $this->sms_model->getTemplateById($id, $type);
                $data['shortcode'] = $this->sms_model->getTag();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('addtemplate', $data);
                $this->load->view('home/footer', $data); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $data['shortcode'] = $this->sms_model->getTag();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('addtemplate', $data);
                $this->load->view('home/footer', $data); // just the footer file
            }
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
                'type' => $type
            );
            if (empty($id)) {
                $this->sms_model->addTemplate($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->sms_model->updateTemplate($data, $id);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('sms/sendView');
        }
    }

    function getTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getTemplateBySearch($search, $type);
            } else {
                $data['cases'] = $this->sms_model->getTemplate($type);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getTemplateByLimitBySearch($limit, $start, $search, $type);
            } else {
                $data['cases'] = $this->sms_model->getTemplateByLimit($limit, $start, $type);
            }
        }
//  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin'))) {

                $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
// $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
                $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            }
            $info[] = array(
                $i,
                $case->name,
                $case->message,
                ' ' . $options1 . ' ' . $options2
            );
            $count = $count + 1;
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
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

    public function editTemplate() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data['settings'] = $this->settings_model->getSettings();
        $data['templatename'] = $this->sms_model->getTemplateById($id, $type);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('addtemplate', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function editSmsTemplate() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');

        $data['templatename'] = $this->sms_model->getTemplateById($id, $type);

        echo json_encode($data);
    }

    public function deleteTemplate() {
        $id = $this->input->get('id');
        $this->sms_model->deleteTemplate($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('sms/smsTemplate');
    }

    public function getTemplateText() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data['user'] = $this->sms_model->getTemplateById($id, $type);
        echo json_encode($data);
    }

    public function tag() {
        $this->load->view('addtag');
    }

    public function addTag() {
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $data = array('name' => $name,
            'type' => $type);
        $this->sms_model->insertTag($data);
        redirect('sms/tag');
    }

    public function autotag() {
        $this->load->view('addautotag');
    }

    public function addAutoTag() {
        $name = $this->input->post('name');
        $type = $this->input->post('type');
        $data = array('name' => $name,
            'type' => $type);
        $this->sms_model->insertAutoTag($data);
        redirect('sms/autotag');
    }

    public function autoSmsTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->sms_model->getTag();
        $this->load->view('home/dashboard', $data);
        $this->load->view('autosmstemplate', $data);
        $this->load->view('home/footer', $data);
    }

    function getAutoTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getAutoTemplateBySearch($search);
            } else {
                $data['cases'] = $this->sms_model->getAutoTemplate();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->sms_model->getAutoTemplateByLimitBySearch($limit, $start, $type);
            } else {
                $data['cases'] = $this->sms_model->getAutoTemplateByLimit($limit, $start);
            }
        }
//  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin'))) {

                $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"> </i></a>';
// $options1 = '<a type='button" class="btn btn-success btn-xs btn_width" title="" . lang('edit') . '"data-toggle = "modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i></a>';
//    $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            }
            $info[] = array(
                $i,
                $case->name,
                $case->message,
                $case->status,
                $options1
            );
            $count = $count + 1;
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
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

    public function editAutoSmsTemplate() {
        $id = $this->input->get('id');
        $data['autotemplatename'] = $this->sms_model->getAutoTemplateById($id);
        $data['autotag'] = $this->sms_model->getAutoTemplateTag($data['autotemplatename']->type);

        if ($data['autotemplatename']->status == 'Active') {
            $data['status_options'] = '<option value="Active" selected>' . lang("active") . '
                            </option>
                            <option value="Inactive"> ' . lang("inactive") . '
        </option>';
        } else {
            $data['status_options'] = '<option value="Active">' . lang("active") . '
                            </option>
                            <option value="Inactive" selected> ' . lang("inactive") . '
        </option>';
        }

        echo json_encode($data);
    }

    public function addNewAutoTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('category');
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {

            $data['settings'] = $this->settings_model->getSettings();
            $data['shortcode'] = $this->sms_model->getTag();
            $this->load->view('home/dashboard', $data);
            $this->load->view('autosmstemplate', $data);
            $this->load->view('home/footer', $data);
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
                'status' => $status,
            );

            $this->sms_model->updateAutoTemplate($data, $id);
            $this->session->set_flashdata('feedback', 'Updated');

            redirect('sms/autoSmsTemplate');
        }
    }

}

/* End of file profile.php */
/* Location: ./application/modules/profile/controllers/profile.php */
