<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('event_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor', 'Student', 'Employee'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function upcoming() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('upcoming', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function ongoing() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('ongoing', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function eventByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchEvent() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['events'] = $this->event_model->getEventByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
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
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Start Field
        $this->form_validation->set_rules('start', 'Start', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating End Field   
        $this->form_validation->set_rules('end', 'End', 'trim|required|min_length[1]|max_length[500]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("event/editEvent?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            $data = array();
            $data = array(
                'title' => $title,
                'start' => $start,
                'end' => $end
            );

            if (empty($id)) {     // Adding New Event
                $this->event_model->insertEvent($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Event
                $this->event_model->updateEvent($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('event');
        }
    }

    function getEvent() {
        $data['events'] = $this->event_model->getEvent();
        $this->load->view('event', $data);
    }

    function calendar() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('calendar', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function getEventByJason() {
        $query = $this->event_model->getEventForCalendar();

        //   $jsonevents = array();

        foreach ($query as $entry) {

            $start_string = explode('-', $entry->start);
            $start_time = implode(' ', $start_string);
            $start_time = strtotime($start_time);

            $end_string = explode('-', $entry->end);
            $end_time = implode(' ', $end_string);
            $end_time = strtotime($end_time);


            $jsonevents[] = array(
                'id' => $entry->id,
                'title' => $entry->title,
                'start' => $start_time,
                'end' => $end_time,
                    // 'color' => 'green',
            );
        }

        echo json_encode($jsonevents);
    }

    function editEvent() {
        $data = array();
        $id = $this->input->get('id');
        $data['event'] = $this->event_model->getEventById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editEventByJason() {
        $id = $this->input->get('id');
        $data['event'] = $this->event_model->getEventById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->event_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('event');
    }

    function getEventList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventBySearch($search);
            } else {
                $data['cases'] = $this->event_model->getEvent();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->event_model->getEventByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="event/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';

            $start_string = explode('-', $case->start);
            $start_time = implode(' ', $start_string);
            $start_time = strtotime($start_time);

            $end_string = explode('-', $case->end);
            $end_time = implode(' ', $end_string);
            $end_time = strtotime($end_time);

            if ($start_time > time()) {
                $status = lang('upcoming');
            }
            if ($start_time < time() && $end_time > time()) {
                $status = lang('ongoing');
            }
            if ($end_time < time()) {
                $status = lang('done');
            }
            $info[] = array(
                $i,
                $case->title,
                $case->start,
                $case->end,
                $status,
                $option2 . ' ' . $option3
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('event')->num_rows(),
                "recordsFiltered" => $this->db->get('event')->num_rows(),
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

    function getOngoingEventList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventBySearch($search);
            } else {
                $data['cases'] = $this->event_model->getEvent();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->event_model->getEventByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count=0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="event/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';

            $start_string = explode('-', $case->start);
            $start_time = implode(' ', $start_string);
            $start_time = strtotime($start_time);

            $end_string = explode('-', $case->end);
            $end_time = implode(' ', $end_string);
            $end_time = strtotime($end_time);


            if ($start_time < time() && $end_time > time()) {
                $status = lang('ongoing');
            }
            if ($start_time < time() && $end_time > time()) {
                $info[] = array(
                    $i,
                    $case->title,
                    $case->start,
                    $case->end,
                    $status,
                    $option2 . ' ' . $option3
                );
                $count=$count+1;
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
  function getUpcomingEventList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventBySearch($search);
            } else {
                $data['cases'] = $this->event_model->getEvent();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->event_model->getEventByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->event_model->getEventByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count=0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            //  $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="event/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';

            $start_string = explode('-', $case->start);
            $start_time = implode(' ', $start_string);
            $start_time = strtotime($start_time);

            $end_string = explode('-', $case->end);
            $end_time = implode(' ', $end_string);
            $end_time = strtotime($end_time);


           if ($start_time > time()) {
                $status = lang('upcoming');
            }
           if ($start_time > time()) {
                $info[] = array(
                    $i,
                    $case->title,
                    $case->start,
                    $case->end,
                    $status,
                    $option2 . ' ' . $option3
                );
                $count=$count+1;
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

/* End of file event.php */
/* Location: ./application/modules/event/controllers/event.php */
