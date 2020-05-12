<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Routine_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertRoutine($data) {
        $this->db->insert('routine', $data);
    }

    function getRoutine() {
        $query = $this->db->get('routine');
        return $query->result();
    }

    function getRoutineById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('routine');
        return $query->row();
    }

    function getRoutineByBatchId($batch) {
        $this->db->where('batch_id', $batch);
        $query = $this->db->get('routine');
        return $query->row();
    }
    
    function deleteRoutineByBatchId($id){
        $this->db->where('batch_id', $id);
        $this->db->delete('routine');
    }

    function getRoutineByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('routine', 50, $data_range_1);
        return $query->result();
    }

    function getRoutineByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('routine', 1, $data_range_1);
        return $query->result();
    }

    function updateRoutine($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('routine', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('routine');
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
    function getRoutineBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
          $this->db->or_like('course', $search);
        $this->db->or_like('batchcode', $search);
        $query = $this->db->get('routine');
        return $query->result();
    }

    function getRoutineByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('routine');
        return $query->result();
    }

    function getRoutineByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('course', $search);
        $this->db->or_like('batchcode', $search);
      


        $this->db->limit($limit, $start);
        $query = $this->db->get('routine');
        return $query->result();
    }
}
