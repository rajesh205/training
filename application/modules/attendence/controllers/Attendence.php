<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendence extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('attendence_model');
        $this->load->model('course/course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('student/student_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('employee/employee_model');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor', 'Employee'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['attendences'] = $this->attendence_model->getAttendenceByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function attendenceByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['attendences'] = $this->attendence_model->getAttendenceByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchAttendence() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['attendences'] = $this->attendence_model->getAttendenceByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function viewAttendence() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('view_attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function viewAttendenceDetails() {
        $data['batch'] = (int) $this->input->post('batch_id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['attendences'] = $this->attendence_model->getAttendenceByBatch($data['batch']);

        $submit = $this->input->post('submit');

        if ($submit == 'submit') {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('date_wise', $data);
            $this->load->view('home/footer'); // just the header file
        }

        if ($submit == 'submit1') {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('student_wise', $data);
            $this->load->view('home/footer'); // just the header file
        }
    }

    function attendenceDetails() {
        $attendence_id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['attendence'] = $this->attendence_model->getAttendenceById($attendence_id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('date_wise_details', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function attendenceDetailsByStudent() {
        $data['student'] = $this->input->get('student');
        $data['batch'] = (int) $this->input->get('batch');
        $data['settings'] = $this->settings_model->getSettings();
        $data['attendences'] = $this->attendence_model->getAttendenceByBatch($data['batch']);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student_wise_details', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    function takeAttendence() {
        $data['course'] = $this->input->post('course');
        $data['batch'] = $this->input->post('batch_id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['students'] = $this->batch_model->getStudentsByBatchId($data['batch']);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('take_attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $course = $this->input->post('course');
        $batch = $this->input->post('batch');
        $student = $this->input->post('student');
        $date = $this->input->post('date');
        if (!empty($date)) {
            $date = strtotime($date);
        }
        $attendence = $this->input->post('attendence');

        $student_attendence = array();
        $student_attendence = array_combine($student, $attendence);

        foreach ($student_attendence as $key => $value) {
            $attendence_details[] = $key . '*' . $value;
        }

        $attendence_details = implode(',', $attendence_details);

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('batch', 'Batch', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[1]|max_length[500]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("attendence/editAttendence?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'course' => $course,
                'batch' => $batch,
                'date' => $date,
                'attendence' => $attendence_details
            );

            if (empty($id)) {     // Adding New Attendence
                $this->attendence_model->insertAttendence($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Attendence
                $this->attendence_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->attendence_model->updateAttendence($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('attendence/addNewView');
        }
    }

    function staffAttendence() {
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('staff_attendence', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function staffAttendenceDetails() {
        $data['staff_type'] = $this->input->post('staff_type');
        $data['user'] = $this->input->post('user');
        if ($data['staff_type'] == 1) {
            $data['staff'] = $this->instructor_model->getInstructorByIonUserId($data['user']);
        }
        if ($data['staff_type'] == 2) {
            $data['staff'] = $this->employee_model->getEmployeeByIonUserId($data['user']);
        }


        $list = array();
        $month = $this->input->post('month');
        $year = $this->input->post('year');

        if (empty($month)) {
            $month = date('m');
        }

        if (empty($year)) {
            $year = date('Y');
        }

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('d-m-Y', $time);
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $data['all_dates'] = $list;
        $data['settings'] = $this->settings_model->getSettings();
        $data['logs'] = $this->attendence_model->getOfficeLogByIonUserId($data['user']);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('staff_attendence_details', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getStaffsByJason() {
        $id = $this->input->get('id');
        if ($id == 1) {
            $data['staffs'] = $this->instructor_model->getInstructor();
            $data['staff_type'] = 'instructor';
        } else {
            $data['staffs'] = $this->employee_model->getEmployee();
            $data['staff_type'] = 'employee';
        }
        echo json_encode($data);
    }

    function addOfficeLog() {

        $check = $this->attendence_model->checkSingedIn();
        if ($check != 0) {
            $this->session->set_flashdata('feedback', 'Already Signed In');
            redirect('');
        }

        $user = $this->ion_auth->get_user_id();
        $sign_in_time = time();
        $sign_in_ip = $this->input->ip_address();

        $data = array();
        $data = array(
            'user' => $user,
            'sign_in_time' => $sign_in_time,
            'sign_in_ip' => $sign_in_ip,
        );
        $this->session->set_flashdata('feedback', 'Successfully Signied In');
        $this->attendence_model->insertOfficeLog($data);
        redirect('');
    }

    function addOfficeLogOut() {
        $user = $this->ion_auth->get_user_id();
        $sign_out_time = time();
        $sign_out_ip = $this->input->ip_address();

        $data = array();
        $data = array(
            'user' => $user,
            'sign_out_time' => $sign_out_time,
            'sign_out_ip' => $sign_out_ip,
        );
        $this->session->set_flashdata('feedback', 'Successfully Signied In');
        $this->attendence_model->updateOfficeLog($data);
        redirect('');
    }

    function getAttendence() {
        $data['attendences'] = $this->attendence_model->getAttendence();
        $this->load->view('attendence', $data);
    }

    function editAttendence() {
        $data = array();
        $id = $this->input->get('id');
        $data['attendence'] = $this->attendence_model->getAttendenceById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editAttendenceByJason() {
        $id = $this->input->get('id');
        $data['attendence'] = $this->attendence_model->getAttendenceById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('attendence', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->attendence_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('attendence');
    }

}

/* End of file attendence.php */
/* Location: ./application/modules/attendence/controllers/attendence.php */
