<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/custom.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <script type="text/javascript" src="<?php echo base_url('dist/js/respond.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/npm.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/jquery-3.2.1.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('projectCi/dist/js/jquery.cookie.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.js') ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('dist/js/bootstrap.min.js') ?>"></script>

        <style type="text/css">
            .body{
                padding: 0;
                margin: 0;

            }   

            .menu{
                float: left;
                width: 180px; 
                height:auto;
                background-color: #262626;
                margin-left:0px;
                padding: 0;
            }

            .btn-group{
                margin-top: 80px;
                padding: 0;
                float: left;
                width: 180px;
                height: auto;
                background-color: #262626;

            }

            h5{
                font-size: 15px;
                color: #ccc;
            }
            h5:hover{
                color: white;
            }
            .btn {
                margin-top: 0;
                padding: 0;
                float: top;
                background-color: #262626;
                width: 180px;
                height: 100px;

            }

            .dropdown-menu{
                margin: 0;
                padding: 0;
                top:25%;
                left: 100%;
                float: left;
                background-color:#282828;

            }


            .caret {

                color: #ccc;
                text-align: right;
            }
            #button_1,#button_2,#button_3,#button_4{
                text-decoration: none; 
            }
            #exTab1{
                margin-left:350px;
            }
            .cont_1{
                float: left;
                margin-top: -530px;
                height: 850px;
                
            }
            #p_f{

                margin-top:-5px;
            }
            #table{
                float: left;
                margin-left: 180px;
                font-size: 12px;
                border: 1px;
            }

        </style>
    </head>
    <body>
        <div class="container">
            
            </br>
            </br>
            </br>
            
            <div class="caption text-center">
                <h2>Samochody wynajęte</h2>
            </div>
           
            <div class="cont_1">
                <table class="table" id="table">
                    <tr>
                        <th>Usuń</th>
                        <th>Marka</th>
                        <th>Liczba dni</th>
                        <th>Od</th>
                        <th>Do</th>
                        <th>Cena za dobe</th>
                        <th>Kaucja</th>
                        <th>Wartość</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Miejscowość</th>
                        <th>Kod pocztowy</th>
                        <th>Ulica</th>
                        <th>Numer domu</th>
                        <th>Numer lokalu</th>
                        <th>E-mail</th>
                        <th>Nr</th>
                            
                            
                    </tr>
                         
                    <?php  $i=0; foreach ($lista as $row ):?> 
                    <tr>
                        <?php $i++?>
                        <td><a id="delete" href="<?php echo base_url('index.php/Admin/delete/'. auto_link($row['nr']));?>" >Usuń</a></td>
                        <td><?php echo$row['marka'];?></td>
                        <td><?php echo $row['liczba_dni'];?></td>
                        <td><?php echo $row['od'];?></td>
                        <td><?php echo $row['do'];?></td>     
                        <td><?php echo $row['cena'];?></td>
                        <td><?php echo $row['kaucja'];?></td>
                        <td><?php echo $row['wartosc'];?></td>
                        <td><?php echo $row['imie'];?></td>
                        <td><?php echo $row['nazwisko'];?></td>
                        <td><?php echo $row['miejscowosc'];?></td>
                        <td><?php echo $row['kod_pocztowy'];?></td>
                        <td><?php echo $row['ulica'];?></td>
                        <td><?php echo $row['nr_domu'];?></td>
                        <td><?php echo $row['nr_mieszkania'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['nr'];?></td>
                    </tr>
                     <?php endforeach;?>
                </table>
                
                
            </div>