<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kontakt
 *
 * @author emplast
 */
class Kontakt extends CI_Controller{
    public function index(){
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
       
        
         if($this->session->userdata('name')==null){
            $login=null;
            
        }else{
            $login=$this->session->userdata('name');
        }
        
        $dane = array('naglowek'=>NULL,'tytul' => 'Witamy w wypożyczalni samochodów', 'name' =>$login,'admin'=>'Wynajem samochodów');
        $this->load->view('header',$dane);
        $dane=array('tresc'=>NULL);
        $this->load->view('kontakt',$dane);
        $this->load->view('footer');
        
    }
   
}
