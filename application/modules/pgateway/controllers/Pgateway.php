<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pgateway extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('pgateway_model');
    }

    function index() {
        $data['gateways'] = $this->pgateway_model->getGateway();
        $data['settings'] = $this->db->get('settings')->row();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pgateway_setting', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function pgateway() {
        $data['gateways'] = $this->pgateway_model->getGateway();
        $data['settings'] = $this->db->get('settings')->row();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('pgateway_setting', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function setting() {
        $id = $this->input->get('id');
        $data['gateway'] = $this->pgateway_model->getGatewayById($id);
        $data['settings'] = $this->db->get('settings')->row();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('setting', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addNewSetting() {
        $id = $this->input->post('id');
        $this->load->library('form_validation');
        if ($id == 1) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $signature = $this->input->post('signature');
            $status = $this->input->post('status');
            $this->form_validation->set_rules('username', 'API Username', 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', 'API Password', 'required|trim|xss_clean');
            $this->form_validation->set_rules('signature', 'API Signature', 'required|trim|xss_clean');
            $data = array(
                'username' => $username,
                'password' => $password,
                'signature' => $signature,
                'status' => $status
            );
        }
        if ($id == 2) {
            $secret = $this->input->post('secret');
            $publish = $this->input->post('publish');
            $this->form_validation->set_rules('secret', 'API Secret Key', 'required|trim|xss_clean');
            $this->form_validation->set_rules('publish', 'API Publish Key', 'required|trim|xss_clean');
            $data = array(
                'secret' => $secret,
                'publish' => $publish
            );
        }
        if ($id == 3) {
            $merchant = $this->input->post('merchant');
            $salt = $this->input->post('salt');
            $status = $this->input->post('status');
            $this->form_validation->set_rules('merchant', 'API Merchant Key', 'required|trim|xss_clean');
            $this->form_validation->set_rules('salt', 'API Salt', 'required|trim|xss_clean');
            $data = array(
                'merchant_key' => $merchant,
                'salt' => $salt,
                'status' => $status
            );
        }
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('feedback', 'All Fields are required');
            redirect('pgateway/setting?id=' . $id);
        } else {
            $this->pgateway_model->updateSetting($id, $data);
            $this->session->set_flashdata('feedback', 'Updated!');
            redirect('pgateway/setting?id=' . $id);
        }
    }

    function gatewaySetting() {
        $gateway = $this->input->post('gateway');
        $this->form_validation->set_rules('gateway', 'Gateway', 'required|trim|xss_clean');
        $data = array(
            'payment_gateway' => $gateway
        );

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('feedback', 'Select One!');
            redirect('pgateway');
        } else {
            $this->pgateway_model->updateGateway($data);
            redirect('pgateway');
        }
    }

}
