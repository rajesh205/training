<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pgateway_model extends CI_model {
    public function __construct() {
        parent::__construct();
    }
    
    function getGateway() {
        $query = $this->db->get('pgateway');
        return $query->result();
    } 
    
    function getGatewayById($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('pgateway')->row();
        return $query;
    } 
    
    function updateSetting($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('pgateway',$data);
    } 
    
    function updateGateway($data) {
        $this->db->where('id',1);
        $this->db->update('settings',$data);
    }
}
