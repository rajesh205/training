<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertCourse($data) {
        $this->db->insert('course', $data);
    }

    function getCourse() {
        $query = $this->db->get('course');
        return $query->result();
    }

    function getCourseById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('course');
        return $query->row();
    }

    function getCourseByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('course', 50, $data_range_1);
        return $query->result();
    }

    function getCourseByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('topic', $key);
        $this->db->or_like('course_id', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('course', 50, $data_range_1);
        return $query->result();
    }

    function updateCourse($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('course', $data);
    }

    function insertCourseMaterial($data) {
        $this->db->insert('course_material', $data);
    }

    function insertBatchMaterial($data) {
        $this->db->insert('batch_material', $data);
    }

    function updateCourseMaterial($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('course_material', $data);
    }

    function getCourseMaterial() {
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function getCourseMaterialById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('course_material');
        return $query->row();
    }

    function getCourseMaterialByCourseId($id) {
        $this->db->where('course', $id);
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('course');
    }

    function deleteCourseMaterial($id) {
        $this->db->where('id', $id);
        $this->db->delete('course_material');
    }

    function deleteBatchMaterial($id) {
        $this->db->where('materialid', $id);
        $this->db->delete('batch_material');
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

    function getCourseMaterialBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('coursename', $search);
        $this->db->or_like('title', $search);
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function getCourseMaterialByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function getCourseMaterialByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->order_by('id', 'desc');
        $this->db->or_like('coursename', $search);
        $this->db->or_like('title', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function getcourses($searchTerm) {
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

    function getBatchesBycourse($searchTerm, $course) {
        if (!empty($searchTerm)) {

            $this->db->select('*');
            $this->db->where('course', $course);
            $this->db->where("batch_id like '%" . $searchTerm . "%' ");

            $fetched_records = $this->db->get('batch');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('course', $course);
            $this->db->limit(2);
            $fetched_records = $this->db->get('batch');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            // $this->db->where('id', $user['course']);
            //  $coursename = $this->db->get('course')->row()->name;
            $data[] = array("id" => $user['id'], "text" => $user['coursename'] . '-' . $user['batch_id']);
        }
        return $data;
    }

    function checkExistMaterialInBatch($batch, $materialid) {
        $this->db->where('batch_id', $batch);
        $this->db->where('materialid', $materialid);
        $materials = $this->db->get('batch_material')->result();
        return $materials;
    }
   function getCourseBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('course_id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('topic', $search);
        $query = $this->db->get('course');
        return $query->result();
    }

    function getCourseByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('course');
        return $query->result();
    }

    function getCourseByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('course_id', $search);
        $this->db->or_like('name', $search);
        $this->db->or_like('topic', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('course');
        return $query->result();
    }

}
