<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page
 *
 * @author emplast
 */
class Page extends CI_Controller {

    public function index($data) {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');
        $_POST['wartosc'] = null;
        $_POST['dni'] = null;

        if ($this->session->userdata('name') == null) {
            $login = null;
        } else {
            $login = $this->session->userdata('name');
        }
        $dane = array('naglowek' => null, 'tytul' => 'Witamy w wypożyczalni samochodów', 'name' => $login, 'admin' => 'Wynajem samochodów');
        $this->load->view('header', $dane);
        $dane = array('photo' => $data['photo'],
            'marka' => $data['marka'],
            'cena' => $data['cena'],
            'kaucja' => $data['kaucja'],
            'wynajem' => $data['wynajem'],
            'alert' => $data['alert'],
            'wartosc' => $_POST['wartosc'],
            'dni' => $_POST['dni'],
            'form' => $data['form']);
        $this->load->view('page', $dane);
        $this->load->view('footer');
    }

    public function date_valid() {
        $date = $this->input->post('start');
        $date_1 = $this->input->post('end');
        $parts = explode("/", $date);
        $parts_1 = explode("/", $date_1);
        if (count($parts) == 3 & count($parts_1) == 3 & date('y') <= $parts[2] & date('m') <= $parts[1] & date('d') <= $parts[0]) {
            if ($parts[0] < $parts_1[0] & $parts[1] <= $parts_1[1] & $parts[2] <= $parts_1[2]) {
                return true;
            }
        }


        return false;
    }

