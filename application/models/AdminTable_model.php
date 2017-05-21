<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminTable
 *
 * @author emplast
 */
class AdminTable_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function tabelaWynajm() {
        $result = $this->db->query('SELECT * FROM wynajem');
        for($i=0;$i<$result->num_rows();$i++){
            $row['lista'.$i]=$result->row_array($i);
            
        }
       
        return $row ;
    }
    public function deleteRowWynajem($row){
        $result=$this->db->query('DELETE FROM wynajem WHERE nr="'.$row.'"');
    }
    public function tabelaRezerwacja() {
        $result = $this->db->query('SELECT * FROM rezerwacja');
        for($i=0;$i<$result->num_rows();$i++){
            $row['lista'.$i]=$result->row_array($i);
            
        }
       
        return $row ;
    }
     public function deleteRowRezerwacja($row){
        $result=$this->db->query('DELETE FROM rezerwacja WHERE nr="'.$row.'"');
    }

}
