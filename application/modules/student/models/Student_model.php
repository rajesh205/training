<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertStudent($data) {
        $this->db->insert('student', $data);
    }

    function getStudent() {
        $query = $this->db->get('student');
        return $query->result();
    }

    function getStudentByKeyforBatch($key) {
        $this->db->like('name', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student');
        return $query->result();
    }

    function getBatchByStudentId($student_id) {
        $this->db->where('student', $student_id);
        $student_batchs = $this->db->get('student_batch')->result();
        $expected_batches = array();
        foreach ($student_batchs as $student_batch) {
            $expected_batches[] = $student_batch->batch;
        }

        return $expected_batches;
    }

    function getStudentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('student');
        return $query->row();
    }

    function getStudentByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student', 50, $data_range_1);
        return $query->result();
    }

    function getStudentByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student', 1, $data_range_1);
        return $query->result();
    }

    function updateStudent($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('student', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('student');
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

    function getStudentBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('email', $search);
        $query = $this->db->get('student');
        return $query->result();
    }

    function getStudentByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('student');
        return $query->result();
    }

    function getStudentByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('name', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('email', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('student');
        return $query->result();
    }

    function getstudents($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("id ", $searchTerm);
            $this->db->or_where("name like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('student');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('student');
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

    function getStudentFeedback($student) {
        $this->db->where("student",$student);
        $result = $this->db->get('student_lead');
        return $result->result_array();
        
    }
}
