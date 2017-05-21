<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usunStrone
 *
 * @author emplast
 */
class UsunStrone extends CI_Controller {
    
    public function index(){
        $this->load->model('panel_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
       
        
        $this->form_validation->set_rules('part_3', 'numer_strony', 'numeric');
        $input=$this->input->cookie('numer_7');
        $input_1=$this->input->cookie('numer_8');
        $formularz= new Panel_model();

        

        if ($this->form_validation->run() != FALSE) {

            
            $zapis=$this->sprawdzenieUsunięcia();
            
           
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
        } else {
            $dane = array('tytul' => 'Panel administracyjny', 'opis' => null, 'naglowek_zdjecia' => null, 'url' => null, 'photo' => '../jpg/01_240_200_p.png', 'zapisano' => 'Zapis do bazy się nie udał');
           
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
    }
    public function sprawdzenieUsunięcia(){
       $this->load->model('panel_model');
       $formularz= new Panel_model();
       if($formularz->deleteStrona()==1){
        $zapis='Strona została usunięta';
          $formularz->delete();
           return $zapis;
       } else{
           $zapis='Nie można usunąć strony ponieważ nie jest ostatnia';
           return $zapis; 
       }
      
       
        
    }



}
