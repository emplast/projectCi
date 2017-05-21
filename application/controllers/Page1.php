<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page1
 *
 * @author emplast
 */
class Page1 extends CI_Controller {

    public function index() {
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');

        
        if ($this->session->userdata('name') == null) {
            $login = null;
        } else {
            $login = $this->session->userdata('name');
        }

        $dane = array('naglowek' => NULL, 'tytul' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => 'Wynajem samochodów');
        $this->load->view('header', $dane);
        $dane['tresc'] = 'Dodawanie nowego użytkownika';
        $dane['alert']=null;
        $dane['informacja'] = 'Pola zaznaczone czerwoną gwiazdką są wymagalne';
        $this->load->view('page1', $dane);
        $this->load->view('footer');






    }
    


}
