<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of headerAdmin
 *
 * @author emplast
 */
class HeaderAdmin extends CI_Controller {
    
    
    public function index(){
        
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->view('headerAdmin');
    }
}
    
