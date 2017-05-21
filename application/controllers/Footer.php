<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of footer
 *
 * @author emplast
 */
class Footer extends CI_Controller {
    
    public function index(){
        $dane=array('id'=>'footer','class'=>'container');
        $this->load->helper('form');
        $this->load->view('footer');
    }
}
