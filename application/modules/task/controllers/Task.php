<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Task extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('employee/employee_model');
        $this->load->model('task_model');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Employee', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        if (!$this->ion_auth->in_group(array('admin'))) {
            $data['current_user'] = $this->ion_auth->get_user_id();
        }
        $data['tasks'] = $this->task_model->getTask();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addTaskView() {
        $data = array();
        $data['current_user'] = $this->ion_auth->get_user_id();
        $data['settings'] = $this->settings_model->getSettings();
        $data['employees'] = $this->employee_model->getEmployee();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_task_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewTask() {
        $id = $this->input->post('id');
        $date = $this->input->post('date');
        $requested_by = $this->input->post('requested_by');
        $requested_for = $this->input->post('requested_for');
        $to_do = $this->input->post('to_do');
        $timeline = $this->input->post('timeline');
        $status = $this->input->post('status');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('task', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('requested_by', 'Requested By', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('requested_for', 'Requested For', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('to_do', 'To Do', 'trim|min_length[1]|max_length[1000]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('timeline', 'Timeline', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['employees'] = $this->employee_model->getEmployee();
            $data['categories'] = $this->task_model->getTaskCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_task_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $rebyname = $this->employee_model->getEmployeeByIonUserId($requested_by);
            $reforname = $this->employee_model->getEmployeeByIonUserId($requested_for);
            $data = array(
                'date' => $date,
                'requested_by' => $requested_by,
                'requested_byname' => $rebyname->name,
                'requested_for' => $requested_for,
                'requested_forname' => $reforname->name,
                'to_do' => $to_do,
                'timeline' => $timeline,
                'status' => $status,
                'add_date' => $add_date,
            );
            if (empty($id)) {
                $this->task_model->insertTask($data);

                $set['settings'] = $this->settings_model->getSettings();
                $autosms = $this->sms_model->getAutoSmsByType('taskassign');
                $message = $autosms->message;
                $to = $reforname->phone;
                $name1 = explode(' ', $reforname->name);
                $name2 = explode(' ', $rebyname->name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                if (!isset($name2[1])) {
                    $name2[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $reforname->name,
                    'assignbyfirstname' => $name2[0],
                    'assignbylastname' => $name2[1],
                    'assignbyname' => $rebyname->name,
                    'taskname' => 'to do'
                );

                if ($autosms->status == 'Active') {
                    $messageprint = $this->parser->parse_string($message, $data1);
                    $data2[] = array($to => $messageprint);
                    $this->sms->sendSms($to, $message, $data2);
                }
                //end
                //email

                $autoemail = $this->email_model->getAutoEmailByType('taskassign');
                if ($autoemail->status == 'Active') {
                    $emailSettings = $this->email_model->getEmailSettings();
                    $message1 = $autoemail->message;
                    $messageprint1 = $this->parser->parse_string($message1, $data1);
                    $this->email->from($emailSettings->admin_email);
                    $this->email->to($reforname->email);
                    $this->email->subject('enrollment confirmation');
                    $this->email->message($messageprint1);
                    $this->email->send();
                }

                //end

                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->task_model->updateTask($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('task');
        }
    }

    function editTask() {
        $data = array();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_task_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editTaskByJason() {
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->task_model->deleteTask($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('task');
    }

    function done() {
        $status = '2';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('done_tasks', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function open() {
        $status = '1';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('open_tasks', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myTask() {
        $data['tasks'] = $this->task_model->getTask();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myDone() {
        $status = '2';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_done_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myOpen() {
        $status = '1';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_open_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function taskCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('task_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addReport() {
        $task_id = $this->input->post('task_id');
        $report = $this->input->post('to_do_report');
        $data = array();
        $data = array('to_do_report' => $report);
        $this->task_model->updateTask($task_id, $data);
        $this->session->set_flashdata('feedback', 'Report Added');
        if ($this->ion_auth->in_group(array('admin'))) {
            redirect('task');
        } else {
            $current_user = $this->ion_auth->get_user_id();
            $task_details = $this->task_model->getTaskById($task_id);
            if ($current_user == $task_details->requested_for) {
                redirect('task/myTask');
            } else {
                redirect('task');
            }
        }
    }

    public function addCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->task_model->insertTaskCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->task_model->updateTaskCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('task/taskCategory');
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editTaskCategoryByJason() {
        $id = $this->input->get('id');
        $data['taskcategory'] = $this->task_model->getTaskCategoryById($id);
        echo json_encode($data);
    }

    function deleteTaskCategory() {
        $id = $this->input->get('id');
        $this->task_model->deleteTaskCategory($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('task/taskCategory');
    }

    function getTaskList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearch($search);
            } else {
                $data['cases'] = $this->task_model->getTask();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {
            //   $i = $i + 1;
            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="task/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }

            if (!$this->ion_auth->in_group(array('admin'))) {
                if ($case->requested_by == $current_user) {
                    $info[] = array(
                        $status,
                        $case->date,
                        $case->requested_byname,
                        $case->requested_forname,
                        $option5,
                        $case->timeline,
                        $option6,
                        $option2 . ' ' . $option3
                    );
                    $count = $count + 1;
                }
            } else {
                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                    $option2 . ' ' . $option3
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

    function getOpenTaskList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $status = $this->input->post('open');
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearchByStatus($status, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByStatusByStatus($status);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearchByStatus($status, $limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimitByStatus($status, $limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {
            //   $i = $i + 1;
            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="task/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }

            if (!$this->ion_auth->in_group(array('admin'))) {
                if ($case->requested_by == $current_user) {
                    $info[] = array(
                        $status,
                        $case->date,
                        $case->requested_byname,
                        $case->requested_forname,
                        $option5,
                        $case->timeline,
                        $option6,
                        $option2 . ' ' . $option3
                    );
                    $count = $count + 1;
                }
            } else {
                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                    $option2 . ' ' . $option3
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

    function getCompletedTaskList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $status = $this->input->post('completed');
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearchByStatus($status, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByStatusByStatus($status);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearchByStatus($status, $limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimitByStatus($status, $limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {
            //   $i = $i + 1;
            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="task/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }

            if (!$this->ion_auth->in_group(array('admin'))) {
                if ($case->requested_by == $current_user) {
                    $info[] = array(
                        $status,
                        $case->date,
                        $case->requested_byname,
                        $case->requested_forname,
                        $option5,
                        $case->timeline,
                        $option6,
                        $option2 . ' ' . $option3
                    );
                    $count = $count + 1;
                }
            } else {
                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                    $option2 . ' ' . $option3
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

    function getMyTaskList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearch($search);
            } else {
                $data['cases'] = $this->task_model->getTask();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {

            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }


            if ($case->requested_for == $current_user) {
                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

    function getMyOpenTaskList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $status = $this->input->post('open');
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearchByStatus($status, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByStatusByStatus($status);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearchByStatus($status, $limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimitByStatus($status, $limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {
            //   $i = $i + 1;
            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';

            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }


            if ($case->requested_for == $current_user) {

                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

    function getMyDoneTaskList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $status = $this->input->post('completed');
        $current_user = $this->ion_auth->get_user_id();
        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskBySearchByStatus($status, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByStatusByStatus($status);
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->task_model->getTaskByLimitBySearchByStatus($status, $limit, $start, $search);
            } else {
                $data['cases'] = $this->task_model->getTaskByLimitByStatus($status, $limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $count = 0;
        foreach ($data['cases'] as $case) {
            //   $i = $i + 1;
            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';

            $option5 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';

            if ($case->status == 1) {
                $status = lang('open');
            } else {
                $status = lang('completed');
            }
            if (!empty($case->to_do_report)) {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width see_to_do_report" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-eye"></i>' . lang('see') . '</button>';
            } else {
                $option6 = '<button type="button" class="btn btn-info btn-xs btn_width addreport" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-plus-circle"></i>' . lang('add') . '' . lang('report') . '</button>';
            }


            if ($case->requested_for == $current_user) {

                $info[] = array(
                    $status,
                    $case->date,
                    $case->requested_byname,
                    $case->requested_forname,
                    $option5,
                    $case->timeline,
                    $option6,
                );
                $count = $count + 1;
            }
        }

        if (!empty($info)) {
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

}

/* End of file task.php */
/* Location: ./application/modules/task/controllers/task.php */
