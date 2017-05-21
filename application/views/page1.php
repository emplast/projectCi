<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $tytul ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/custom.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('dist/css/bootstrap-theme.min.css') ?>">
        <script type="text/javascript" src="dist/js/bootstrap.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="dist/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="dist/js/npm.js"></script>
        <style type="text/css">
            #login,
            #password,
            #repassword,
            #imie,
            #nazwisko,
            #miejscowosc,
            #kod,
            #ulica,
            #nr_domu,
            #nr_mieszkania,
            #e-mail{
                width: 150px;
                
            }
            .cont_2{
                margin-left: 450px;
            }
            .gwiazdka{
                color: red;
            }
            .p{
                
            }
        </style>
    </head>
    <body>

        <div class="container">
        <div class="cont_1 text-center  ">
            
            <h1><?php echo $tresc ?></h1>
            <h3><?php echo $alert?></h3>
            <h6><?php echo $informacja ?></h6>
        </div>            
            <div class="cont_2 form-group ">
                <?php
                $dane = array('id' => 'from_1 ');
                echo form_open('index.php/Walidacja/index', $dane);
                ?>
               
                <p><span class="gwiazdka">*</span>&nbspLogin
                <?php
                $dane = array('class' => 'form-control ','type'=>'text', 'name' => 'login', 'placeholder' => 'Login:','id'=>'login');
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('login') ; ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Hasło
                <?php
                $dane = array('class' => 'form-control', 'name' => 'password', 'placeholder' => 'Hasło:','id'=>'password');
                echo form_password($dane);
                ?><span class="text-danger"><?php echo form_error('password') ; ?></span></p>
                </br>
                </br>
                <p class="p"><span class="gwiazdka">*</span>&nbsp;Imie
                <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'imie', 'placeholder' => 'Imie','id'=>'imie' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('imie') ; ?></span></p>
                <p class="p"><span class="gwiazdka">*</span>&nbsp;Nazwisko
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'nazwisko', 'placeholder' => 'Nazwisko','id'=>'nazwisko' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('nazwisko') ; ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Miejscowość
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'miejscowosc', 'placeholder' => 'Miejscowość','id'=>'miejscowosc' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('miejscowosc'); ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Kod pocztowy
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'kod', 'placeholder' => '00-000','id'=>'kod' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('kod') ; ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Ulica
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'ulica', 'placeholder' => 'Ulica','id'=>'ulica' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('ulica') ; ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Numer mieszkania
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'nr_domu', 'placeholder' => 'Nr domu','id'=>'nr_domu' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('nr_domu') ; ?></span></p>
                <p><span class="gwiazdka">*</span>&nbsp;Numer mieszkania
                 <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'nr_mieszkania', 'placeholder' => 'Nr mieszkania','id'=>'nr_mieszkania' );
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('nr_mieszkania'); ?></span></p>
                <p>&nbsp;&nbsp;E-mail
                <?php
                $dane = array('class' => 'form-control','type'=>'text', 'name' => 'email', 'placeholder' => 'E-mail:','id'=>'e-mail');
                echo form_input($dane);
                ?><span class="text-danger"><?php echo form_error('email'); ?></span></p>
                </br>
                </br>
                </br>
                
                <?php
                $dane = array('class' => 'btn btn-primary', 'name' => 'submit', 'type' => 'submit', 'value' => 'Zaloguj', 'content' => 'Zaloguj');
                echo form_button($dane);
                echo form_close();
                ?>





            </div>
   