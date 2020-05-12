<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('sms');
        $this->load->model('finance_model');
        $this->load->model('course/course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('student/student_model');
        $this->load->model('home/home_model');
        require APPPATH . 'third_party/stripe/stripe-php/init.php';
        $this->load->module('paypal');
        $this->load->module('payu');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Employee', 'Student', 'Instructor'))) {
            redirect('home/permission');
        }
        require_once APPPATH.'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function index() {
        redirect('finance/financial_report');
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByPageNumber($page_number);

        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function paymentByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['payments'] = $this->finance_model->getPaymentByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentView() {
        $data = array();
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentViewDebug() {
        $data = array();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_view_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function getPaymentByBatchIdByStudentIdByJason() {
        $batch_id = $this->input->get('batch_id');
        $student_id = $this->input->get('student_id');
        $data['payments'] = $this->finance_model->getPaymentByBatchIdByStudentId($batch_id, $student_id);
        $data['currency'] = $this->db->get('settings')->row()->currency;
        echo json_encode($data);
    }

    function searchPayment() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['payments'] = $this->finance_model->getPaymentByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function sendingSms($data1, $to, $email1) {
        $autosms = $this->sms_model->getAutoSmsByType('payment');
        $message = $autosms->message;
        if ($autosms->status == 'Active') {
            $messageprint = $this->parser->parse_string($message, $data1);
            $data2[] = array($to => $messageprint);
            $this->sms->sendSms($to, $message, $data2);
        }


        $autoemail = $this->email_model->getAutoEmailByType('payment');
        if ($autoemail->status == 'Active') {
            $emailSettings = $this->email_model->getEmailSettings();
            $message1 = $autoemail->message;
            $messageprint1 = $this->parser->parse_string($message1, $data1);
            $this->email->from($emailSettings->admin_email);
            $this->email->to($email1);
            $this->email->subject('Payment confirmation');
            $this->email->message($messageprint1);
            $this->email->send();
        }
    }

    public function addPayment() {
        $token = $this->input->post('token');
        $id = $this->input->post('id');
        $student = $this->input->post('student');
        $batch = $this->input->post('batch_id');
        $course = $this->input->post('course');
        $amount = $this->input->post('amount');
        $discount = $this->input->post('discount');
        $next_payment_date = $this->input->post('next_payment_date');
        $invoice = $this->input->post('invoice_id');
        $tds = $this->input->post('tds');
        $type = $this->input->post('ptype');
        $gateway1 = $this->db->get('settings')->row()->payment_gateway;
        if ($type == 'card' && $gateway1 != 'PayU Money') {
            $card = $this->input->post('card');
            $expire = $this->input->post('expire');
            $cvv = $this->input->post('cvv');
            $cardType = $this->input->post('cardType');
            $this->form_validation->set_rules('card', 'Card', 'trim|required|xss_clean');
            $this->form_validation->set_rules('expire', 'Expire Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('cvv', 'CVV Number', 'trim|required|xss_clean');
        }

        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Course Field
        $this->form_validation->set_rules('course', 'course', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Student Field
        $this->form_validation->set_rules('student', 'Student', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Student Field
        $this->form_validation->set_rules('batch', 'batch', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Amount Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Discount Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data = array();
//$data['setval']='setval';
            $data['courses'] = $this->course_model->getCourse();
            $data['settings'] = $this->settings_model->getSettings();
            $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_payment_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            if (!empty($discount)) {
                $gross_total = $amount - $discount;
            } else {
                $gross_total = $amount;
            }

            $data = array();
            $data = array(
                'course' => $course,
                'batch' => $batch,
                'student' => $student,
                'student_name' => $this->db->get_where('student', array('id=' => $student))->row()->name,
                'amount' => $amount,
                'discount' => $discount,
                'gross_total' => $gross_total,
                'date' => $date,
                'next_payment_date'=>$next_payment_date,
                'invoice_id'=>$invoice,
                'tds'=>$tds
            );
            if (empty($id)) {
// $this->finance_model->insertPayment($data);
                $batchdetails = $this->batch_model->getBatchById($batch);
                $getcourse = $this->course_model->getCourseById($batchdetails->course)->name;
//sms
                $studentdetails = $this->db->get_where('student', array('id=' => $student))->row();
                $to = $studentdetails->phone;
                $email1 = $studentdetails->email;
                $name1 = explode(' ', $studentdetails->name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $studentdetails->name,
                    'amount' => $gross_total,
                    'course' => $getcourse,
                    'batch' => $batchdetails->batch_id,
                    'next_payment_date'=>$next_payment_date
                );


                $gateway = $this->db->get('settings')->row()->payment_gateway;
                if ($gateway == 'Stripe' && $type == 'card') {
                    $stripe = $this->db->get_where('pgateway', array('id =' => 2))->row();
                    \Stripe\Stripe::setApiKey($stripe->secret);
                    $charge = \Stripe\Charge::create(array(
                                "amount" => $gross_total * 100,
                                "currency" => "usd",
                                "source" => $token
                    ));
                    $chargeJson = $charge->jsonSerialize();
                    if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                        $payment_status = $chargeJson['status'];
                    }
                    if ($payment_status == 'succeeded') {
                        $this->finance_model->insertPayment($data);
                        $this->sendingSms($data1, $to, $email1);
                        $this->session->set_flashdata('feedback', 'Added');
                        redirect("finance/payment");
                    } else {

                        $this->session->set_flashdata('feedback', 'Payment failed. Not enough money');

                        redirect('finance/addPaymentView');
                    }
                } else if ($gateway == 'PayPal' && $type == 'card') {


                    $cvv = $this->input->post('cvv');
//  echo $cardType;
                    $all_details = array(
                        'deposited_amount' => $gross_total,
                        'card_number' => $card,
                        'expire_date' => $expire,
                        'cvv' => $cvv,
                        'from' => 'pos',
                        'customer_name' => $studentdetails->name,
                        'customer_email' => $studentdetails->email,
                        'customer_phone' => $studentdetails->phone,
                        'card_type' => $cardType
                    );

                    $response = $this->paypal->Do_direct_payment($all_details);
                    if ($response === 1) {
                        $this->finance_model->insertPayment($data);
                        $this->sendingSms($data1, $to, $email1);
                        $this->session->set_flashdata('feedback', 'Payment Completed Successfully');
                        redirect("finance/payment");
                    } else {
                        $this->session->set_flashdata('feedback', 'Payment Failed!');
                        redirect('finance/addPaymentView');
                    }
                } elseif ($gateway == 'PayU Money' && $type == 'card') {
                    $this->payu->check1($gross_total, $data,0);
                } else if ($type == 'card') {
                    $this->session->set_flashdata('feedback', 'Payment failed. No Gateway Selected');
                    redirect("finance/payment");
                } else if ($type == 'cash') {
                    $this->finance_model->insertPayment($data);
                    $this->sendingSms($data1, $to, $email1);
                    $this->session->set_flashdata('feedback', 'Payment Completed Successfully');
                    redirect("finance/payment");
                }
                $this->session->set_flashdata('feedback', 'Added');
            } else {

                $this->finance_model->updatePayment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
                redirect("finance/payment");
            }
        }
    }

    public function addpaymentFromStudentProfile() {
         $token = $this->input->post('token');
        $id = $this->input->post('id');
        $batch_course_array = array();
        $student = $this->input->post('student_id');
        $batch_course = $this->input->post('batch_course');
        $batch_course_array = explode('*', $batch_course);
        $batch = $batch_course_array[0];
        $course = $batch_course_array[1];
        $amount = $this->input->post('amount');
        $discount = $this->input->post('discount');
        $date = time();
        $type = $this->input->post('ptype');
        $gateway1 = $this->db->get('settings')->row()->payment_gateway;
        if ($type == 'card' && $gateway1 != 'PayU Money') {
            $card = $this->input->post('card');
            $expire = $this->input->post('expire');
            $cvv = $this->input->post('cvv');
            $cardType = $this->input->post('cardType');
            $this->form_validation->set_rules('card', 'Card', 'trim|required|xss_clean');
            $this->form_validation->set_rules('expire', 'Expire Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('cvv', 'CVV Number', 'trim|required|xss_clean');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

// Validating Batch - Course Field
// $this->form_validation->set_rules('batch_course', 'Batch - Course', 'trim|min_length[2]|max_length[100]|xss_clean');
// Validating Amount Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
// Validating Discount Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $student_id = $this->input->post('student_id');

            if ($this->ion_auth->in_group(array('Student'))) {
                $user = $this->ion_auth->get_user_id();
                $student_table_id = $this->db->get_where('student', array('ion_user_id' => $user))->row()->id;
                if ($student_id != $student_table_id) {
                    redirect('home/permission');
                }
            }

            $data['batches'] = $this->student_model->getBatchByStudentId($student_id);
            $data['payments'] = $this->finance_model->getPaymentByStudentId($student_id);
            $data['settings'] = $this->settings_model->getSettings();
               $data['gateway'] = $this->finance_model->getGatewayByName($data['settings']->payment_gateway);
            $data['student_details'] = $this->student_model->getStudentById($student_id);
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('student_details', $data);
            $this->load->view('home/footer'); // just the footer file
        } else {
            if (!empty($discount)) {
                $gross_total = $amount - $discount;
            } else {
                $gross_total = $amount;
            }

            $data = array();
            $data = array(
                'course' => $course,
                'batch' => $batch,
                'student' => $student,
                'student_name' => $this->db->get_where('student', array('id=' => $student))->row()->name,
                'amount' => $amount,
                'discount' => $discount,
                'gross_total' => $gross_total,
                'date' => $date
            );
            if (empty($id)) {
// $this->finance_model->insertPayment($data);
                $batchdetails = $this->batch_model->getBatchById($batch);
                $getcourse = $this->course_model->getCourseById($batchdetails->course)->name;
//sms
                $studentdetails = $this->db->get_where('student', array('id=' => $student))->row();
                $to = $studentdetails->phone;
                $email1 = $studentdetails->email;
                $name1 = explode(' ', $studentdetails->name);
                if (!isset($name1[1])) {
                    $name1[1] = null;
                }
                $data1 = array(
                    'firstname' => $name1[0],
                    'lastname' => $name1[1],
                    'name' => $studentdetails->name,
                    'amount' => $gross_total,
                    'course' => $getcourse,
                    'batch' => $batchdetails->batch_id
                );


                $gateway = $this->db->get('settings')->row()->payment_gateway;
                if ($gateway == 'Stripe' && $type == 'card') {
                    $stripe = $this->db->get_where('pgateway', array('id =' => 2))->row();
                    \Stripe\Stripe::setApiKey($stripe->secret);
                    $charge = \Stripe\Charge::create(array(
                                "amount" => $gross_total * 100,
                                "currency" => "usd",
                                "source" => $token
                    ));
                    $chargeJson = $charge->jsonSerialize();
                    if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                        $payment_status = $chargeJson['status'];
                    }
                    if ($payment_status == 'succeeded') {
                        $this->finance_model->insertPayment($data);
                        $this->sendingSms($data1, $to, $email1);
                        $this->session->set_flashdata('feedback', 'Added');
                         redirect("student/details?student_id=" . $student);
                    } else {

                        $this->session->set_flashdata('feedback', 'Payment failed. Not enough money');

                         redirect("student/details?student_id=" . $student);
                    }
                } else if ($gateway == 'PayPal' && $type == 'card') {


                    $cvv = $this->input->post('cvv');
//  echo $cardType;
                    $all_details = array(
                        'deposited_amount' => $gross_total,
                        'card_number' => $card,
                        'expire_date' => $expire,
                        'cvv' => $cvv,
                        'from' => 'pos',
                        'customer_name' => $studentdetails->name,
                        'customer_email' => $studentdetails->email,
                        'customer_phone' => $studentdetails->phone,
                        'card_type' => $cardType
                    );

                    $response = $this->paypal->Do_direct_payment($all_details);
                    if ($response === 1) {
                        $this->finance_model->insertPayment($data);
                        $this->sendingSms($data1, $to, $email1);
                        $this->session->set_flashdata('feedback', 'Payment Completed Successfully');
                          redirect("student/details?student_id=" . $student);
                    } else {
                        $this->session->set_flashdata('feedback', 'Payment Failed!');
                        redirect("student/details?student_id=" . $student);
                    }
                } elseif ($gateway == 'PayU Money' && $type == 'card') {
                    $this->payu->check1($gross_total, $data,1);
                } else if ($type == 'card') {
                    $this->session->set_flashdata('feedback', 'Payment failed. No Gateway Selected');
                    redirect("finance/payment");
                } else if ($type == 'cash') {
                    $this->finance_model->insertPayment($data);
                    $this->sendingSms($data1, $to, $email1);
                    $this->session->set_flashdata('feedback', 'Payment Completed Successfully');
                   redirect("student/details?student_id=" . $student);
                }
                $this->session->set_flashdata('feedback', 'Added');
            } else {

                $this->finance_model->updatePayment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
                  redirect("student/details?student_id=" . $student);
            }
        }
    }

    function delete() {
      
        if ($this->ion_auth->in_group('admin')) {
            $id = $this->input->get('id');
            $student_id = $this->finance_model->getStudentByPaymentId($id)->student;
            $this->finance_model->deletePayment($id);
            $this->session->set_flashdata('feedback', 'Deleted');
            redirect('finance/payment');
        }
    }

    public function expense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpense();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpense() {
        $token = $this->input->post('token');
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $date = time();
        $amount = $this->input->post('amount');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Generic Name Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');
// Validating Company Name Field
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $data['categories'] = $this->finance_model->getExpenseCategory();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_expense_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'category' => $category,
                    'date' => $date,
                    'amount' => $amount
                );
            } else {
                $data = array(
                    'category' => $category,
                    'amount' => $amount
                );
            }
            if (empty($id)) {
                $this->finance_model->insertExpense($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpense($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expense');
        }
    }

    function editExpense() {
        $data = array();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['expense'] = $this->finance_model->getExpenseById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpense() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpense($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('finance/expense');
    }

    public function expenseCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
// Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
// Validating Description Field
        $data['settings'] = $this->settings_model->getSettings();
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_expense_category');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->finance_model->insertExpenseCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpenseCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expenseCategory');
        }
    }

    function editExpenseCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['category'] = $this->finance_model->getExpenseCategoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpenseCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpenseCategory($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('finance/expenseCategory');
    }

    function invoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function todaySales() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_sales', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayExpense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpenseByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_expenses', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayNetCash() {
        $data['today_sales_amount'] = $this->finance_model->todaySalesAmount();
        $data['today_expenses_amount'] = $this->finance_model->todayExpensesAmount();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_net_cash', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function salesPerMonth() {

        $payments = $this->finance_model->getPayment();
        foreach ($payments as $payment) {
            $date = $payment->date;
            $month = date('m', $date);
            $year = date('y', $date);
            if ($month = '01') {
                
            }
        }
    }

    function courseWiseIncomeReportView() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_wise_payment_report_view', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function courseWiseIncomeReport() {
        $course = $this->input->post('course');
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();

        $data['course_id'] = $course;
        $data['batchs'] = $this->batch_model->getBatch();


        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);

        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_wise_payment_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function expenseReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        $data['expense_categories'] = $this->finance_model->getExpenseCategory();


// if(empty($date_from)&&empty($date_to)) {
//    $data['payments']=$this->finance_model->get_payment();
//     $data['ot_payments']=$this->finance_model->get_ot_payment();
//     $data['expenses']=$this->finance_model->get_expense();
// }
// else{

        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to);
// } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function batchWiseIncomeReportView() {
        $data['courses'] = $this->course_model->getCourse();
        $data['batchs'] = $this->batch_model->getBatch();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_wise_payment_report_view', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function batchWiseIncomeReport() {
        $course = $this->input->post('course');
        $batch = $this->input->post('batch_id');
        $data['students'] = $this->student_model->getStudent();
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();

        $data['course_id'] = $course;
        $data['batch_id'] = $batch;
        $data['batchs'] = $this->batch_model->getBatch();


        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);

        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_wise_payment_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        $data['batchs'] = $this->batch_model->getBatch();
        $data['expense_categories'] = $this->finance_model->getExpenseCategory();


// if(empty($date_from)&&empty($date_to)) {
//    $data['payments']=$this->finance_model->get_payment();
//     $data['ot_payments']=$this->finance_model->get_ot_payment();
//     $data['expenses']=$this->finance_model->get_expense();
// }
// else{

        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to);
// } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function getExpense() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $settings = $this->settings_model->getSettings();

        if ($limit == -1) {
            if (!empty($search)) {
                $data['expenses'] = $this->finance_model->getExpenseBysearch($search);
            } else {
                $data['expenses'] = $this->finance_model->getExpense();
            }
        } else {
            if (!empty($search)) {
                $data['expenses'] = $this->finance_model->getExpenseByLimitBySearch($limit, $start, $search);
            } else {
                $data['expenses'] = $this->finance_model->getExpenseByLimit($limit, $start);
            }
        }
