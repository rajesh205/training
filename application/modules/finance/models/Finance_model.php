<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertPayment($data) {
        $this->db->insert('payment', $data);
    }

    function getPayment() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('payment');
        return $query->row();
    }

    function getPaymentByStudentId($student_id) {
        $this->db->where('student', $student_id);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getReceivedAmountByBatchIdByStudentId($batch_id, $student_id) {
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);
        $query = $this->db->get('payment')->result();
        $amount = array();
        if (!empty($query)) {
            foreach ($query as $payment) {
                $amount[] = $payment->gross_total;
            }
            if (!empty($amount)) {
                $total_amount_received = array_sum($amount);
            } else {
                $total_amount_received = 0;
            }
        } else {
            $total_amount_received = 0;
        }

        return $total_amount_received;
    }

    function getPaymentByBatchIdByStudentId($batch_id, $student_id) {
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);

        $query = $this->db->get('payment')->result();
        return $query;
    }
    
    function getCourseFeeByBatchIdByStudentId($batch_id, $student_id){
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);
        $query = $this->db->get('payment')->row();
        return $query->course_fee;
    }

    function getDiscountByBatchIdByStudentId($batch_id, $student_id) {
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);
        $query = $this->db->get('payment')->result();
        $amount = array();
        if (!empty($query)) {
            foreach ($query as $payment) {
                $discount[] = $payment->discount;
            }
            if (!empty($discount)) {
                $total_discount = array_sum($discount);
            } else {
                $total_discount = 0;
            }
        } else {
            $total_discount = 0;
        }

        return $total_discount;
    }

    function getPaymentByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('id', $key);
        $this->db->or_like('student', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('payment', 50, $data_range_1);
        return $query->result();
    }
    
    function getStudentByPaymentId($id){
        $this->db->where('id', $id);
        $query = $this->db->get('payment')->row();
        return $query;
    }

    function getPaymentByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('payment', 50, $data_range_1);
        return $query->result();
    }

    function updatePayment($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function deletePayment($id) {
        $this->db->where('id', $id);
        $this->db->delete('payment');
    }

    function insertExpense($data) {
        $this->db->insert('expense', $data);
    }

    function getExpense() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('expense');
        return $query->row();
    }

    function updateExpense($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('expense', $data);
    }

    function insertExpenseCategory($data) {
        $this->db->insert('expense_category', $data);
    }

    function getExpenseCategory() {
        $query = $this->db->get('expense_category');
        return $query->result();
    }

    function getExpenseCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('expense_category');
        return $query->row();
    }

    function updateExpenseCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('expense_category', $data);
    }

    function deleteExpense($id) {
        $this->db->where('id', $id);
        $this->db->delete('expense');
    }

    function deleteExpenseCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('expense_category');
    }

    function getDiscountType() {
        $query = $this->db->get('settings');
        return $query->row()->discount;
    }

    function getPaymentByDate($date_from, $date_to) {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function getExpenseByDate($date_from, $date_to) {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $query->result();
    }

    function amountReceived($id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update('payment', $data);
    }

    function todaySalesAmount() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->getPaymentByDate($today, $today_last);

        foreach ($data['payments'] as $sales) {
            $sales_amount[] = $sales->gross_total;
        }
        if (!empty($sales_amount)) {
            return array_sum($sales_amount);
        } else {
            return 0;
        }
    }

    function todayExpensesAmount() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['payments'] = $this->getExpenseByDate($today, $today_last);

        foreach ($data['payments'] as $expenses) {
            $expenses_amount[] = $expenses->amount;
        }
        if (!empty($expenses_amount)) {
            return array_sum($expenses_amount);
        } else {
            return 0;
        }
    }
    
    function getGatewayByName($name) {
        $this->db->where('gateway',$name);
        $query = $this->db->get('pgateway')->row();
        return $query;
    }
    
    
    
     function getPaymentPerMonthThisYear() {
        $query = $this->db->get('payment')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->gross_total;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->gross_total;
                }
            }
        }
        
        
        if(!empty($total['january'])){
            $total['january'] = array_sum($total['january']);
        }else{
            $total['january'] = 0;
        }
        if(!empty($total['february'])){
            $total['february'] = array_sum($total['february']);
        }else{
            $total['february'] = 0;
        }
        if(!empty($total['march'])){
            $total['march'] = array_sum($total['march']);
        }else{
            $total['march'] = 0;
        }
        if(!empty($total['april'])){
            $total['april'] = array_sum($total['april']);
        }else{
            $total['april'] = 0;
        }
        if(!empty($total['may'])){
            $total['may'] = array_sum($total['may']);
        }else{
            $total['may'] = 0;
        }
        if(!empty($total['june'])){
            $total['june'] = array_sum($total['june']);
        }else{
            $total['june'] = 0;
        }
        if(!empty($total['july'])){
            $total['july'] = array_sum($total['july']);
        }else{
            $total['july'] = 0;
        }
        if(!empty($total['august'])){
            $total['august'] = array_sum($total['august']);
        }else{
            $total['august'] = 0;
        }
        if(!empty($total['september'])){
            $total['september'] = array_sum($total['september']);
        }else{
            $total['september'] = 0;
        }
        if(!empty($total['october'])){
            $total['october'] = array_sum($total['october']);
        }else{
            $total['october'] = 0;
        }
        if(!empty($total['november'])){
            $total['november'] = array_sum($total['november']);
        }else{
            $total['november'] = 0;
        }
        if(!empty($total['december'])){
            $total['december'] = array_sum($total['december']);
        }else{
            $total['december'] = 0;
        }
        
        return $total;
    }
    
    function getExpensePerMonthThisYear() {
        $query = $this->db->get('expense')->result();
        $total = array();
        foreach ($query as $q) {
            if (date('Y', time()) == date('Y', $q->date)) {
                if (date('m', $q->date) == '01') {
                    $total['january'][] = $q->amount;
                }
                if (date('m', $q->date) == '02') {
                    $total['february'][] = $q->amount;
                }
                if (date('m', $q->date) == '03') {
                    $total['march'][] = $q->amount;
                }
                if (date('m', $q->date) == '04') {
                    $total['april'][] = $q->amount;
                }
                if (date('m', $q->date) == '05') {
                    $total['may'][] = $q->amount;
                }
                if (date('m', $q->date) == '06') {
                    $total['june'][] = $q->amount;
                }
                if (date('m', $q->date) == '07') {
                    $total['july'][] = $q->amount;
                }
                if (date('m', $q->date) == '08') {
                    $total['august'][] = $q->amount;
                }
                if (date('m', $q->date) == '09') {
                    $total['september'][] = $q->amount;
                }
                if (date('m', $q->date) == '10') {
                    $total['october'][] = $q->amount;
                }
                if (date('m', $q->date) == '11') {
                    $total['november'][] = $q->amount;
                }
                if (date('m', $q->date) == '12') {
                    $total['december'][] = $q->amount;
                }
            }
        }
        
        
        if(!empty($total['january'])){
            $total['january'] = array_sum($total['january']);
        }else{
            $total['january'] = 0;
        }
        if(!empty($total['february'])){
            $total['february'] = array_sum($total['february']);
        }else{
            $total['february'] = 0;
        }
        if(!empty($total['march'])){
            $total['march'] = array_sum($total['march']);
        }else{
            $total['march'] = 0;
        }
        if(!empty($total['april'])){
            $total['april'] = array_sum($total['april']);
        }else{
            $total['april'] = 0;
        }
        if(!empty($total['may'])){
            $total['may'] = array_sum($total['may']);
        }else{
            $total['may'] = 0;
        }
        if(!empty($total['june'])){
            $total['june'] = array_sum($total['june']);
        }else{
            $total['june'] = 0;
        }
        if(!empty($total['july'])){
            $total['july'] = array_sum($total['july']);
        }else{
            $total['july'] = 0;
        }
        if(!empty($total['august'])){
            $total['august'] = array_sum($total['august']);
        }else{
            $total['august'] = 0;
        }
        if(!empty($total['september'])){
            $total['september'] = array_sum($total['september']);
        }else{
            $total['september'] = 0;
        }
        if(!empty($total['october'])){
            $total['october'] = array_sum($total['october']);
        }else{
            $total['october'] = 0;
        }
        if(!empty($total['november'])){
            $total['november'] = array_sum($total['november']);
        }else{
            $total['november'] = 0;
        }
        if(!empty($total['december'])){
            $total['december'] = array_sum($total['december']);
        }else{
            $total['december'] = 0;
        }
        
        return $total;
    }


    function getExpenseBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('expense');
        return $query->result();
    }

    function getExpenseByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('expense');
        return $query->result();
    }
    
    function getPaymentBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('student_name', $search);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }

    function getPaymentByLimitBySearch($limit, $start, $search) {
        $this->db->like('id', $search);
        $this->db->or_like('amount', $search);
        $this->db->or_like('student_name', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('payment');
        return $query->result();
    }
    
    function getIncomeReport($from='',$to='') {
        $this->db->select('gross_total as income,p.tds,t.*');
        $this->db->from("payment p");
        $this->db->join("student t","t.id=p.student");
        
        if($from && $to){
            $this->db->where("date between ".strtotime($from)." and ".strtotime($to));    
        } else {
            $this->db->where("DATE_FORMAT(FROM_UNIXTIME(date), '%b')  =",date('M'));
        }
        $result = $this->db->get();
        return $result->result_array();
    }

    function getExpenseReport($from='',$to='') {
        $this->db->select('amount as expenses_amount,category');
        $this->db->from("expense");
        if($from && $to){
            $this->db->where("date between ".strtotime($from)." and ".strtotime($to));    
        } else {
            $this->db->where("DATE_FORMAT(FROM_UNIXTIME(date), '%b')  =",date('M'));
        }
        $result = $this->db->get();
        return $result->result_array();
    }
    
    

}
