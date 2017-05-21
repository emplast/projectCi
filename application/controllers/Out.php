<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logout
 *
 * @author emplast
 */
class Out extends CI_Controller{
    
    public function index(){
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        if(!empty($this->session->userdata('name'))){
        $login=null;
        $dane = array('naglowek'=>NULL,'tytul' => 'Witamy w wypożyczalni samochodów', 'name' =>$login,'admin'=>'Wynajem samochodów');
        $this->load->view('header',$dane);
        $data = array('tresc' => 'Poprawne wylogowanie ze strony', 'tytul' => 'Żegnamy w naszej wypożyczalni samochodów');
        $this->session->set_userdata('name', null);
        $this->session->set_userdata('admin', null);
        $this->session->set_userdata('zalogowany',NULL);
        $this->load->view('out',$data);
        $this->load->view('footer');
        
        
        }else{
            redirect('index.php/Aplikacja/index');
        }
    }
    
}
