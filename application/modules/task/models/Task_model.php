<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Task_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertTask($data) {
        $this->db->insert('task', $data);
    }

    function getTask() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskByStatus($status) {
        $this->db->where('status', $status);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('task');
        return $query->row();
    }

    function taskAssignedByUser($user) {
        $this->db->where('requested_by', $user);
        $query = $this->db->get('task');
        return $query->result();
    }

    function taskAssignedForUser($user) {
        $this->db->where('requested_for', $user);
        $query = $this->db->get('task');
        return $query->result();
    }

    function updateTask($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('task', $data);
    }

    function insertTaskCategory($data) {

        $this->db->insert('task_category', $data);
    }

    function getTaskCategory() {
        $query = $this->db->get('task_category');
        return $query->result();
    }

    function getTaskCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('task_category');
        return $query->row();
    }

    function updateTaskCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('task_category', $data);
    }

    function deleteTask($id) {
        $this->db->where('id', $id);
        $this->db->delete('task');
    }

    function deleteTaskCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('task_category');
    }

    function getTaskBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('requested_byname', $search);
        $this->db->or_like('requested_forname', $search);
        $this->db->or_like('date', $search);
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('requested_byname', $search);
        $this->db->or_like('requested_forname', $search);
        $this->db->or_like('date', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskBySearchByStatus($status, $search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->where('status', $status);
        $this->db->or_like('requested_byname', $search);
        $this->db->or_like('requested_forname', $search);
        $this->db->or_like('date', $search);
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskByLimitByStatus($status, $limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $this->db->limit($limit, $start);
        $query = $this->db->get('task');
        return $query->result();
    }

    function getTaskByLimitBySearchByStatus($status, $limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');
        $this->db->where('status', $status);
        $this->db->or_like('requested_byname', $search);
        $this->db->or_like('requested_forname', $search);
        $this->db->or_like('date', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('task');
        return $query->result();
    }

}
