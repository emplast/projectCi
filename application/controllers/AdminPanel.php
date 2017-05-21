<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminPanel
 *
 * @author emplast
 */
class AdminPanel extends CI_Controller {

    public function index() {
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->helper('cookie');

        $this->load->model('panel_model');
        $formularz = new Panel_model();
        
        $input = $this->input->cookie('numer_7');
        $input_1 = $this->input->cookie('numer_8');
       
        if (empty($input) & empty($input_1)) {

            $this->input->set_cookie('numer_7', 1, 360);
            $this->input->set_cookie('numer_8', 1, 360);
            $input = $this->input->cookie('numer_7');
            $input_1 = $this->input->cookie('numer_8');
        }


        if (empty($this->session->userdata('name'))) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        if(!empty($this->session->userdata('admin'))){
        $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
        $this->load->view('headerAdmin', $dane);
        $this->load->view('menuAdmin');
        $data = array('input' => $input,
                      'input_1' => $input_1,
                      'tytul' => 'Panel administracyjny',
                      'naglowek_zdjecia' => $formularz->wyswietlanie()['naglowek'],
                      'opis' => $formularz->wyswietlanie()['opis'],
                      'cena'=>$formularz->wyswietlanie()['cena'],
                      'kaucja'=>$formularz->wyswietlanie()['kaucja'],
                      'url' => '#', 'photo' => $formularz->wyswietlanie()['photo'],
                      'zapisano' => null);
        $this->load->view('adminPanel', $data);
        $this->load->view('footerAdmin');
        }else{
            redirect('index.php/Aplikacja/index');
        }
        
    }

}
