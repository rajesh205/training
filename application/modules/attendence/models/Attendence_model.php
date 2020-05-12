<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendence_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertAttendence($data) {
        $this->db->insert('attendence', $data);
    }

    function getAttendence() {
        $query = $this->db->get('attendence');
        return $query->result();
    }

    function getAttendenceById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('attendence');
        return $query->row();
    }

    function getAttendenceByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('attendence', 50, $data_range_1);
        return $query->result();
    }

    function getAttendenceByBatch($batch) {
        $this->db->where('batch', $batch);
        $query = $this->db->get('attendence');
        return $query->result();
    }
    
    function getOfficeLogByIonUserId($user) {
        $this->db->where('user', $user);
        $query = $this->db->get('office_log');
        return $query->result();
    }

    function insertOfficeLog($data) {
        $this->db->insert('office_log', $data);
    }

    function updateOfficeLog($data) {
        $user = $this->ion_auth->get_user_id();
        $date = date('d-m-y');
        $this->db->where('user', $user);
        $query = $this->db->get('office_log');
        $logs = $query->result();

        $sign_in_time = 0;
        foreach ($logs as $log) {
            if ($date == date('d-m-y', $log->sign_in_time)) {
                $sign_in_time = $log->sign_in_time;
            }
        }
        $this->db->where('sign_in_time', $sign_in_time);
        $this->db->update('office_log', $data);
    }

    function checkSingedIn() {
        $user = $this->ion_auth->get_user_id();
        $date = date('d-m-y');
        $this->db->where('user', $user);
        $query = $this->db->get('office_log');
        $logs = $query->result();

        $sign_in_time = 0;
        foreach ($logs as $log) {
            if ($date == date('d-m-y', $log->sign_in_time)) {
                $sign_in_time = $log->sign_in_time;
            }
        }
        return $sign_in_time;
    }
    
    function checkSignedOut() {
        $user = $this->ion_auth->get_user_id();
        $date = date('d-m-y');
        $this->db->where('user', $user);
        $query = $this->db->get('office_log');
        $logs = $query->result();

        $sign_out_time = 0;
        foreach ($logs as $log) {
            if ($date == date('d-m-y', (int)$log->sign_out_time)) {
                $sign_out_time = $log->sign_out_time;
            }
        }
        return $sign_out_time;
    }

    function getAttendenceByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('attendence', 1, $data_range_1);
        return $query->result();
    }

    function updateAttendence($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('attendence', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('attendence');
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

}
