<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('Ion_auth');
        $this->load->module('finance');
        $this->load->model('batch/batch_model');
        $this->load->model('finance/finance_model');
        $this->load->model('student/student_model');
        $this->load->model('pgateway/pgateway_model');
        $this->load->library('session');
    }

    public function index() {
        $status = $this->input->post('status');
        if (empty($status)) {
            redirect('payu');
        }

        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');

        $email = $this->input->post('email');

        $payumoney = $this->pgateway_model->getPaymentGatewaySettingsById('Pay U Money');

        $salt = $payumoney->salt; //  Your salt
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $data['hash'] = hash("sha512", $retHashSeq);
        $data['amount'] = $amount;
        $data['txnid'] = $txnid;
        $data['posted_hash'] = $posted_hash;
        $data['status'] = $status;

        $client_info = $this->customer_model->getcustomerByEmail($email);
        $client_id = $client_info->id;


        if ($status == 'success') {

            $data = array();
            $data = array('customer' => $client_id,
                'date' => time(),
                'payment_id' => $productinfo,
                'deposited_amount' => $amount,
                'deposit_type' => 'Card',
                'gateway' => 'Pay U Money',
                'user' => $this->ion_auth->get_user_id()
            );
            $this->finance_model->insertDeposit($data);

            $this->session->set_flashdata('feedback', 'Payment Completed Successfully');

            if ($this->ion_auth->in_group(array('Customer'))) {
                redirect('customer/myPaymentHistory');
            } else {
                redirect('finance/customerPaymentHistory?customer=' . $client_id);
            }
            //  $this->load->view('success', $data);
        } else {
            $this->session->set_flashdata('feedback', 'Payment Failed!');
            redirect('finance/customerPaymentHistory?customer=' . $client_id);
        }
    }

    public function index1() {
        $status = $this->input->post('status');
        if (empty($status)) {
            redirect('payu');
        }

        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $productexplode = explode('-', $productinfo);
        $email = $this->input->post('email');
        $payumoney = $this->pgateway_model->getGatewayById('3');
        //  $studentid = $this->input->post('studentid');
        //  $discount = $this->input->post('discount');
        $amountactual = $productexplode[2] + $amount;
        $salt = $payumoney->salt; //  Your salt
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $data['hash'] = hash("sha512", $retHashSeq);
        $data['amount'] = $amount;
        $data['txnid'] = $txnid;
        $data['posted_hash'] = $posted_hash;
        $data['status'] = $status;

        $client_info = $this->batch_model->getBatchById($productexplode[0]);
        $getcourse = $this->course_model->getCourseById($client_info->course)->name;

        $studentlist1 = $this->student_model->getStudentById($productexplode[1]);

        if ($status == 'success') {
            $date = time();
            $data = array();
            $data = array(
                'course' => $client_info->course,
                'batch' => $client_info->id,
                'student' => $studentlist1->id,
                'student_name' => $studentlist1->name,
                'amount' => $amountactual,
                'discount' => $productexplode[2],
                'gross_total' => $amount,
                'date' => $date
            );
            $to = $studentlist1->phone;
            $email1 = $studentlist1->email;
            $name1 = explode(' ', $studentlist1->name);
            if (!isset($name1[1])) {
                $name1[1] = null;
            }
            $data1 = array(
                'firstname' => $name1[0],
                'lastname' => $name1[1],
                'name' => $studentlist1->name,
                'amount' => $amount,
                'course' => $getcourse,
                'batch' => $client_info->batch_id
            );


            $this->finance_model->insertPayment($data);
            $this->finance->sendingSms($data1, $to, $email1);
            $this->session->set_flashdata('feedback', 'Payment Completed Successfully');
            if ($productexplode[2] == 0) {
                redirect("finance/payment");
            } else {
                redirect("student/details?student_id=" . $productexplode[1]);
            }
        } else {
            $this->session->set_flashdata('feedback', 'Payment Failed!');
            if ($productexplode[2] == 0) {
                redirect('finance/addPaymentView');
            } else {
                redirect("student/details?student_id=" . $productexplode[1]);
            }
        }
    }

    public function index2() {
        $status = $this->input->post('status');
        if (empty($status)) {
            redirect('payu');
        }

        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $email = $this->input->post('email');
        $payumoney = $this->pgateway_model->getPaymentGatewaySettingsById(1);
        $salt = $payumoney->salt; //  Your salt
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $data['hash'] = hash("sha512", $retHashSeq);
        $data['amount'] = $amount;
        $data['txnid'] = $txnid;
        $data['posted_hash'] = $posted_hash;
        $data['status'] = $status;

        $client_info = $this->customer_model->getcustomerByEmail($email);
        $client_id = $client_info->id;


        if ($status == 'success') {

            $previous_amount_received = $this->pharmacy_model->getPaymentById($productinfo)->amount_received;
            $data = array();
            $data = array(
                'amount_received' => $amount + $previous_amount_received,
            );
            $this->pharmacy_model->updatePayment($productinfo, $data);

            $this->session->set_flashdata('feedback', 'Amount Added Successfully');
            redirect("finance/pharmacy/invoice?id=" . "$productinfo");
            //  $this->load->view('success', $data);
        } else {
            $this->session->set_flashdata('feedback', 'Payment Failed!');
            redirect("finance/pharmacy/invoice?id=" . "$productinfo");
        }
    }

}
