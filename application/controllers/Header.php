<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of naglowek
 *
 * @author emplast
 */
class Header extends CI_Controller {
    public function index(){
        $this->load->helper('form');
        $this->load->view('header');
    }
    
}
