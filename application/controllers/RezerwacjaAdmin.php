<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RezerwacjaAdmin
 *
 * @author emplast
 */
class RezerwacjaAdmin extends CI_Controller {

    public function index() {

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('adminTable_model');
        $this->load->helper('url');

        $table = new AdminTable_model();

        if ($this->session->userdata('name') == NULL) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        if (!empty($this->session->userdata('admin'))) {
            $dane = array('tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $dane['tytul'] = 'Strona administratora';
            $dane['lista'] = $table->tabelaRezerwacja();

            $this->load->view('rezerwacjaAdmin', $dane);
            $this->load->view('footerAdmin');
        } else {
            redirect('index.php/Aplikacja/index');
        }
    }
    
     public function delete(){
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('adminTable_model');
       
        $table = new AdminTable_model();
        
        
        if(!empty($this->uri->segment(3))){
            $row= $this->uri->segment(3);
            $table->deleteRowRezerwacja($row);
        }
        if ($this->session->userdata('name') == NULL) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        if (!empty($this->session->userdata('admin'))) {
            
            $dane = array(  'naglowek' => 'Samochody zarezerwowane', 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $dane['tytul'] = 'Strona administratora';
            $dane['lista'] = $table->tabelaRezerwacja();
            $this->load->view('rezerwacjaAdmin', $dane);
            
            $this->load->view('footerAdmin');
        } else {
            redirect('index.php/Aplikacja/index');
        }
        
        
        }
       
    

}
