<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getbatches($searchTerm) {
        if (!empty($searchTerm)) {
            $this->db->select('*');
            $this->db->where("batch_id like '%" . $searchTerm . "%' ");
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
            $fetched_records = $this->db->get('template');
            $users = $fetched_records->result_array();
        } else {
            $this->db->select('*');
            $this->db->limit(2);
            $fetched_records = $this->db->get('template');
            $users = $fetched_records->result_array();
        }
        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['name']);
        }
        return $data;
    }

    function getSmsSettingsById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sms_settings');
        return $query->row();
    }

    function getSmsByUser($user) {
        $this->db->order_by('id', 'desc');
        $this->db->where('user', $user);
        $query = $this->db->get('sms');
        return $query->result();
    }

    function getSmsSettings() {
        $query = $this->db->get('sms_settings');
        return $query->result();
    }

    function getSmsSettingsByGatewayName($name) {
        $this->db->where('name', $name);
        $query = $this->db->get('sms_settings');
        return $query->row();
    }

    function updateSmsSettings($data,$id) {
         $this->db->where('id', $id);
        $this->db->update('sms_settings', $data);
    }

    function addSmsSettings($data) {
        $this->db->insert('sms_settings', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('sms');
    }

    function insertSms($data) {
        $this->db->insert('sms', $data);
    }

    function getSms() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('sms');
        return $query->result();
    }

    function getSmsBySearch($search) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('dateformat', $search);

        $query = $this->db->get('sms');
        return $query->result();
    }

    function getSmsByLimit($limit, $start) {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('sms');
        return $query->result();
    }

    function getSmsByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);

        $this->db->order_by('id', 'desc');

        $this->db->or_like('dateformat', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('sms');
        return $query->result();
    }

    function addTemplate($data) {
        $this->db->insert('template', $data);
    }

    function updateTemplate($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('template', $data);
    }

    function getTemplateById($id, $type) {
        $this->db->where('id', $id);
        $this->db->where('type', $type);
        $query = $this->db->get('template');
        return $query->row();
    }
     function getAutoSmsByType($type) {
        
        $this->db->where('type', $type);
        $query = $this->db->get('autosmstemplate');
        return $query->row();
    }
    function getTemplate($type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateBySearch($search, $type) {
        $this->db->order_by('id', 'desc');
        $this->db->like('id', $search);
        $this->db->or_like('message', $search);
        $this->db->where('type', $type);
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateByLimit($limit, $start, $type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type', $type);
        $this->db->limit($limit, $start);
        $query = $this->db->get('template');
        return $query->result();
    }

    function getTemplateByLimitBySearch($limit, $start, $search, $type) {

        $this->db->like('id', $search);
        $this->db->where('type', $type);
        $this->db->order_by('id', 'desc');

        $this->db->or_like('message', $search);


        $this->db->limit($limit, $start);
        $query = $this->db->get('template');
        return $query->result();
    }

    function deleteTemplate($id) {
        $this->db->where('id', $id);
        $this->db->delete('template');
    }

    function insertTag($data) {
        $this->db->insert('manualemailshortcode', $data);
    }
    function insertAutoTag($data) {
        $this->db->insert('autoemailshortcode', $data);
    }
     function getAutoTag() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('autoshortcode');
        return $query->result();
    }
    function getTag() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('manualshortcode');
        return $query->result();
    }
     function getAutoTemplate() {
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('autosmstemplate');
        return $query->result();
    }

    function getAutoTemplateBySearch($search) {
        $this->db->order_by('id', 'asc');
        $this->db->like('id', $search);
        $this->db->or_like('message', $search);
        $query = $this->db->get('autosmstemplate');
        return $query->result();
    }

    function getAutoTemplateByLimit($limit, $start) {
        $this->db->order_by('id', 'asc');
        $this->db->limit($limit, $start);
        $query = $this->db->get('autosmstemplate');
        return $query->result();
    }

    function getAutoTemplateByLimitBySearch($limit, $start, $search) {

        $this->db->like('id', $search);
        $this->db->order_by('id', 'asc');
        $this->db->or_like('message', $search);
        $this->db->limit($limit, $start);
        $query = $this->db->get('autosmstemplate');
        return $query->result();
    }
       function getAutoTemplateById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('autosmstemplate');
        return $query->row();
    }
    function getAutoTemplateTag($type) {
        $this->db->order_by('id', 'desc');
        $this->db->where('type',$type);
        $query = $this->db->get('autoshortcode');
        return $query->result();
    }
    function updateAutoTemplate($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('autosmstemplate', $data);
    }
}
