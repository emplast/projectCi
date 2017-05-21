<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of panelAplikacja_model
 *
 * @author emplast
 */
class PanelAplikacja_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function daneDoWyswietlenia(){
        $result=$this->db->query('SELECT * FROM formularz ORDER BY numer_strony ASC, numer_panelu ASC');
        
        
        for($i=0;$i<=$result->num_rows();$i++){
          
        $dane['naglowek_zdjecia'.$i]=$result->row($i)->naglowek_panelu;
        $dane['opis'.$i]=$result->row($i)->opis_panelu;
        $dane['cena'.$i]=$result->row($i)->cena;
        $dane['kaucja'.$i]=$result->row($i)->kaucja;
        $dane['photo'.$i]=$result->row($i)->zdjecie;
             
         }
        
          
        $dane['ilosc']=$result->num_rows();
        return $dane;
        
    }
    public function iloscStron(){
        $count=$this->db->count_all('formularz');
        
        $result=$this->db->query('SELECT COUNT(*) FROM formularz GROUP BY numer_strony ');
        $strona=$result->num_rows();
        
        return $strona;
        
    }
    public function iloscPaneliNaStronie($strona){
        $strona=$strona;
        $result=$this->db->query('SELECT COUNT(numer_panelu),numer_strony FROM formularz WHERE numer_strony="'.$strona.'" GROUP BY numer_panelu');
        $panel=$result->num_rows();
        return $panel;
    }
    public function iloscPaneli(){
        for($i=0;$i<=$this->iloscStron();$i++){
            $ilość_paneli[$i]=$this->iloscPaneliNaStronie($i);
           
        }
         $ilosc_paneli_1= array_sum($ilość_paneli);
         return $ilosc_paneli_1;
    }
    
}