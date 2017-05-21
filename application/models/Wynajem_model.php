<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wynajem
 *
 * @author emplast
 */
class Wynajem_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function zapiszWynajem() {
        if (empty($this->session->userdata('zalogowany'))) {
            $data = array('marka' => $this->input->post('marka'),
                'liczba_dni' => $this->input->post('dni'),
                'od' => $this->input->post('start'),
                'do' => $this->input->post('end'),
                'cena' => $this->input->post('cena'),
                'kaucja' => $this->input->post('kaucja'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod_pocztowy' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email'));
            $this->db->insert('wynajem', $data);
            
        } else {
            $result = $this->db->query('SELECT * FROM login WHERE name="' . $this->session->userdata('name') . '"');
            $data = array('marka' => $this->input->post('marka'),
                'liczba_dni' => $this->input->post('dni'),
                'od' => $this->input->post('start'),
                'do' => $this->input->post('end'),
                'cena' => $this->input->post('cena'),
                'kaucja' => $this->input->post('kaucja'),
                'wartosc' => $this->input->post('wartosc'),
                'imie' => $result->row()->imie,
                'nazwisko' => $result->row()->nazwisko,
                'miejscowosc' => $result->row()->miejscowosc,
                'kod_pocztowy' => $result->row()->kod,
                'ulica' => $result->row()->ulica,
                'nr_domu' => $result->row()->nr_domu,
                'nr_mieszkania' => $result->row()->nr_mieszkania,
                'email' => $result->row()->email);
            $this->db->insert('wynajem', $data);
            
        }
    }
    public function odczytDanych(){
         $result = $this->db->query('SELECT * FROM login WHERE name="' . $this->session->userdata('name') . '"');
         return array('imie'=>$result->row()->imie,
                         'nazwisko'=>$result->row()->nazwisko,
                         'miejscowosc'=>$result->row()->miejscowosc,
                         'kod'=>$result->row()->kod,
                         'ulica'=>$result->row()->ulica,
                         'nr_domu'=>$result->row()->nr_domu,
                         'nr_mieszkania'=>$result->row()->nr_mieszkania,
                         'email'=>$result->row()->email);
    }

}
