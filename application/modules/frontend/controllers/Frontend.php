<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('settings/settings_model');
        $this->load->model('frontend_model');
    }

    function index() {
        $data['setting'] = $this->settings_model->getSettings();
        $data['website'] = $this->frontend_model->getWebsite();
        $this->load->view('frontend', $data);
    }

    function setting() {
        if ($this->ion_auth->logged_in()) {
            $data = array();
            $data['setting'] = $this->frontend_model->getInfo();
            $data['website'] = $this->frontend_model->getWebsite();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('addFrontend', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
           redirect('home/permission');
        }
    }

    function addNew() {
        $facebook = $this->input->post('facebook');
        $twitter = $this->input->post('twitter');
        $tumblr = $this->input->post('tumblr');
        $about = $this->input->post('about');
        $course1 = $this->input->post('course1');
        $course1detail = $this->input->post('course1detail');
        $course2 = $this->input->post('course2');
        $course2detail = $this->input->post('course2detail');
        $course3 = $this->input->post('course3');
        $course3detail = $this->input->post('course3detail');
        $instructor1 = $this->input->post('instructor1');
        $instructor1detail = $this->input->post('instructor1detail');
        $instructor2 = $this->input->post('instructor2');
        $instructor2detail = $this->input->post('instructor2detail');
        $instructor3 = $this->input->post('instructor3');
        $instructor3detail = $this->input->post('instructor3detail');

        //Image 1
        $file_name = $_FILES['img_url1']['name'];
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

        if ($this->upload->do_upload('img_url1')) {
            $path = $this->upload->data();
            $img_url = "uploads/" . $path['file_name'];
            $data = array(
                'slider1' => $img_url
            );
            $this->frontend_model->editSite(1, $data);
        }


        //Image 2
        $file_name = $_FILES['img_url2']['name'];
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

        if ($this->upload->do_upload('img_url2')) {
            $path = $this->upload->data();
            $img_url = "uploads/" . $path['file_name'];
            $data = array(
                'slider2' => $img_url
            );
            $this->frontend_model->editSite(1, $data);
        }


        //Image 3
        $file_name = $_FILES['img_url3']['name'];
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

        if ($this->upload->do_upload('img_url3')) {
            $path = $this->upload->data();
            $img_url = "uploads/" . $path['file_name'];
            $data = array(
                'slider3' => $img_url
            );
            $this->frontend_model->editSite(1, $data);
        }


        $data = array(
            'facebook' => $facebook,
            'twitter' => $twitter,
            'tumblr' => $tumblr,
            'about' => $about,
            'course1' => $course1,
            'course1detail' => $course1detail,
            'course2' => $course2,
            'course2detail' => $course2detail,
            'course3' => $course3,
            'course3detail' => $course3detail,
            'instructor1' => $instructor1,
            'instructor1detail' => $instructor1detail,
            'instructor2' => $instructor2,
            'instructor2detail' => $instructor2detail,
            'instructor3' => $instructor3,
            'instructor3detail' => $instructor3detail,
        );

        $this->frontend_model->editSite(1, $data);
        redirect('frontend/setting');
    }

}
