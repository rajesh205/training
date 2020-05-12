<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend_model extends CI_model {
    function __construct() {
        parent::__construct();
    }
    
    function getInfo() {
        $this->db->where('id',1);
        $query = $this->db->get('frontend')->row();
        return $query;
    }
    
    function getWebsite() {
        $this->db->where('id',1);
        $query = $this->db->get('website')->row();
        return $query;
    }
    
    function editSite($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('website',$data);
    }
}