<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deletePanel
 *
 * @author emplast
 */
class deletePanel extends CI_Controller {
   
    public function index(){
         $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('panel_model');
        $this->load->model('deletePanel_model');
        $formularz = new Panel_model();
        
        $input = $this->input->post('part_7');
        $input_1 = $this->input->post('part_8');
        if (empty($input) & empty($input_1)) {

            
            $input = $this->input->cookie('numer_7');
            $input_1 = $this->input->cookie('numer_8');
        }
        $zapis=$this->sprawdzenieUsunieciaPanelu();


        if (empty($this->session->userdata->name)) {
            $login = NULL;
        } else {
            $login = $this->session->userdata->name;
        }
        $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
        $this->load->view('headerAdmin', $dane);
        $this->load->view('menuAdmin');
        $data = array('input' => $input, 'input_1' => $input_1, 'tytul' => 'Panel administracyjny', 'opis' => $formularz->wyswietlanie()['opis'], 'naglowek_zdjecia' => $formularz->wyswietlanie()['naglowek'], 'url' => '#', 'photo' => $formularz->wyswietlanie()['photo'], 'zapisano' => $zapis);
        $this->load->view('adminPanel', $data);
        $this->load->view('footerAdmin');
        
        
        
    }
    public function sprawdzenieUsunieciaPanelu(){
        $formularz= new DeletePanel_model();
        if($formularz->sprawdzenieEdycji()==1){
           
            $zapis='Udało się edytować panele na stronie';
                  
        }else{
            $zapis='Niestety edycja paneli na stronie się nie powiodla';
        }
        return $zapis;
        
    }
}
