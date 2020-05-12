<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends MX_Controller {

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
        $data['email'] = $this->email_model->getProfileById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('profile', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function sendView() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $type = 'email';
        $data['templates'] = $this->sms_model->getTemplate($type);
        $data['shortcode'] = $this->email_model->getTag();
        
        $data['settings'] = $this->settings_model->getSettings();

        // $data['teams'] = $this->doctor_model->getDoctor();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('sendview', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function autoEmailTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->email_model->getTag();
        $this->load->view('home/dashboard', $data);
        $this->load->view('autoemailtemplate', $data);
        $this->load->view('home/footer', $data);
    }

    public function settings() {
        $data = array();
        $id = $this->ion_auth->get_user_id();
        $data['settings'] = $this->settings_model->getSettings();
        $data['settings1'] = $this->email_model->getEmailSettingsById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('settings', $data);
        $this->load->view('home/footer', $data); // just the footer file
    }

    public function addNewSettings() {

        $id = $this->input->post('id');
        $email = $this->input->post('email');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('email', 'Admin Email', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('api_id', 'Api Id', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $id = $this->ion_auth->get_user_id();
            $data['settings'] = $this->settings_model->getSettings();
            $data['email'] = $this->email_model->getEmailSettingsById($id);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('settings', $data);
            $this->load->view('home/footer', $data); // just the footer file
        } else {
            $data = array();
            $data = array(
                'admin_email' => $email,
            );
            if (empty($this->email_model->getEmailSettingsById($id)->admin_email)) {
                $this->email_model->addEmailSettings($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->email_model->updateEmailSettings($data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('email/settings');
        }
    }

    function send() {
        // Count total files
        $countfiles = count($_FILES['files']['name']);
        //   echo $countfiles;
        //die();
        if ($_FILES['files']['name'] != NULL) {
            // Looping all files
            for ($i = 0; $i < $countfiles; $i++) {

                if (!empty($_FILES['files']['name'][$i])) {

                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    $file_name_pieces = explode('_', $_FILES['file']['name']);
                    $new_file_name = '';
                    $count = 1;
                    foreach ($file_name_pieces as $piece) {
                        if ($count !== 1) {
                            $piece = ucfirst($piece);
                        }

                        $new_file_name .= $piece;
                        $count++;
                    }
                    $config = array();
                    $config = array(
                        'file_name' => $new_file_name,
                        'upload_path' => "./uploads/",
                        'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt",
                        'overwrite' => False,
                        'max_size' => "200000000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                            //   'max_height' => "1768",
                            // 'max_width' => "2024"
                    );

                    //Load upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    // File upload
                    if ($this->upload->do_upload('file')) {
                        // Get data about the file
                        $uploadData = $this->upload->data();
                        $filename = "uploads/" . $uploadData['file_name'];

                        // Initialize array
                        $updateData[$i] = $filename;
                    }
                }
            }
        }

        if ($countfiles > 1) {
            $upload = implode(',', $updateData);
        } else {
            $upload = $updateData[0];
        }
        $userId = $this->ion_auth->get_user_id();
        $is_v_v = $this->input->post('radio');
        $emailSettings = $this->email_model->getEmailSettings();

        if ($is_v_v == 'allstudent') {
            $students = $this->student_model->getStudent();
            foreach ($students as $student) {
                $to[] = $student->email;
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
                    $data2[] = array($student->email => $messageprint);
            }
            $recipient = 'All Patient';
        }

        if ($is_v_v == 'allinstructor') {
            $instructors = $this->instructor_model->getInstructor();
            foreach ($instructors as $instructor) {
                $to[] = $instructor->email;
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
                    $data2[] = array($instructor->email => $messageprint);
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
                $to[] = $studentname->email;
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
                      $data2[] = array($studentname->email => $messageprint);
            }
            $recipient = 'All Students With batch id ' . $batchwise;
        }


        if ($is_v_v == 'single_student') {
            $student = $this->input->post('student');

            $student_detail = $this->student_model->getStudentById($student);
            $single_student_email = $student_detail->email;
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
              $data2[] = array($student_detail->email => $messageprint);
            $recipient = 'Student Id: ' . $student_detail->id . '<br> Student Name: ' . $student_detail->name . '<br> Student Email: ' . $student_detail->email;
        }
        if ($is_v_v == 'single_instructor') {
            $instructor = $this->input->post('instructor');

            $instructor_detail = $this->instructor_model->getInstructorById($instructor);
            $single_instructor_email = $instructor_detail->email;
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
              $data2[] = array($instructor_detail->email => $messageprint);
            $recipient = 'Instructor Id: ' . $instructor_detail->id . '<br> Instructor Name: ' . $instructor_detail->name . '<br> Instructor Email: ' . $instructor_detail->email;
        }

        if ($is_v_v == 'other') {
            $other_email = $this->input->post('other_email');

            $data1 = array();
            $data1 = array(
                'firstname' => 'sir/madam',
                'lastname' => 'sir/madam',
                'name' => 'sir/madam',
                'phone' => ' ',
                'email' => $other_email,
                'address' => ''
            );
            $messageprint = $this->parser->parse_string($message, $data1);
             $data2[] = array($other_email => $messageprint);
            $recipient = $other_email;
        }

        if (!empty($single_student_email)) {
            $to1 = $single_student_email;
        } elseif (!empty($other_email)) {
            $to1 = $other_email;
        } else {
            if (!empty($to)) {
                $to1 = implode(',', $to);
            }
        }
        if (!empty($single_instructor_email)) {
            $to1 = $single_instructor_email;
        } elseif (!empty($other_email)) {
            $to1 = $other_email;
        } else {
            if (!empty($to1)) {
                $to1 = implode(',', $to);
            }
        }

        // $message = urlencode("Test Message");
        if (!empty($to1)) {
            // $message = $this->input->post('message');
            $subject = $this->input->post('subject');


            foreach ($data2 as $key => $value) {
                foreach ($value as $key2 => $value2) {


                    if ($upload != NULL) {
                        $this->email->from($emailSettings->admin_email);
                        $this->email->to($key2);
                        $this->email->subject($subject);
                        $this->email->message($value2);

                        $uploadExtract = explode(',', $upload);
                        foreach ($uploadExtract as $uploads) {
                            $this->email->attach($uploads);
                        }
                    } else {
                        $this->email->from($emailSettings->admin_email);
                        $this->email->to($key2);
                        $this->email->subject($subject);
                        $this->email->message($value2);
                    }

                    $this->email->send();
                    $data = array();
                    $date = time();
                    if (!empty($_FILES['files']['name'])) {

                        $dateinformat = date('h:i:s a m/d/y', $date);
                        $data = array(
                            'subject' => $subject,
                            'message' => $message,
                            'date' => $date,
                            'dateformat' => $dateinformat,
                            'reciepient' => $recipient,
                            'user' => $this->ion_auth->get_user_id(),
                            'path' => $upload
                        );
                    } else {
                        $data = array(
                            'subject' => $subject,
                            'message' => $message,
                            'date' => $date,
                            'dateformat' => $dateinformat,
                            'reciepient' => $recipient,
                            'user' => $this->ion_auth->get_user_id(),
                        );
                    }
                    $this->email_model->insertEmail($data);
                   // $this->session->set_flashdata('feedback', 'Message Sent');
                }
            }
             $this->session->set_flashdata('feedback', 'Message Sent');
            //array end here
        } else {
            $this->session->set_flashdata('feedback', 'Not Sent');
        }
        redirect('email/sendView');
    }

    function appointmentReminder() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $to = $patient_detail->email;

        // $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Reminder: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
            $this->session->set_flashdata('feedback', 'Message Sent');
        }

        redirect('appointment/upcoming');
    }

    function sendEmailDuringAppointment($patient, $doctor, $date, $s_time, $e_time) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);
        $doctor_detail = $this->doctor_model->getDoctorById($doctor);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $recipient_d = 'Doctor Id: ' . $doctor_detail->id . '<br> Patient Name: ' . $doctor_detail->name . '<br> Doctor Email: ' . $doctor_detail->email;


        $to = $patient_detail->email . ', ' . $doctor_detail->email;

        // $message = urlencode("Test Message");
        if (!empty($patient)) {
            $message = 'Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }

        if (!empty($doctor)) {
            $message = 'Appointment is scheduled for you With Patient ' . $patient_detail->name . ' Date: ' . date('d-m-Y', $date) . ' Time: ' . $s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_d = array();
            $date = time();
            $data_d = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_d,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_d);
        }
    }

    function appointmentApproved() {
        $id = $this->input->post('id');
        $appointment_details = $this->appointment_model->getAppointmentById($id);
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($appointment_details->patient);
        $doctor_detail = $this->doctor_model->getDoctorById($appointment_details->doctor);
        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;
        $to = $patient_detail->email;

        // $message = urlencode("Test Message");
        if (!empty($to)) {
            $message = 'Approval: Appointment is scheduled for you With Doctor ' . $doctor_detail->name . ' Date: ' . date('d-m-Y', $appointment_details->date) . ' Time: ' . $appointment_details->s_time;
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sendEmailDuringPayment($patient, $amount, $date) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;

        // $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->email;
            $message = 'Bill For Patient ' . $patient_detail->name . 'Amount: ' . $amount . ' Date: ' . date('d-m-Y', $date);
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('http://bhashemail.com/api/sendmsg.php?user=' . $username . '&pass=' . $password . '&sender=SKESWA&email=' . $to . '&text=' . $message1 . '&priority=ndnd&stype=normal');
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sendEmailDuringPatientRegistration($patient) {
        $emailSettings = $this->email_model->getEmailSettings();
        $username = $emailSettings->username;
        $password = $emailSettings->password;
        $api_id = $emailSettings->api_id;

        $patient_detail = $this->patient_model->getPatientById($patient);

        $recipient_p = 'Patient Id: ' . $patient_detail->id . '<br> Patient Name: ' . $patient_detail->name . '<br> Patient Email: ' . $patient_detail->email;

        // $message = urlencode("Test Message");
        if (!empty($patient)) {
            $to = $patient_detail->email;
            $message = 'Patient Registration' . $patient_detail->name . 'is successfully registerred';
            $message1 = urlencode($message);
            file_get_contents('https://platform.clickatell.com/messages/http/send?apiKey=' . $api_id . '==&to=' . $to . '&content=' . $message1);           // file_get_contents('https://api.clickatell.com/http/sendmsg?user=' . $username . '&password=' . $password . '&api_id=' . $api_id . '&to=' . $to . '&text=' . $message1);
            $data_p = array();
            $date = time();
            $data_p = array(
                'message' => $message,
                'date' => $date,
                'recipient' => $recipient_p,
                'user' => $this->ion_auth->get_user_id()
            );
            $this->email_model->insertEmail($data_p);
        }
    }

    function sent() {
        if ($this->ion_auth->in_group(array('admin'))) {
            $data['sents'] = $this->email_model->getEmail();
        } else {
            $current_user_id = $this->ion_auth->user()->row()->id;
            $data['sents'] = $this->email_model->getEmailByUser($current_user_id);
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data);
        $this->load->view('email', $data);
        $this->load->view('home/footer', $data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->email_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('email/sent');
    }

    public function getStudentinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->email_model->getstudents($searchTerm);

        echo json_encode($response);
    }

    public function getBatchinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->email_model->getbatches($searchTerm);

        echo json_encode($response);
    }

    public function getInstructorinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->email_model->getinstructors($searchTerm);

        echo json_encode($response);
    }

    public function getTemplateinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $type = 'email';
        // Get users
        $response = $this->email_model->gettemplates($searchTerm, $type);

        echo json_encode($response);
    }

    function getAutoTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getAutoTemplateBySearch($search);
            } else {
                $data['cases'] = $this->email_model->getAutoTemplate();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getAutoTemplateByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->email_model->getAutoTemplateByLimit($limit, $start);
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

    public function editAutoEmailTemplate() {
        $id = $this->input->get('id');
        $data['autotemplatename'] = $this->email_model->getAutoTemplateById($id);
        $data['autotag'] = $this->email_model->getAutoTemplateTag($data['autotemplatename']->type);
        echo json_encode($data);
    }

    public function addNewAutoTemplate() {
        $message = $this->input->post('message');
        $name = $this->input->post('category');
        $id = $this->input->post('id');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {

            $data['settings'] = $this->settings_model->getSettings();
            $data['shortcode'] = $this->email_model->getTag();
            $this->load->view('home/dashboard', $data);
            $this->load->view('autoemailtemplate', $data);
            $this->load->view('home/footer', $data);
        } else {
            $data = array();
            $data = array(
                'name' => $name,
                'message' => $message,
            );

            $this->email_model->updateAutoTemplate($data, $id);
            $this->session->set_flashdata('feedback', 'Updated');

            redirect('email/autoEmailTemplate');
        }
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
                $data['templatename'] = $this->email_model->getTemplateById($id, $type);
                $data['shortcode'] = $this->email_model->getTag();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('addtemplate', $data);
                $this->load->view('home/footer', $data); // just the footer file
            } else {
                $data = array();
                $data['setval'] = 'setval';
                $data['settings'] = $this->settings_model->getSettings();
                $data['shortcode'] = $this->email_model->getTag();
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
                $this->email_model->addTemplate($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->email_model->updateTemplate($data, $id);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('email/sendView');
        }
    }

    public function getTemplateText() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data['user'] = $this->email_model->getTemplateById($id, $type);
        echo json_encode($data);
    }

    public function emailTemplate() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['shortcode'] = $this->email_model->getTag();
        $this->load->view('home/dashboard', $data);
        $this->load->view('email_template', $data);
        $this->load->view('home/footer', $data);
    }

    public function editEmailTemplate() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');

        $data['templatename'] = $this->email_model->getTemplateById($id, $type);

        echo json_encode($data);
    }

    function getTemplateList() {
        $type = $this->input->post('type');
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getTemplateBySearch($search, $type);
            } else {
                $data['cases'] = $this->email_model->getTemplate($type);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getTemplateByLimitBySearch($limit, $start, $search, $type);
            } else {
                $data['cases'] = $this->email_model->getTemplateByLimit($limit, $start, $type);
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
                $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="email/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
            }
            $info[] = array(
                $i,
                $case->name,
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

    public function deleteTemplate() {
        $id = $this->input->get('id');
        $this->email_model->deleteTemplate($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('email/emailTemplate');
    }

    function getEmailList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getEmailBySearch($search);
            } else {
                $data['cases'] = $this->email_model->getEmail();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->email_model->getEmailByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->email_model->getEmailByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin'))) {
                //   $options1 = '<a type="button" class="btn editbutton" title="Edit" data-toggle="modal" data-id="463"><i class="fa fa-edit"> </i> Edit</a>';

                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" title="' . lang('delete') . '" href="email/delete?id=' . $case->id . '&redirect=email" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i></a>';
            }


            $info[] = array(
                $i,
                date('h:i:s a m/d/y', $case->date),
                $case->message,
                $case->reciepient,
                $options2
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('email')->num_rows(),
                "recordsFiltered" => $this->db->get('email')->num_rows(),
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

/* End of file profile.php */
/* Location: ./application/modules/profile/controllers/profile.php */
