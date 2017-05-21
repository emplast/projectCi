<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of addPanelSide
 *
 * @author emplast
 */
class AddPanelSide_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    public function dodajStrone() {

        $strona = $this->input->post('part_1');
        $naglowek = 'Witaj udało się zapisać';
        $opis = 'opis';
        $cena=0;
        $kaucja=0;
        $zdjecie = '01_240_200_p.png';
        $panel = $this->input->post('part_2');
        
        $i = 1;
        do {

            $result = $this->db->query('INSERT INTO formularz (numer_strony,numer_panelu,naglowek_panelu,opis_panelu,cena,kaucja,zdjecie)'
                    . ' VALUES("' . $strona . '","' . $i . '","' . $naglowek . '","' . $opis . '","'.$cena.'","'.$kaucja.'","' . $zdjecie . '")');
            $i++;
        } while ($i <= $panel);


        /*
          $dane = array(
          'numer_strony' =>$this->sprawdzenieDodajStrone()['numer_strony'],
          'numer_panelu' => $this->sprawdzenieDodajStrone()['numer_panelu'],
          );

          $result = $this->db->insert('formularz', $dane); */

        return $result;
    }

   

    public function sprawdzenieDodajStrone() {
       
        $input = (($this->input->post('part_1'))-1);
        $result = $this->db->query('SELECT numer_strony FROM formularz ORDER BY numer_strony ASC');
         $count=$this->db->count_all('formularz');
      
        if($result->row($count-1)->numer_strony==$input){
            return array('wynik'=>TRUE,'count'=>$count);
        }
        return array('wynik'=>FALSE,'count'=>$count);
        
    }

}
