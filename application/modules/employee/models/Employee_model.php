<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertEmployee($data) {
        $this->db->insert('employee', $data);
    }

    function getEmployee() {
        $query = $this->db->get('employee');
        return $query->result();
    }

    function getEmployeeById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('employee');
        return $query->row();
    }
    

    function getEmployeeByIonUserid($id) {
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('employee');
        return $query->row();
    }

    function getEmployeeByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('employee', 50, $data_range_1);
        return $query->result();
    }

    function getEmployeeByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('employee', 1, $data_range_1);
        return $query->result();
    }

    function updateEmployee($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('employee', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('employee');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }
    function getEmployeeBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('email', $search);
        $query = $this->db->get('employee');
        return $query->result();
    }

    function getEmployeeByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('employee');
        return $query->result();
    }

    function getEmployeeByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('email', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('employee');
        return $query->result();
    }

    function getemployees($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("id ", $searchTerm);
            $this->db->or_where("name like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('employee');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('employee');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            // $this->db->where('id', $user['course']);
            //  $coursename = $this->db->get('course')->row()->name;
            $data[] = array("id" => $user['id'], "text" => $user['name']);
        }
        return $data;
    }



    function storeIncentive($data) {
        $this->db->insert('employee_incentive',$data);
    }

    function getStudents($employee) {
        $this->db->select("s.*,i.technology,sl.student,p.student,b.id,b.instructor,p.date");
        $this->db->from("student s");
        $this->db->join("student_lead sl","sl.student=s.id");
        $this->db->join("payment p","p.student=s.id");
        $this->db->join("batch b","b.id=p.batch");
        $this->db->join("instructor i","i.id=b.instructor");
        $this->db->where("p.date between ".strtotime(date("m/10/yy")) ." and ".strtotime(date("Y-m-d",strtotime('+30 days'))));
        $this->db->where("s.employee",$employee);
        $result = $this->db->get();
        return $result->result_array();

    }


    function getIncentives(){
        $this->db->select("*");
        $this->db->from("employee t");
        $this->db->join("employee_incentive t1","t1.employee=t.id");
        $result = $this->db->get();
        return $result->result();
    }

    function getIncentiveBySearch($search='', $limit='', $start='') {
        $this->db->select("*");
        $this->db->from("employee t");
        $this->db->join("employee_incentive t1","t1.employee=t.id");
        
        if($search) {
            $this->db->like('t.id', $search);
            $this->db->or_like('t.name', $search);
        }
        if($limit) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('t.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function getIncentiveByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('employee', 50, $data_range_1);
        return $query->result();
    }
}
