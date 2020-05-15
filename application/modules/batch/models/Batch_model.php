<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Batch_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertBatch($data) {
        $this->db->insert('batch', $data);
    }

    function getBatch() {
        $query = $this->db->get('batch');
        return $query->result();
    }

    function getBatchById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('batch');
        return $query->row();
    }

    function getBatchByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('batch', 50, $data_range_1);
        return $query->result();
    }

    function getBatchQuantityByCourseId($course_id) {
        $this->db->where('course', $course_id);
        $query = $this->db->get('batch')->result();
        $i = 0;
        foreach ($query as $batch) {
            if ($batch->course == $course_id) {
                $i = $i + 1;
            }
        }

        return $i;
    }

    function checkExistInBatch($batch_id, $student_id) {
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);
        $student_batchs = $this->db->get('student_batch')->result();
        return $student_batchs;
    }

    function getBatchByCourseId($course_id) {
        $this->db->where('course', $course_id);
        $query = $this->db->get('batch')->result();
        return $query;
    }

    function getCourseByBatchId($batch_id) {
        $this->db->where('id', $batch_id);
        $query = $this->db->get('batch')->row();
        return $query;
    }

    function getBatchByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('batch_id', $key);
        $this->db->or_like('course', $key);
        $this->db->or_like('instructor', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('batch', 1, $data_range_1);
        return $query->result();
    }

    function insertStudentToBatch($data) {
        $this->db->insert('student_batch', $data);
    }

    function getStudentsByBatchId($batch_id) {
        $this->db->where('batch', $batch_id);
        $student_batchs = $this->db->get('student_batch')->result();
        $expected_students = array();
        foreach ($student_batchs as $student_batch) {
            $expected_students[] = $student_batch->student;
        }

        return $expected_students;
    }

    function getStudentsNumberByBatchId($batch_id) {
        $this->db->where('batch', $batch_id);
        $student_batchs = $this->db->get('student_batch')->result();
        $expected_students = array();
        $i = 0;
        foreach ($student_batchs as $student_batch) {
            $this->db->where('id', $student_batch->student);
            $student = $this->db->get('student')->result();
            if (!empty($student)) {
                $expected_students[] = $student_batch->student;
                $i = $i + 1;
            }
        }

        return $i;
    }

    function updateBatch($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('batch', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('batch');
    }

    function deleteStudentFromBatch($student_id, $batch_id) {
        $this->db->where('student', $student_id);
        $this->db->where('batch', $batch_id);
        $this->db->delete('student_batch');
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

    function getBatchBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('coursename', $search);
        $this->db->or_like('instructorname', $search);
        $this->db->or_like('batch_id', $search);
        $query = $this->db->get('batch');
        return $query->result();
    }

    function getBatchByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('batch');
        return $query->result();
    }

    function getBatchByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->order_by('id', 'desc');
        $this->db->or_like('coursename', $search);
        $this->db->or_like('instructorname', $search);
        $this->db->or_like('batch_id', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('batch');
        return $query->result();
    }

    function getCourses($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("course_id like '%" . $searchTerm . "%' ");
            $this->db->or_where("name like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('course');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('course');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            // $this->db->where('id', $user['course']);
            //  $coursename = $this->db->get('course')->row()->name;
            $data[] = array("id" => $user['id'], "text" => $user['name'] . '-' . $user['course_id']);
        }
        return $data;
    }

    function getInstructors($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('instructor');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('instructor');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . '-' . $user['id']);
        }
        return $data;
    }

    function getStudents($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('student');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(10);
            $fetched_records = $this->db->get('student');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name'] . '-' . $user['id']);
        }
        return $data;
    }

    function getBatchMaterialBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('coursename', $search);
        $this->db->or_like('batchname', $search);
        $query = $this->db->get('batch_material');
        return $query->result();
    }

    function getBatchMaterialByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('batch_material');
        return $query->result();
    }

    function getBatchMaterialByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->order_by('id', 'desc');
        $this->db->or_like('coursename', $search);
        $this->db->or_like('batchname', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('batch_material');
        return $query->result();
    }

    function getBatchMaterial() {
        $query = $this->db->get('batch_material');
        return $query->result();
    }

    function deleteBatchMaterial($id) {
        $this->db->where('id', $id);
        $this->db->delete('batch_material');
    }

    function getBatchMaterialByBatchId($id) {
        $this->db->where('batch_id', $id);
        $query = $this->db->get('batch_material');
        return $query->result();
    }

    function getBatchMaterialById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('batch_material');
        return $query->row();
    }

    function getOngoingBatch() {
        $this->db->select('*');
        $this->db->from('batch');
        $this->db->where('end_date >=', time());
        $this->db->where('start_date <=', time());
        $query = $this->db->get();
        return $query->result();
    }
    
    function getStudentsByBatch($batch_id) {
        $this->db->select("s.name, s.phone,s.id");
        $this->db->from("student s");
        $this->db->join("student_batch sb", "sb.student = s.id");
        $this->db->where("sb.batch", $batch_id);
        $students = $this->db->get();
        return $students->result_array();
    }    
    
    function insertBatchReport($data) {
        $this->db->insert('batch_reports', $data);
    }

    function getBatchReport($from='', $to='') {
         $this->db->select('*');
        $this->db->from('batch_reports');
        if(!empty($from) && !empty($to)) {
            $this->db->where("date between '".$from."' and '".$to."'");
        }
        $query = $this->db->get();
        return $query->result();
    }

    function getCourseByBatch($batch_id) {
        $this->db->select("c.name,c.id,b.course");
        $this->db->from("course c");
       $this->db->join('batch b',"b.course=c.id");
       $this->db->where("b.batch_id",$batch_id);
       $result = $this->db->get();
        return $result->result_array();
    }

}
