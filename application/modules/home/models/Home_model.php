<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getSum($field, $table) {
        $this->db->select_sum($field);
        $query = $this->db->get($table);
        return $query->result();
    }

    public function getUnpaidStudents() {

        $today = strtotime(date("Y-m-d"));
        $this->db->select("s.name,s.phone,s.email,p.next_payment_date");
        $this->db->from('student s');
        $this->db->join("student_batch sb","sb.student=s.id");
        $this->db->join("batch b","b.id=sb.batch");
        $this->db->join("payment p","p.student=s.id","p.batch=b.id");
        $this->db->where("b.start_date <= ".$today);
        $this->db->where("b.end_date >= ".$today);
        $this->db->where("p.next_payment_date",date("m/d/Y", strtotime('+2 days')) );
        $this->db->or_where("p.next_payment_date",date("m/d/Y", strtotime('+1 days')) );
        $result  = $this->db->get();
        // echo $this->db->last_query();
        return $result->result_array();
    }

}
