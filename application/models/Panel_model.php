<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of panel_model
 *
 * @author emplast
 */
class Panel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function edycjaPaneluZapisz() {
       
        $this->load->helper('cookie');
        $input = $this->input->cookie('numer_7');
        $input_1 = $this->input->cookie('numer_8');
        
        $input_2= basename($this->input->cookie('plik'));
        if(empty($this->input->cookie('plik'))){
            
            $input_2= basename($this->input->post('part_12'));
           
        }
        
        
        $dane = array(
            'numer_strony' => $input,
            'numer_panelu' => $input_1,
            'naglowek_panelu' => $this->input->post('part_6'),
            'opis_panelu' => $this->input->post('part_9'),
            'cena'=>$this->input->post('part_13'),
            'kaucja'=>$this->input->post('part_14'),
            'zdjecie' => $input_2,
        );
        $data = array('numer_strony' => $input, 'numer_panelu' => $input_1);
        $this->db->where($data);
        $result = $this->db->update('formularz', $dane);
       

        return array('result'=>$result,'photo'=>$input_2);
    }

    public function edycja() {
        $input = $this->input->post('part_7');
        $input_1 = $this->input->post('part_8');
        if(empty($input)& empty($input_1)){
            $input=$this->input->cookie('numer_7');
            $input_1=$this->input->cookie('numer_8');
        }
        $result = $this->db->query('SELECT * FROM formularz WHERE numer_strony="' . $input . '" AND numer_panelu="' . $input_1 . '"');
        $count = $result->num_rows();
        if ($count > 0) {

            return array('input'=>$input,
                         'form'=>$count,
                         'wynik' => 1,
                         'naglowek' => $result->row()->naglowek_panelu,
                         'opis' => $result->row()->opis_panelu,
                         'cena'=>$result->row()->cena,
                         'kaucja'=>$result->row()->kaucja,
                         'photo' => $result->row()->zdjecie);
        }
        return array('input'=>$input,
                     'form'=>$count,
                     'wynik'=>0,
                     'naglowek'=>null,
                     'opis'=>null,
                     'cena'=>null,
                     'kaucja'=>null,
                     'photo'=>null);
    }

    public function wyswietlanie() {
        $input = $this->input->post('part_7');
        $input_1 = $this->input->post('part_8');
       if(empty($input)& empty($input_1)){
           $input=$this->input->cookie('numer_7');
           $input_1=$this->input->cookie('numer_8');
       }



        $result = $this->db->query('SELECT * FROM formularz WHERE numer_strony="' . $input . '" AND numer_panelu="' . $input_1 . '"');
        $count = $result->num_rows();
        if ($count > 0) {


            return array('input'=>$input,
                         'naglowek' => $result->row()->naglowek_panelu,
                         'opis' => $result->row()->opis_panelu,
                         'cena'=>$result->row()->cena,
                         'kaucja'=>$result->row()->kaucja,
                         'photo' => $result->row()->zdjecie);
        }
        return array('input'=>$input,
                     'naglowek' => null,
                     'opis' => null,
                     'cena'=>NULL,
                     'kaucja'=>NULL,
                     'photo' => null);
    }

   

    public function delete() {

        $query = $this->db->query('DELETE FROM formularz WHERE numer_strony="' . $this->db->escape_str($this->input->post('part_3')) . '"');
        return $query;
    }

    public function deleteStrona() {
        $result = $this->db->query('SELECT numer_strony FROM formularz ');
        $count = $this->db->count_all_results('formularz');
        (int) $last = $result->row($count - 1)->numer_strony;
        if ( $last != $this->input->post('part_3') ) {
            
            return 0;
        } else if($last==1){
            
                return 0;
        }
            return 1;
        }
    }


