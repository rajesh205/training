<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Batch extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('batch_model');
        $this->load->model('course/course_model');
        $this->load->model('employee/employee_model');
        $this->load->model('routine/routine_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('student/student_model');
        $this->load->model('home/home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['batchs'] = $this->batch_model->getBatchByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function ongoing() {
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('ongoing', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
     public function upcoming() {
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('upcoming', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
     public function completed() {
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('completed', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function batchByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['batchs'] = $this->batch_model->getBatchByPageNumber($page_number);
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchBatch() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['batchs'] = $this->batch_model->getBatchByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['courses'] = $this->course_model->getCourse();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {
        $id = $this->input->post('id');
        $batch_id = $this->input->post('batch_id');
        $course = $this->input->post('course');
        $instructor = $this->input->post('instructor');
        $course_fee = $this->input->post('course_fee');
        $instructorname = $this->instructor_model->getInstructorById($instructor)->name;
        $course_name = $this->course_model->getCourseById($course)->name;
        if (empty($course_fee)) {
            $course_fee = $this->course_model->getCourseById($course)->course_fee;
        }
        $start_date = $this->input->post('start_date');
        if (!empty($start_date)) {
            $start_date = strtotime($start_date);
        }
        $end_date = $this->input->post('end_date');
        if (!empty($end_date)) {
            $end_date = strtotime($end_date);
        }

        $start_time = $this->input->post('start_time');
        if (!empty($start_time)) {
            $start_time = $start_time;
        }
        $end_time = $this->input->post('end_time');
        if (!empty($end_time)) {
            $end_time = $end_time;
        }
        $feedback = $this->input->post('feedback');
        $employee = $this->input->post('employee');
        $type = $this->input->post('type');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Id Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('instructor', 'Instructor', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("batch/editBatch?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $data['nextPayments'] = $this->home_model->getUnpaidStudents();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'batch_id' => $batch_id,
                'course' => $course,
                'instructor' => $instructor,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'course_fee' => $course_fee,
                'coursename' => $course_name,
                'instructorname' => $instructorname,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'feedback' => $feedback,
                'employee' => $employee,
                'type' => $type,
            );
            if (empty($id)) {     // Adding New Batch
                $this->batch_model->insertBatch($data);
                $set['settings'] = $this->settings_model->getSettings();
                $autosms = $this->sms_model->getAutoSmsByType('instructor');
                $instructordetails11 = $this->instructor_model->getInstructorById($instructor);
                $message = $autosms->message;
                $to = $instructordetails11->phone;
                $name1 = explode(' ', $instructordetails11->name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $instructordetails11->name,
                    'batch' => $batch_id,
                    'course' => $course_name
                );
                if ($autosms->status == 'Active') {
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($to => $messageprint);

                    $this->sms->sendSms($to, $message, $data2);
                }
                //end
                //email
                $autoemail = $this->email_model->getAutoEmailByType('instructor');
                if ($autoemail->status == 'Active') {
                    $emailSettings = $this->email_model->getEmailSettings();
                    $message1 = $autoemail->message;
                    $messageprint1 = $this->parser->parse_string($message1, $data1);
                    $this->email->from($emailSettings->admin_email);
                    $this->email->to($instructordetails11->email);
                    $this->email->subject('Appoinment confirmation');
                    $this->email->message($messageprint1);
                    $this->email->send();
                }
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Batch
                $this->batch_model->updateBatch($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('batch');
        }
    }

    function batchByCourseId() {
        $course_id = $this->input->get('course_id');
        $data['batchs'] = $this->batch_model->getBatchByCourseId($course_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function students() {

        $batch_id = $this->input->get('batch_id');
        $data['students'] = $this->batch_model->getStudentsByBatchId($batch_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['batch_id'] = $batch_id;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function getBatch() {
        $data['batchs'] = $this->batch_model->getBatch();
        $this->load->view('batch', $data);
    }

    function getStudentByKey() {
        $key = $this->input->get('keyword');
        $students = $this->student_model->getStudentByKeyforBatch($key);

        $data[] = array();
        $options = array();
        foreach ($students as $student) {
            $options[] = '<option class="ooppttiioonn"    value="' . $student->id . '">' . $student->name . '</option>';
        }
        $data['opp'] = $options;
        $options = NULL;
        echo json_encode($data);
    }

    function getStudentsByBatchIdByJason() {
        $id = $this->input->get('id');
        $students = $this->batch_model->getStudentsByBatchId($id);
        foreach ($students as $key => $value) {
            $studentlist = $this->student_model->getStudentById($value);
            if (!empty($studentlist)) {
                $all_students[] = $studentlist;
            }
        }
        $data['students'] = $all_students;
        echo json_encode($data);
    }

    function addStudentToBatch() {

        $batch_id = $this->input->post('batch_id');
        $student_id = $this->input->post('student');

        $student_exist = $this->batch_model->checkExistInBatch($batch_id, $student_id);
        if (!empty($student_exist)) {
            $this->session->set_flashdata('feedback', 'This Student Already Exist');
            redirect('batch/students?batch_id=' . $batch_id);
            die();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Batch Id Field
        $this->form_validation->set_rules('batch_id', 'Batch', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Student Field 
        $this->form_validation->set_rules('student', 'Student', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect("batch/students?batch_id=$batch_id");
        } else {

            $data = array();
            $data = array(
                'batch' => $batch_id,
                'student' => $student_id,
            );
            $this->batch_model->insertStudentToBatch($data);
            // Loading View
            //sms


            $autosms = $this->sms_model->getAutoSmsByType('studentbatch');

            $studentdetails = $this->student_model->getStudentById($student_id);
            $batchdetails = $this->batch_model->getBatchById($batch_id);
            $message = $autosms->message;
            $to = $studentdetails->phone;
            $name1 = explode(' ', $studentdetails->name);
            if (!isset($name1[1])) {
                $name1[1] = null;
            }
            $data1 = array(
                'firstname' => $name1[0],
                'lastname' => $name1[1],
                'name' => $studentdetails->name,
                'batch' => $batchdetails->batch_id,
                'course' => $batchdetails->coursename
            );
            if ($autosms->status == 'Active') {
                $messageprint = $this->parser->parse_string($message, $data1);
                $data2[] = array($to => $messageprint);
                $this->sms->sendSms($to, $message, $data2);
            }
            //end
            //email
            $autoemail = $this->email_model->getAutoEmailByType('studentbatch');
            if ($autoemail->status == 'Active') {
                $emailSettings = $this->email_model->getEmailSettings();
                $message1 = $autoemail->message;
                $messageprint1 = $this->parser->parse_string($message1, $data1);
                $this->email->from($emailSettings->admin_email);
                $this->email->to($studentdetails->email);
                $this->email->subject('batch enrollment confirmation');
                $this->email->message($messageprint1);
                $this->email->send();
            }

            //end
            $this->session->set_flashdata('feedback', 'Student Added To This Batch');
            redirect('batch/students?batch_id=' . $batch_id);
        }
    }

    function editBatch() {
        $data = array();
        $id = $this->input->get('id');
        $data['batch'] = $this->batch_model->getBatchById($id);
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editBatchByJason() {
        $id = $this->input->get('id');
        $data['batch'] = $this->batch_model->getBatchById($id);
        $data['courses'] = $this->course_model->getCourseById($data['batch']->course);
        $data['employees'] = $this->employee_model->getEmployeeById($data['batch']->employee);
        echo json_encode($data);
    }

    function getBatchByCourseIdByJason() {
        $id = $this->input->get('id');
        $data['batches'] = $this->batch_model->getBatchByCourseId($id);
        echo json_encode($data);
    }

    function getCourseFeeByCourseIdByJason() {
        $id = $this->input->get('id');
        $data['course_fee'] = $this->course_model->getCourseById($id)->course_fee;
        echo json_encode($data);
    }

    function deleteStudentFromBatch() {
        $data = array();
        $student_id = $this->input->get('student_id');
        $batch_id = $this->input->get('batch_id');
        $this->batch_model->deleteStudentFromBatch($student_id, $batch_id);
        $this->session->set_flashdata('feedback', '<span class="color: maroon">Removed</span>');
        redirect('batch/students?batch_id=' . $batch_id);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->routine_model->deleteRoutineByBatchId($id);
        $this->batch_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('batch');
    }

    function getBatchList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchBySearch($search);
            } else {
                $data['cases'] = $this->batch_model->getBatch();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->batch_model->getBatchByLimit($limit, $start);
            }
        }
        $data['settings'] = $this->settings_model->getSettings();
        if ($data['settings']->date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        $options2 = '';
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin'))) {

                $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="batch/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
                //$options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
            }

            $option1 = '<a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('students') . '</a>';
            $option3 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option4 = '<a class="btn btn-info btn-xs btn_width" href="batch/batchDocuments?batch_id=' . $case->id . '"><i class="fa fa-file"> </i>' . lang('documents') . '</a>';
             $option5 = '<a class="btn btn-info btn-xs btn_width feedback_btn" id="'.$case->id.'">Feedback</a>';
            if (time() < $case->start_date) {
                $status = lang('upcoming');
            }
            if ((time() > $case->start_date) && (time() < $case->end_date)) {
                $status = lang('running');
            }
            if (time() > $case->end_date) {
                $status = lang('completed');
            }
            $no_of_student = $this->batch_model->getStudentsNumberByBatchId($case->id);
            $info[] = array(
                $case->batch_id,
                $case->type,
                $case->coursename,
                $case->instructorname,
                date($date_format, $case->start_date),
                date($date_format, $case->end_date),
                "<a href='#?' id='".$case->id."' class='batch_students'>".$no_of_student."</a>",
                
                $case->start_time,$case->end_time,$status,
                ' ' . $option1 . ' ' . $option4 . ' ' . $options2 . ' ' . $option3. ' ' . $option5
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

    function getOngoingBatchList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchBySearch($search);
            } else {
                $data['cases'] = $this->batch_model->getBatch();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->batch_model->getBatchByLimit($limit, $start);
            }
        }
        $data['settings'] = $this->settings_model->getSettings();
        if ($data['settings']->date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        $options2 = '';
        foreach ($data['cases'] as $case) {
            if ($case->end_date >=  time() && $case->start_date <= time()) {
                $i = $i + 1;
                if ($this->ion_auth->in_group(array('admin'))) {

                    $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="batch/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
                    //$options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
                }

                $option1 = '<a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('students') . '</a>';
                $option3 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
                $option4 = '<a class="btn btn-info btn-xs btn_width" href="batch/batchDocuments?batch_id=' . $case->id . '"><i class="fa fa-file"> </i>' . lang('documents') . '</a>';
                if (time() < $case->start_date) {
                    $status = lang('upcoming');
                }
                if ((time() > $case->start_date) && (time() < $case->end_date)) {
                    $status = lang('running');
                }
                if (time() > $case->end_date) {
                    $status = lang('completed');
                }
                $no_of_student = $this->batch_model->getStudentsNumberByBatchId($case->id);
                $info[] = array(
                    $case->batch_id,
                    $case->coursename,
                    $case->instructorname,
                    date($date_format, $case->start_date),
                    date($date_format, $case->end_date),
                    $no_of_student,
                    $status,
                    ' ' . $option1 . ' ' . $option4 . ' ' . $options2 . ' ' . $option3
                );
                $count = $count + 1;
            }
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
    
    
    
    function getUpcomingBatchList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchBySearch($search);
            } else {
                $data['cases'] = $this->batch_model->getBatch();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->batch_model->getBatchByLimit($limit, $start);
            }
        }
        $data['settings'] = $this->settings_model->getSettings();
        if ($data['settings']->date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        $options2 = '';
        foreach ($data['cases'] as $case) {
            if ($case->end_date >  time() && $case->start_date > time()) {
                $i = $i + 1;
                if ($this->ion_auth->in_group(array('admin'))) {

                    $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="batch/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
                    //$options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
                }

                $option1 = '<a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('students') . '</a>';
                $option3 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
                $option4 = '<a class="btn btn-info btn-xs btn_width" href="batch/batchDocuments?batch_id=' . $case->id . '"><i class="fa fa-file"> </i>' . lang('documents') . '</a>';
                if (time() < $case->start_date) {
                    $status = lang('upcoming');
                }
                if ((time() > $case->start_date) && (time() < $case->end_date)) {
                    $status = lang('running');
                }
                if (time() > $case->end_date) {
                    $status = lang('completed');
                }
                $no_of_student = $this->batch_model->getStudentsNumberByBatchId($case->id);
                $info[] = array(
                    $case->batch_id,
                    $case->coursename,
                    $case->instructorname,
                    date($date_format, $case->start_date),
                    date($date_format, $case->end_date),
                    $no_of_student,
                    $status,
                    ' ' . $option1 . ' ' . $option4 . ' ' . $options2 . ' ' . $option3
                );
                $count = $count + 1;
            }
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
    
    
    
    function getCompletedBatchList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchBySearch($search);
            } else {
                $data['cases'] = $this->batch_model->getBatch();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->batch_model->getBatchByLimit($limit, $start);
            }
        }
        $data['settings'] = $this->settings_model->getSettings();
        if ($data['settings']->date_format == 1) {
            $date_format = 'd-m-Y';
        } else {
            $date_format = 'm/d/Y';
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        $options2 = '';
        foreach ($data['cases'] as $case) {
            if ($case->end_date <  time() && $case->start_date < time()) {
                $i = $i + 1;
                if ($this->ion_auth->in_group(array('admin'))) {

                    $options2 = '<a class="btn btn-info btn-xs btn_width delete_button" href="batch/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
                    //$options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="sms/deleteTemplate?id=' . $case->id . '&redirect=sms/smsTemplate" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash-o"></i></a>';
                }

                $option1 = '<a class="btn btn-info btn-xs btn_width" href="batch/students?batch_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('students') . '</a>';
                $option3 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
                $option4 = '<a class="btn btn-info btn-xs btn_width" href="batch/batchDocuments?batch_id=' . $case->id . '"><i class="fa fa-file"> </i>' . lang('documents') . '</a>';
                if (time() < $case->start_date) {
                    $status = lang('upcoming');
                }
                if ((time() > $case->start_date) && (time() < $case->end_date)) {
                    $status = lang('running');
                }
                if (time() > $case->end_date) {
                    $status = lang('completed');
                }
                $no_of_student = $this->batch_model->getStudentsNumberByBatchId($case->id);
                $info[] = array(
                    $case->batch_id,
                    $case->coursename,
                    $case->instructorname,
                    date($date_format, $case->start_date),
                    date($date_format, $case->end_date),
                    $no_of_student,
                    $status,
                    ' ' . $option1 . ' ' . $option4 . ' ' . $options2 . ' ' . $option3
                );
                $count = $count + 1;
            }
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
    
    
    

    public function getCourseList() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->batch_model->getcourses($searchTerm);

        echo json_encode($response);
    }

    public function getCourseListedit() {
        // Search term
        $searchTerm = $this->input->get('searchTerm');
        $id = $this->input->get('id');
        // Get users
        $response = $this->batch_model->getcoursesedit($searchTerm, $id);

        echo json_encode($response);
    }

    public function getInstructorinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->batch_model->getinstructors($searchTerm);

        echo json_encode($response);
    }

    public function getStudentinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->batch_model->getstudents($searchTerm);

        echo json_encode($response);
    }

    public function batchMaterial() {
        $data = array();
        //$id = $this->input->get('course');
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function getBatchMaterialList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchMaterialBySearch($search);
            } else {
                $data['cases'] = $this->batch_model->getBatchMaterial();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->batch_model->getBatchMaterialByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->batch_model->getBatchMaterialByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin', 'Instructor'))) {

                $optiondown = '<a class="btn btn-info btn-xs btn_width" href="' . $case->url . '" download>' . lang('download') . '</a>';
                //$options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '">' . lang('edit') . '</a>';
                $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="batch/deleteBatchMaterial?id=' . $case->id . '&redirect=batch/batchMaterial" onclick="return confirm(\'Are you sure you want to delete this item?\');">' . lang('delete') . '</a>';
                // $option3 = ' <a type="button" class="btn btn-success btn-xs btn_width addtobatch" href="#myModal2"title="' . lang('add_to_batch') . '" data-toggle = "modal" data-id="' . $case->id . '"data-course="' . $case->course . '">' . lang('add_to_batch') . '</a>';
            }
            $batchid = $this->batch_model->getBatchById($case->batch_id)->batch_id;
            $info[] = array(
                $i,
                $case->coursename,
                $batchid,
                $case->title,
                ' ' . $optiondown . ' ' . $options2
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

    function deleteBatchMaterial() {
        $id = $this->input->get('id');

        $this->batch_model->deleteBatchMaterial($id);

        $this->session->set_flashdata('feedback', 'Deleted');
        redirect("batch/batchMaterial");
    }

    function deleteBatchMaterialDetails() {
        $id = $this->input->get('id');
        $batchmaterial1 = $this->batch_model->getBatchMaterialById($id)->batch_id;
        $this->batch_model->deleteBatchMaterial($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect("course/courseMaterial?course=" . $batchmaterial1);
    }

    function batchDocuments() {

        $batch_id = $this->input->get('batch_id');
        // echo $batch_id;
        $data['batches'] = $this->batch_model->getBatchById($batch_id);
        $data['batchmaterial'] = $this->batch_model->getBatchMaterialByBatchId($batch_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['batch_id'] = $batch_id;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batchdocuments', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addBatchMaterial() {
        $title = $this->input->post('title');
        $course_id = $this->input->post('course');
        $batch_id = $this->input->post('batch');
        $img_url = $this->input->post('img_url');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating File Field           
        // $this->form_validation->set_rules('img_url', 'Material', 'trim|required|min_length[1]|max_length[1000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', 'Validation Error !');
            redirect("batch/batchDocuments?batch_id=" . $batch_id);
        } else {
            $file_name = $_FILES['img_url']['name'];
            $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

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
                'allowed_types' => "gif|jpg|png|jpeg|pdf|docx|doc|xlsx|xls",
                'overwrite' => False,
                'max_size' => "204800000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "1768",
                'max_width' => "2024"
            );

            $this->load->library('Upload', $config);
            $this->upload->initialize($config);
            $coursename = $this->course_model->getCourseById($course_id)->name;
            if ($this->upload->do_upload('img_url')) {
                $path = $this->upload->data();

                $img_url = "uploads/" . $path['file_name'];
                if ($imageFileType == 'pdf') {
                    $filepath = "uploads/pdfimage.jpg";
                } elseif ($imageFileType == 'doc') {
                    $filepath = "uploads/doc.png";
                } elseif ($imageFileType == 'docx') {
                    $filepath = "uploads/docxcopy.png";
                } elseif ($imageFileType == 'xlsx' || $imageFileType == 'xls') {
                    $filepath = "uploads/excel.png";
                } else {
                    $filepath = $img_url;
                }
                $data = array();
                $data = array(
                    'coursename' => $coursename,
                    'title' => $title,
                    'url' => $img_url,
                    'course' => $course_id,
                    'iconurl' => $filepath,
                );
                $this->course_model->insertCourseMaterial($data);
                $last_id = $this->db->insert_id('course_material');
                $batchdetails = $this->batch_model->getBatchById($batch_id);
                $data1 = array();
                $data1 = array(
                    'coursename' => $coursename,
                    'title' => $title,
                    'url' => $img_url,
                    'course_id' => $course_id,
                    'iconurl' => $filepath,
                    'batch_id' => $batch_id,
                    'materialid' => $last_id,
                    'batchname' => $batchdetails->batch_id
                );
                $this->course_model->insertBatchMaterial($data1);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->session->set_flashdata('feedback', 'Upload Error !');
                redirect("batch/batchDocuments?batch_id=" . $batch_id);
            }




            redirect("batch/batchDocuments?batch_id=" . $batch_id);
        }
    }

    function getBatchFeedback() {
        $batchId = $this->input->get('id');
        $data['batch'] = $this->batch_model->getBatchById($batchId);
        echo json_encode($data);
    }

    function getStudentDetails() {
        $batchId = $this->input->get('id');
        $data['students'] = $this->batch_model->getStudentsByBatch($batchId);
        echo json_encode($data);
    }

    function getEmployees() {
        $searchTerm = $this->input->post('searchTerm');
        
        $response = $this->employee_model->getemployees($searchTerm);
        echo json_encode($response);
    }

}

/* End of file batch.php */
/* Location: ./application/modules/batch/controllers/batch.php */
