<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instructor extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('instructor_model');
        $this->load->model('home/home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel(); 
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['instructors'] = $this->instructor_model->getInstructorByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('instructor', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function instructorByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['instructors'] = $this->instructor_model->getInstructorByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('instructor', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchInstructor() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['instructors'] = $this->instructor_model->getInstructorByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('instructor', $data);
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
        $technology = $this->input->post('technology');
        $experiance = $this->input->post('experiance');
        $expected_amount = $this->input->post('expected_amount');
        $status = $this->input->post('status');
        $feedback = $this->input->post('feedback');
        $skill = $this->input->post('skill');
        $bank_name = $this->input->post('bank_name');
        $ifsc_code = $this->input->post('ifsc_code');
        $bank_account = $this->input->post('bank_account');
        $holder_name = $this->input->post('holder_name');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
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
                redirect("instructor/editInstructor?id=$id");
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
                    'technology' => $technology,
                    'experiance' => $experiance,
                    'expected_amount' => $expected_amount,
                    'status' => $status,
                    'feedback'=>$feedback,
                    'bank_name'=>$bank_name,
                    'ifsc_code'=>$ifsc_code,
                    'bank_account'=>$bank_account,
                    'holder_name'=>$holder_name,
                    'skill'=>$skill,
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'technology' => $technology,
                    'experiance' => $experiance,
                    'expected_amount' => $expected_amount,
                    'status' => $status,
                    'feedback'=>$feedback,
                    'bank_name'=>$bank_name,
                    'ifsc_code'=>$ifsc_code,
                    'bank_account'=>$bank_account,
                    'holder_name'=>$holder_name,
                    'skill'=>$skill,
                );
            }

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Instructor
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', 'This Email Address Is Already Registered');
                    redirect('instructor/addNewView');
                } else {
                    $dfg = 4;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $user_id = $this->db->insert_id();
                    $ion_user_id = $this->db->get_where('users_groups', array('id' => $user_id))->row()->user_id;
                    $this->instructor_model->insertInstructor($data);
                    $instructor_user_id = $this->db->insert_id();
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->instructor_model->updateInstructor($instructor_user_id, $id_info);

                    //sms
                    $set['settings'] = $this->settings_model->getSettings();
                    $autosms = $this->sms_model->getAutoSmsByType('instructoraapoin');
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

                    $autoemail = $this->email_model->getAutoEmailByType('instructoraapoin');
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
            } else { // Updating Instructor
                $ion_user_id = $this->db->get_where('instructor', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->instructor_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->instructor_model->updateInstructor($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('instructor');
        }
    }

    function getInstructor() {
        $data['instructors'] = $this->instructor_model->getInstructor();
        $this->load->view('instructor', $data);
    }

    function editInstructor() {
        $data = array();
        $id = $this->input->get('id');
        $data['instructor'] = $this->instructor_model->getInstructorById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editInstructorByJason() {
        $id = $this->input->get('id');
        $data['instructor'] = $this->instructor_model->getInstructorById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('instructor', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->instructor_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('instructor');
    }

    function getInstructorList() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];

        if ($limit == -1) {
            if (!empty($search)) {
                $data['cases'] = $this->instructor_model->getInstructorBySearch($search);
            } else {
                $data['cases'] = $this->instructor_model->getInstructor();
            }
        } else {
            if (!empty($search)) {
                $data['cases'] = $this->instructor_model->getInstructorByLimitBySearch($limit, $start, $search);
            } else {
                $data['cases'] = $this->instructor_model->getInstructorByLimit($limit, $start);
            }
        }
        //  $data['patients'] = $this->patient_model->getPatient();
        $i = 0;
        foreach ($data['cases'] as $case) {
            $i = $i + 1;

            // $option1 = '<a class="btn btn-info btn-xs btn_width" href="student/details?student_id=' . $case->id . '"><i class="fa fa-eye"> </i>' . lang('details') . '</a>';
            $option2 = '<button type="button" class="btn btn-info btn-xs btn_width editbutton" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>' . lang('edit') . '</button>';
            $option3 = '<a class="btn btn-info btn-xs btn_width delete_button" href="instructor/delete?id=' . $case->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"> </i>' . lang('delete') . '</a>';
            $option4 = '<button type="button" class="btn btn-info btn-xs btn_width bankdetails" data-toggle="modal" data-id="' . $case->id . '"><i class="fa fa-edit"></i>Bank Details</button>';
            $imgoption = '<img style="width:95%;"src="' . $case->img_url . '">';
            

            $info[] = array(
                $imgoption,
                $case->name,
                $case->email,
                $case->address,
                $case->phone,$case->technology,$case->experiance,"Rs.".($case->expected_amount==''?'0000':$case->expected_amount),($case->status==1?"Active":"In Active"),$case->feedback,$case->skill,
                $option2 . ' ' . $option3 . " " .$option4,
            );
        }

        if (!empty($data['cases'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('instructor')->num_rows(),
                "recordsFiltered" => $this->db->get('instructor')->num_rows(),
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

    public function getBankDetails() {
        $instructor = $this->input->post("instructor");
        $response = $this->instructor_model->getInstructorById($instructor);
        echo json_encode($response);
    }

    public function importTrainers() {


            if($_FILES['import']['name']) {
                $config = array(
                    'file_name' => $_FILES['import']['name'],
                    'upload_path' => "./uploads/imports/",
                    'allowed_types' => "xlsx",
                    'overwrite' => False,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "1768",
                    'max_width' => "2024"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('import'))
                {
                    $error = array ('error' =>$this->upload->display_errors());
                    
                } else { 
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                    $path = $_FILES["import"]["tmp_name"];
                    $fileType = $_FILES['import']['type'];
                    
                    // $fileType = $fileType;
                    
                    $inputFileType = PHPExcel_IOFactory::identify($path);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($path);
                    // $sheet_data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    foreach($objPHPExcel->getWorksheetIterator() as $worksheet)
                    {
                        $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                        $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                        for($row=2; $row <= $highestRow; $row++) {
                            
                            $instructorData['name'] = $worksheet->getCellByColumnAndRow(0,$row)->getValue();
                            $instructorData['technology'] = $worksheet->getCellByColumnAndRow(1,$row)->getValue();
                            $instructorData['phone'] = $worksheet->getCellByColumnAndRow(2,$row)->getValue();
                            $instructorData['email'] = $worksheet->getCellByColumnAndRow(3,$row)->getValue();
                            $instructorData['address'] = $worksheet->getCellByColumnAndRow(4,$row)->getValue();
                            $instructorData['bank_account'] = $worksheet->getCellByColumnAndRow(5,$row)->getValue();
                            $instructorData['ifsc_code'] = $worksheet->getCellByColumnAndRow(6,$row)->getValue();
                            $instructorData['skill'] = $worksheet->getCellByColumnAndRow(7,$row)->getValue();
                            $instructorData['expected_amount'] = $worksheet->getCellByColumnAndRow(8,$row)->getValue();
                            $instructorData['status'] = $worksheet->getCellByColumnAndRow(9,$row)->getValue();
                            $this->instructor_model->insertInstructor($instructorData);

                        }
                    }
                    
                    
                }
                $this->session->set_flashdata('status', 'Trainsers has been imported Successfully');
                    redirect('instructor/importTrainers');

            }
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard',$data); // just the header file
        $this->load->view('importTrainer');
        $this->load->view('home/footer'); // just the footer file
    }

}

/* End of file instructor.php */
/* Location: ./application/modules/instructor/controllers/instructor.php */
