<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deletePanel_model
 *
 * @author emplast
 */
class DeletePanel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function delete() {
        $input=$this->input->post('part_4');
        $result=$this->db->query('DELETE FROM formularz WHERE numer_strony="'.$input.'"');
        return $result;
    }

    public function add() {

        $strona = $this->input->post('part_4');
        $naglowek = 'Witaj udało się zapisać';
        $opis = 'opis';
        $zdjecie = '01_240_200_p.png';
        $panel = $this->input->post('part_5');

        $i = 1;
        do {

            $result = $this->db->query('INSERT INTO formularz (numer_strony,numer_panelu,naglowek_panelu,opis_panelu,zdjecie)'
                    . ' VALUES("' . $strona . '","' . $i . '","' . $naglowek . '","' . $opis . '","' . $zdjecie . '")');
            $i++;
        } while ($i <= $panel);
    }

    public function sprawdzenieEdycji() {

        $input = $this->input->post('part_4');
        $result = $this->db->query('SELECT * FROM formularz WHERE numer_strony="' . $input . '"');
   
        if ($result->num_rows() > 0) {
            $this->delete();
            $this->add();
            return 1;
        }
        return 0;
    }

}
