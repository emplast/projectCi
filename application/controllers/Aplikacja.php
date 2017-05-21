<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aplicacja
 *
 * @author emplast
 */
class Aplikacja extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('html');
        $this->load->helper('cookie');

        $this->load->model('PanelAplikacja_model');


        $formularz = new PanelAplikacja_model();
        if (!empty($this->session->userdata('zalogowany'))) {

            $login = $this->session->userdata('name');
            $admin = 'Wynajem samochodów';
            if (!empty($this->session->userdata('admin'))) {
                $admin = 'Panel Administracyjny';
            }


            $this->load->view('aplikacja', array('tytul' => 'Witamy w wypożyczalni samochodów'));
            $dane = array('id' => 'header', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => $admin);
            $this->load->view('header', $dane);

            for ($i = 0; $i <= $formularz->daneDoWyswietlenia()['ilosc'] - 1; $i++) {
                $dane = array('id' => $i,
                    'photo' => $formularz->daneDoWyswietlenia()['photo' . $i],
                    'naglowek_zdjecia' => $formularz->daneDoWyswietlenia()['naglowek_zdjecia' . $i],
                    'opis' => $formularz->daneDoWyswietlenia()['opis' . $i],
                    'cena' => $formularz->daneDoWyswietlenia()['cena' . $i],
                    'kaucja' => $formularz->daneDoWyswietlenia()['kaucja' . $i]);
                $this->session->set_userdata('marka_' . $i, $formularz->daneDoWyswietlenia()['naglowek_zdjecia' . $i]);
                $this->session->set_userdata('cena_' . $i, $formularz->daneDoWyswietlenia()['cena' . $i]);
                $this->session->set_userdata('kaucja_' . $i, $formularz->daneDoWyswietlenia()['kaucja' . $i]);
                $this->session->set_userdata('photo_' . $i, $formularz->daneDoWyswietlenia()['photo' . $i]);
                $this->load->view('panel', $dane);
            }

            $dane = array('id' => 'pagination', 'class' => 'container text-center');


            $this->load->view('pagination', $dane);
            $dane = array('id' => 'footer', 'class' => 'container');
            $this->load->view('footer', $dane);
        } else {
            if (!empty($this->session->userdata('zalogowany'))) {
                $login = $this->session->userdata('name');
            } else {
                $login=null;
            }
            $admin = 'Wynajem samochodów';
            $this->load->view('aplikacja', array('tytul' => 'Witamy w wypożyczalni samochodów'));
            $dane = array('id' => 'header', 'tytul' => 'Witamy w wypożyczalni samochodów', 'naglowek' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => $admin);
            $this->load->view('header', $dane);

            for ($i = 0; $i <= $formularz->daneDoWyswietlenia()['ilosc'] - 1; $i++) {
                $dane = array('id' => $i,
                    'photo' => $formularz->daneDoWyswietlenia()['photo' . $i],
                    'naglowek_zdjecia' => $formularz->daneDoWyswietlenia()['naglowek_zdjecia' . $i],
                    'opis' => $formularz->daneDoWyswietlenia()['opis' . $i],
                    'cena' => $formularz->daneDoWyswietlenia()['cena' . $i],
                    'kaucja' => $formularz->daneDoWyswietlenia()['kaucja' . $i]);
                $this->session->set_userdata('marka_' . $i, $formularz->daneDoWyswietlenia()['naglowek_zdjecia' . $i]);
                $this->session->set_userdata('cena_' . $i, $formularz->daneDoWyswietlenia()['cena' . $i]);
                $this->session->set_userdata('kaucja_' . $i, $formularz->daneDoWyswietlenia()['kaucja' . $i]);
                $this->session->set_userdata('photo_' . $i, $formularz->daneDoWyswietlenia()['photo' . $i]);
                $this->load->view('panel', $dane);
            }

            $dane = array('id' => 'pagination', 'class' => 'container text-center');


            $this->load->view('pagination', $dane);
            $dane = array('id' => 'footer', 'class' => 'container');
            $this->load->view('footer', $dane);
        }
    }

}
