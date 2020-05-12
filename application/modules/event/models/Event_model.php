<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertEvent($data) {
        $this->db->insert('event', $data);
    }

    function getEvent() {
        $query = $this->db->get('event');
        return $query->result();
    }

    function getEventForCalendar() {
        $query = $this->db->get('event');
        return $query->result();
    }

    function getEventById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('event');
        return $query->row();
    }

    function getEventByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('event', 50, $data_range_1);
        return $query->result();
    }

    function getEventByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('event', 1, $data_range_1);
        return $query->result();
    }

    function updateEvent($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('event', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('event');
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

    function getEventBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('title', $search);
        $this->db->or_like('start', $search);
        $this->db->or_like('end', $search);
        $query = $this->db->get('event');
        return $query->result();
    }

    function getEventByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('event');
        return $query->result();
    }

    function getEventByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('title', $search);
        $this->db->or_like('start', $search);
        $this->db->or_like('end', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('event');
        return $query->result();
    }

}