    public function sprawdzenieFormularza() {
        $this->load->library('form_validation');
        if (empty($this->session->userdata('zalogowany'))) {
            $this->form_validation->set_rules('imie', 'Imie', 'required', 'trim|required|min_length[5]|max_length[100]');
            $this->form_validation->set_rules('nazwisko', 'nazwisko', 'required', 'trim|required|min_lenght[5]|max_length[100]');
            $this->form_validation->set_rules('miejscowosc', 'miejscowosc', 'required', 'trim|required|min_lenght[5]|max_length[100]');
            $this->form_validation->set_rules('kod', 'kod', 'required', 'trim|required|min_lenght[5]|max_length[100]');
            $this->form_validation->set_rules('ulica', 'nazwisko', 'required', 'trim|required|min_lenght[5]|max_length[100]');
            $this->form_validation->set_rules('nr_domu', 'nr_domu', 'required', 'trim|required|min_lenght[1]|max_length[100]');
            $this->form_validation->set_rules('email', 'email', 'required', 'trim|required|min_lenght[3]|max_length[100]');
            if ($this->form_validation->run() != FALSE) {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function A0() {
        $data = array('photo' => $this->session->userdata('photo_0'),
            'marka' => $this->session->userdata('marka_0'),
            'cena' => $this->session->userdata('cena_0'),
            'kaucja' => $this->session->userdata('kaucja_0'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C0');
        $this->session->set_userdata('numer_zamowienia', 'A0');
        $this->index($data);
    }

    public function B0() {
        $data = array('photo' => $this->session->userdata('photo_0'),
            'marka' => $this->session->userdata('marka_0'),
            'cena' => $this->session->userdata('cena_0'),
            'kaucja' => $this->session->userdata('kaucja_0'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D0');
        $this->session->set_userdata('numer_zamowienia', 'B0');
        $this->index($data);
    }

    public function C0() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_0'),
                    'marka' => $this->session->userdata('marka_0'),
                    'cena' => $this->session->userdata('cena_0'),
                    'kaucja' => $this->session->userdata('kaucja_0'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C0');
                $this->session->set_userdata('numer_zamowienia', 'A0');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_0'),
                'marka' => $this->session->userdata('marka_0'),
                'cena' => $this->session->userdata('cena_0'),
                'kaucja' => $this->session->userdata('kaucja_0'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C0');
            $this->session->set_userdata('numer_zamowienia', 'A0');
            $this->index($data);
        }
    }

    public function D0() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();

        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_0'),
                    'marka' => $this->session->userdata('marka_0'),
                    'cena' => $this->session->userdata('cena_0'),
                    'kaucja' => $this->session->userdata('kaucja_0'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D0');
                $this->session->set_userdata('numer_zamowienia', 'B0');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_0'),
                'marka' => $this->session->userdata('marka_0'),
                'cena' => $this->session->userdata('cena_0'),
                'kaucja' => $this->session->userdata('kaucja_0'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D0');
            $this->session->set_userdata('numer_zamowienia', 'B0');
            $this->index($data);
        }
    }

    public function A1() {

        $data = array('photo' => $this->session->userdata('photo_1'),
            'marka' => $this->session->userdata('marka_1'),
            'cena' => $this->session->userdata('cena_1'),
            'kaucja' => $this->session->userdata('kaucja_1'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C1');
        $this->session->set_userdata('numer_zamowienia', 'A1');
        $this->index($data);
    }

    public function B1() {
        $data = array('photo' => $this->session->userdata('photo_1'),
            'marka' => $this->session->userdata('marka_1'),
            'cena' => $this->session->userdata('cena_1'),
            'kaucja' => $this->session->userdata('kaucja_1'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D1');
        $this->session->set_userdata('numer_zamowienia', 'B1');
        $this->index($data);
    }

    public function C1() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_1'),
                    'marka' => $this->session->userdata('marka_1'),
                    'cena' => $this->session->userdata('cena_1'),
                    'kaucja' => $this->session->userdata('kaucja_1'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C1');
                $this->session->set_userdata('numer_zamowienia', 'A1');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_1'),
                'marka' => $this->session->userdata('marka_1'),
                'cena' => $this->session->userdata('cena_1'),
                'kaucja' => $this->session->userdata('kaucja_1'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C1');
            $this->session->set_userdata('numer_zamowienia', 'A1');
            $this->index($data);
        }
    }

    public function D1() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_1'),
                    'marka' => $this->session->userdata('marka_1'),
                    'cena' => $this->session->userdata('cena_1'),
                    'kaucja' => $this->session->userdata('kaucja_1'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D1');
                $this->session->set_userdata('numer_zamowienia', 'B1');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_1'),
                'marka' => $this->session->userdata('marka_1'),
                'cena' => $this->session->userdata('cena_1'),
                'kaucja' => $this->session->userdata('kaucja_1'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D1');
            $this->session->set_userdata('numer_zamowienia', 'B1');
            $this->index($data);
        }
    }

    public function A2() {
        $data = array('photo' => $this->session->userdata('photo_2'),
            'marka' => $this->session->userdata('marka_2'),
            'cena' => $this->session->userdata('cena_2'),
            'kaucja' => $this->session->userdata('kaucja_2'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C2');
        $this->session->set_userdata('numer_zamowienia', 'A2');
        $this->index($data);
    }

    public function B2() {
        $data = array('photo' => $this->session->userdata('photo_2'),
            'marka' => $this->session->userdata('marka_2'),
            'cena' => $this->session->userdata('cena_2'),
            'kaucja' => $this->session->userdata('kaucja_2'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D2');
        $this->session->set_userdata('numer_zamowienia', 'B2');
        $this->index($data);
    }

    public function C2() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_2'),
                    'marka' => $this->session->userdata('marka_2'),
                    'cena' => $this->session->userdata('cena_2'),
                    'kaucja' => $this->session->userdata('kaucja_2'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C2');
                $this->session->set_userdata('numer_zamowienia', 'A2');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_2'),
                'marka' => $this->session->userdata('marka_2'),
                'cena' => $this->session->userdata('cena_2'),
                'kaucja' => $this->session->userdata('kaucja_2'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C2');
            $this->session->set_userdata('numer_zamowienia', 'A2');
            $this->index($data);
        }
    }

    public function D2() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_2'),
                    'marka' => $this->session->userdata('marka_2'),
                    'cena' => $this->session->userdata('cena_2'),
                    'kaucja' => $this->session->userdata('kaucja_2'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D2');
                $this->session->set_userdata('numer_zamowienia', 'B2');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_2'),
                'marka' => $this->session->userdata('marka_2'),
                'cena' => $this->session->userdata('cena_2'),
                'kaucja' => $this->session->userdata('kaucja_2'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D2');
            $this->session->set_userdata('numer_zamowienia', 'B2');
            $this->index($data);
        }
    }

    public function A3() {
        $data = array('photo' => $this->session->userdata('photo_3'),
            'marka' => $this->session->userdata('marka_3'),
            'cena' => $this->session->userdata('cena_3'),
            'kaucja' => $this->session->userdata('kaucja_3'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C3');
        $this->session->set_userdata('numer_zamowienia', 'A3');
        $this->index($data);
    }

    public function B3() {
        $data = array('photo' => $this->session->userdata('photo_3'),
            'marka' => $this->session->userdata('marka_3'),
            'cena' => $this->session->userdata('cena_3'),
            'kaucja' => $this->session->userdata('kaucja_3'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D3');
        $this->session->set_userdata('numer_zamowienia', 'B3');
        $this->index($data);
    }

    public function C3() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_3'),
                    'marka' => $this->session->userdata('marka_3'),
                    'cena' => $this->session->userdata('cena_3'),
                    'kaucja' => $this->session->userdata('kaucja_3'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C3');
                $this->session->set_userdata('numer_zamowienia', 'A3');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_3'),
                'marka' => $this->session->userdata('marka_3'),
                'cena' => $this->session->userdata('cena_3'),
                'kaucja' => $this->session->userdata('kaucja_3'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C3');
            $this->session->set_userdata('numer_zamowienia', 'A3');
            $this->index($data);
        }
    }

    public function D3() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_3'),
                    'marka' => $this->session->userdata('marka_3'),
                    'cena' => $this->session->userdata('cena_3'),
                    'kaucja' => $this->session->userdata('kaucja_3'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D3');
                $this->session->set_userdata('numer_zamowienia', 'B3');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_3'),
                'marka' => $this->session->userdata('marka_3'),
                'cena' => $this->session->userdata('cena_3'),
                'kaucja' => $this->session->userdata('kaucja_3'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D3');
            $this->session->set_userdata('numer_zamowienia', 'B3');
            $this->index($data);
        }
    }

    public function A4() {
        $data = array('photo' => $this->session->userdata('photo_4'),
            'marka' => $this->session->userdata('marka_4'),
            'cena' => $this->session->userdata('cena_4'),
            'kaucja' => $this->session->userdata('kaucja_4'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C4');
        $this->session->set_userdata('numer_zamowienia', 'A4');
        $this->index($data);
    }

    public function B4() {
        $data = array('photo' => $this->session->userdata('photo_4'),
            'marka' => $this->session->userdata('marka_4'),
            'cena' => $this->session->userdata('cena_4'),
            'kaucja' => $this->session->userdata('kaucja_4'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D4');
        $this->session->set_userdata('numer_zamowienia', 'B4');
        $this->index($data);
    }

    public function C4() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_4'),
                    'marka' => $this->session->userdata('marka_4'),
                    'cena' => $this->session->userdata('cena_4'),
                    'kaucja' => $this->session->userdata('kaucja_4'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C4');
                $this->session->set_userdata('numer_zamowienia', 'A4');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_4'),
                'marka' => $this->session->userdata('marka_4'),
                'cena' => $this->session->userdata('cena_4'),
                'kaucja' => $this->session->userdata('kaucja_4'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C4');
            $this->session->set_userdata('numer_zamowienia', 'A4');
            $this->index($data);
        }
    }

    public function D4() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_4'),
                    'marka' => $this->session->userdata('marka_4'),
                    'cena' => $this->session->userdata('cena_4'),
                    'kaucja' => $this->session->userdata('kaucja_4'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D4');
                $this->session->set_userdata('numer_zamowienia', 'B4');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_4'),
                'marka' => $this->session->userdata('marka_4'),
                'cena' => $this->session->userdata('cena_4'),
                'kaucja' => $this->session->userdata('kaucja_4'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D4');
            $this->session->set_userdata('numer_zamowienia', 'B4');
            $this->index($data);
        }
    }

    public function A5() {
        $data = array('photo' => $this->session->userdata('photo_5'),
            'marka' => $this->session->userdata('marka_5'),
            'cena' => $this->session->userdata('cena_5'),
            'kaucja' => $this->session->userdata('kaucja_5'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C5');
        $this->session->set_userdata('numer_zamowienia', 'A5');
        $this->index($data);
    }

    public function B5() {
        $data = array('photo' => $this->session->userdata('photo_5'),
            'marka' => $this->session->userdata('marka_5'),
            'cena' => $this->session->userdata('cena_5'),
            'kaucja' => $this->session->userdata('kaucja_5'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D5');
        $this->session->set_userdata('numer_zamowienia', 'B5');
        $this->index($data);
    }

    public function C5() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_5'),
                    'marka' => $this->session->userdata('marka_5'),
                    'cena' => $this->session->userdata('cena_5'),
                    'kaucja' => $this->session->userdata('kaucja_5'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C5');
                $this->session->set_userdata('numer_zamowienia', 'A5');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_5'),
                'marka' => $this->session->userdata('marka_5'),
                'cena' => $this->session->userdata('cena_5'),
                'kaucja' => $this->session->userdata('kaucja_5'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C5');
            $this->session->set_userdata('numer_zamowienia', 'A5');
            $this->index($data);
        }
    }

    public function D5() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_5'),
                    'marka' => $this->session->userdata('marka_5'),
                    'cena' => $this->session->userdata('cena_5'),
                    'kaucja' => $this->session->userdata('kaucja_5'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D5');
                $this->session->set_userdata('numer_zamowienia', 'B5');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_5'),
                'marka' => $this->session->userdata('marka_5'),
                'cena' => $this->session->userdata('cena_5'),
                'kaucja' => $this->session->userdata('kaucja_5'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D5');
            $this->session->set_userdata('numer_zamowienia', 'B5');
            $this->index($data);
        }
    }

    public function A6() {
        $data = array('photo' => $this->session->userdata('photo_6'),
            'marka' => $this->session->userdata('marka_6'),
            'cena' => $this->session->userdata('cena_6'),
            'kaucja' => $this->session->userdata('kaucja_6'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C6');
        $this->session->set_userdata('numer_zamowienia', 'A6');
        $this->index($data);
    }

    public function B6() {
        $data = array('photo' => $this->session->userdata('photo_6'),
            'marka' => $this->session->userdata('marka_6'),
            'cena' => $this->session->userdata('cena_6'),
            'kaucja' => $this->session->userdata('kaucja_6'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D6');
        $this->session->set_userdata('numer_zamowienia', 'B6');
        $this->index($data);
    }

    public function C6() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_6'),
                    'marka' => $this->session->userdata('marka_6'),
                    'cena' => $this->session->userdata('cena_6'),
                    'kaucja' => $this->session->userdata('kaucja_6'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C6');
                $this->session->set_userdata('numer_zamowienia', 'A6');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_6'),
                'marka' => $this->session->userdata('marka_6'),
                'cena' => $this->session->userdata('cena_6'),
                'kaucja' => $this->session->userdata('kaucja_6'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C6');
            $this->session->set_userdata('numer_zamowienia', 'A6');
            $this->index($data);
        }
    }

    public function D6() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_6'),
                    'marka' => $this->session->userdata('marka_6'),
                    'cena' => $this->session->userdata('cena_6'),
                    'kaucja' => $this->session->userdata('kaucja_6'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D6');
                $this->session->set_userdata('numer_zamowienia', 'B6');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_6'),
                'marka' => $this->session->userdata('marka_6'),
                'cena' => $this->session->userdata('cena_6'),
                'kaucja' => $this->session->userdata('kaucja_6'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D6');
            $this->session->set_userdata('numer_zamowienia', 'B6');
            $this->index($data);
        }
    }

    public function A7() {
        $data = array('photo' => $this->session->userdata('photo_7'),
            'marka' => $this->session->userdata('marka_7'),
            'cena' => $this->session->userdata('cena_7'),
            'kaucja' => $this->session->userdata('kaucja_7'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C7');
        $this->session->set_userdata('numer_zamowienia', 'A7');
        $this->index($data);
    }

    public function B7() {
        $data = array('photo' => $this->session->userdata('photo_7'),
            'marka' => $this->session->userdata('marka_7'),
            'cena' => $this->session->userdata('cena_7'),
            'kaucja' => $this->session->userdata('kaucja_7'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D7');
        $this->session->set_userdata('numer_zamowienia', 'B7');
        $this->index($data);
    }

    public function C7() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_7'),
                    'marka' => $this->session->userdata('marka_7'),
                    'cena' => $this->session->userdata('cena_7'),
                    'kaucja' => $this->session->userdata('kaucja_7'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C7');
                $this->session->set_userdata('numer_zamowienia', 'A7');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_7'),
                'marka' => $this->session->userdata('marka_7'),
                'cena' => $this->session->userdata('cena_7'),
                'kaucja' => $this->session->userdata('kaucja_7'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C7');
            $this->session->set_userdata('numer_zamowienia', 'A7');
            $this->index($data);
        }
    }

    public function D7() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_7'),
                    'marka' => $this->session->userdata('marka_7'),
                    'cena' => $this->session->userdata('cena_7'),
                    'kaucja' => $this->session->userdata('kaucja_7'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D7');
                $this->session->set_userdata('numer_zamowienia', 'B7');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_7'),
                'marka' => $this->session->userdata('marka_7'),
                'cena' => $this->session->userdata('cena_7'),
                'kaucja' => $this->session->userdata('kaucja_7'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D7');
            $this->session->set_userdata('numer_zamowienia', 'B7');
            $this->index($data);
        }
    }

    public function A8() {
        $data = array('photo' => $this->session->userdata('photo_8'),
            'marka' => $this->session->userdata('marka_8'),
            'cena' => $this->session->userdata('cena_8'),
            'kaucja' => $this->session->userdata('kaucja_8'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C8');
        $this->session->set_userdata('numer_zamowienia', 'A8');
        $this->index($data);
    }

    public function B8() {
        $data = array('photo' => $this->session->userdata('photo_8'),
            'marka' => $this->session->userdata('marka_8'),
            'cena' => $this->session->userdata('cena_8'),
            'kaucja' => $this->session->userdata('kaucja_8'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D8');
        $this->session->set_userdata('numer_zamowienia', 'B8');
        $this->index($data);
    }

    public function C8() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_8'),
                    'marka' => $this->session->userdata('marka_8'),
                    'cena' => $this->session->userdata('cena_8'),
                    'kaucja' => $this->session->userdata('kaucja_8'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C8');
                $this->session->set_userdata('numer_zamowienia', 'A8');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_8'),
                'marka' => $this->session->userdata('marka_8'),
                'cena' => $this->session->userdata('cena_8'),
                'kaucja' => $this->session->userdata('kaucja_8'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C8');
            $this->session->set_userdata('numer_zamowienia', 'A8');
            $this->index($data);
        }
    }

    public function D8() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_8'),
                    'marka' => $this->session->userdata('marka_8'),
                    'cena' => $this->session->userdata('cena_8'),
                    'kaucja' => $this->session->userdata('kaucja_8'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D8');
                $this->session->set_userdata('numer_zamowienia', 'B8');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_8'),
                'marka' => $this->session->userdata('marka_8'),
                'cena' => $this->session->userdata('cena_8'),
                'kaucja' => $this->session->userdata('kaucja_8'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D8');
            $this->session->set_userdata('numer_zamowienia', 'B8');
            $this->index($data);
        }
    }

    public function A9() {
        $data = array('photo' => $this->session->userdata('photo_9'),
            'marka' => $this->session->userdata('marka_9'),
            'cena' => $this->session->userdata('cena_9'),
            'kaucja' => $this->session->userdata('kaucja_9'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C9');
        $this->session->set_userdata('numer_zamowienia', 'A9');
        $this->index($data);
    }

    public function B9() {
        $data = array('photo' => $this->session->userdata('photo_9'),
            'marka' => $this->session->userdata('marka_9'),
            'cena' => $this->session->userdata('cena_9'),
            'kaucja' => $this->session->userdata('kaucja_9'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D9');
        $this->session->set_userdata('numer_zamowienia', 'B9');
        $this->index($data);
    }

    public function C9() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_9'),
                    'marka' => $this->session->userdata('marka_9'),
                    'cena' => $this->session->userdata('cena_9'),
                    'kaucja' => $this->session->userdata('kaucja_9'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C9');
                $this->session->set_userdata('numer_zamowienia', 'A9');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_9'),
                'marka' => $this->session->userdata('marka_9'),
                'cena' => $this->session->userdata('cena_9'),
                'kaucja' => $this->session->userdata('kaucja_9'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C9');
            $this->session->set_userdata('numer_zamowienia', 'A9');
            $this->index($data);
        }
    }

    public function D9() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_9'),
                    'marka' => $this->session->userdata('marka_9'),
                    'cena' => $this->session->userdata('cena_9'),
                    'kaucja' => $this->session->userdata('kaucja_9'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D9');
                $this->session->set_userdata('numer_zamowienia', 'B9');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_9'),
                'marka' => $this->session->userdata('marka_9'),
                'cena' => $this->session->userdata('cena_9'),
                'kaucja' => $this->session->userdata('kaucja_9'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D9');
            $this->session->set_userdata('numer_zamowienia', 'B9');
            $this->index($data);
        }
    }

    public function A10() {
        $data = array('photo' => $this->session->userdata('photo_10'),
            'marka' => $this->session->userdata('marka_10'),
            'cena' => $this->session->userdata('cena_10'),
            'kaucja' => $this->session->userdata('kaucja_10'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C10');
        $this->session->set_userdata('numer_zamowienia', 'A10');
        $this->index($data);
    }

    public function B10() {
        $data = array('photo' => $this->session->userdata('photo_10'),
            'marka' => $this->session->userdata('marka_10'),
            'cena' => $this->session->userdata('cena_10'),
            'kaucja' => $this->session->userdata('kaucja_10'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D10');
        $this->session->set_userdata('numer_zamowienia', 'B10');
        $this->index($data);
    }

    public function C10() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_10'),
                    'marka' => $this->session->userdata('marka_10'),
                    'cena' => $this->session->userdata('cena_10'),
                    'kaucja' => $this->session->userdata('kaucja_10'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C10');
                $this->session->set_userdata('numer_zamowienia', 'A10');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_10'),
                'marka' => $this->session->userdata('marka_10'),
                'cena' => $this->session->userdata('cena_10'),
                'kaucja' => $this->session->userdata('kaucja_10'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C10');
            $this->session->set_userdata('numer_zamowienia', 'A10');
            $this->index($data);
        }
    }

    public function D10() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_10'),
                    'marka' => $this->session->userdata('marka_10'),
                    'cena' => $this->session->userdata('cena_10'),
                    'kaucja' => $this->session->userdata('kaucja_10'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D10');
                $this->session->set_userdata('numer_zamowienia', 'B10');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_10'),
                'marka' => $this->session->userdata('marka_10'),
                'cena' => $this->session->userdata('cena_10'),
                'kaucja' => $this->session->userdata('kaucja_10'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D10');
            $this->session->set_userdata('numer_zamowienia', 'B10');
            $this->index($data);
        }
    }

    public function A11() {
        $data = array('photo' => $this->session->userdata('photo_11'),
            'marka' => $this->session->userdata('marka_11'),
            'cena' => $this->session->userdata('cena_11'),
            'kaucja' => $this->session->userdata('kaucja_11'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C11');
        $this->session->set_userdata('numer_zamowienia', 'A11');
        $this->index($data);
    }

    public function B11() {
        $data = array('photo' => $this->session->userdata('photo_11'),
            'marka' => $this->session->userdata('marka_11'),
            'cena' => $this->session->userdata('cena_11'),
            'kaucja' => $this->session->userdata('kaucja_11'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D11');
        $this->session->set_userdata('numer_zamowienia', 'B11');
        $this->index($data);
    }

    public function C11() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_11'),
                    'marka' => $this->session->userdata('marka_11'),
                    'cena' => $this->session->userdata('cena_11'),
                    'kaucja' => $this->session->userdata('kaucja_11'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C11');
                $this->session->set_userdata('numer_zamowienia', 'A11');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_11'),
                'marka' => $this->session->userdata('marka_11'),
                'cena' => $this->session->userdata('cena_11'),
                'kaucja' => $this->session->userdata('kaucja_11'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C11');
            $this->session->set_userdata('numer_zamowienia', 'A11');
            $this->index($data);
        }
    }

    public function D11() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_11'),
                    'marka' => $this->session->userdata('marka_11'),
                    'cena' => $this->session->userdata('cena_11'),
                    'kaucja' => $this->session->userdata('kaucja_11'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D11');
                $this->session->set_userdata('numer_zamowienia', 'B11');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_11'),
                'marka' => $this->session->userdata('marka_11'),
                'cena' => $this->session->userdata('cena_11'),
                'kaucja' => $this->session->userdata('kaucja_11'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D11');
            $this->session->set_userdata('numer_zamowienia', 'B11');
            $this->index($data);
        }
    }

    public function A12() {
        $data = array('photo' => $this->session->userdata('photo_12'),
            'marka' => $this->session->userdata('marka_12'),
            'cena' => $this->session->userdata('cena_12'),
            'kaucja' => $this->session->userdata('kaucja_12'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C12');
        $this->session->set_userdata('numer_zamowienia', 'A12');
        $this->index($data);
    }

    public function B12() {
        $data = array('photo' => $this->session->userdata('photo_12'),
            'marka' => $this->session->userdata('marka_12'),
            'cena' => $this->session->userdata('cena_12'),
            'kaucja' => $this->session->userdata('kaucja_12'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D12');
        $this->session->set_userdata('numer_zamowienia', 'B12');
        $this->index($data);
    }

    public function C12() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_12'),
                    'marka' => $this->session->userdata('marka_12'),
                    'cena' => $this->session->userdata('cena_12'),
                    'kaucja' => $this->session->userdata('kaucja_12'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C12');
                $this->session->set_userdata('numer_zamowienia', 'A12');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_12'),
                'marka' => $this->session->userdata('marka_12'),
                'cena' => $this->session->userdata('cena_12'),
                'kaucja' => $this->session->userdata('kaucja_12'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C12');
            $this->session->set_userdata('numer_zamowienia', 'A12');
            $this->index($data);
        }
    }

    public function D12() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_12'),
                    'marka' => $this->session->userdata('marka_12'),
                    'cena' => $this->session->userdata('cena_12'),
                    'kaucja' => $this->session->userdata('kaucja_12'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D12');
                $this->session->set_userdata('numer_zamowienia', 'B12');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_12'),
                'marka' => $this->session->userdata('marka_12'),
                'cena' => $this->session->userdata('cena_12'),
                'kaucja' => $this->session->userdata('kaucja_12'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D12');
            $this->session->set_userdata('numer_zamowienia', 'B12');
            $this->index($data);
        }
    }

    public function A13() {
        $data = array('photo' => $this->session->userdata('photo_13'),
            'marka' => $this->session->userdata('marka_13'),
            'cena' => $this->session->userdata('cena_13'),
            'kaucja' => $this->session->userdata('kaucja_13'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C13');
        $this->session->set_userdata('numer_zamowienia', 'A13');
        $this->index($data);
    }

    public function B13() {
        $data = array('photo' => $this->session->userdata('photo_13'),
            'marka' => $this->session->userdata('marka_13'),
            'cena' => $this->session->userdata('cena_13'),
            'kaucja' => $this->session->userdata('kaucja_13'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D13');
        $this->session->set_userdata('numer_zamowienia', 'B13');
        $this->index($data);
    }

    public function C13() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_13'),
                    'marka' => $this->session->userdata('marka_13'),
                    'cena' => $this->session->userdata('cena_13'),
                    'kaucja' => $this->session->userdata('kaucja_13'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C13');
                $this->session->set_userdata('numer_zamowienia', 'A13');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_13'),
                'marka' => $this->session->userdata('marka_13'),
                'cena' => $this->session->userdata('cena_13'),
                'kaucja' => $this->session->userdata('kaucja_13'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C13');
            $this->session->set_userdata('numer_zamowienia', 'A13');
            $this->index($data);
        }
    }

    public function D13() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_13'),
                    'marka' => $this->session->userdata('marka_13'),
                    'cena' => $this->session->userdata('cena_13'),
                    'kaucja' => $this->session->userdata('kaucja_13'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D13');
                $this->session->set_userdata('numer_zamowienia', 'B13');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_13'),
                'marka' => $this->session->userdata('marka_13'),
                'cena' => $this->session->userdata('cena_13'),
                'kaucja' => $this->session->userdata('kaucja_13'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D13');
            $this->session->set_userdata('numer_zamowienia', 'B13');
            $this->index($data);
        }
    }

    public function A14() {
        $data = array('photo' => $this->session->userdata('photo_14'),
            'marka' => $this->session->userdata('marka_14'),
            'cena' => $this->session->userdata('cena_14'),
            'kaucja' => $this->session->userdata('kaucja_14'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C14');
        $this->session->set_userdata('numer_zamowienia', 'A14');
        $this->index($data);
    }

    public function B14() {
        $data = array('photo' => $this->session->userdata('photo_14'),
            'marka' => $this->session->userdata('marka_14'),
            'cena' => $this->session->userdata('cena_14'),
            'kaucja' => $this->session->userdata('kaucja_14'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D14');
        $this->session->set_userdata('numer_zamowienia', 'B14');
        $this->index($data);
    }

    public function C14() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_14'),
                    'marka' => $this->session->userdata('marka_14'),
                    'cena' => $this->session->userdata('cena_14'),
                    'kaucja' => $this->session->userdata('kaucja_14'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C14');
                $this->session->set_userdata('numer_zamowienia', 'A14');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_14'),
                'marka' => $this->session->userdata('marka_14'),
                'cena' => $this->session->userdata('cena_14'),
                'kaucja' => $this->session->userdata('kaucja_14'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C14');
            $this->session->set_userdata('numer_zamowienia', 'A14');
            $this->index($data);
        }
    }

    public function D14() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_14'),
                    'marka' => $this->session->userdata('marka_14'),
                    'cena' => $this->session->userdata('cena_14'),
                    'kaucja' => $this->session->userdata('kaucja_14'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D14');
                $this->session->set_userdata('numer_zamowienia', 'B14');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_14'),
                'marka' => $this->session->userdata('marka_14'),
                'cena' => $this->session->userdata('cena_14'),
                'kaucja' => $this->session->userdata('kaucja_14'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D14');
            $this->session->set_userdata('numer_zamowienia', 'B14');
            $this->index($data);
        }
    }

    public function A15() {
        $data = array('photo' => $this->session->userdata('photo_15'),
            'marka' => $this->session->userdata('marka_15'),
            'cena' => $this->session->userdata('cena_15'),
            'kaucja' => $this->session->userdata('kaucja_15'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C15');
        $this->session->set_userdata('numer_zamowienia', 'A15');
        $this->index($data);
    }

    public function B15() {
        $data = array('photo' => $this->session->userdata('photo_15'),
            'marka' => $this->session->userdata('marka_15'),
            'cena' => $this->session->userdata('cena_15'),
            'kaucja' => $this->session->userdata('kaucja_15'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D15');
        $this->session->set_userdata('numer_zamowienia', 'B15');
        $this->index($data);
    }

    public function C15() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_15'),
                    'marka' => $this->session->userdata('marka_15'),
                    'cena' => $this->session->userdata('cena_15'),
                    'kaucja' => $this->session->userdata('kaucja_15'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C15');
                $this->session->set_userdata('numer_zamowienia', 'A15');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_15'),
                'marka' => $this->session->userdata('marka_15'),
                'cena' => $this->session->userdata('cena_15'),
                'kaucja' => $this->session->userdata('kaucja_15'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C15');
            $this->session->set_userdata('numer_zamowienia', 'A15');
            $this->index($data);
        }
    }

    public function D15() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_15'),
                    'marka' => $this->session->userdata('marka_15'),
                    'cena' => $this->session->userdata('cena_15'),
                    'kaucja' => $this->session->userdata('kaucja_15'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D15');
                $this->session->set_userdata('numer_zamowienia', 'B15');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_15'),
                'marka' => $this->session->userdata('marka_15'),
                'cena' => $this->session->userdata('cena_15'),
                'kaucja' => $this->session->userdata('kaucja_15'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D15');
            $this->session->set_userdata('numer_zamowienia', 'B15');
            $this->index($data);
        }
    }

    public function A16() {
        $data = array('photo' => $this->session->userdata('photo_16'),
            'marka' => $this->session->userdata('marka_16'),
            'cena' => $this->session->userdata('cena_16'),
            'kaucja' => $this->session->userdata('kaucja_16'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C16');
        $this->session->set_userdata('numer_zamowienia', 'A16');
        $this->index($data);
    }

    public function B16() {
        $data = array('photo' => $this->session->userdata('photo_16'),
            'marka' => $this->session->userdata('marka_16'),
            'cena' => $this->session->userdata('cena_16'),
            'kaucja' => $this->session->userdata('kaucja_16'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D16');
        $this->session->set_userdata('numer_zamowienia', 'B16');
        $this->index($data);
    }

    public function C16() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_16'),
                    'marka' => $this->session->userdata('marka_16'),
                    'cena' => $this->session->userdata('cena_16'),
                    'kaucja' => $this->session->userdata('kaucja_16'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C16');
                $this->session->set_userdata('numer_zamowienia', 'A16');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_16'),
                'marka' => $this->session->userdata('marka_16'),
                'cena' => $this->session->userdata('cena_16'),
                'kaucja' => $this->session->userdata('kaucja_16'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C16');
            $this->session->set_userdata('numer_zamowienia', 'A16');
            $this->index($data);
        }
    }

    public function D16() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_16'),
                    'marka' => $this->session->userdata('marka_16'),
                    'cena' => $this->session->userdata('cena_16'),
                    'kaucja' => $this->session->userdata('kaucja_16'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D16');
                $this->session->set_userdata('numer_zamowienia', 'B16');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_16'),
                'marka' => $this->session->userdata('marka_16'),
                'cena' => $this->session->userdata('cena_16'),
                'kaucja' => $this->session->userdata('kaucja_16'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D16');
            $this->session->set_userdata('numer_zamowienia', 'B16');
            $this->index($data);
        }
    }

    public function A17() {
        $data = array('photo' => $this->session->userdata('photo_17'),
            'marka' => $this->session->userdata('marka_17'),
            'cena' => $this->session->userdata('cena_17'),
            'kaucja' => $this->session->userdata('kaucja_17'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C17');
        $this->session->set_userdata('numer_zamowienia', 'A17');
        $this->index($data);
    }

    public function B17() {
        $data = array('photo' => $this->session->userdata('photo_17'),
            'marka' => $this->session->userdata('marka_17'),
            'cena' => $this->session->userdata('cena_17'),
            'kaucja' => $this->session->userdata('kaucja_17'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D17');
        $this->session->set_userdata('numer_zamowienia', 'B17');
        $this->index($data);
    }

    public function C17() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_17'),
                    'marka' => $this->session->userdata('marka_17'),
                    'cena' => $this->session->userdata('cena_17'),
                    'kaucja' => $this->session->userdata('kaucja_17'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C17');
                $this->session->set_userdata('numer_zamowienia', 'A17');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_17'),
                'marka' => $this->session->userdata('marka_17'),
                'cena' => $this->session->userdata('cena_17'),
                'kaucja' => $this->session->userdata('kaucja_17'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C17');
            $this->session->set_userdata('numer_zamowienia', 'A17');
            $this->index($data);
        }
    }

    public function D17() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_17'),
                    'marka' => $this->session->userdata('marka_17'),
                    'cena' => $this->session->userdata('cena_17'),
                    'kaucja' => $this->session->userdata('kaucja_17'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D17');
                $this->session->set_userdata('numer_zamowienia', 'B17');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_17'),
                'marka' => $this->session->userdata('marka_17'),
                'cena' => $this->session->userdata('cena_17'),
                'kaucja' => $this->session->userdata('kaucja_17'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D17');
            $this->session->set_userdata('numer_zamowienia', 'B17');
            $this->index($data);
        }
    }

    public function A18() {
        $data = array('photo' => $this->session->userdata('photo_18'),
            'marka' => $this->session->userdata('marka_18'),
            'cena' => $this->session->userdata('cena_18'),
            'kaucja' => $this->session->userdata('kaucja_18'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C18');
        $this->session->set_userdata('numer_zamowienia', 'A18');
        $this->index($data);
    }

    public function B18() {
        $data = array('photo' => $this->session->userdata('photo_18'),
            'marka' => $this->session->userdata('marka_18'),
            'cena' => $this->session->userdata('cena_18'),
            'kaucja' => $this->session->userdata('kaucja_18'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D18');
        $this->session->set_userdata('numer_zamowienia', 'B18');
        $this->index($data);
    }

    public function C18() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_18'),
                    'marka' => $this->session->userdata('marka_18'),
                    'cena' => $this->session->userdata('cena_18'),
                    'kaucja' => $this->session->userdata('kaucja_18'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C18');
                $this->session->set_userdata('numer_zamowienia', 'A18');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_18'),
                'marka' => $this->session->userdata('marka_18'),
                'cena' => $this->session->userdata('cena_18'),
                'kaucja' => $this->session->userdata('kaucja_18'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C18');
            $this->session->set_userdata('numer_zamowienia', 'A18');
            $this->index($data);
        }
    }

    public function D18() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_18'),
                    'marka' => $this->session->userdata('marka_18'),
                    'cena' => $this->session->userdata('cena_18'),
                    'kaucja' => $this->session->userdata('kaucja_18'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D18');
                $this->session->set_userdata('numer_zamowienia', 'B18');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_18'),
                'marka' => $this->session->userdata('marka_18'),
                'cena' => $this->session->userdata('cena_18'),
                'kaucja' => $this->session->userdata('kaucja_18'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D18');
            $this->session->set_userdata('numer_zamowienia', 'B18');
            $this->index($data);
        }
    }

    public function A19() {
        $data = array('photo' => $this->session->userdata('photo_19'),
            'marka' => $this->session->userdata('marka_19'),
            'cena' => $this->session->userdata('cena_19'),
            'kaucja' => $this->session->userdata('kaucja_19'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C19');
        $this->session->set_userdata('numer_zamowienia', 'A19');
        $this->index($data);
    }

    public function B19() {
        $data = array('photo' => $this->session->userdata('photo_19'),
            'marka' => $this->session->userdata('marka_19'),
            'cena' => $this->session->userdata('cena_19'),
            'kaucja' => $this->session->userdata('kaucja_19'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D19');
        $this->session->set_userdata('numer_zamowienia', 'B19');
        $this->index($data);
    }

    public function C19() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_19'),
                    'marka' => $this->session->userdata('marka_19'),
                    'cena' => $this->session->userdata('cena_19'),
                    'kaucja' => $this->session->userdata('kaucja_19'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C19');
                $this->session->set_userdata('numer_zamowienia', 'A19');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_19'),
                'marka' => $this->session->userdata('marka_19'),
                'cena' => $this->session->userdata('cena_19'),
                'kaucja' => $this->session->userdata('kaucja_19'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C19');
            $this->session->set_userdata('numer_zamowienia', 'A19');
            $this->index($data);
        }
    }

    public function D19() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_19'),
                    'marka' => $this->session->userdata('marka_19'),
                    'cena' => $this->session->userdata('cena_19'),
                    'kaucja' => $this->session->userdata('kaucja_19'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D19');
                $this->session->set_userdata('numer_zamowienia', 'B19');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_19'),
                'marka' => $this->session->userdata('marka_19'),
                'cena' => $this->session->userdata('cena_19'),
                'kaucja' => $this->session->userdata('kaucja_19'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D19');
            $this->session->set_userdata('numer_zamowienia', 'B19');
            $this->index($data);
        }
    }

    public function A20() {
        $data = array('photo' => $this->session->userdata('photo_20'),
            'marka' => $this->session->userdata('marka_20'),
            'cena' => $this->session->userdata('cena_20'),
            'kaucja' => $this->session->userdata('kaucja_20'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C20');
        $this->session->set_userdata('numer_zamowienia', 'A20');
        $this->index($data);
    }

    public function B20() {
        $data = array('photo' => $this->session->userdata('photo_20'),
            'marka' => $this->session->userdata('marka_20'),
            'cena' => $this->session->userdata('cena_20'),
            'kaucja' => $this->session->userdata('kaucja_20'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D20');
        $this->session->set_userdata('numer_zamowienia', 'B20');
        $this->index($data);
    }

    public function C20() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_20'),
                    'marka' => $this->session->userdata('marka_20'),
                    'cena' => $this->session->userdata('cena_20'),
                    'kaucja' => $this->session->userdata('kaucja_20'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C20');
                $this->session->set_userdata('numer_zamowienia', 'A20');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_20'),
                'marka' => $this->session->userdata('marka_20'),
                'cena' => $this->session->userdata('cena_20'),
                'kaucja' => $this->session->userdata('kaucja_20'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C20');
            $this->session->set_userdata('numer_zamowienia', 'A20');
            $this->index($data);
        }
    }

    public function D20() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_20'),
                    'marka' => $this->session->userdata('marka_20'),
                    'cena' => $this->session->userdata('cena_20'),
                    'kaucja' => $this->session->userdata('kaucja_20'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D20');
                $this->session->set_userdata('numer_zamowienia', 'B20');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_20'),
                'marka' => $this->session->userdata('marka_20'),
                'cena' => $this->session->userdata('cena_20'),
                'kaucja' => $this->session->userdata('kaucja_20'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D20');
            $this->session->set_userdata('numer_zamowienia', 'B20');
            $this->index($data);
        }
    }

    public function A21() {
        $data = array('photo' => $this->session->userdata('photo_21'),
            'marka' => $this->session->userdata('marka_21'),
            'cena' => $this->session->userdata('cena_21'),
            'kaucja' => $this->session->userdata('kaucja_21'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C21');
        $this->session->set_userdata('numer_zamowienia', 'A21');
        $this->index($data);
    }

    public function B21() {
        $data = array('photo' => $this->session->userdata('photo_21'),
            'marka' => $this->session->userdata('marka_21'),
            'cena' => $this->session->userdata('cena_21'),
            'kaucja' => $this->session->userdata('kaucja_21'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D21');
        $this->session->set_userdata('numer_zamowienia', 'B21');
        $this->index($data);
    }

    public function C21() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_21'),
                    'marka' => $this->session->userdata('marka_21'),
                    'cena' => $this->session->userdata('cena_21'),
                    'kaucja' => $this->session->userdata('kaucja_21'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C21');
                $this->session->set_userdata('numer_zamowienia', 'A21');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_21'),
                'marka' => $this->session->userdata('marka_21'),
                'cena' => $this->session->userdata('cena_21'),
                'kaucja' => $this->session->userdata('kaucja_21'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C21');
            $this->session->set_userdata('numer_zamowienia', 'A21');
            $this->index($data);
        }
    }

    public function D21() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_21'),
                    'marka' => $this->session->userdata('marka_21'),
                    'cena' => $this->session->userdata('cena_21'),
                    'kaucja' => $this->session->userdata('kaucja_21'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D21');
                $this->session->set_userdata('numer_zamowienia', 'B21');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_21'),
                'marka' => $this->session->userdata('marka_21'),
                'cena' => $this->session->userdata('cena_21'),
                'kaucja' => $this->session->userdata('kaucja_21'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D21');
            $this->session->set_userdata('numer_zamowienia', 'B21');
            $this->index($data);
        }
    }

    public function A22() {
        $data = array('photo' => $this->session->userdata('photo_22'),
            'marka' => $this->session->userdata('marka_22'),
            'cena' => $this->session->userdata('cena_22'),
            'kaucja' => $this->session->userdata('kaucja_22'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C22');
        $this->session->set_userdata('numer_zamowienia', 'A22');
        $this->index($data);
    }

    public function B22() {
        $data = array('photo' => $this->session->userdata('photo_22'),
            'marka' => $this->session->userdata('marka_22'),
            'cena' => $this->session->userdata('cena_22'),
            'kaucja' => $this->session->userdata('kaucja_22'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D22');
        $this->session->set_userdata('numer_zamowienia', 'B22');
        $this->index($data);
    }

    public function C22() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_22'),
                    'marka' => $this->session->userdata('marka_22'),
                    'cena' => $this->session->userdata('cena_22'),
                    'kaucja' => $this->session->userdata('kaucja_22'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C22');
                $this->session->set_userdata('numer_zamowienia', 'A22');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_22'),
                'marka' => $this->session->userdata('marka_22'),
                'cena' => $this->session->userdata('cena_22'),
                'kaucja' => $this->session->userdata('kaucja_22'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C22');
            $this->session->set_userdata('numer_zamowienia', 'A22');
            $this->index($data);
        }
    }

    public function D22() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_22'),
                    'marka' => $this->session->userdata('marka_22'),
                    'cena' => $this->session->userdata('cena_22'),
                    'kaucja' => $this->session->userdata('kaucja_22'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D22');
                $this->session->set_userdata('numer_zamowienia', 'B22');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_22'),
                'marka' => $this->session->userdata('marka_22'),
                'cena' => $this->session->userdata('cena_22'),
                'kaucja' => $this->session->userdata('kaucja_22'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D22');
            $this->session->set_userdata('numer_zamowienia', 'B22');
            $this->index($data);
        }
    }

    public function A23() {
        $data = array('photo' => $this->session->userdata('photo_23'),
            'marka' => $this->session->userdata('marka_23'),
            'cena' => $this->session->userdata('cena_23'),
            'kaucja' => $this->session->userdata('kaucja_23'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C23');
        $this->session->set_userdata('numer_zamowienia', 'A23');
        $this->index($data);
    }

    public function B23() {
        $data = array('photo' => $this->session->userdata('photo_23'),
            'marka' => $this->session->userdata('marka_23'),
            'cena' => $this->session->userdata('cena_23'),
            'kaucja' => $this->session->userdata('kaucja_23'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D23');
        $this->session->set_userdata('numer_zamowienia', 'B23');
        $this->index($data);
    }

    public function C23() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_23'),
                    'marka' => $this->session->userdata('marka_23'),
                    'cena' => $this->session->userdata('cena_23'),
                    'kaucja' => $this->session->userdata('kaucja_23'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C23');
                $this->session->set_userdata('numer_zamowienia', 'A23');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_23'),
                'marka' => $this->session->userdata('marka_23'),
                'cena' => $this->session->userdata('cena_23'),
                'kaucja' => $this->session->userdata('kaucja_23'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C23');
            $this->session->set_userdata('numer_zamowienia', 'A23');
            $this->index($data);
        }
    }

    public function D23() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_23'),
                    'marka' => $this->session->userdata('marka_23'),
                    'cena' => $this->session->userdata('cena_23'),
                    'kaucja' => $this->session->userdata('kaucja_23'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D23');
                $this->session->set_userdata('numer_zamowienia', 'B23');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_23'),
                'marka' => $this->session->userdata('marka_23'),
                'cena' => $this->session->userdata('cena_23'),
                'kaucja' => $this->session->userdata('kaucja_23'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D23');
            $this->session->set_userdata('numer_zamowienia', 'B23');
            $this->index($data);
        }
    }

    public function A24() {
        $data = array('photo' => $this->session->userdata('photo_24'),
            'marka' => $this->session->userdata('marka_24'),
            'cena' => $this->session->userdata('cena_24'),
            'kaucja' => $this->session->userdata('kaucja_24'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C24');
        $this->session->set_userdata('numer_zamowienia', 'A24');
        $this->index($data);
    }

    public function B24() {
        $data = array('photo' => $this->session->userdata('photo_24'),
            'marka' => $this->session->userdata('marka_24'),
            'cena' => $this->session->userdata('cena_24'),
            'kaucja' => $this->session->userdata('kaucja_24'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D24');
        $this->session->set_userdata('numer_zamowienia', 'B24');
        $this->index($data);
    }

    public function C24() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_24'),
                    'marka' => $this->session->userdata('marka_24'),
                    'cena' => $this->session->userdata('cena_24'),
                    'kaucja' => $this->session->userdata('kaucja_24'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C24');
                $this->session->set_userdata('numer_zamowienia', 'A24');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_24'),
                'marka' => $this->session->userdata('marka_24'),
                'cena' => $this->session->userdata('cena_24'),
                'kaucja' => $this->session->userdata('kaucja_24'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C24');
            $this->session->set_userdata('numer_zamowienia', 'A24');
            $this->index($data);
        }
    }

    public function D24() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_24'),
                    'marka' => $this->session->userdata('marka_24'),
                    'cena' => $this->session->userdata('cena_24'),
                    'kaucja' => $this->session->userdata('kaucja_24'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D24');
                $this->session->set_userdata('numer_zamowienia', 'B24');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_24'),
                'marka' => $this->session->userdata('marka_24'),
                'cena' => $this->session->userdata('cena_24'),
                'kaucja' => $this->session->userdata('kaucja_24'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D24');
            $this->session->set_userdata('numer_zamowienia', 'B24');
            $this->index($data);
        }
    }

    public function A25() {
        $data = array('photo' => $this->session->userdata('photo_25'),
            'marka' => $this->session->userdata('marka_25'),
            'cena' => $this->session->userdata('cena_25'),
            'kaucja' => $this->session->userdata('kaucja_25'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C25');
        $this->session->set_userdata('numer_zamowienia', 'A25');
        $this->index($data);
    }

    public function B25() {
        $data = array('photo' => $this->session->userdata('photo_25'),
            'marka' => $this->session->userdata('marka_25'),
            'cena' => $this->session->userdata('cena_25'),
            'kaucja' => $this->session->userdata('kaucja_25'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D25');
        $this->session->set_userdata('numer_zamowienia', 'B25');
        $this->index($data);
    }

    public function C25() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_25'),
                    'marka' => $this->session->userdata('marka_25'),
                    'cena' => $this->session->userdata('cena_25'),
                    'kaucja' => $this->session->userdata('kaucja_25'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C25');
                $this->session->set_userdata('numer_zamowienia', 'A25');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_25'),
                'marka' => $this->session->userdata('marka_25'),
                'cena' => $this->session->userdata('cena_25'),
                'kaucja' => $this->session->userdata('kaucja_25'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C25');
            $this->session->set_userdata('numer_zamowienia', 'A25');
            $this->index($data);
        }
    }

    public function D25() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_25'),
                    'marka' => $this->session->userdata('marka_25'),
                    'cena' => $this->session->userdata('cena_25'),
                    'kaucja' => $this->session->userdata('kaucja_25'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D25');
                $this->session->set_userdata('numer_zamowienia', 'B25');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_25'),
                'marka' => $this->session->userdata('marka_25'),
                'cena' => $this->session->userdata('cena_25'),
                'kaucja' => $this->session->userdata('kaucja_25'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D25');
            $this->session->set_userdata('numer_zamowienia', 'B25');
            $this->index($data);
        }
    }

    public function A26() {
        $data = array('photo' => $this->session->userdata('photo_26'),
            'marka' => $this->session->userdata('marka_26'),
            'cena' => $this->session->userdata('cena_26'),
            'kaucja' => $this->session->userdata('kaucja_26'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C26');
        $this->session->set_userdata('numer_zamowienia', 'A26');
        $this->index($data);
    }

    public function B26() {
        $data = array('photo' => $this->session->userdata('photo_26'),
            'marka' => $this->session->userdata('marka_26'),
            'cena' => $this->session->userdata('cena_26'),
            'kaucja' => $this->session->userdata('kaucja_26'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D26');
        $this->session->set_userdata('numer_zamowienia', 'B26');
        $this->index($data);
    }

    public function C26() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_26'),
                    'marka' => $this->session->userdata('marka_26'),
                    'cena' => $this->session->userdata('cena_26'),
                    'kaucja' => $this->session->userdata('kaucja_26'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C26');
                $this->session->set_userdata('numer_zamowienia', 'A26');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_26'),
                'marka' => $this->session->userdata('marka_26'),
                'cena' => $this->session->userdata('cena_26'),
                'kaucja' => $this->session->userdata('kaucja_26'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C26');
            $this->session->set_userdata('numer_zamowienia', 'A26');
            $this->index($data);
        }
    }

    public function D26() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_26'),
                    'marka' => $this->session->userdata('marka_26'),
                    'cena' => $this->session->userdata('cena_26'),
                    'kaucja' => $this->session->userdata('kaucja_26'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D26');
                $this->session->set_userdata('numer_zamowienia', 'B26');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_26'),
                'marka' => $this->session->userdata('marka_26'),
                'cena' => $this->session->userdata('cena_26'),
                'kaucja' => $this->session->userdata('kaucja_26'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D26');
            $this->session->set_userdata('numer_zamowienia', 'B26');
            $this->index($data);
        }
    }

    public function A27() {
        $data = array('photo' => $this->session->userdata('photo_27'),
            'marka' => $this->session->userdata('marka_27'),
            'cena' => $this->session->userdata('cena_27'),
            'kaucja' => $this->session->userdata('kaucja_27'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C27');
        $this->session->set_userdata('numer_zamowienia', 'A27');
        $this->index($data);
    }

    public function B27() {
        $data = array('photo' => $this->session->userdata('photo_27'),
            'marka' => $this->session->userdata('marka_27'),
            'cena' => $this->session->userdata('cena_27'),
            'kaucja' => $this->session->userdata('kaucja_27'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D27');
        $this->session->set_userdata('numer_zamowienia', 'B27');
        $this->index($data);
    }

    public function C27() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_27'),
                    'marka' => $this->session->userdata('marka_27'),
                    'cena' => $this->session->userdata('cena_27'),
                    'kaucja' => $this->session->userdata('kaucja_27'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C27');
                $this->session->set_userdata('numer_zamowienia', 'A27');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_27'),
                'marka' => $this->session->userdata('marka_27'),
                'cena' => $this->session->userdata('cena_27'),
                'kaucja' => $this->session->userdata('kaucja_27'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C27');
            $this->session->set_userdata('numer_zamowienia', 'A27');
            $this->index($data);
        }
    }

    public function D27() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_27'),
                    'marka' => $this->session->userdata('marka_27'),
                    'cena' => $this->session->userdata('cena_27'),
                    'kaucja' => $this->session->userdata('kaucja_27'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D27');
                $this->session->set_userdata('numer_zamowienia', 'B27');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_27'),
                'marka' => $this->session->userdata('marka_27'),
                'cena' => $this->session->userdata('cena_27'),
                'kaucja' => $this->session->userdata('kaucja_27'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D27');
            $this->session->set_userdata('numer_zamowienia', 'B27');
            $this->index($data);
        }
    }

    public function A28() {
        $data = array('photo' => $this->session->userdata('photo_28'),
            'marka' => $this->session->userdata('marka_28'),
            'cena' => $this->session->userdata('cena_28'),
            'kaucja' => $this->session->userdata('kaucja_28'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C28');
        $this->session->set_userdata('numer_zamowienia', 'A28');
        $this->index($data);
    }

    public function B28() {
        $data = array('photo' => $this->session->userdata('photo_28'),
            'marka' => $this->session->userdata('marka_28'),
            'cena' => $this->session->userdata('cena_28'),
            'kaucja' => $this->session->userdata('kaucja_28'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D28');
        $this->session->set_userdata('numer_zamowienia', 'B28');
        $this->index($data);
    }

    public function C28() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_28'),
                    'marka' => $this->session->userdata('marka_28'),
                    'cena' => $this->session->userdata('cena_28'),
                    'kaucja' => $this->session->userdata('kaucja_28'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C28');
                $this->session->set_userdata('numer_zamowienia', 'A28');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_28'),
                'marka' => $this->session->userdata('marka_28'),
                'cena' => $this->session->userdata('cena_28'),
                'kaucja' => $this->session->userdata('kaucja_28'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C28');
            $this->session->set_userdata('numer_zamowienia', 'A28');
            $this->index($data);
        }
    }

    public function D28() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_28'),
                    'marka' => $this->session->userdata('marka_28'),
                    'cena' => $this->session->userdata('cena_28'),
                    'kaucja' => $this->session->userdata('kaucja_28'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D28');
                $this->session->set_userdata('numer_zamowienia', 'B28');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_28'),
                'marka' => $this->session->userdata('marka_28'),
                'cena' => $this->session->userdata('cena_28'),
                'kaucja' => $this->session->userdata('kaucja_28'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D28');
            $this->session->set_userdata('numer_zamowienia', 'B28');
            $this->index($data);
        }
    }

    public function A29() {
        $data = array('photo' => $this->session->userdata('photo_29'),
            'marka' => $this->session->userdata('marka_29'),
            'cena' => $this->session->userdata('cena_29'),
            'kaucja' => $this->session->userdata('kaucja_29'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C29');
        $this->session->set_userdata('numer_zamowienia', 'A29');
        $this->index($data);
    }

    public function B29() {
        $data = array('photo' => $this->session->userdata('photo_29'),
            'marka' => $this->session->userdata('marka_29'),
            'cena' => $this->session->userdata('cena_29'),
            'kaucja' => $this->session->userdata('kaucja_29'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D29');
        $this->session->set_userdata('numer_zamowienia', 'B29');
        $this->index($data);
    }

    public function C29() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_29'),
                    'marka' => $this->session->userdata('marka_29'),
                    'cena' => $this->session->userdata('cena_29'),
                    'kaucja' => $this->session->userdata('kaucja_29'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C29');
                $this->session->set_userdata('numer_zamowienia', 'A29');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_29'),
                'marka' => $this->session->userdata('marka_29'),
                'cena' => $this->session->userdata('cena_29'),
                'kaucja' => $this->session->userdata('kaucja_29'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C29');
            $this->session->set_userdata('numer_zamowienia', 'A29');
            $this->index($data);
        }
    }

    public function D29() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_29'),
                    'marka' => $this->session->userdata('marka_29'),
                    'cena' => $this->session->userdata('cena_29'),
                    'kaucja' => $this->session->userdata('kaucja_29'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D29');
                $this->session->set_userdata('numer_zamowienia', 'B29');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_29'),
                'marka' => $this->session->userdata('marka_29'),
                'cena' => $this->session->userdata('cena_29'),
                'kaucja' => $this->session->userdata('kaucja_29'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D29');
            $this->session->set_userdata('numer_zamowienia', 'B29');
            $this->index($data);
        }
    }

    public function A30() {
        $data = array('photo' => $this->session->userdata('photo_30'),
            'marka' => $this->session->userdata('marka_30'),
            'cena' => $this->session->userdata('cena_30'),
            'kaucja' => $this->session->userdata('kaucja_30'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C30');
        $this->session->set_userdata('numer_zamowienia', 'A30');
        $this->index($data);
    }

    public function B30() {
        $data = array('photo' => $this->session->userdata('photo_30'),
            'marka' => $this->session->userdata('marka_30'),
            'cena' => $this->session->userdata('cena_30'),
            'kaucja' => $this->session->userdata('kaucja_30'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D30');
        $this->session->set_userdata('numer_zamowienia', 'B30');
        $this->index($data);
    }

    public function C30() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_30'),
                    'marka' => $this->session->userdata('marka_30'),
                    'cena' => $this->session->userdata('cena_30'),
                    'kaucja' => $this->session->userdata('kaucja_30'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C30');
                $this->session->set_userdata('numer_zamowienia', 'A30');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_30'),
                'marka' => $this->session->userdata('marka_30'),
                'cena' => $this->session->userdata('cena_30'),
                'kaucja' => $this->session->userdata('kaucja_30'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C30');
            $this->session->set_userdata('numer_zamowienia', 'A30');
            $this->index($data);
        }
    }

    public function D30() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_30'),
                    'marka' => $this->session->userdata('marka_30'),
                    'cena' => $this->session->userdata('cena_30'),
                    'kaucja' => $this->session->userdata('kaucja_30'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D30');
                $this->session->set_userdata('numer_zamowienia', 'B30');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_30'),
                'marka' => $this->session->userdata('marka_30'),
                'cena' => $this->session->userdata('cena_30'),
                'kaucja' => $this->session->userdata('kaucja_30'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D30');
            $this->session->set_userdata('numer_zamowienia', 'B30');
            $this->index($data);
        }
    }

    public function A31() {
        $data = array('photo' => $this->session->userdata('photo_31'),
            'marka' => $this->session->userdata('marka_31'),
            'cena' => $this->session->userdata('cena_31'),
            'kaucja' => $this->session->userdata('kaucja_31'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C31');
        $this->session->set_userdata('numer_zamowienia', 'A31');
        $this->index($data);
    }

    public function B31() {
        $data = array('photo' => $this->session->userdata('photo_31'),
            'marka' => $this->session->userdata('marka_31'),
            'cena' => $this->session->userdata('cena_31'),
            'kaucja' => $this->session->userdata('kaucja_31'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D31');
        $this->session->set_userdata('numer_zamowienia', 'B31');
        $this->index($data);
    }

    public function C31() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_31'),
                    'marka' => $this->session->userdata('marka_31'),
                    'cena' => $this->session->userdata('cena_31'),
                    'kaucja' => $this->session->userdata('kaucja_31'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C31');
                $this->session->set_userdata('numer_zamowienia', 'A31');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_31'),
                'marka' => $this->session->userdata('marka_31'),
                'cena' => $this->session->userdata('cena_31'),
                'kaucja' => $this->session->userdata('kaucja_31'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C31');
            $this->session->set_userdata('numer_zamowienia', 'A31');
            $this->index($data);
        }
    }

    public function D31() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_31'),
                    'marka' => $this->session->userdata('marka_31'),
                    'cena' => $this->session->userdata('cena_31'),
                    'kaucja' => $this->session->userdata('kaucja_31'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D31');
                $this->session->set_userdata('numer_zamowienia', 'B31');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_31'),
                'marka' => $this->session->userdata('marka_31'),
                'cena' => $this->session->userdata('cena_31'),
                'kaucja' => $this->session->userdata('kaucja_31'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D31');
            $this->session->set_userdata('numer_zamowienia', 'B31');
            $this->index($data);
        }
    }

    public function A32() {
        $data = array('photo' => $this->session->userdata('photo_32'),
            'marka' => $this->session->userdata('marka_32'),
            'cena' => $this->session->userdata('cena_32'),
            'kaucja' => $this->session->userdata('kaucja_32'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C32');
        $this->session->set_userdata('numer_zamowienia', 'A32');
        $this->index($data);
    }

    public function B32() {
        $data = array('photo' => $this->session->userdata('photo_32'),
            'marka' => $this->session->userdata('marka_32'),
            'cena' => $this->session->userdata('cena_32'),
            'kaucja' => $this->session->userdata('kaucja_32'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D32');
        $this->session->set_userdata('numer_zamowienia', 'B32');
        $this->index($data);
    }

    public function C32() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_32'),
                    'marka' => $this->session->userdata('marka_32'),
                    'cena' => $this->session->userdata('cena_32'),
                    'kaucja' => $this->session->userdata('kaucja_32'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C32');
                $this->session->set_userdata('numer_zamowienia', 'A32');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_32'),
                'marka' => $this->session->userdata('marka_32'),
                'cena' => $this->session->userdata('cena_32'),
                'kaucja' => $this->session->userdata('kaucja_32'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C32');
            $this->session->set_userdata('numer_zamowienia', 'A32');
            $this->index($data);
        }
    }

    public function D32() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_32'),
                    'marka' => $this->session->userdata('marka_32'),
                    'cena' => $this->session->userdata('cena_32'),
                    'kaucja' => $this->session->userdata('kaucja_32'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D32');
                $this->session->set_userdata('numer_zamowienia', 'B32');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_32'),
                'marka' => $this->session->userdata('marka_32'),
                'cena' => $this->session->userdata('cena_32'),
                'kaucja' => $this->session->userdata('kaucja_32'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D32');
            $this->session->set_userdata('numer_zamowienia', 'B32');
            $this->index($data);
        }
    }

    public function A33() {
        $data = array('photo' => $this->session->userdata('photo_33'),
            'marka' => $this->session->userdata('marka_33'),
            'cena' => $this->session->userdata('cena_33'),
            'kaucja' => $this->session->userdata('kaucja_33'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C33');
        $this->session->set_userdata('numer_zamowienia', 'A33');
        $this->index($data);
    }

    public function B33() {
        $data = array('photo' => $this->session->userdata('photo_33'),
            'marka' => $this->session->userdata('marka_33'),
            'cena' => $this->session->userdata('cena_33'),
            'kaucja' => $this->session->userdata('kaucja_33'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D33');
        $this->session->set_userdata('numer_zamowienia', 'B33');
        $this->index($data);
    }

    public function C33() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_33'),
                    'marka' => $this->session->userdata('marka_33'),
                    'cena' => $this->session->userdata('cena_33'),
                    'kaucja' => $this->session->userdata('kaucja_33'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C33');
                $this->session->set_userdata('numer_zamowienia', 'A33');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_33'),
                'marka' => $this->session->userdata('marka_33'),
                'cena' => $this->session->userdata('cena_33'),
                'kaucja' => $this->session->userdata('kaucja_33'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C33');
            $this->session->set_userdata('numer_zamowienia', 'A33');
            $this->index($data);
        }
    }

    public function D33() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_33'),
                    'marka' => $this->session->userdata('marka_33'),
                    'cena' => $this->session->userdata('cena_33'),
                    'kaucja' => $this->session->userdata('kaucja_33'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D33');
                $this->session->set_userdata('numer_zamowienia', 'B33');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_33'),
                'marka' => $this->session->userdata('marka_33'),
                'cena' => $this->session->userdata('cena_33'),
                'kaucja' => $this->session->userdata('kaucja_33'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D33');
            $this->session->set_userdata('numer_zamowienia', 'B33');
            $this->index($data);
        }
    }

    public function A34() {
        $data = array('photo' => $this->session->userdata('photo_34'),
            'marka' => $this->session->userdata('marka_34'),
            'cena' => $this->session->userdata('cena_34'),
            'kaucja' => $this->session->userdata('kaucja_34'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C34');
        $this->session->set_userdata('numer_zamowienia', 'A34');
        $this->index($data);
    }

    public function B34() {
        $data = array('photo' => $this->session->userdata('photo_34'),
            'marka' => $this->session->userdata('marka_34'),
            'cena' => $this->session->userdata('cena_34'),
            'kaucja' => $this->session->userdata('kaucja_34'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D34');
        $this->session->set_userdata('numer_zamowienia', 'B34');
        $this->index($data);
    }

    public function C34() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_34'),
                    'marka' => $this->session->userdata('marka_34'),
                    'cena' => $this->session->userdata('cena_34'),
                    'kaucja' => $this->session->userdata('kaucja_34'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C34');
                $this->session->set_userdata('numer_zamowienia', 'A34');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_34'),
                'marka' => $this->session->userdata('marka_34'),
                'cena' => $this->session->userdata('cena_34'),
                'kaucja' => $this->session->userdata('kaucja_34'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C34');
            $this->session->set_userdata('numer_zamowienia', 'A34');
            $this->index($data);
        }
    }

    public function D34() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_34'),
                    'marka' => $this->session->userdata('marka_34'),
                    'cena' => $this->session->userdata('cena_34'),
                    'kaucja' => $this->session->userdata('kaucja_34'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D34');
                $this->session->set_userdata('numer_zamowienia', 'B34');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_34'),
                'marka' => $this->session->userdata('marka_34'),
                'cena' => $this->session->userdata('cena_34'),
                'kaucja' => $this->session->userdata('kaucja_34'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D34');
            $this->session->set_userdata('numer_zamowienia', 'B34');
            $this->index($data);
        }
    }

    public function A35() {
        $data = array('photo' => $this->session->userdata('photo_35'),
            'marka' => $this->session->userdata('marka_35'),
            'cena' => $this->session->userdata('cena_35'),
            'kaucja' => $this->session->userdata('kaucja_35'),
            'wynajem' => 'Wynajem',
            'alert' => null,
            'form' => 'C35');
        $this->session->set_userdata('numer_zamowienia', 'A35');
        $this->index($data);
    }

    public function B35() {
        $data = array('photo' => $this->session->userdata('photo_35'),
            'marka' => $this->session->userdata('marka_35'),
            'cena' => $this->session->userdata('cena_35'),
            'kaucja' => $this->session->userdata('kaucja_35'),
            'wynajem' => 'Rezerwacja',
            'alert' => null,
            'form' => 'D35');
        $this->session->set_userdata('numer_zamowienia', 'B35');
        $this->index($data);
    }

    public function C35() {
        $this->load->model('wynajem_model');
        $formularz = new Wynajem_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszWynajem();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_35'),
                    'marka' => $this->session->userdata('marka_35'),
                    'cena' => $this->session->userdata('cena_35'),
                    'kaucja' => $this->session->userdata('kaucja_35'),
                    'wynajem' => 'Wynajem',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Wynajem bez rejestracji',
                    'form' => 'C35');
                $this->session->set_userdata('numer_zamowienia', 'A35');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_35'),
                'marka' => $this->session->userdata('marka_35'),
                'cena' => $this->session->userdata('cena_35'),
                'kaucja' => $this->session->userdata('kaucja_35'),
                'wynajem' => 'Wynajem',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'C35');
            $this->session->set_userdata('numer_zamowienia', 'A35');
            $this->index($data);
        }
    }

    public function D35() {
        $this->load->model('rezerwacja_model');
        $formularz = new Rezerwacja_model();
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
        } else {
            $data = array('cena' => $this->input->post('cena'),
                'dni' => $this->input->post('dni'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $formularz->odczytDanych()['imie'],
                'nazwisko' => $formularz->odczytDanych()['nazwisko'],
                'miejscowosc' => $formularz->odczytDanych()['miejscowosc'],
                'kod' => $formularz->odczytDanych()['kod'],
                'ulica' => $formularz->odczytDanych()['ulica'],
                'nr_domu' => $formularz->odczytDanych()['nr_domu'],
                'nr_mieszkania' => $formularz->odczytDanych()['nr_mieszkania'],
                'email' => $formularz->odczytDanych()['email']);
        }

        if ($this->date_valid() == TRUE) {
            if ($this->sprawdzenieFormularza() == TRUE) {
                $formularz->zapiszRezerwacja();
                $this->load->view('platnosc', $data);
            } else {
                $data = array('photo' => $this->session->userdata('photo_35'),
                    'marka' => $this->session->userdata('marka_35'),
                    'cena' => $this->session->userdata('cena_35'),
                    'kaucja' => $this->session->userdata('kaucja_35'),
                    'wynajem' => 'Rezerwacja',
                    'alert' => 'Musisz się zalogować albo wypełnić pola ukryte pod linkiem Rezerwacja bez rejestracji',
                    'form' => 'D35');
                $this->session->set_userdata('numer_zamowienia', 'B35');
                $this->index($data);
            }
        } else {

            $data = array('photo' => $this->session->userdata('photo_35'),
                'marka' => $this->session->userdata('marka_35'),
                'cena' => $this->session->userdata('cena_35'),
                'kaucja' => $this->session->userdata('kaucja_35'),
                'wynajem' => 'Rezerwacja',
                'alert' => 'Podana data jest negatywna lub ujemna',
                'form' => 'D35');
            $this->session->set_userdata('numer_zamowienia', 'B35');
            $this->index($data);
        }
    }

}
