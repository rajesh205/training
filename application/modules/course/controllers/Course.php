<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('home/home_model');
        $this->load->model('instructor/instructor_model');
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
        $data['courses'] = $this->course_model->getCourseByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function courseByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['courses'] = $this->course_model->getCourseByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function course_details() {

        $course_id = $this->input->get('course_id');
        $data['batchs'] = $this->batch_model->getBatchByCourseId($course_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['course_id'] = $course_id;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function searchCourse() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['courses'] = $this->course_model->getCourseByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
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
        $course_id = $this->input->post('course_id');
        $name = $this->input->post('name');
        $topic = $this->input->post('topic');
        $duration = $this->input->post('duration');
        $course_fee = $this->input->post('course_fee');
        $phone = $this->input->post('phone');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('topic', 'Topic', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required|min_length[1]|max_length[500]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("course/editCourse?id=$id");
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
                'course_id' => $course_id,
                'name' => $name,
                'topic' => $topic,
                'duration' => $duration,
                'course_fee' => $course_fee,
            );
            if (empty($id)) {     // Adding New Course    
                $this->course_model->insertCourse($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Course
                $this->course_model->updateCourse($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('course');
        }
    }

    function courseMaterial() {
        $data = array();
        $id = $this->input->get('course');
        $data['settings'] = $this->settings_model->getSettings();
        $data['course'] = $this->course_model->getCourseById($id);
        $data['course_materials'] = $this->course_model->getCourseMaterialByCourseId($id);
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function courseMaterialDetails() {
        $data = array();
        $id = $this->input->get('course');
        $data['settings'] = $this->settings_model->getSettings();
        //$data['course'] = $this->course_model->getCourseById($id);
        //$data['course_materials'] = $this->course_model->getCourseMaterialByCourseId($id);
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('coursematerial_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editCourseMaterialData() {
        $title = $this->input->post('title');
        $course_id = $this->input->post('course');
        $id = $this->input->post('id');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', 'Validation Error !');
            redirect("course/courseMaterialDetails");
        } else {
            $data = array();
            $coursename = $this->course_model->getCourseById($course_id)->name;
            $data = array(
                'coursename' => $coursename,
                'title' => $title,
                'course' => $course_id,
            );
            $this->course_model->updateCourseMaterial($data, $id);
            $this->session->set_flashdata('feedback', 'Updated');
            redirect("course/courseMaterialDetails");
        }
    }

    function addCourseMaterial() {
        $title = $this->input->post('title');
        $course_id = $this->input->post('course');
        $img_url = $this->input->post('img_url');
        $redirect = $this->input->post('redirect');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating File Field           
        //  $this->form_validation->set_rules('img_url', 'Material', 'trim|required|min_length[1]|max_length[1000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', 'Validation Error !');
            redirect("course/courseMaterial?course=" . $course_id);
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
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->session->set_flashdata('feedback', 'Upload Error !');
                redirect("course/courseMaterial?course=" . $course_id);
            }


            if (!empty($redirect)) {
                redirect($redirect);
            } else {
                redirect("course/courseMaterial?course=" . $course_id);
            }
        }
    }

    function getCourse() {
        $data['courses'] = $this->course_model->getCourse();
        $this->load->view('course', $data);
    }

    function editCourse() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['course'] = $this->course_model->getCourseById($id);
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editCourseByJason() {
        $id = $this->input->get('id');
        $data['course'] = $this->course_model->getCourseById($id);
        echo json_encode($data);
    }

    function deleteCourseMaterial() {
        $id = $this->input->get('id');
        $course_material = $this->course_model->getCourseMaterialById($id);
        $path = $course_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->course_model->deleteCourseMaterial($id);
        $this->course_model->deleteBatchMaterial($course_material->id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect("course/courseMaterial?course=" . $course_material->course);
    }

    function deleteCourseMaterialDetails() {
        $id = $this->input->get('id');
        $course_material = $this->course_model->getCourseMaterialById($id);
        $path = $course_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->course_model->deleteCourseMaterial($id);
        $this->course_model->deleteBatchMaterial($course_material->id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect("course/courseMaterialDetails");
    }

    function delete() {
        $id = $this->input->get('id');
        $this->course_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('course');
    }

    function getCourseMaterialList() {

        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->course_model->getCourseMaterialBySearch($search);
            } else {
                $data['cases'] = $this->course_model->getCourseMaterial();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->course_model->getCourseMaterialByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->course_model->getCourseMaterialByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $count = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            if ($this->ion_auth->in_group(array('admin', 'Instructor'))) {

                $optiondown = '<a class="btn btn-info btn-xs btn_width" href="' . $case->url . '" download>' . lang('download') . '</a>';
                $options1 = ' <a type="button" class="btn btn-success btn-xs btn_width editbutton1" title="' . lang('edit') . '" data-toggle = "modal" data-id="' . $case->id . '">' . lang('edit') . '</a>';
                $options2 = '<a class="btn btn-danger btn-xs btn_width" title="' . lang('delete') . '" href="course/deleteCourseMaterialDetails?id=' . $case->id . '&redirect=course/courseMaterialDetails" onclick="return confirm(\'Are you sure you want to delete this item?\');">' . lang('delete') . '</a>';
                $option3 = ' <a type="button" class="btn btn-success btn-xs btn_width addtobatch" href="#myModal2"title="' . lang('add_to_batch') . '" data-toggle = "modal" data-id="' . $case->id . '"data-course="' . $case->course . '">' . lang('add_to_batch') . '</a>';
            }

            $info[] = array(
                $i,
                $case->coursename,
                $case->title,
                ' ' . $optiondown . ' ' . $options1 . ' ' . $options2 . ' ' . $option3
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

    public function getCourseList() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->course_model->getcourses($searchTerm);

        echo json_encode($response);
    }

    public function editCourseMaterial() {
        // Search term
        $id = $this->input->get('id');

        // Get users
        $data['response'] = $this->course_model->getCourseMaterialById($id);

        echo json_encode($data);
    }

    public function getBatchListByCourse() {
        // Search term
        $searchTerm = $this->input->get('searchTerm');
        $course = $this->input->get('course');

        $response = $this->course_model->getBatchesBycourse($searchTerm, $course);

        echo json_encode($response);
    }

    public function addbatchMatrial() {
        $batch = $this->input->post('batch');
        $materialid = $this->input->post('materialid');
        $sharedmaterialwithbatch = $this->course_model->checkExistMaterialInBatch($batch, $materialid);
        if (!empty($sharedmaterialwithbatch)) {
            $this->session->set_flashdata('feedback', 'This Material Already Exist in Batch');
            redirect("course/courseMaterialDetails");
            die();
        }
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
        $this->form_validation->set_rules('batch', 'Batch', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', 'Validation Error !');
            redirect("course/courseMaterialDetails");
        } else {
            $materialdetails = $this->course_model->getCourseMaterialById($materialid);
            $batchdetails = $this->batch_model->getBatchById($batch);
            $data = array();
            $data = array(
                'coursename' => $materialdetails->coursename,
                'course_id' => $materialdetails->course,
                'title' => $materialdetails->title,
                'url' => $materialdetails->url,
                'batch_id' => $batch,
                'materialid' => $materialid,
                'iconurl' => $materialdetails->iconurl,
                'batchname' => $batchdetails->batch_id
            );
            $this->course_model->insertBatchMaterial($data);
            $this->session->set_flashdata('feedback', 'Added');


            redirect("course/courseMaterialDetails");
        }
    }

    function getCourseListJson() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->course_model->getCourseBySearch($search);
            } else {
                $data['cases'] = $this->course_model->getCourse();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->course_model->getCourseByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->course_model->getCourseByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        $option4 = '';
        foreach ($data['cases'] as $case) {
            $i = $i + 1;
            $option1 = '<a class="btn btn-info btn-xs btn_width details" href="course/course_details?course_id=' . $case->id . '"> <i class="fa fa-eye"> </i>' . lang('batches') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width" href="course/courseMaterial?course=' . $case->id . '"><i class="fa fa-file"> </i>' . lang('course') . ' ' . lang('material') . '</a>';
            if ($this->ion_auth->in_group('admin')) {
                $option4 = '<a class="btn btn-info btn-xs btn_width delete_button" href="course/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            }

            $data1['settings'] = $this->settings_model->getSettings();
            $batchquan = $this->batch_model->getBatchQuantityByCourseId($case->id);
            $info[] = array(
                $case->course_id,
                $case->name,
                $case->topic,
                $case->duration,
                $data1['settings']->currency . $case->course_fee,
                $batchquan,
                $option1 . ' ' . $option2 . ' ' . $option3 . ' ' . $option4
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('course')->num_rows(),
                "recordsFiltered" => $this->db->get('course')->num_rows(),
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

/* End of file course.php */
/* Location: ./application/modules/course/controllers/course.php */
