<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sprawdzenie
 *
 * @author emplast
 */
class Sprawdzenie extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->form_validation->set_rules('login', 'Username', 'required', 'trim|required|min_length[5]|max_length[12]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required', 'trim|required|md5');


        $login = $this->db->query('SELECT count(id) AS IloscUzytkownikow FROM login WHERE'
                . ' name = "' . $this->db->escape_str($this->input->post('login')) . '"AND'
                . '  password = "' . $this->db->escape_str(md5($this->input->post('password'))) . '"');

        if ($this->form_validation->run() != FALSE) {
            

            foreach ($login->result() as $Wiersz) {
                $IloscUzytkownikow = $Wiersz->IloscUzytkownikow;
            }
            if ($IloscUzytkownikow > 0) {
                $this->session->set_userdata('zalogowany', '*)(*');
                $this->session->set_userdata('name', $this->input->post('login'));
                if(strcmp($this->input->post('login'),'admin')==0& strcmp(md5($this->input->post('password')),md5('admin123'))==0){
                     $this->session->set_userdata('admin', '+)(+');
                    redirect('index.php/Aplikacja/index');
                }
                                 
                redirect('index.php/Aplikacja/index');
            } else {
                
                redirect('index.php/Login/index');
            }
        }
        else{
           
            
           redirect('login/index');
        }
    }

}
