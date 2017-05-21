<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formularz
 *
 * @author emplast
 */
class EdytujFormularz extends CI_Controller {

    public function index() {

        $this->load->model('panel_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('panel_model');

        $formularz = new Panel_model();


        $this->form_validation->set_rules('part_6', 'naglowek', 'max_length[1000]');
        $this->form_validation->set_rules('part_9', 'opis_panelu', 'max_length[10000]');
        $input = $this->input->cookie('numer_7');
        $input_1 = $this->input->cookie('numer_8');
        $zapis = $this->sprawdzenieEdycji();


        if ($this->form_validation->run() != FALSE) {




            if (empty($this->session->userdata->name)) {
                $login = NULL;
            } else {
                $login = $this->session->userdata->name;
            }
            $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
            $this->load->view('headerAdmin', $dane);
            $this->load->view('menuAdmin');
            $dane = array( 'input' => $input,
                           'input_1' => $input_1,
                           'tytul' => 'Panel administracyjny',
                           'naglowek_zdjecia' => $formularz->edycja()['naglowek'],
                           'opis' => $formularz->edycja()['opis'],
                           'cena'=>$formularz->edycja()['cena'],
                           'kaucja'=>$formularz->edycja()['kaucja'],
                           'photo' => $formularz->edycja()['photo'],
                           'url' => null,
                           'zapisano' => $zapis);
            $this->load->view('adminPanel', $dane);
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
            $dane = array( 'input' => $input, 'input_1' => $input_1, 'tytul' => 'Panel administracyjny', 'opis' => $formularz->edycja()['opis'], 'naglowek_zdjecia' => $formularz->edycja()['naglowek'], 'url' => null, 'photo' => $formularz->edycja()['photo'], 'zapisano' => null);
            $this->load->view('adminPanel', $dane);
            $this->load->view('footerAdmin');
        }
    }

    public function sprawdzenieEdycji() {
        $formularz = new Panel_model();

        if ($formularz->edycja()['wynik'] == 1) {

            $formularz->edycjaPaneluZapisz();
            $zapis = 'Edycja stron i paneli się powiodła';
        } else {
            $zapis = 'Niestety nie udało się edytować paneli i stron';
        }

        return $zapis;
    }

    public function wyswietlanie() {
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('url');


        $this->load->model('panel_model');
        $formularz = new Panel_model();

        $input = $this->input->post('part_7');
        $input_1 = $this->input->post('part_8');
        $cookie_7 = $this->input->set_cookie('numer_7', $input, 3600);
        $cookie_8 = $this->input->set_cookie('numer_8', $input_1, 3600);


        if (empty($this->session->userdata('name'))) {
            $login = NULL;
        } else {
            $login = $this->session->userdata('name');
        }
        $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
        $this->load->view('headerAdmin', $dane);
        $this->load->view('menuAdmin');
        $data = array('input' => $input, 'input_1' => $input_1, 'tytul' => 'Panel administracyjny', 'opis' => $formularz->wyswietlanie()['opis'], 'naglowek_zdjecia' => $formularz->wyswietlanie()['naglowek'], 'url' => '#', 'photo' => $formularz->wyswietlanie()['photo'], 'zapisano' => null);
        $this->load->view('adminPanel', $data);
        $this->load->view('footerAdmin');

        redirect('index.php/AdminPanel/index');
    }

    public function upload() {
        $config['upload_path'] = './jpg/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '350';
        $config['max_height'] = '300';

        $this->load->library('upload', $config);
        $this->upload->do_upload();
        $data = array('upload_data' => $this->upload->data());
        $this->input->set_cookie('plik', $this->upload->data()['file_name'], 36);

        $this->load->helper('form');
        $this->load->library('session');
        $this->load->helper('url');


        $this->load->model('panel_model');
        $formularz = new Panel_model();

        $input = $this->input->cookie('numer_7');
        $input_1 = $this->input->cookie('numer_8');


        if (empty($this->session->userdata->name)) {
            $login = NULL;
        } else {
            $login = $this->session->userdata->name;
        }
        $dane = array('id' => 'header', 'class' => 'container', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => null, 'name' => $login);
        $this->load->view('headerAdmin', $dane);
        $this->load->view('menuAdmin');
         $data = array( 'input' => $input,
                           'input_1' => $input_1,
                           'tytul' => 'Panel administracyjny',
                           'naglowek_zdjecia' => $formularz->edycja()['naglowek'],
                           'opis' => $formularz->edycja()['opis'],
                           'cena'=>$formularz->edycja()['cena'],
                           'kaucja'=>$formularz->edycja()['kaucja'],
                           'photo' => $formularz->edycja()['photo'],
                           'url' => null,
                           'zapisano' => 'Udało się pobrać pliki');
        $this->load->view('adminPanel', $data);
        $this->load->view('footerAdmin');
       // redirect('edytujFormularz/index');
    }

}
