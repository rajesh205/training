<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('course/course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('student/student_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('attendence/attendence_model');
        $this->load->model('notice/notice_model');
        $this->load->model('finance/finance_model');
        $this->load->model('event/event_model');
        $this->load->model('task/task_model');
        $this->load->model('home_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        $data = array();
        $current_user = $this->ion_auth->get_user_id();
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPayment();
        $data['events'] = $this->event_model->getEvent();
        $data['expenses'] = $this->finance_model->getExpense();
        $data['notices'] = $this->notice_model->getNotice();
        $data['tasks_by'] = $this->task_model->taskAssignedByUser($current_user);
        $data['tasks_for'] = $this->task_model->taskAssignedForUser($current_user);
        $data['today_sales_amount'] = $this->finance_model->todaySalesAmount();
        $data['today_expenses_amount'] = $this->finance_model->todayExpensesAmount();
        $data['sum'] = $this->home_model->getSum('gross_total', 'payment');

        $data['this_year']['payment_per_month'] = $this->finance_model->getPaymentPerMonthThisYear();
        $data['this_year']['expense_per_month'] = $this->finance_model->getExpensePerMonthThisYear();
        
        $data['ongoing_batches'] = $this->batch_model->getOngoingBatch();

        $data['nextPayments'] = $this->home_model->getUnpaidStudents();
        $this->load->view('dashboard', $data); // just the header file
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

    public function permission() {
        $this->load->view('permission');
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
