<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Walidacja extends CI_Controller {

    function index() {
        $this->load->helper('url');
        $this->load->model('walidacja_model');
        $this->load->library('form_validation');
        $formularz= new Walidacja_model();

        $this->form_validation->set_rules('login', 'login', 'required', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required', 'trim|required | min_length[5]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('imie', 'Imie', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('nazwisko', 'Nazwisko', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('miejscowosc', 'Miejscowosc', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('kod', 'Kod', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('ulica', 'Ulica', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('nr_domu', 'Nr domu', 'required', 'required|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            if ($this->session->userdata('name') == null) {
                $login = null;
            } else {
                $login = $this->session->userdata('name');
            }

            $dane = array('naglowek' => NULL, 'tytul' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => 'Wynajem samochodów');
            $this->load->view('header', $dane);
            $dane['tresc'] = 'Dodawanie nowego użytkownika';
            $dane['tytul'] = 'Witamy w wypożyczalni samochodów';
            $dane['alert']=null;
            $dane['informacja'] = 'Pola zaznaczone czerwoną gwiazdką są wymagalne';
            $this->load->view('page1', $dane);
            $this->load->view('footer');
        } else {

            if($formularz->sprawdzenieNowyUrzytkownik()!=0){
            $this->session->set_userdata('name', $this->input->post('login'));
            $this->session->set_userdata('zalogowany', '*)(*');
             redirect('index.php/Aplikacja/index');
                
            }
            else{
           
            $formularz->zapiszNowyUzytkownik();
            $this->session->set_userdata('name', $this->input->post('login'));
            $this->session->set_userdata('zalogowany', '*)(*');
            redirect('index.php/Aplikacja/index');
            }
        }
    }

    

}
