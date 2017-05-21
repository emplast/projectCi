<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of strona
 *
 * @author emplast
 */
class DodajStronePanel extends CI_Controller {

    public function index() {

        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('addPanelSide_model');
        $this->load->model('panel_model');
        $this->form_validation->set_rules('part_1', 'numer_strony', 'numeric');
        $this->form_validation->set_rules('part_2', 'numer_panelu', 'numeric');
        $input = $this->input->cookie('numer_7');
        $input_1 = $this->input->cookie('numer_8');
        $formularz=new Panel_model();



        if ($this->form_validation->run() != FALSE) {


            $zapisz = $this->sprawdzenieDodania();

            if (empty($this->session->userdata->name)) {
                $login = NULL;
            } else {
                $login = $this->session->userdata->name;
            }
            $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $data = array('input' => $input, 'input_1' => $input_1, 'tytul' => 'Panel administracyjny', 'opis' => $formularz->edycja()['opis'], 'naglowek_zdjecia' => $formularz->edycja()['naglowek'], 'url' => null, 'photo' => $formularz->edycja()['photo'], 'zapisano' => $zapisz);
            $this->load->view('adminPanel', $data);
            $this->load->view('footerAdmin');
            
        } else {

            if (empty($this->session->userdata->name)) {
                $login = NULL;
            } else {
                $login = $this->session->userdata->name;
            }
            $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $data = array('input' => $input, 'input_1' => $input_1, 'tytul' => 'Panel administracyjny', 'opis' => $formularz->edycja()['opis'], 'naglowek_zdjecia' => $formularz->edycja()['naglowek'], 'url' => null, 'photo' => $formularz->edycja()['photo'], 'zapisano' =>$zapisz);
            $this->load->view('adminPanel', $data);
            $this->load->view('footerAdmin');
            
        }
    }

    public function sprawdzenieDodania() {
        $this->load->model('addPanelSide_model');
        $formularz = new AddPanelSide_model();

        if ($formularz->sprawdzenieDodajStrone()['wynik'] == TRUE) {
            $zapisz = 'Udało się dodać strony i panele';
            $formularz->dodajStrone();
            return $zapisz;
        }

        $zapisz = 'Niestety nie udało się dodać strony i paneli';
        return $zapisz;
        
        
    }

}
