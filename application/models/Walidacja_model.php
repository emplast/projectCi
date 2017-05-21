<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Walidacja_model
 *
 * @author emplast
 */
class Walidacja_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function zapiszNowyUzytkownik(){
        $dane = array(
                'name' => $this->input->post('login'),
                'password' => md5($this->input->post('password')),
                'imie' => $this->input->post('imie'),
                'nazwisko' => $this->input->post('nazwisko'),
                'miejscowosc' => $this->input->post('miejscowosc'),
                'kod' => $this->input->post('kod'),
                'ulica' => $this->input->post('ulica'),
                'nr_domu' => $this->input->post('nr_domu'),
                'nr_mieszkania' => $this->input->post('nr_mieszkania'),
                'email' => $this->input->post('email')
            );

            $this->db->insert('login', $dane);
    }
    public function sprawdzenieNowyUrzytkownik(){
        $result=$this->db->query('SELECT * FROM login WHERE name="'.$this->input->post('login').'"AND password="'. md5($this->input->post('password')).'"');
       return $result->num_rows();
    }
}
