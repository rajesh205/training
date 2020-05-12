<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function required() {
    $CI = & get_instance();

    $CI->load->library('session');


    $CI->load->library('form_validation');
    $CI->load->library('upload');

    $CI->load->library('Ion_auth');

    $CI->language = $CI->db->get('settings')->row()->language;
    $CI->lang->load('system_syntax', $CI->language); #

    $CI->load->model('sms/sms_model');
    $CI->load->model('email/email_model');
    $CI->load->model('settings/settings_model');
    $CI->load->model('ion_auth_model');
    $CI->load->library('parser');
    $CI->load->helper('security');
}
