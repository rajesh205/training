<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertNotice($data) {
        $this->db->insert('notice', $data);
    }

    function getNotice() {
        $query = $this->db->get('notice');
        return $query->result();
    }

    function getNoticeById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('notice');
        return $query->row();
    }

    function getNoticeByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('notice', 50, $data_range_1);
        return $query->result();
    }

    function getNoticeByBatch($batch) {
        $this->db->where('batch', $batch);
        $query = $this->db->get('notice');
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

    function getNoticeByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('title', $key);
        $this->db->or_like('description', $key);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('notice', 1, $data_range_1);
        return $query->result();
    }

    function updateNotice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('notice', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('notice');
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
     function getNoticeBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('title', $search);
        $this->db->or_like('adddate', $search);
        $query = $this->db->get('notice');
        return $query->result();
    }

    function getNoticeByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('notice');
        return $query->result();
    }

    function getNoticeByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('title', $search);
        $this->db->or_like('adddate', $search);
       


        $this->db->limit($limit, $start);
        $query = $this->db->get('notice');
        return $query->result();
    }
}
