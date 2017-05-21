<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author emplast
 */
class Admin extends CI_Controller {

    public function index() {

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('adminTable_model');
       
        
        $table = new AdminTable_model();

        if ($this->session->userdata('name') == NULL) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        if (!empty($this->session->userdata('admin'))) {
            $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $dane['tytul'] = 'Strona administratora';
            $dane['lista'] = $table->tabelaWynajm();

            $this->load->view('admin', $dane);
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
            $table->deleteRowWynajem($row);
        }
        if ($this->session->userdata('name') == NULL) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        if (!empty($this->session->userdata('admin'))) {
            $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $dane['tytul'] = 'Strona administratora';
            $dane['lista'] = $table->tabelaWynajm();

            $this->load->view('admin', $dane);
            $this->load->view('footerAdmin');
        } else {
            redirect('index.php/Aplikacja/index');
        }
        
        
        }
       
}
