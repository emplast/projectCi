<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author emplast
 */
class Login extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('login_model');
        $this->load->library('form_validation');
       
        
        
         
        if ($this->session->userdata('name') == null) {
            $login = null;
        } else {
            $login = $this->session->userdata('name');
        }

        $dane = array('naglowek' => NULL, 'tytul' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => 'Wynajem samochodów');
        $this->load->view('header', $dane);
        $data = array('tresc' => 'Witamy w wypożyczalni samochodów');
        $this->load->view('login', $data);
         $this->load->view('footer');
    }
   
}

