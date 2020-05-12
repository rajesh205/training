<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getEmailSettingsById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('email_settings');
        return $query->row();
    }

    function getEmailByUser($user) {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $user);
        $query = $this->db->get('email');
        return $query->result();
    }

    function getEmailSettings() {
        $query = $this->db->get('email_settings');
        return $query->row();
    }
     function getAutoEmailByType($type) {
        
        $this->db->where('type', $type);
        $query = $this->db->get('autoemailtemplate');
        return $query->row();
    }

    function updateEmailSettings($data) {
        $this->db->update('email_settings', $data);
    }

    function addEmailSettings($data) {
        $this->db->insert('email_settings', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('email');
    }

    function insertEmail($data) {
        $this->db->insert('email', $data);
    }

    function getEmail() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('email');
        return $query->result();
    }

    function getstudents($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('student');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
            $this->db->limit(2);
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

    function getbatches($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
             $this->db->where("coursename like '%" . $searchTerm . "%' ");
            $this->db->or_where("batch_id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('batch');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('batch');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $this->db->where('id', $user['course']);
            $coursename = $this->db->get('course')->row()->name;
            $data[] = array("id" => $user['id'], "text" => $coursename . '-' . $user['batch_id']);
        }
        return $data;
    }

    function getinstructors($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->or_where("id like '%" . $searchTerm . "%' ");
            $fetched_records = $this->db->get('instructor');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            // $this->db->where("name like '%".$searchTerm."%' ");
            //  $this->db->or_where("id like '%".$searchTerm."%' ");
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

    function gettemplates($searchTerm, $type) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("name like '%" . $searchTerm . "%' ");
            $this->db->where('type', $type);
            $fetched_records = $this->db->get('email_template');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('email_template');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name']);
        }
        return $data;
    }

    function getTag() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('manualemailshortcode');
        return $query->result();
    }

    function getAutoTemplate() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('autoemailtemplate');
        return $query->result();
    }

    function getAutoTemplateBySearch($search) {
        $this->db->order_by('id', 'asc');
        $this->db->like('id', $search);
        $this->db->or_like('message', $search);
        $query = $this->db->get('autoemailtemplate');
        return $query->result();
    }

    function getAutoTemplateByLimit($limit, $start) {
        $this->db->order_by('id', 'asc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('autoemailtemplate');
        return $query->result();
    }

    function getAutoTemplateByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->order_by('id', 'asc');
        $this->db->or_like('message', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('autoemailtemplate');
        return $query->result();
    }

    function getAutoTemplateById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('autoemailtemplate');
        return $query->row();
    }

    function getAutoTemplateTag($type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $query = $this->db->get('autoemailshortcode');
        return $query->result();
    }

    function updateAutoTemplate($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('autoemailtemplate', $data);
    }

    function getTemplateById($id, $type) {
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $query = $this->db->get('email_template');
        return $query->row();
    }

    function addTemplate($data) {
        $this->db->insert('email_template', $data);
    }

    function updateTemplate($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('email_template', $data);
    }

    function getTemplate($type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $query = $this->db->get('email_template');
        return $query->result();
    }

    function getTemplateBySearch($search, $type) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('message', $search);
        $this->db->where('type', $type);
        $query = $this->db->get('email_template');
        return $query->result();
    }

    function getTemplateByLimit($limit, $start, $type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $this->db->limit($limit, $start);
        $query = $this->db->get('email_template');
        return $query->result();
    }

    function getTemplateByLimitBySearch($limit, $start, $search, $type) {

        $this->db->like('id', $search);
        $this->db->where('type', $type);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('message', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('email_template');
        return $query->result();
    }

    function deleteTemplate($id) {
        $this->db->where('id', $id);
        $this->db->delete('email_template');
    }
   

    function getEmailBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('dateformat', $search);

        $query = $this->db->get('email');
        return $query->result();
    }

    function getEmailByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('email');
        return $query->result();
    }

    function getEmailByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('dateformat', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('email');
        return $query->result();
    }
}
