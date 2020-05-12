<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('notice_model');
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
        $data['notices'] = $this->notice_model->getNoticeByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('notice', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function noticeByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['notices'] = $this->notice_model->getNoticeByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('notice', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchNotice() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['notices'] = $this->notice_model->getNoticeByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('notice', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function viewNotice() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('view_notice', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function viewNoticeDetails() {
        $data['batch'] = (int) $this->input->post('batch_id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['notices'] = $this->notice_model->getNoticeByBatch($data['batch']);

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

    function noticeDetails() {
        $notice_id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['notice'] = $this->notice_model->getNoticeById($notice_id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('date_wise_details', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function noticeDetailsByStudent() {
        $data['student'] = $this->input->get('student');
        $data['batch'] = (int) $this->input->get('batch');
        $data['settings'] = $this->settings_model->getSettings();
        $data['notices'] = $this->notice_model->getNoticeByBatch($data['batch']);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student_wise_details', $data);
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
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        if (empty($id)) {
            $add_date = time();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("notice/editNotice?id=$id");
            } else {
                $data['setval']='setval';
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();

            if (!empty($id)) {
                $data = array(
                    'title' => $title,
                    'description' => $description,
                );
            } else {
                $data = array(
                    'title' => $title,
                    'description' => $description,
                    'add_date' => $add_date,
                    'adddate'=> date('d-m-y', $add_date)
                );
            }

            if (empty($id)) {     // Adding New Notice
                $this->notice_model->insertNotice($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Notice
                $this->notice_model->updateNotice($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('notice');
        }
    }


    function editNotice() {
        $data = array();
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editNoticeByJason() {
        $id = $this->input->get('id');
        $data['notice'] = $this->notice_model->getNoticeById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->notice_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('notice');
    }
     function getNoticeList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->notice_model->getNoticeBySearch($search);
            } else {
                $data['cases'] = $this->notice_model->getNotice();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->notice_model->getNoticeByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->notice_model->getNoticeByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
       // $i = 0;
        foreach ($data['cases'] as $case) {
            //$i = $i + 1;

          //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="notice/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
          

            $info[] = array(
                date('d-m-y', $case->add_date),
                $case->title,
                $case->description,
                $option2 . ' ' . $option3
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('notice')->num_rows(),
                "recordsFiltered" => $this->db->get('notice')->num_rows(),
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

/* End of file notice.php */
/* Location: ./application/modules/notice/controllers/notice.php */