//  $data['payments'] = $this->finance_model->getPayment();

        foreach ($data['expenses'] as $expense) {
            $date = date('d-m-y', $expense->date);

            if ($this->ion_auth->in_group(array('admin', 'Super', 'Accountant'))) {
                $options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="finance/editExpense?id=' . $expense->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Super', 'Accountant'))) {
                $options3 = '<a class="btn btn-info btn-xs delete_button" title="' . lang('delete') . '" href="finance/deleteExpense?id=' . $expense->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }

            if (empty($options1)) {
                $options1 = '';
            }

            if (empty($options3)) {
                $options3 = '';
            }

            $info[] = array(
                $expense->id,
                $date,
                $expense->amount,
                $options1 . ' ' . $options3,
                    //  $options2
            );
        }

        if (!empty($data['expenses'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('expense')->num_rows(),
                "recordsFiltered" => $this->db->get('expense')->num_rows(),
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

    function getPayment() {
        $requestData = $_REQUEST;
        $start = $requestData['start'];
        $limit = $requestData['length'];
        $search = $this->input->post('search')['value'];
        $settings = $this->settings_model->getSettings();

        if ($limit == -1) {
            if (!empty($search)) {
                $data['payments'] = $this->finance_model->getPaymentBysearch($search);
            } else {
                $data['payments'] = $this->finance_model->getPayment();
            }
        } else {
            if (!empty($search)) {
                $data['payments'] = $this->finance_model->getPaymentByLimitBySearch($limit, $start, $search);
            } else {
                $data['payments'] = $this->finance_model->getPaymentByLimit($limit, $start);
            }
        }
//  $data['payments'] = $this->finance_model->getPayment();

        foreach ($data['payments'] as $payment) {
            $date = date('d-m-y', $payment->date);

            if ($this->ion_auth->in_group(array('admin', 'Super', 'Accountant'))) {
//$options1 = ' <a class="btn btn-info btn-xs editbutton" title="' . lang('edit') . '" href="finance/editExpense?id=' . $expense->id . '"><i class="fa fa-edit"> </i> ' . lang('edit') . '</a>';
            }
            if ($this->ion_auth->in_group(array('admin', 'Super', 'Accountant'))) {
                $options3 = '<a class="btn btn-info btn-xs delete_button" title="' . lang('delete') . '" href="finance/delete?id=' . $payment->id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');"><i class="fa fa-trash"></i> ' . lang('delete') . '</a>';
            }
            $options2 = '<a class="btn btn-info btn-xs invoicebutton" title="' . lang('invoice') . '" style="color: #fff;" href="finance/invoice?id=' . $payment->id . '"><i class="fa fa-book"></i> ' . lang('invoice') . '</a>';
            if (empty($options1)) {
                $options1 = '';
            } 

            if (empty($options3)) {
                $options3 = '';
            }
             $tds = $payment->gross_total - ($payment->gross_total*$payment->tds)/100;
            $info[] = array(
                $payment->invoice_id,
                $this->db->get_where('student', array('id=' => $payment->student))->row()->name,
                $payment->student,
                $date,
                $settings->currency . '' . $payment->amount,
                $settings->currency . '' . $payment->discount,
                $settings->currency . '' . $payment->gross_total,
                $settings->currency . '' . ( $payment->tds == '' ? 0 : $payment->tds),
                $settings->currency . '' . $tds,
                $payment->next_payment_date,
                $options2 . ' ' . $options3,
                    //  $options2
            );
        }

        if (!empty($data['payments'])) {
            $output = array(
                "draw" => intval($requestData['draw']),
                "recordsTotal" => $this->db->get('payment')->num_rows(),
                "recordsFiltered" => $this->db->get('payment')->num_rows(),
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

    public function pending(){
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('notifications', $data);
        $this->load->view('home/footer');
    }

    public function reports() {
        $from = $to = '';
        $dateFilter = date("M Y");
        if($this->input->post("start_date")){
            $from = $this->input->post("start_date");
            $dateFilter = $this->input->post("start_date") ."-" .$this->input->post("end_date");
        }
        if($this->input->post("end_date")){
            $to = $this->input->post("end_date");
        }
        $data['date'] = $dateFilter;
        $data['settings'] = $this->settings_model->getSettings();
        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $data['incomeReport'] = $this->finance_model->getIncomeReport($from, $to);
        $data['expenseReport'] = $this->finance_model->getExpenseReport($from, $to);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expenceIncomeReport',$data);
        $this->load->view('home/footer');
    }

    public function exportReport() {
        $from = $to = '';
        if($this->input->get("start_date")){
            $from = $this->input->get("start_date");
        }
        if($this->input->get("end_date")){
            $to = $this->input->get("end_date");
        }
        $incomeReport = $this->finance_model->getIncomeReport($from, $to);
        $expenseReport = $this->finance_model->getExpenseReport($from, $to);
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        
        $table_headers = array("Student Name","Amount","Expenses for","Amount");
        $column = 0;
        foreach($table_headers as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $excelRow = 2;
        $incomeRecieved = $totalIncome = 0;
        foreach($incomeReport as $result) {
            $tds = $result['tds'] == '' ? 0 : $result['tds'];
            $tdsAmount = ($result['income']*$tds/100);
            $incomeRecieved = $result['income']-$tdsAmount;
            $total += $incomeRecieved; 
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excelRow, $result['name']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excelRow, $incomeRecieved);
            $excelRow++;
        }
        $totalColumn = $excelRow+1;
        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $totalColumn, 'Total Income');
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $totalColumn, $total);
        $total_expense = 0;
        $excelExpenseRow = 2;
        foreach($expenseReport as $result) {
            $total_expense += $result['expenses_amount']; 
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excelExpenseRow, $result['category']);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excelExpenseRow, $result['expenses_amount']);
            $excelExpenseRow++;
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $totalColumn, 'Total Expense');
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $totalColumn, $total_expense);


        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $totalColumn+2, 'Profit');
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $totalColumn+2, $total-$total_expense);

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ExpenditureReport.xls"');
        $object_writer->save('php://output');


    }

}

/* End of file finance.php */
/* Location: ./application/modules/finance/controllers/finance.php */